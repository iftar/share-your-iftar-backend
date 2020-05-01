<?php

namespace App\Notifications;

class SmsMessage
{
    public $message = [];

    public $phoneNumbers = [];

    public function line($line)
    {
        $this->message[] = $this->formatLine($line);

        return $this;
    }

    public function emptyLine()
    {
        $this->message[] = "";

        return $this;
    }

    public function formatLine($line)
    {
        return trim($line);
    }

    public function getMessage()
    {
        return join("\n", $this->message);
    }

    public function hasMessage()
    {
        return count($this->message) > 0;
    }

    public function addPhoneNumber($phoneNumber)
    {
        $this->phoneNumbers[] = $phoneNumber;

        return $this;
    }

    public function getPhoneNumbers()
    {
        return $this->phoneNumbers;
    }

    public function hasPhoneNumbers()
    {
        return count($this->phoneNumbers) > 0;
    }
}
