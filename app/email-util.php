<?php
//////////////////////
// Class for Email (via SendGrid)
//////////////////////
class comm_builder_send_email {
	public function sendEmail($email_address, $subject, $message) {
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.sendgrid.com/v3/mail/send",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{ \"personalizations\": "
										."[ {"
											."\"to\": [ { \"email\": \"".$email_address."\" } ],"
											."\"subject\": \"".$subject."\" "
										."} ],"
										."\"from\": { \"email\": \"admin@".$GLOBALS['org_domain']."\" },"
										."\"content\": [ { \"type\": \"text/html\","
											."\"value\": \"".$message."\" "
											."} ] "
									."}",
			CURLOPT_HTTPHEADER => array(
				"authorization: Bearer ".$GLOBALS['sendgrid_api_key'],
				"cache-control: no-cache",
				"content-type: application/json"
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		// Return either the error or the response
		if ($err) {
			return $err;
		} else {
			return $response;
		}
	}
}
?>