<?php

$arp = shell_exec('ping -b -c 1 192.168.1.1 && /usr/sbin/arp -n');

if ( false === stripos( $arp, '38:f8:89:01:e2:d0' ) ) {
	syslog( LOG_ERR, 'LMT router not found' );
	die;
}

exec( 'php speedtest.php http://speedtest.lmt.lv/speedtest', $results );

if ( count( $results ) < 3 ) {
	syslog( LOG_ERR, 'LMT Speedtest failed: ' . implode( '|', $results ) );
	die;
} else {
	syslog( LOG_NOTICE, 'LMT Speedtest OK: ' . implode( '|', $results ) );
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
