<?php

header('Content-Type: text/html; charset=utf-8');

// $postfields =  "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:voic=\"http://voiceinteraction.pt\">\n   <soapenv:Header/>\n   <soapenv:Body>\n      <voic:get>\n         <Login>\n            <userName>info4ws</userName>\n            <password>info4360ws</password>\n         </Login>\n         <request>\n            <!--<hash>855983532</hash>-->\n            <!--<taskIdCreator>1093573680534824</taskIdCreator>-->\n            <source>SBT - RJ</source>\n            <startDate>1499850100000</startDate>\n            <endDate>1499850110000</endDate>\n            <!--<taskIdCreator>1089973838390171</taskIdCreator>-->\n         </request>\n      </voic:get>\n   </soapenv:Body>\n</soapenv:Envelope>";

$postfields =	'<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:voic="http://voiceinteraction.pt">
					<soapenv:Header/>
					<soapenv:Body>
						<voic:get>
							<Login>
								<userName>info4ws</userName>
								<password>info4360ws</password>
							</Login>
							<request>
								<source>SBT - RJ</source>
								<startDate>1499850100000</startDate>
								<endDate>1499850110000</endDate>
							</request>
						</voic:get>
					</soapenv:Body>
				</soapenv:Envelope>';

$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_PORT => "8030",
	CURLOPT_URL => "http://189.3.21.194:8030/MMS/WS/StoryManager",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => $postfields,
	CURLOPT_HTTPHEADER => array(
	"accept-encoding: gzip,deflate",
	"cache-control: no-cache",
	"connection: Keep-Alive",
	"content-type: application/xml",
	"postman-token: f8c05d07-403b-4782-9480-aab43b040f13",
	"soapaction: \"\""
	),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	// echo $response;
	$data = simplexml_load_string($response);
}

?>