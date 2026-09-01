<?php

require_once dirname( __DIR__ ) . '/includes/Randomizer.php';

function assert_same( mixed $expected, mixed $actual, string $message ): void {
	if ( $expected !== $actual ) {
		fwrite(
			STDERR,
			sprintf(
				"FAIL: %s\nExpected: %s\nActual: %s\n",
				$message,
				var_export( $expected, true ),
				var_export( $actual, true )
			)
		);
		exit( 1 );
	}
}

$literal = new Randomizer( 'hello' );
assert_same( 1, $literal->numVariant(), 'Literal variant count' );
assert_same( 'hello', $literal->getText(), 'Literal output' );

$alternatives = new Randomizer( '{red|green|blue}' );
assert_same( 3, $alternatives->numVariant(), 'Alternative variant count' );

for ( $i = 0; $i < 10; ++$i ) {
	if ( ! in_array( $alternatives->getText(), array( 'red', 'green', 'blue' ), true ) ) {
		fwrite( STDERR, "FAIL: Alternative output is invalid.\n" );
		exit( 1 );
	}
}

$nested = new Randomizer( '{a|b}[x|y]' );
assert_same( 4, $nested->numVariant(), 'Nested variant count' );

$escaped = new Randomizer( '\\{\\|\\}\\[\\+\\]' );
assert_same( '{|}[+]', $escaped->getText(), 'Escaped syntax output' );

$random_digit = new Randomizer( '%rand%' );
if ( 1 !== preg_match( '/^[0-9]$/', $random_digit->getText() ) ) {
	fwrite( STDERR, "FAIL: Random digit output is invalid.\n" );
	exit( 1 );
}

echo "Smoke tests passed.\n";
