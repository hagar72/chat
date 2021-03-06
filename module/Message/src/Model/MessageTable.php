<?php
namespace Message\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\Sql\Select;
use Zend\Stdlib\ArrayUtils;

class MessageTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select(function (Select $select) {
            $select->order('created DESC')->limit(10);
        });
    }
    
    public function fetchAllToArray() {
        $results = $this->fetchAll();
        return ArrayUtils::iteratorToArray($results);
    }

    public function getMessage($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveMessage(Message $message)
    {
        $data = [
            'message' => $message->message,
            'created'  => $message->created,
        ];

        $id = (int) $message->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getMessage($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update message with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteOlderMessages()
    {
        $messages = $this->tableGateway->select(function (Select $select) {
            $select->order('created DESC')->limit(10)->offset(10);
        });
        
        foreach ($messages as $message) {
            $this->tableGateway->delete(['id' => (int) $message->id]);
        }
    }
}