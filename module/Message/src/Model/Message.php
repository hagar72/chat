<?php
namespace Message\Model;

class Message
{
    public $id;
    public $message;
    public $created;

    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->message = !empty($data['message']) ? $data['message'] : null;
        $this->created  = new \DateTime();
    }
}