<?php
/**
 * Command line interface for professional text randomizer and ad generator.
 *
 * USAGE: php ad-generator-cli.php -n 300 -f template.txt -o result.txt
 *
 * -n, -N        number of variants in output file (default: 300)
 * -f, --file    input file with template (required)
 * -o, --out     result file (default: result-N.txt)
 * -h, --help    show help message
 *
 * @package    AiratTop/ad-generator
 * @category   Core
 * @author     AiratTop
 * @license    Apache-2.0
 * @link       https://github.com/AiratTop/ad-generator
 * @version    2.3.0
 */

const DEFAULT_VARIANTS = 300;
const MAX_VARIANTS = 1_000_000_000;

function show_help(): void {
	echo <<<'HELP_TEXT'

HELP:
Version: 2.3.0
Command line interface for professional text randomizer and ad generator.

USAGE:
  php ad-generator-cli.php -n 300 -f template.txt -o result.txt

Arguments:
  -n, -N        number of variants in output file (default: 300)
  -f, --file    input file with template (required)
  -o, --out     output file (default: result-N.txt)
  -h, --help    show this help message

Author: AiratTop
Link: https://github.com/AiratTop/ad-generator

HELP_TEXT;
}

function read_file( string $filename ): string {
	$content = @file_get_contents( $filename );

	if ( false === $content ) {
		throw new RuntimeException( sprintf( 'Unable to read input file: %s', $filename ) );
	}

	if ( '' === trim( $content ) ) {
		throw new RuntimeException( 'Input file should not be empty.' );
	}

	return $content;
}

function save_file( string $filename, string $content ): void {
	if ( false === @file_put_contents( $filename, $content ) ) {
		throw new RuntimeException( sprintf( 'Unable to write output file: %s', $filename ) );
	}
}

function ad_generator_cli( int $max_res, string $filename ): string {
	$result_text = '';
	$ad_text     = read_file( $filename );
	$ad_text     = str_replace( '\\\\', '\\', $ad_text );
	$ad_text     = str_replace( '\\"', '"', $ad_text );
	$ad_text     = str_replace( "\\'", "'", $ad_text );

	require_once __DIR__ . '/includes/Randomizer.php';

	$randomizer = new Randomizer( $ad_text );
	$num_var    = $randomizer->numVariant();

	if ( $num_var > 1 ) {
		$max_tmp      = min( $num_var, $max_res );
		$result_text .= sprintf(
			"The number of all possible variants: %s. Here are %s random ones:\n\n",
			$num_var,
			$max_tmp
		);

		for ( $i = 0; $i < $max_tmp; ++$i ) {
			$result_text .= $randomizer->getText() . "\n\n\n";
		}
	} else {
		$result_text .= "Only 1 possible variant:\n\n";
		$result_text .= $randomizer->getText();
	}

	$result_text = preg_replace( "/\n /", "\n", trim( $result_text ) ) ?? '';
	$result_text = preg_replace( "/ \n/", "\n", $result_text ) ?? '';

	return $result_text;
}

/**
 * @param array<int, string> $arguments
 */
function main( array $arguments ): int {
	if ( count( $arguments ) < 2 ) {
		show_help();
		return 0;
	}

	$variant_count = DEFAULT_VARIANTS;
	$input_file    = '';
	$output_file   = '';

	for ( $i = 1, $length = count( $arguments ); $i < $length; ++$i ) {
		switch ( $arguments[ $i ] ) {
			case '-n':
			case '-N':
				if ( ! isset( $arguments[ $i + 1 ] ) ) {
					fwrite( STDERR, "Error: missing value for {$arguments[ $i ]}.\n" );
					return 1;
				}
				$variant_count = (int) $arguments[ ++$i ];
				break;

			case '-f':
			case '--file':
				if ( ! isset( $arguments[ $i + 1 ] ) ) {
					fwrite( STDERR, "Error: missing value for {$arguments[ $i ]}.\n" );
					return 1;
				}
				$input_file = $arguments[ ++$i ];
				break;

			case '-o':
			case '--out':
				if ( ! isset( $arguments[ $i + 1 ] ) ) {
					fwrite( STDERR, "Error: missing value for {$arguments[ $i ]}.\n" );
					return 1;
				}
				$output_file = $arguments[ ++$i ];
				break;

			case '-h':
			case '--help':
				show_help();
				return 0;
		}
	}

	if ( $variant_count < 1 || $variant_count > MAX_VARIANTS ) {
		fwrite( STDERR, sprintf( "Warning: variant count must be between 1 and %d; using %d.\n", MAX_VARIANTS, DEFAULT_VARIANTS ) );
		$variant_count = DEFAULT_VARIANTS;
	}

	if ( '' === $input_file ) {
		fwrite( STDERR, "Error: missing input file; use -f or --file to specify it.\n\n" );
		show_help();
		return 1;
	}

	if ( '' === $output_file ) {
		$output_file = 'result-' . $variant_count . '.txt';
	}

	try {
		save_file( $output_file, ad_generator_cli( $variant_count, $input_file ) );
	} catch ( RuntimeException $exception ) {
		fwrite( STDERR, 'Error: ' . $exception->getMessage() . "\n" );
		return 1;
	}

	return 0;
}

exit( main( $argv ) );
