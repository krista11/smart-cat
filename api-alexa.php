<?php

// Get raw POST data
$post = file_get_contents( 'php://input' );

// Decode the JSON into a stdClass object
$post = json_decode( $post );
var_dump($post);
$data = array (
    'version' => '1.0',
    'sessionAttributes' => 
    array (
      'supportedHoroscopePeriods' => 
      array (
        'daily' => true,
        'weekly' => false,
        'monthly' => false,
      ),
    ),
    'response' => 
    array (
      'outputSpeech' => 
      array (
        'type' => 'PlainText',
        'text' => 'Today will provide you a new learning opportunity.  Stick with it and the possibilities will be endless. Can I help you with anything else?',
      ),
      'card' => 
      array (
        'type' => 'Simple',
        'title' => 'Horoscope',
        'content' => 'Today will provide you a new learning opportunity.  Stick with it and the possibilities will be endless.',
      ),
      'reprompt' => 
      array (
        'outputSpeech' => 
        array (
          'type' => 'PlainText',
          'text' => 'Can I help you with anything else?',
        ),
      ),
      'shouldEndSession' => false,
    ),
);

$response = json_encode($data);
echo $response;


?>