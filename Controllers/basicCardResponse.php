<?php
function basicCardResponse(){

    return array (
      'fulfillmentText' => 'Successful',
      'payload' => 
      array (
        'google' => 
        array (
          'expectUserResponse' => true,
          'richResponse' => 
          array (
            'items' => 
            array (
              0 => 
              array (
                'simpleResponse' => 
                array (
                  'textToSpeech' => 'Here\'s Bossy Cat Notes.',
                ),
              ),
              1 => 
              array (
                'basicCard' => 
                array (
                  'title' => 'Bossy Cat Notes',
                  'subtitle' => 'Here you can see all your devices.',
                  'image' => 
                  array (
                    'url' => 'https://057001a1.ngrok.io/bossy-cat/images/pijus.jpg',
                    'accessibilityText' => 'My Bossy Cat'
                  ),
                  'buttons' => 
                  array (
                    0 => 
                    array (
                      'title' => 'Open',
                      'openUrlAction' => 
                      array (
                        'url' => 'https://057001a1.ngrok.io/bossy-cat',
                      ),
                    ),
                  ),
                  'imageDisplayOptions' => 'CROPPED',
                ),
              ),
            ),
          ),
        ),
      ),
    );
}
?>