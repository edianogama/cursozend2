<?php

namespace Application\Controller;

use Application\Form\VideoForm;
use Application\Model\Video;
use Exception;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class VideoController extends AbstractActionController {

    protected $videoTable;

    public function listAction() {
        return new ViewModel(array(
            "videos" => $this->getVideoTable()->fetchAll(),
        ));
    }

    public function getVideoTable() {
        if (!$this->videoTable) {
            $sm = $this->getServiceLocator();
            $this->videoTable = $sm->get('Application\Model\VideoTable');
        }
        return $this->videoTable;
    }

    public function addAction() {
        $form = new VideoForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $video = new Video();
            $form->setInputFilter($video->getInputFilter());

            $form->setData($request->getPost());

            if ($form->isValid()) {
                $video->exchangeArray($form->getData());
                $this->getVideoTable()->salvarVideo($video);
                return $this->redirect()->toUrl("/application/video/list");
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
            $video = $this->getVideoTable()->getVideo($id);
        } catch (Exception $ex) {
            return $this->redirect()->toUrl('list');
        }

        $form = new VideoForm();
        $form->bind($video);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($video->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getVideoTable()->salvarVideo($form->getData());

                return $this->redirect()->toUrl("/application/video/list");
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
            return $this->redirect()->toUrl('/application/video/list');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Nao');

            if ($del == 'Sim') {
                $id = (int) $request->getPost('id');
                $this->getVideoTable()->deletarVideo($id);
            }
            return $this->redirect()->toUrl('list');
        }

        return array(
            'id' => $id,
            'video' => $this->getVideoTable()->getVideo($id)
        );
    }

}
