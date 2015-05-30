<?php

$logs = glob( __DIR__ . '/logs/*/*.csv' );
$raw = array();

foreach ( $logs as $log ) {
	$handle = fopen( $log, 'r' );

	$twi = array(
		'lmt' => '#manslmt',
		'bite' => '#bitelv',
	);

	$modem = basename( dirname( $log ) );
	$twitter = $twi[ $modem ];

	while ( ( $data = fgetcsv( $handle, 1000, ',' ) ) !== false ) {
		$time = strtotime( $data[0] );

		$raw[ $modem ][] = array(
			'guid' => $modem . $time,
			'pubDate' => date( 'r', $time ),
			'title' => sprintf(
				'%s #4G mājas internets %s lejup, %s augšup un %s ping plkst. %s #speedtest',
				$twitter,
				$data[2],
				$data[3],
				$data[1],
				date( 'H:i', strtotime( $data[0] ) )
			),
			'link' => 'https://github.com/kasparsd/4g-speed-log',
			'description' => '',
		);
	}

	fclose($handle);
}

class SimpleXMLExtended extends SimpleXMLElement {
  public function addCData($name, $cdata_text) {
        $new_child = $this->addChild($name);
        $node = dom_import_simplexml($new_child); 
    $no   = $node->ownerDocument; 
    $node->appendChild($no->createCDATASection($cdata_text));
  }
}

foreach ( $raw as $feed => $items ) {

$items = array_reverse( $items );

$xml = new SimpleXMLExtended('<rss/>');
$xml->addAttribute("version", "2.0");

$channel = $xml->addChild("channel");
$channel->addChild('title', '4G Latvijā');
$channel->addChild('description', '4G mājas interneta pieslēgumu salīdzinājums Latvijā');

foreach ( $items as $item ) {
        $r = $channel->addChild("item");

        $r->addCData("title", $item['title']);
        $r->addCData("description", $item['description']);
        $r->addChild("link", $item['link']);
        $r->addChild("guid", $item['guid']);
}

$xml->asXML( __DIR__  . '/logs/' . $feed . '.xml' );

}

