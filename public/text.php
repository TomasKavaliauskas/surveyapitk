<?php
$opts = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept-language: en\r\n" .
              "Cookie: foo=bar\r\n" .
              "User-agent: BROWSER-DESCRIPTION-HERE\r\n" .
			  "token: TOKEN\r\n"
  )
);

$context = stream_context_create($opts);

// Open the file using the HTTP headers set above
$file = file_get_contents('http://surveyapi.tk/target.php', false, $context);

print_r($file);