<?php

namespace Application\Controller;

use Application\Form\CanalForm;
use Application\Model\Canal;
use Exception;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CanalController extends AbstractActionController {

    protected $canalTable;

    public function listAction() {
        return new ViewModel(
                array(
            "canais" => $this->getCanalTable()->fetchAll()
        ));
    }

    public function getCanalTable() {
        if (!$this->canalTable) {
            $sm = $this->getServiceLocator();
            $this->canalTable = $sm->get('Application\Model\CanalTable');
        }
        return $this->canalTable;
    }

    public function addAction() {
        $form = new CanalForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $canal = new Canal();
            $form->setInputFilter($canal->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $canal->exchangeArray($form->getData());

                $this->getCanalTable()->salvarCanal($canal);
                return $this->redirect()->toUrl("/application/canal/list");
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
            $canal = $this->getCanalTable()->getCanal($id);
        } catch (Exception $ex) {
            return $this->redirect()->toUrl('list');
        }

        $form = new CanalForm();
        $form->bind($canal);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($canal->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getCanalTable()->salvarCanal($form->getData());

                return $this->redirect()->toUrl("/application/canal/list");
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
            return $this->redirect()->toUrl('/application/canal/list');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Nao');

            if ($del == 'Sim') {
                $id = (int) $request->getPost('id');
                $this->getCanalTable()->deletarCanal($id);
            }
            return $this->redirect()->toUrl('list');
        }

        return array(
            'id' => $id,
            'canal' => $this->getCanalTable()->getCanal($id)
        );
    }

}
