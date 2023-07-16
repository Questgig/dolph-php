<?php

require_once __DIR__.'/../../vendor/autoload.php';

use DolphPHP\App;
use DolphPHP\Request;
use DolphPHP\Response;

ini_set('memory_limit', '512M');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('display_socket_timeout', -1);
error_reporting(E_ALL);

App::get('/')
    ->inject('response')
    ->action(function ($response) {
        $response->send('Hello World!');
    });

App::get('/chunked')
    ->inject('response')
    ->action(function (Response $response) {
        foreach (['Hello ', 'World!'] as $key => $word) {
            $response->chunk($word, $key == 1);
        }
    });

App::get('/redirect')
    ->inject('response')
    ->action(function (Response $response) {
        $response->redirect('/');
    });

$request = new Request();
$response = new Response();

$app = new App('UTC');
$app->run($request, $response);
