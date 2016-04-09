<?php

namespace Application\Controller;

use Application\Form\PerfilForm;
use Application\Model\Perfil;
use Exception;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PerfilController extends AbstractActionController {

    protected $perfilTable;

    public function listAction() {
        return new ViewModel(
                array(
            "perfis" => $this->getPerfilTable()->fetchPars()
        ));
    }

    public function getPerfilTable() {
        if (!$this->perfilTable) {
            $sm = $this->getServiceLocator();
            $this->perfilTable = $sm->get('Application\Model\PerfilTable');
        }
        return $this->perfilTable;
    }

    public function addAction() {
        $form = new PerfilForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $perfil = new Perfil();
            $form->setInputFilter($perfil->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $perfil->exchangeArray($form->getData());

                $this->getPerfilTable()->salvarPerfil($perfil);
                return $this->redirect()->toUrl("/application/perfil/list");
            }
        }
        return array('form' => $form);
    }

    public function editAction() {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (empty($id)) {
            $id = $this->getRequest()->getPost('id');
            if (empty($id)) {
                return $this->redirect()->toUrl('add');
            }
        }

        try {
            $perfil = $this->getPerfilTable()->getPerfil($id);
        } catch (Exception $ex) {
            return $this->redirect()->toUrl('list');
        }

        $form = new PerfilForm();
        $form->bind($perfil);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($perfil->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getPerfilTable()->salvarPerfil($form->getData());

                return $this->redirect()->toUrl("/application/perfil/list");
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toUrl('/application/perfil/list');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Nao');

            if ($del == 'Sim') {
                $id = (int) $request->getPost('id');
                $this->getPerfilTable()->deletarPerfil($id);
            }
            return $this->redirect()->toUrl('list');
        }

        return array(
            'id' => $id,
            'perfil' => $this->getPerfilTable()->getPerfil($id)
        );
    }

}
