<?php
    // parameters
    $access_token = "EAAFww0kN59EBAEtxHyoq0aaiETu3rhAOPo4AttIed5GlxVWrSabcP12fMibiO042XHeKs5oo5Vub95bS2cmtsYNDIyM0JWbz9QNZCPLcO2XlKjUfVVeYV9Ni9ZBGDfQPyCtDHUnCwFutweMnLD4o1U67WSgp3iOratgwa2nAZDZD";
    $verify_token = "skylakebotfacebook";
    $hub_verify_token = null;
    if(isset($_REQUEST['hub_challenge'])) {
     $challenge = $_REQUEST['hub_challenge'];
     $hub_verify_token = $_REQUEST['hub_verify_token'];
    }
    if ($hub_verify_token === $verify_token) {
     echo $challenge;
    }

    // handle bot's anwser
    $input = json_decode(file_get_contents('php://input'), true);

    $senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
    $messageText = $input['entry'][0]['messaging'][0]['message']['text'];
    $message_to_reply = '';

    
    if($messageText == "hi") {
        $message_to_reply = "Hello";
    }
    else
    {
        $message_to_reply = "I don't understand. Ask me 'hi'.".$senderId;
    }
        $jsonData = '{
            "recipient":{
                "id":"'.$senderId.'"
            },
            "message":{
                "text":"'.$message_to_reply.'"
            }
        }';
    //Encode the array into JSON.
    $jsonDataEncoded = $jsonData;
    $ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$access_token);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    if(!empty($input['entry'][0]['messaging'][0]['message'])){
        $result = curl_exec($ch);
    }


?>
