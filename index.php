<?php

if (isset($_GET['hub_mode']) && isset($_GET['hub_challenge']) && isset($_GET['hub_verify_token'])) {
    if ($_GET['hub_verify_token'] == 'skylakebotfacebook')
        echo $_GET['hub_challenge'];
} else {
    // parameters
   // $hubVerifyToken = 'skylakebotfacebook';
    $accessToken = "EAAFww0kN59EBABCPxeZBYkPOLMMbX1gNCVYIP9uQlan9vZBCWCdrOEoIHb2G8wzFJP2LZAjFSJ1gMpDHqrxsZAWpToZBefmjA9XH2ZBoKAIZCoLF9ApEEa9GP7uaHI82wCeHuvVdLNIL9dG52Hrl0kN0aNCgRfxMwoVOMZBX23YQippqaZCU6eBze";

    // check token at setup
    // if ($_REQUEST['hub_verify_token'] === $hubVerifyToken) {
    // echo $_REQUEST['hub_challenge'];
    

    // handle bot's anwser
    $input = json_decode(file_get_contents('php://input'), true);

    $senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
    $messageText = $input['entry'][0]['messaging'][0]['message']['text'];


    $answer = "I don't understand. Ask me 'hi'.".$senderId;
    if($messageText == "hi") {
        $answer = "Hello";
    }
    else
    {

    $response = [
        'recipient' => [ 'id' => $senderId ],
        'message' => [ 'text' => $answer ]
    ];
    // $ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken);
    // curl_setopt($ch, CURLOPT_POST, 1);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
    // curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $response = curl_exec($ch);
    curl_close($ch);

    exit;
    }
}
http_response_code(200);
?>
