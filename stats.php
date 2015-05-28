<?php

$logs = glob( __DIR__ . '/logs/*/*.csv' );
$raw = array();

foreach ( $logs as $log ) {
	$handle = fopen( $log, 'r' );
	$modem = basename( dirname( $log ) );

	while ( ( $data = fgetcsv( $handle, 1000, ',' ) ) !== false ) {
		$raw[ $modem ]['timestamp'][] = $data[0];
		$raw[ $modem ]['download'][] = $data[2];
		$raw[ $modem ]['upload'][] = $data[3];
		$raw[ $modem ]['ping'][] = $data[1];
	}

	fclose($handle);
}

$totals = array();

foreach ( $raw as $modem => $logs ) {
	$totals = array(
		'download' => array_sum( $logs['download'] ) / count( $logs['download'] ),
		'upload' => array_sum( $logs['upload'] ) / count( $logs['upload'] ),
		'ping' => array_sum( $logs['ping'] ) / count( $logs['ping'] ),
	);

	$totals = array_map( 'round', $totals );

	file_put_contents( __DIR__ . '/logs/' . $modem . '.json', json_encode( array(
		'updated' => date('Y-m-d H:i'),
		'totals' => $totals,
		'log' => $logs
	), JSON_PRETTY_PRINT ) );
}
