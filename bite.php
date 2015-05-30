<?php

$failtouch = __DIR__ . '/.bitefailtouch';

$arp = shell_exec('ping -b -c 1 192.168.8.1 && /usr/sbin/arp -n');

if ( false === stripos( $arp, '58:7f:66:c9:45:b2' ) ) {
	syslog( LOG_ERR, 'Bite router not found' );
	die;
}

exec( 'php speedtest.php http://speedtest.bite.lv/speedtest', $results );

if ( count( $results ) < 3 ) {
	syslog( LOG_ERR, 'Bite Speedtest failed: ' . implode( '|', $results ) );
	die;
} else {
	syslog( LOG_NOTICE, 'Bite Speedtest OK: ' . implode( '|', $results ) );
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
	'%s/logs/bite/%s.csv',
	__DIR__,
	date('Ymd')
);

file_put_contents(
	$filename,
	implode( ',', array_values($o) ) . PHP_EOL,
	FILE_APPEND
);

print_r($o);
