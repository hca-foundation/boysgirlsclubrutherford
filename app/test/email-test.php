<?php
	// Title
	echo "Testing Email";

	// Error display
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	// Setup Globals and connections
	include_once '../global.php';
	
	$curl = curl_init();
	$name = "Jeremiah"; //$_POST['name']; 
	$email = "jeremiah.weedenwright@gmail.com"; //$_POST['email']; 
	$subject = "SendGrid Test"; //$_POST['subject']; 
	$message = "This is a test from npcb"; //$_POST['message'];

	echo "No Class Approach";
	curl_setopt_array($curl, array(
		CURLOPT_URL => "https://api.sendgrid.com/v3/mail/send",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "{\n  \"personalizations\": [\n    {\n      \"to\": [\n        {\n          \"email\": \"jeremiah.weedenwright@gmail.com\"\n        }\n      ],\n      \"subject\": \"New Contact\"\n    }\n  ],\n  \"from\": {\n    \"email\": \"test-email@npcb-tester.com\"\n  },\n  \"content\": [\n    {\n      \"type\": \"text/html\",\n      \"value\": \"$name<br>$email<br>$subject<br>$message\"\n    }\n  ]\n}",
		CURLOPT_HTTPHEADER => array(
			"authorization: Bearer ".$GLOBALS['sendgrid_api_key'],
			"cache-control: no-cache",
			"content-type: application/json"
		),
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	//header('Location: thanks.html');
	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		echo $response;
	}

	echo "Class Approach";
	$results = $email_util->sendEmail("admin@".$GLOBALS['org_domain'], "Let's do this", "I hope this worked...");
	echo $results;
?>