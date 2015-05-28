<?php

return;

exec( '/usr/local/bin/speedtest-cli --simple --share', $results );

if ( count( $results ) < 3 ) {
	print_r($results);
	die;
}

$o = array(
	'timestamp' => date('Y-m-d H:i'),
);

foreach ( $results as $line ) {
	$set = explode( ':', $line, 2 );
	$key = str_replace( ' ', '_', strtolower( trim( $set[0] ) ) );

	$o[ $key ] = trim( $set[1] );
}

$filename = sprintf(
	'%s/logs/lmt/%s.csv',
	__DIR__,
	date('Ymd')
);

file_put_contents( $filename, implode( ',', array_values($o) ) . PHP_EOL, FILE_APPEND );

print_r($o);
