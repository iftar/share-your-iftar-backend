<?php

namespace App\Services\All;

use MessageBird\Client as Client;
use MessageBird\Objects\Message as Message;

class SmsService
{
    public function __construct()
    {
        $this->enabled = config('sms.enabled');
        $this->messagebird = new Client( config('sms.api_key') );
        $this->originator_number = config('sms.originator_number');
    }

    public function sendMessage($to, $body)
    {
        if( ! $this->enabled ) return false;

        $message = new Message();
        $message->originator = $this->originator_number;
        $message->recipients = [ $to ];
        $message->body = $body;

        $response = $this->messagebird->messages->create($message);
        return $response;
    }
}
