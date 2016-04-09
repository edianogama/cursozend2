<?php

namespace Application\Form;

use Zend\Form\Form;

class UsuarioForm extends Form {

    protected $perfilTable;

    public function __construct($name = null) {
        parent::__construct('usuario');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('role', 'form');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'nome',
            'type' => 'Text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Nome'
            )
        ));
        $this->add(array(
            'name' => 'email',
            'type' => 'Email',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'E-mail'
            )
        ));
        $this->add(array(
            'name' => 'user_channel',
            'type' => 'Text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Nome de Usuário'
            ),
        ));
        $this->add(array(
            'name' => 'login',
            'type' => 'Text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Login'
            ),
        ));
        $this->add(array(
            'name' => 'senha',
            'type' => 'Password',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Senha'
            ),
        ));

        $this->add(array(
            'name' => 'perfil_id',
            'type' => 'Select',
            'attributes' => array(
                'options' => $this->getValueOptions()
            ),
        ));
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

    private function getPerfilTable() {
        if (!$this->perfilTable) {
            $sm = $GLOBALS['sm'];
            $this->perfilTable = $sm->get('Application\Model\PerfilTable');
        }
        return $this->perfilTable;
    }

    private function getValueOptions() {
        $valueOptions = array("" => "Selectione");
        $perfils = $this->getPerfilTable()->fetchPars();

        foreach ($perfils as $perfil) {
            $valueOptions[$perfil->id] = $perfil->nome;
        }
        return $valueOptions;
    }

}
