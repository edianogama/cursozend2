<?php

namespace Application\Model;

use Exception;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;

class Video {

    public $id;
    public $titulo;
    public $tamanho;
    public $url;
    public $data_adicionada;
    private $inputFilter;

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->titulo = (isset($data['titulo'])) ? $data['titulo'] : null;
        $this->tamanho = (isset($data['tamanho'])) ? $data['tamanho'] : null;
        $this->url = (isset($data['url'])) ? $data['url'] : null;
        $this->data_adicionada = (isset($data['data_adicionada'])) ? $data['data_adicionada'] : null;

        /*
          $this->perfil = new Perfil();

          $this->perfil->id = (isset($data['perfil_id'])) ? $data['perfil_id'] : null;
          $this->perfil->nome = (isset($data['nome_perfil'])) ? $data['nome_perfil'] : null; */
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new Exception("Não validado");
    }

    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
            $inputFilter->add($factory->createInput(array(
                        'name' => 'id',
                        'required' => false,
                        'filters' => array(
                            array('name' => 'Int'),
                        ),
            )));
            $inputFilter->add($factory->createInput(array(
                        'name' => 'titulo',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StripTags'),
                        ),
                        'validators' => array(
                            array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min' => 1,
                                    'max' => 255,
                                ),
                            ),
                        ),
            )));


            $inputFilter->add($factory->createInput(array(
                        'name' => 'url',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StripTags'),
                        ),
                        'validators' => array(
                            array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min' => 1,
                                ),
                            ),
                        ),
            )));

            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }

    public function getArrayCopy() {
        return array(
            'id' => $this->id,
            'titulo' => $this->titulo,
            'tamanho' => $this->tamanho,
            'url' => $this->url,
            'data_adicionada' => $this->data_adicionada,
        );
    }

}
