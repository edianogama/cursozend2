<?php

namespace Application\Model;

use Application\Model\Perfil;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Factory as InputFactory;

class Usuario {

    public $id;
    public $login;
    public $senha;
    public $nome;
    public $email;
    public $user_channel;
    public $perfil;
    public $inputFilter;

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->login = (isset($data['login'])) ? $data['login'] : null;
        $this->senha = (isset($data['senha'])) ? $data['senha'] : null;
        $this->nome = (isset($data['nome'])) ? $data['nome'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->user_channel = (isset($data['user_channel'])) ? $data['user_channel'] : null;


        $this->perfil = new Perfil();

        $this->perfil->id = (isset($data['perfil_id'])) ? $data['perfil_id'] : null;
        $this->perfil->nome = (isset($data['nome_perfil'])) ? $data['nome_perfil'] : null;
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
                        'name' => 'nome',
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
                                    'max' => 100,
                                ),
                            ),
                        ),
            )));
            $inputFilter->add($factory->createInput(array(
                        'name' => 'email',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StringTrim'),
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
                        'name' => 'user_channel',
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
            $inputFilter->add($factory->createInput(array(
                        'name' => 'login',
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
            $inputFilter->add($factory->createInput(array(
                        'name' => 'senha',
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
            'login' => $this->login,
            'senha' => md5($this->senha),
            'nome' => $this->nome,
            'user_channel' => $this->user_channel,
            'email' => $this->email,
            'perfil_id' => $this->perfil->id
        );
    }

}
