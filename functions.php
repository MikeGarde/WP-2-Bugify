<?php
function get_remote_file($url, $method='GET') {
	echo 'getting file: '.$url;
// get the host name and url path
	$parsedUrl = parse_url($url);
	$host = $parsedUrl['host'];
	if (isset($parsedUrl['path'])) {
		$path = $parsedUrl['path'];
	} else {
		// the url is pointing to the host like http://www.mysite.com
		$path = '/';
	}

	if (isset($parsedUrl['query'])) {
		$path .= '?' . $parsedUrl['query'];
	}

	if (isset($parsedUrl['port'])) {
		$port = $parsedUrl['port'];
	} else {
		$port = '80';
	}

	$timeout = 10;
	$response = '';
	// connect to the remote server
	$fp = @fsockopen($host, '80', $errno, $errstr, $timeout );

	if( !$fp ) {
		echo "Cannot retrieve $url";
	} else {
		$headers =	$method .' '. $path .' HTTP/1.0'.PHP_EOL.
					'Host: '.$host.PHP_EOL.
					'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.0.3) Gecko/20060426 Firefox/1.5.0.3'.PHP_EOL.
					'Accept: */*'.PHP_EOL.
					'Accept-Language: en-us,en;q=0.5'.PHP_EOL.
					'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7'.PHP_EOL.
					'Keep-Alive: 300'.PHP_EOL.
					'Connection: keep-alive'.PHP_EOL.
					'Referer: http://localhost/'.PHP_EOL.PHP_EOL;

		fputs($fp, $headers);

		while ( $line = fread( $fp, 4096 ) ) {
			$response .= $line;
		}

		fclose( $fp );

		// strip the headers
		$pos      = strpos($response, "\r\n\r\n");
		$response = substr($response, $pos + 4);
	}

	// return the file content
	return $response;
}