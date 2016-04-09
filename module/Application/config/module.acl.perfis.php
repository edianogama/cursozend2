<?php

return array(
// Perfil de administrador
    array(
        'role' => 1,
        'resource' => 'Application\Controller\Index',
        'privileges' => array(
            'list',
            'add',
            'edit'
        ),
        'role' => 1,
        'resource' => 'Application\Controller\Usuario',
        'privileges' => array(
            'list',
            'add',
            'edit'
        ),
    )
);
