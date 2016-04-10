<?php

namespace Application\Model;

use Exception;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class CanalTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $select = new Select();
        $select->from('canal')
                ->columns(array('*'));
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet;
    }

    public function getCanal($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array(
            'id' => $id
        ));
        $row = $rowset->current();
        if (!$row) {
            throw new Exception("Não existe linha no banco para este id $id");
        }
        return $row;
    }

    public function salvarCanal(Canal $canal) {
        $data = array(
            'nome' => $canal->nome,
            'url' => $canal->url
        );

        $id = (int) $canal->id;

        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getCanal($id)) {
                $this->tableGateway->update($data, array(
                    'id' => $id
                ));
            } else {
                throw new Exception('Não existe registro com esse ID' . $id);
            }
        }
    }

    public function deletarCanal($id) {
        $this->tableGateway->delete(array(
            'id' => $id
        ));
    }

}
