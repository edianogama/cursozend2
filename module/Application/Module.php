<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Model\Perfil;
use Application\Model\PerfilTable;
use Application\Model\Usuario;
use Application\Model\UsuarioTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module {

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $GLOBALS['sm'] = $e->getApplication()->getServiceManager();
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function loadConfiguration(MvcEvent $e) {

//        $application = $e->getApplication();
        //$sm = $application->getServiceManager();
        /*

          if ($sm->get('AuthService')->hasIdentity()) {
          $usuario = $sm->get('Autenticacao\Model\AutenticacaoStorage')->read();
          if (!empty($usuario->perfil->id)) {
          return $usuario->perfil->id;
          }
          } */
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Application\Model\UsuarioTable' => function($sm) {
                    $tableGateway = $sm->get('UsuarioTableGateway');
                    $table = new UsuarioTable($tableGateway);
                    return $table;
                },
                'UsuarioTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Usuario());
                    return new TableGateway('usuario', $dbAdapter, null, $resultSetPrototype);
                },
                'Application\Model\PerfilTable' => function($sm) {
                    $tableGateway = $sm->get('PerfilTableGateway');
                    $table = new PerfilTable($tableGateway);
                    return $table;
                },
                'PerfilTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Perfil());
                    return new TableGateway('perfil', $dbAdapter, null, $resultSetPrototype);
                }
            ),
        );
    }

}
