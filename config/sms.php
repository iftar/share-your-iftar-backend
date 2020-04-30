<?php

return [
  'enabled' => env('SMS_ENABLED', true),
  'api_key' => env('SMS_API_KEY'),
  'originator_number' => env('SMS_ORIGINATOR_NUMBER'),
];
