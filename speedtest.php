<?php

if ( ! isset( $argv[1] ) )
	die( 'Please specify the download URL.' );

$url = rtrim( $argv[1], '/' );
$domain = parse_url( $url, PHP_URL_HOST );
$url_up = $url . '/upload.php';
$url_down = $url . '/random4000x4000.jpg';

// Make sure we have the upload file
if ( ! file_exists( __DIR__ . '/random4000x4000.jpg' ) ) {
	exec( 'curl -o ' . __DIR__ . '/random4000x4000.jpg ' . $url_down, $_o, $ok );

	if ( ! ok )
		die( 'Failed to download random4000x4000.jpg from ' . $url_down );
}

$ping = exec( 'ping -c 3 ' . $domain );
$down = exec( 'curl --interface eth0 -o /dev/null -sS -w "%{speed_download}" ' . $url_down );
$up = exec( 'curl --interface eth0 -o /dev/null -sS -w "%{speed_upload}" --form "file_box=@random4000x4000.jpg" ' . $url_up );

// Ping
preg_match( '/= (.*) ms/', $ping, $r );
$r = explode( '/', $r[1] );
$log[ 'Ping' ] = round( $r[1], 2 ) . ' ms';

// Download
$log[ 'Download' ] = round( $down * 0.000008, 2 ) . ' Mbit/s';

// Upload
$log[ 'Upload' ] = round( $up * 0.000008, 2 ) . ' Mbit/s';

// Output similar to speedtest-cli --simple
foreach ( $log as $k => $v )
	printf( "%s: %s\n", $k, $v );
