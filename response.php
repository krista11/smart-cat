<?php

$response = array(
    "messages" => array(
        "speech" => "This is webhook",
        "type" => 0
    ),
);

{
    "responseId": "f0a877a1-6726-446d-8786-7ca8e35343a2-19db3199",
    "queryResult": {
      "queryText": "i farted",
      "parameters": {
        "activity": "fart"
      },
      "allRequiredParamsPresent": true,
      "fulfillmentMessages": [
        {
          "text": {
            "text": [
              ""
            ]
          }
        }
      ],
      "outputContexts": [
        {
          "name": "projects/device-listener-kaeuco/agent/sessions/3e637eb5-df47-9afa-fabd-6474ab6eee70/contexts/__system_counters__",
          "parameters": {
            "no-input": 0,
            "no-match": 0,
            "activity": "fart",
            "activity.original": "farted"
          }
        }
      ],
      "intent": {
        "name": "projects/device-listener-kaeuco/agent/intents/7569a22e-0dcb-4c35-83c8-c203cc6df100",
        "displayName": "open a webhook"
      },
      "intentDetectionConfidence": 1,
      "languageCode": "en"
    },
    "originalDetectIntentRequest": {
      "payload": {}
    },
    "session": "projects/device-listener-kaeuco/agent/sessions/3e637eb5-df47-9afa-fabd-6474ab6eee70"
  }
?>