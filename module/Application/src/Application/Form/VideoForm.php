<?php

namespace Application\Form;

use Zend\Form\Element\Time;
use Zend\Form\Form;

class VideoForm extends Form {

    protected $videoTable;

    public function __construct($name = null) {
        parent::__construct('video');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('role', 'form');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'data_adicionada',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'titulo',
            'type' => 'Text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Titulo'
            )
        ));
        $this->add(array(
            'name' => 'tamanho',
            'type' => 'Text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Tamanho'
            )
        ));
        /*
          $this->add(array(
          'type' => 'Zend\Form\Element\Time',
          'name' => 'tamanho',
          'attributes' => array(
          'min' => '00:00:00',
          'max' => '23:59:00',
          'step' => '60', // seconds; default step interval is 60 seconds
          )
          )); */
        $this->add(array(
            'name' => 'url',
            'type' => 'Text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Url de video'
            ),
        ));
        /*
          $this->add(array(
          'name' => 'perfil_id',
          'type' => 'Select',
          'attributes' => array(
          'options' => $this->getValueOptions()
          ),
          )); */
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Salvar',
                'id' => 'submitbutton',
                'class' => 'btn btn-default'
            ),
        ));
    }

    private function getVideoTable() {
        if (!$this->videoTable) {
            $sm = $GLOBALS['sm'];
            $this->videoTable = $sm->get('Application\Model\VideoTable');
        }
        return $this->videoTable;
    }

    private function getValueOptions() {
        $valueOptions = array("" => "Selectione");
        $videos = $this->getVideoTable()->fetchAll();

        foreach ($videos as $video) {
            $valueOptions[$video->id] = $video->nome;
        }
        return $valueOptions;
    }

}
