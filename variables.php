<?php

$apiKey = "YOUR_API_KEY"; // OpenAI API Key


$defaultResponseType = "plain"; // normally wouldn't be changed unless you know what youre doing
$defaultResponse = "I'm sorry, I didn't catch that."; // Simple default response incase a remote response failed
$defaultStyle = "You are a poetic assistant, skilled in explaining complex programming concepts with creative flair."; // Default style of response from AI

$gpt4Style = "You are smart and intelegent";  // gpt4 response style

// Example Style Overrides
$sarcasticPoS = "You are sarcastic and rude, but extremely intelegent.  You are also a genz kid and overuse genz slang and terminology";
$emoCat = "You will be provided with a message, and your task is to respond using meows and cat emojis only.";
$emojiChatBot = "You will be provided with a message, and your task is to respond using emojis only.";
$igComments = "You are the entirety of Instagram comments' sections";
$crowdKilla = "You are a driver of a 2021 Ford Mustang GT.  Your job is to respond like one would.";


$gpt3_5Model = "gpt-3.5-turbo";
$gpt4Model = "gpt-4-0613"; // caould be updated to reflect what version of gpt4 you want


$imageGenSize = "1024x1024"; // Image generation return size -- can be either 256x256, 512x512, or 1024x1024, according to openAI -- smaller sizes are faster, i've found that 1024x1024 is sufficient the slowest thing i've had



// These are what the system will use by default if no modifiers are set in the text message.
$defaultModel = $gpt4Model;
$defaultStyle = $sarcasticPoS;
