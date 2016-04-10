<?php

namespace Application\Model;

use Exception;
use Zend\Db\TableGateway\TableGateway;

class VideoTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        //$select = new Select();
        /*        $select->from('usuario')
          ->columns(array('*'))
          ->join('perfil', 'usuario.perfil_id = perfil.id', array('nome_perfil' => 'nome'));
          $resultSet = $this->tableGateway->selectWith($select); */
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getVideo($id) {
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

    public function salvarVideo(Video $video) {
        $data_adicionada = empty($this->data_adicionada) ? date("Y-m-d") : $this->data_adicionada;
        $data = array(
            'titulo' => $video->titulo,
            'tamanho' => $video->tamanho,
            'url' => $video->url,
            'data_adicionada' => $data_adicionada,
                // 'perfil_id' => $usuario->perfil->id,
        );

        $id = (int) $video->id;

        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getVideo($id)) {
                $this->tableGateway->update($data, array(
                    'id' => $id
                ));
            } else {
                throw new Exception('Não existe registro com esse ID' . $id);
            }
        }
    }

    public function deletarVideo($id) {
        $this->tableGateway->delete(array(
            'id' => $id
        ));
    }

    /* public function getVideoIdentidade($login) {
      $select = new Select();
      $select->from('usuario')
      ->columns(array('id', 'nome', 'perfil_id'))
      ->where(array('login' => $login));
      $rowset = $this->tableGateway->selectWith($select);
      $row = $rowset->current();
      return $row;
      }
     */
}
