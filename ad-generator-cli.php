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
 * @author     Airat Halitov
 * @license    GPLv3
 * @link       https://github.com/AiratTop/ad-generator
 * @version    2.2.0
 */

if ( $argc < 2 ) {
    die( show_help() );
}

function show_help() {
    echo <<<END

HELP:
Version: 2.2.0
Command line interface for professional text randomizer and ad generator.

USAGE:
  php ad-generator-cli.php -n 300 -f template.txt -o result.txt

Arguments:
  -n, -N        number of variants in output file (default: 300)
  -f, --file    input file with template (required)
  -o, --out     result file (default: result-N.txt)
  -h, --help    show this help message

Author: Airat Halitov
Link: https://github.com/AiratTop/ad-generator

END;
}

function read_file( $filename ) {
    $fp = fopen( $filename, "r" ) or die( "\nError in read_file(): Unable to open file!\n\n" );
    if ( filesize( $filename ) < 2 ) {
        die( "\nError in read_file(): Input file should not be empty!\n\n" );
    }
    $content = fread( $fp, filesize( $filename ) );
    if ( trim( $content ) === '' ) {
        die( "\nError in read_file(): Input file should not be empty!\n\n" );
    }
    fclose( $fp );
    return $content;
}

function save_file( $filename, $content ) {
    $fp = fopen( $filename, "w" ) or die( "\nError in save_file(): Unable to open file!\n\n" );
    fwrite( $fp, $content );
    fclose( $fp );
}

$N = 300;
$file_in = '';
$file_out = '';

for ( $i = 1; $i < $argc; $i++ ) {
    if ( ( $argv[$i] === "-n" || $argv[$i] === "-N" ) && isset( $argv[$i + 1] ) ) {
        $N = (int) $argv[$i + 1];
    }
    if ( ( $argv[$i] === "-f" || $argv[$i] === "--file" ) && isset( $argv[$i + 1] ) ) {
        $file_in = (string) $argv[$i + 1];
    }
    if ( ( $argv[$i] === "-o" || $argv[$i] === "--out" ) && isset( $argv[$i + 1] ) ) {
        $file_out = (string) $argv[$i + 1];
    }
    if ( $argv[$i] === "-h" || $argv[$i] === "--help" ) {
        die( show_help() );
    }
}

if ( $N < 1 ) {
    echo "\nWarning! N should be > 0! Using default n = 300\n";
    $N = 300;
}
if ( $N > 1e9 ) {
    echo "\nWarning! N is too big (> 1e9)! Using default n = 300\n";
    $N = 300;
}
if ( $file_in === '' ) {
    echo "\nError! Missing input file! (use -f or --file to specify it)\n";
    die( show_help() );
}
if ( $file_out === '' ) {
    $file_out = 'result-' . $N . '.txt';
}

save_file( $file_out, ad_generator_cli( $N, $file_in ) );

function ad_generator_cli( $max_res, $filename ) {
    $result_text = '';
    $ad_text = read_file( $filename );
    $ad_text = str_replace( '\\\\', '\\', $ad_text );
    $ad_text = str_replace( '\\"', '"', $ad_text );
    $ad_text = str_replace( "\\'", "'", $ad_text );

    if ( $ad_text ) {
        require_once 'includes/Randomizer.php';
        $tRand = new Randomizer( $ad_text );
        $num_var = $tRand->numVariant();

        if ( $num_var > 1 ) {
            $max_tmp = min( $num_var, $max_res );
            $result_text .= sprintf(
                "The number of all possible variants: %s. Here are %s random ones:\n\n",
                $num_var,
                $max_tmp
            );

            for ( $i = 0; $i < $max_tmp; ++$i ) {
                $result_text .= $tRand->getText() . "\n\n\n";
            }
        } else {
            $result_text .= "Only 1 possible variant:\n\n";
            $result_text .= $tRand->getText();
        }
    }

    $result_text = preg_replace( "/\n /", "\n", trim( $result_text ) );
    $result_text = preg_replace( "/ \n/", "\n", $result_text );
    return $result_text;
}

exit(0);
