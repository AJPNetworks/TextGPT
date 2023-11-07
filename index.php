<?php

require_once __DIR__ . "/variables.php";
require_once __DIR__ . "/externalSources.php";



$reponseType = $defaultResponseType;
$response = $defaultResponse;


// I would do a POST method here which is what I wanted to, but for some reason the shortcuts app on iPhone wont send a post request, hits the server as a GET request no matter what and I dont know why.
$textMessage = $_GET['textMessage'] ?? null;



// Decodes the textMessage input and creates a parsed version with only letters and numbers for phrase matching
// As of right now, the message is not coming as base64 since for some reason it messes with emojis
//$textMessage = base64_decode($textMessage);



// Checks if a custom style is provided, anywhere in the string can have @style ... @end .. Between these is the style thats sent in the AI prompt, mess
list($defaultStyle, $textMessage) = extractStyle($textMessage, $defaultStyle);





// message starts with /gpt4
if (substr($textMessage, 0, 5) === "/gpt4") {
    $response = getGPTReply($textMessage, $gpt4Model, $gpt4Style);

    if ($response) {
        $reponseType = "plain";
    } else {
        $response = "There was an error in the API response. Try again later.";
    }


// message starts with /image
} elseif (substr($textMessage, 0, 6) === "/image") {

    list($imageGenSize, $textMessage) = extractCustomOption($textMessage, $imageGenSize, "imgSize");

    $response = base64_decode(imageGenByPrompt(($pos = strpos($textMessage, ':')) !== false ? substr($textMessage, $pos + 1) : $textMessage));

    if ($response) {
        $reponseType = "base64Image";
    } else {
        $response = "There was an error in the API response. Try again later.";
    }

// message starts with /audio
} elseif(substr($textMessage, 0, 6) === "/audio") {
    $response = base64_decode(audioGenByPrompt(($pos = strpos($textMessage, ':')) !== false ? substr($textMessage, $pos + 1) : $textMessage));
    
    if ($response) {
        $reponseType = "base64Audio";
    } else {
        $response = "There was an error in the API response. Try again later.";
    }



} else {


    // Default response handling
    $response = getGPTReply($textMessage, $defaultModel, $defaultStyle);

    if (!$response) {
        $response = "There was an error in the API response. Try again later.";
    }
    
}



output("G");



function extractStyle($inputString, $defaultStyle) {

    $stylePattern = "/\@style(.*?)\@end/s";
    $style = $defaultStyle;
    $restOfString = $inputString;

    if (preg_match($stylePattern, $inputString, $matches)) {

        $style = $matches[1];
        $restOfString = preg_replace($stylePattern, '', $inputString);
    }
    
    return [$style, $restOfString];
}

function extractCustomOption($inputString, $defaultStyle, $start) {

    $stylePattern = "/\@$start(.*?)\@end/s";
    $style = $defaultStyle;
    $restOfString = $inputString;

    if (preg_match($stylePattern, $inputString, $matches)) {

        $style = $matches[1];
        $restOfString = preg_replace($stylePattern, '', $inputString);
    }
    
    return [$style, $restOfString];
}



// Function that actually outputs the appropriate JSON response
function output($GorB = false) {
    $status = ($GorB === "G") ? "success" : "failed";

    global $reponseType;
    global $response;

    header("Content-Type: Application/JSON");

    echo json_encode(array(
        "status"=>$status,
        "responseType"=>$reponseType,
        "responseContent"=>base64_encode($response)
    ));

    exit;
}














// Saved for later

function extractStylePreset($inputString, $defaultStyle) {

    $stylePattern = "/\@stylePreset(.*?)\@end/s";
    $style = $defaultStyle;
    $restOfString = $inputString;


    if (preg_match($stylePattern, $inputString, $matches)) {

        $style = $matches[1];
        $restOfString = preg_replace($stylePattern, '', $inputString);
    }
    
    return [$style, $restOfString];
}