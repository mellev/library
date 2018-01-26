<?php

$router->addRoute(['GET'], 'index', '/',
    [
        'controller' => Library\BooksController::class,
        'action' => 'index'
    ]
);

$router->addRoute(['GET'], 'book', '/book/:id',
    [
        'controller' => Library\BooksController::class,
        'action' => 'get'
    ]
);

$router->addRoute(['POST'], 'remove', '/book/:id/remove',
    [
        'controller' => Library\BooksController::class,
        'action' => 'remove'
    ]
);

$router->addRoute(['GET', 'POST'], 'edit', '/book/:id/edit',
    [
        'controller' => Library\BooksController::class,
        'action' => 'edit'
    ]
);

$router->addRoute(['GET', 'POST'], 'create', '/book/create',
    [
        'controller' => Library\BooksController::class,
        'action' => 'create'
    ]
);

$router->setNotFoundHandler([
    'controller' => Library\BooksController::class,
    'action' => 'notFound'
]);