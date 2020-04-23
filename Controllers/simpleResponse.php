<?php
function simpleResponse($text){

    $response = array (
        'fulfillmentText' => $text,
        'payload' => array (
            'google' => array (
                'expectUserResponse' => true,
                'richResponse' => array (
                    'items' => array (
                        0 =>  array (
                            'simpleResponse' => array (
                                'textToSpeech' => $text,
                                'textToDisplay' => $text
                            ),
                        ),
                    ),
                ),
            ),
        ),
    );
    return $response;
}
?>