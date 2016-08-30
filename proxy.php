<?php

/* Config */

$upstream_base_url = 'http://127.0.0.1:9000';
$timeout = 5; // seconds
$latency = 0; // simulate latency; seconds


/* Read incoming request */

$request_method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];

$request_headers = getallheaders();
$request_headers['Host']=parse_url($upstream_base_url, PHP_URL_HOST);
$request_headers['X-forwarded-Host']=$_SERVER['HTTP_HOST'];
$request_headers['X-forwarded-Host']=$_SERVER['HTTP_HOST'];
$request_headers['X-forwarded-For']=$_SERVER['HTTP_HOST'];

$request_body = file_get_contents('php://input');


/* Simulate latency */

if ($latency) {
	sleep($latency);
}


/* Forward request */

$url = $upstream_base_url . $request_uri;
$headers = array();
foreach ($request_headers as $key => $value) {
	$headers[] = $key . ': ' . $value;
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request_method);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if ($response === false) {
	header('HTTP/1.1 502 Bad Gateway');
	header('Content-Type: text/plain');
	echo 'Upstream host did not respond.';
} else {
	$header_length = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$response_headers = explode("\n", substr($response, 0, $header_length));
	$response_body = substr($response, $header_length);

	foreach ($response_headers as $i => $header) {

		if($header = trim($header)){
			
			header($header);
		}
	}
	
	$mimet = array(	
	'ai' =>'application/postscript',
	'aif' =>'audio/x-aiff',
	'aifc' =>'audio/x-aiff',
	'aiff' =>'audio/x-aiff',
	'asc' =>'text/plain',
	'atom' =>'application/atom+xml',
	'avi' =>'video/x-msvideo',
	'bcpio' =>'application/x-bcpio',
	'bmp' =>'image/bmp',
	'cdf' =>'application/x-netcdf',
	'cgm' =>'image/cgm',
	'cpio' =>'application/x-cpio',
	'cpt' =>'application/mac-compactpro',
	'crl' =>'application/x-pkcs7-crl',
	'crt' =>'application/x-x509-ca-cert',
	'csh' =>'application/x-csh',
	'css' =>'text/css',
	'dcr' =>'application/x-director',
	'dir' =>'application/x-director',
	'djv' =>'image/vnd.djvu',
	'djvu' =>'image/vnd.djvu',
	'doc' =>'application/msword',
	'dtd' =>'application/xml-dtd',
	'dvi' =>'application/x-dvi',
	'dxr' =>'application/x-director',
	'eps' =>'application/postscript',
	'etx' =>'text/x-setext',
	'ez' =>'application/andrew-inset',
	'gif' =>'image/gif',
	'gram' =>'application/srgs',
	'grxml' =>'application/srgs+xml',
	'gtar' =>'application/x-gtar',
	'hdf' =>'application/x-hdf',
	'hqx' =>'application/mac-binhex40',
	'html' =>'text/html',
	'html' =>'text/html',
	'ice' =>'x-conference/x-cooltalk',
	'ico' =>'image/x-icon',
	'ics' =>'text/calendar',
	'ief' =>'image/ief',
	'ifb' =>'text/calendar',
	'iges' =>'model/iges',
	'igs' =>'model/iges',
	'jpe' =>'image/jpeg',
	'jpeg' =>'image/jpeg',
	'jpg' =>'image/jpeg',
	'js' =>'application/x-javascript',
	'kar' =>'audio/midi',
	'latex' =>'application/x-latex',
	'm3u' =>'audio/x-mpegurl',
	'man' =>'application/x-troff-man',
	'mathml' =>'application/mathml+xml',
	'me' =>'application/x-troff-me',
	'mesh' =>'model/mesh',
	'mid' =>'audio/midi',
	'midi' =>'audio/midi',
	'mif' =>'application/vnd.mif',
	'mov' =>'video/quicktime',
	'movie' =>'video/x-sgi-movie',
	'mp2' =>'audio/mpeg',
	'mp3' =>'audio/mpeg',
	'mpe' =>'video/mpeg',
	'mpeg' =>'video/mpeg',
	'mpg' =>'video/mpeg',
	'mpga' =>'audio/mpeg',
	'ms' =>'application/x-troff-ms',
	'msh' =>'model/mesh',
	'mxu m4u' =>'video/vnd.mpegurl',
	'nc' =>'application/x-netcdf',
	'oda' =>'application/oda',
	'ogg' =>'application/ogg',
	'pbm' =>'image/x-portable-bitmap',
	'pdb' =>'chemical/x-pdb',
	'pdf' =>'application/pdf',
	'pgm' =>'image/x-portable-graymap',
	'pgn' =>'application/x-chess-pgn',
	'php' =>'application/x-httpd-php',
	'php4' =>'application/x-httpd-php',
	'php3' =>'application/x-httpd-php',
	'phtml' =>'application/x-httpd-php',
	'phps' =>'application/x-httpd-php-source',
	'png' =>'image/png',
	'pnm' =>'image/x-portable-anymap',
	'ppm' =>'image/x-portable-pixmap',
	'ppt' =>'application/vnd.ms-powerpoint',
	'ps' =>'application/postscript',
	'qt' =>'video/quicktime',
	'ra' =>'audio/x-pn-realaudio',
	'ram' =>'audio/x-pn-realaudio',
	'ras' =>'image/x-cmu-raster',
	'rdf' =>'application/rdf+xml',
	'rgb' =>'image/x-rgb',
	'rm' =>'application/vnd.rn-realmedia',
	'roff' =>'application/x-troff',
	'rtf' =>'text/rtf',
	'rtx' =>'text/richtext',
	'sgm' =>'text/sgml',
	'sgml' =>'text/sgml',
	'sh' =>'application/x-sh',
	'shar' =>'application/x-shar',
	'shtml' =>'text/html',
	'silo' =>'model/mesh',
	'sit' =>'application/x-stuffit',
	'skd' =>'application/x-koan',
	'skm' =>'application/x-koan',
	'skp' =>'application/x-koan',
	'skt' =>'application/x-koan',
	'smi' =>'application/smil',
	'smil' =>'application/smil',
	'snd' =>'audio/basic',
	'spl' =>'application/x-futuresplash',
	'src' =>'application/x-wais-source',
	'sv4cpio' =>'application/x-sv4cpio',
	'sv4crc' =>'application/x-sv4crc',
	'svg' =>'image/svg+xml',
	'swf' =>'application/x-shockwave-flash',
	't' =>'application/x-troff',
	'tar' =>'application/x-tar',
	'tcl' =>'application/x-tcl',
	'tex' =>'application/x-tex',
	'texi' =>'application/x-texinfo',
	'texinfo' =>'application/x-texinfo',
	'tgz' =>'application/x-tar',
	'tif' =>'image/tiff',
	'tiff' =>'image/tiff',
	'tr' =>'application/x-troff',
	'tsv' =>'text/tab-separated-values',
	'txt' =>'text/plain',
	'ustar' =>'application/x-ustar',
	'vcd' =>'application/x-cdlink',
	'vrml' =>'model/vrml',
	'vxml' =>'application/voicexml+xml',
	'wav' =>'audio/x-wav',
	'wbmp' =>'image/vnd.wap.wbmp',
	'wbxml' =>'application/vnd.wap.wbxml',
	'wml' =>'text/vnd.wap.wml',
	'wmlc' =>'application/vnd.wap.wmlc',
	'wmlc' =>'application/vnd.wap.wmlc',
	'wmls' =>'text/vnd.wap.wmlscript',
	'wmlsc' =>'application/vnd.wap.wmlscriptc',
	'wmlsc' =>'application/vnd.wap.wmlscriptc',
	'wrl' =>'model/vrml',
	'xbm' =>'image/x-xbitmap',
	'xht' =>'application/xhtml+xml',
	'xhtml' =>'application/xhtml+xml',
	'xls' =>'application/vnd.ms-excel',
	'xml xsl' =>'application/xml',
	'xpm' =>'image/x-xpixmap',
	'xslt' =>'application/xslt+xml',
	'xul' =>'application/vnd.mozilla.xul+xml',
	'xwd' =>'image/x-xwindowdump',
	'xyz' =>'chemical/x-xyz',
	'zip' =>'application/zip'
	);
 
	$mime_type = '';
	
	$path=parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
	
	if($path!=''){
		
		$ext=pathinfo($path, PATHINFO_EXTENSION);

		if(isset($mimet[$ext])){
			
			$mime_type = $mimet[$ext];
		}		
	}
	
	if($mime_type !=''){
		
		header('Content-type: '.$mime_type);
	}
	
	
	header_remove("Transfer-Encoding");
	
	echo $response_body;
}

curl_close($ch);
flush();
exit;
die;
