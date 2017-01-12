<?php
namespace Message\Form;

use Zend\Form\Form;

class MessageForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('messageForm');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'message',
            'type' => 'text',
            'options' => [
                'label' => 'Message',
            ],
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Send',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}