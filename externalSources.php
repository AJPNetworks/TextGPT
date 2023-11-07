<?php

// Basic Chat Response -- pass through model, ai style, and prompt content
function getGPTReply($textMessage, $model, $aiStyle) {

    global $apiKey;

    $postData = [
        'model' => $model,
        'messages' => [
            [
                'role' => 'system',
                'content' => $aiStyle,
            ],
            [
                'role' => 'user',
                'content' => $textMessage,
            ]
        ]
    ];

    $ch = curl_init('https://api.openai.com/v1/chat/completions');

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', "Authorization: Bearer $apiKey"]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        throw new Exception(curl_error($ch));
    }

    curl_close($ch);

    $responseData = json_decode($response, true);

    if (isset($responseData['choices']) && !empty($responseData['choices'])) {

        $content = $responseData['choices'][0]['message']['content'];
        return $content;

    } else {
        return false;
    }
}



// Image Generation
function imageGenByPrompt($textMessage) {
    
    global $apiKey;
    global $imageGenSize;

    $postData = [
        'prompt' => $textMessage,
        'size' => $imageGenSize,
        'response_format' => 'b64_json',
        'n' => 1,
    ];

    $ch = curl_init('https://api.openai.com/v1/images/generations');

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', "Authorization: Bearer $apiKey"]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        throw new Exception(curl_error($ch));
    }

    curl_close($ch);

    $responseData = json_decode($response, true);

    if (isset($responseData['data']) && !empty($responseData['data'])) {

        $imageData = $responseData['data'][0]['b64_json'];
        return $imageData;

    } else {
        return false;
    }
}




// Audio Generation
function audioGenByPrompt($textMessage) {

    return base64_encode("Audio generation is currently not working");

}