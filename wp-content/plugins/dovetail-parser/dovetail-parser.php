<?php
/**
 * Plugin Name: Dovetail Parser
 * Description: Processes {[ ... ]} DSL templates into HTML. Run via WP-CLI: wp dovetail parse [page]
 * Version:     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ─── PARSER ───────────────────────────────────────────────────────────────────

class Dovetail_Parser {

	const KEYWORDS = [ 'section', 'layout', 'component', 'content', 'modifier' ];

	private string $src_dir;
	private string $comp_dir;
	private string $out_dir;

	public function __construct() {
		$theme          = get_template_directory();
		$this->src_dir  = $theme . '/src/pages';
		$this->comp_dir = $theme . '/src/components';
		$this->out_dir  = $theme . '/output';
	}

	// ── Tokenizer ─────────────────────────────────────────────────────────────

	/**
	 * Parse a raw DSL tag string into a structured token.
	 * Returns null if the tag is not part of the DSL grammar.
	 *
	 * Grammar:
	 *   {[ keyword: value | class: cls1 cls2 ]}   open block
	 *   {[/ keyword: name ]}                        close block
	 */
	private function tokenize( string $raw ): ?array {
		$inner = trim( substr( $raw, 2, -2 ) ); // strip {[ and ]}

		// ── Close tag ── {[/ keyword: name ]}
		if ( str_starts_with( $inner, '/' ) ) {
			$body    = trim( substr( $inner, 1 ) );
			$colon   = strpos( $body, ':' );
			$keyword = $colon === false
				? preg_split( '/\s/', $body )[0]
				: trim( substr( $body, 0, $colon ) );
			$value   = $colon === false
				? ''
				: trim( preg_split( '/[\s|]/', substr( $body, $colon + 1 ) )[0] );

			if ( ! in_array( $keyword, self::KEYWORDS, true ) ) {
				return null;
			}
			return [ 'type' => 'close', 'keyword' => $keyword, 'value' => $value ];
		}

		// ── Open tag ── {[ keyword: value | class: cls1 cls2 ]}
		$pipe        = strpos( $inner, '|' );
		$struct_part = $pipe === false ? $inner : trim( substr( $inner, 0, $pipe ) );
		$class_part  = $pipe === false ? ''     : trim( substr( $inner, $pipe + 1 ) );

		$colon = strpos( $struct_part, ':' );
		if ( $colon === false ) {
			return null;
		}

		$keyword = strtolower( trim( substr( $struct_part, 0, $colon ) ) );
		if ( ! in_array( $keyword, self::KEYWORDS, true ) ) {
			return null;
		}

		$value = trim( substr( $struct_part, $colon + 1 ) );

		// Parse classes: "class: foo bar baz"
		$classes = [];
		if ( stripos( $class_part, 'class:' ) === 0 ) {
			$classes = array_values(
				array_filter( preg_split( '/\s+/', trim( substr( $class_part, 6 ) ) ) )
			);
		}

		// Parse key=value attrs for layout: "cols=3, wrap=true, gap=md"
		$attrs = [];
		if ( $keyword === 'layout' ) {
			foreach ( explode( ',', $value ) as $pair ) {
				$eq = strpos( $pair, '=' );
				if ( $eq !== false ) {
					$attrs[ trim( substr( $pair, 0, $eq ) ) ] = trim( substr( $pair, $eq + 1 ) );
				}
			}
		}

		return [
			'type'    => 'open',
			'keyword' => $keyword,
			'value'   => $value,
			'attrs'   => $attrs,
			'classes' => $classes,
		];
	}

	// ── Generators ────────────────────────────────────────────────────────────

	private function gen_section( array $token ): array {
		$name     = strtolower( preg_replace( '/\s+/', '-', $token['value'] ) );
		$base_tag = match ( $name ) {
			'site-header' => 'header',
			'site-footer' => 'footer',
			default       => 'section',
		};
		$cls = implode( ' ', array_filter( array_merge(
			[ 'section', "section--{$name}" ],
			$token['classes']
		) ) );
		return [ 'html' => sprintf( '<%s class="%s">', $base_tag, $cls ), 'tag' => $base_tag ];
	}

	private function gen_layout( array $token ): array {
		$attrs = $token['attrs'];
		$cols  = $attrs['cols']  ?? '1';
		$wrap  = ( $attrs['wrap'] ?? '' ) === 'true' ? ' layout--wrap' : '';
		$gap   = isset( $attrs['gap'] )   ? ' gap-' . $attrs['gap']              : '';
		$align = isset( $attrs['align'] ) ? ' layout--align-' . $attrs['align']  : '';
		$extra = $token['classes'] ? ' ' . implode( ' ', $token['classes'] ) : '';
		$cls   = "layout layout--cols-{$cols}{$wrap}{$gap}{$align}{$extra}";
		return [ 'html' => sprintf( '<div class="%s">', $cls ), 'tag' => 'div' ];
	}

	private function gen_component( array $token ): string {
		$name      = strtolower( preg_replace( '/\s+/', '-', trim( $token['value'] ) ) );
		$tmpl_path = $this->comp_dir . "/{$name}.html";

		if ( ! file_exists( $tmpl_path ) ) {
			trigger_error( "Dovetail: Component not found: {$name}.html", E_USER_WARNING );
			return sprintf( '<!-- component "%s" not found -->', $name );
		}

		$tmpl = rtrim( file_get_contents( $tmpl_path ) );

		if ( $token['classes'] ) {
			$extra = implode( ' ', $token['classes'] ) . ' ';
			$tmpl  = preg_replace( '/(<[\w-]+\s+class=")/', '$1' . $extra, $tmpl, 1 );
		}

		return $tmpl;
	}

	private function gen_content( array $token ): string {
		$slot = strtolower( preg_replace( '/\s+/', '-', trim( $token['value'] ) ) );
		$cls  = implode( ' ', array_merge( [ 'content-slot' ], $token['classes'] ) );
		return sprintf( '<div class="%s" data-content="%s">{{%s}}</div>', $cls, $slot, $slot );
	}

	// ── Parser ────────────────────────────────────────────────────────────────

	public function parse( string $source ): string {
		$stack  = [];
		$output = [];
		$cursor = 0;

		preg_match_all( '/\{\[[\s\S]*?\]\}/', $source, $matches, PREG_OFFSET_CAPTURE );

		foreach ( $matches[0] as [ $raw, $offset ] ) {
			// Pass through everything before this tag unchanged
			$output[] = substr( $source, $cursor, $offset - $cursor );
			$cursor   = $offset + strlen( $raw );

			$token = $this->tokenize( $raw );

			// Not a grammar tag — pass through unchanged
			if ( ! $token ) {
				$output[] = $raw;
				continue;
			}

			if ( $token['type'] === 'close' ) {
				$frame = array_pop( $stack );
				if ( $frame ) {
					$output[] = "</{$frame['tag']}>";
				} else {
					trigger_error( "Dovetail: Unmatched close tag: {$raw}", E_USER_WARNING );
				}
				continue;
			}

			// Open token
			switch ( $token['keyword'] ) {
				case 'section':
					[ 'html' => $html, 'tag' => $tag ] = $this->gen_section( $token );
					$output[] = $html;
					$stack[]  = [ 'tag' => $tag ];
					break;

				case 'layout':
					[ 'html' => $html, 'tag' => $tag ] = $this->gen_layout( $token );
					$output[] = $html;
					$stack[]  = [ 'tag' => $tag ];
					break;

				case 'component':
					$output[] = $this->gen_component( $token );
					break;

				case 'content':
					$output[] = $this->gen_content( $token );
					break;

				case 'modifier':
					$output[] = sprintf( '<!-- modifier: %s -->', $token['value'] );
					break;
			}
		}

		// Remaining source after last tag
		$output[] = substr( $source, $cursor );

		if ( $stack ) {
			$unclosed = implode( ', ', array_column( $stack, 'tag' ) );
			trigger_error(
				sprintf( 'Dovetail: %d unclosed block(s) at end of file: %s', count( $stack ), $unclosed ),
				E_USER_WARNING
			);
		}

		return implode( '', $output );
	}

	// ── Build ─────────────────────────────────────────────────────────────────

	public function build( string $page_name ): void {
		$src_path = $this->src_dir . "/{$page_name}.html";
		$out_path = $this->out_dir . "/{$page_name}.html";

		if ( ! file_exists( $src_path ) ) {
			WP_CLI::error( "Source not found: {$src_path}" );
			return;
		}

		wp_mkdir_p( $this->out_dir );

		WP_CLI::log( "Parsing:  {$src_path}" );
		$source = file_get_contents( $src_path );
		$result = $this->parse( $source );
		file_put_contents( $out_path, $result );
		WP_CLI::success( "Output:   {$out_path}" );
	}
}

// ─── WP-CLI COMMAND ───────────────────────────────────────────────────────────

if ( defined( 'WP_CLI' ) && WP_CLI ) {

	/**
	 * Processes Dovetail DSL templates into HTML.
	 */
	class Dovetail_CLI_Command {

		/**
		 * Parse a DSL page template.
		 *
		 * ## OPTIONS
		 *
		 * [<page>]
		 * : Page name without .html extension. Default: index
		 *
		 * ## EXAMPLES
		 *
		 *   wp dovetail parse
		 *   wp dovetail parse index
		 *   wp dovetail parse about
		 *
		 * @subcommand parse
		 */
		public function parse( array $args ): void {
			$page   = $args[0] ?? 'index';
			$parser = new Dovetail_Parser();
			$parser->build( $page );
		}
	}

	WP_CLI::add_command( 'dovetail', 'Dovetail_CLI_Command' );
}
