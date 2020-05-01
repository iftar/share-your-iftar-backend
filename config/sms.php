<?php

return [
  'enabled' => env('SMS_ENABLED', false),
  'api_key' => env('SMS_API_KEY'),
  'originator_number' => env('SMS_ORIGINATOR_NUMBER'),
];
