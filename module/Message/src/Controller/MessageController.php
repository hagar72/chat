<?php

namespace Message\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Message\Model\MessageTable;
use Message\Form\MessageForm;
use Message\Model\Message;
use Zend\View\Model\JsonModel;

class MessageController extends AbstractActionController
{
    private $table;

    // Add this constructor:
    public function __construct(MessageTable $table)
    {
        $this->table = $table;
    }
    
    public function indexAction()
    {
        $form = new MessageForm();
        $form->get('submit')->setValue('Send');
        
        return [
            'messages' => $this->table->fetchAll(),
            'form' => $form
        ];
    }

    public function addAction()
    {
        $form = new MessageForm();
        $form->get('submit')->setValue('Send');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $message = new Message();
        $form->setInputFilter($message->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $message->exchangeArray($form->getData());
        $this->table->saveMessage($message);
        return $this->redirect()->toRoute('message');
    }

    public function listAction()
    {
        return new JsonModel([
            'messages' => $this->table->fetchAll()
        ]);
    }

    public function deleteAction()
    {
    }
}
