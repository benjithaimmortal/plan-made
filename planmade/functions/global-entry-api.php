<?php

class Global_Entry_Scraper {
	private $params;
	private $http_header;
	// private $endpoint;
	public  $response;

	// make the cURL request
	public static function request($url = null) {
    $api_baseurl = $url ?: "https://ttp.cbp.dhs.gov/schedulerapi/slots?orderBy=soonest&limit=100&locationId=9200&minimum=1";

		// Init cURL session
		$ch = curl_init($api_baseurl);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // // Part 1: want to see the header? (this breaks JSON-only response)
    // curl_setopt($ch, CURLOPT_HEADER, 1);

    // // Part 1: want to see the HTTP request? (this is separate from $response)
    // curl_setopt($ch, CURLINFO_HEADER_OUT, true);

    $response = curl_exec($ch);

    // // Part 2: want to see the header? (this breaks JSON-only response)
    // $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    // $header = substr($response, 0, $header_size);
    // $body = substr($response, $header_size);
    
    // // Part 2: want to see the HTTP request? (this is separate from $response)
    // $info = curl_getinfo($ch);

    curl_close($ch);

		return array(
      'timestamp' => time(),
      'response_decoded' => json_decode($response, true),
      'response' => $response,
    );
	}
}
