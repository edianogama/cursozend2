<?php

return array(
// Perfil de administrador
    array(
        'role' => 1,
        'resource' => 'Application\Controller\Index',
        'privileges' => array(
            'list',
            'add',
            'edit',
            'delete'
        ),
    ),
    array(
        'role' => 1,
        'resource' => 'Application\Controller\Usuario',
        'privileges' => array(
            'index',
            'list',
            'add',
            'edit',
            'delete'
        ),
    ),
    array(
        'role' => 1,
        'resource' => 'Application\Controller\Perfil',
        'privileges' => array(
            'list',
            'add',
            'edit',
            'delete'
        ),
    ), array(
        'role' => 1,
        'resource' => 'Application\Controller\Canal',
        'privileges' => array(
            'list',
            'add',
            'edit',
            'delete'
        ),
    ),
    array(
        'role' => 1,
        'resource' => 'Application\Controller\Video',
        'privileges' => array(
            'list',
            'add',
            'edit',
            'delete'
        ),
    )
);
