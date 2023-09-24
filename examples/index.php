<?php
require_once 'vendor/autoload.php';

use DolphPHP\App;
use DolphPHP\Request;
use DolphPHP\Response;

App::get('/hello-world') // Define Route
    ->inject('request')
    ->inject('response')
    ->action(
        function($request, $response) {
            $response
              ->addHeader('Cache-Control', 'no-cache, no-store, must-revalidate')
              ->addHeader('Expires', '0')
              ->addHeader('Pragma', 'no-cache')
              ->send("<div> Hello World! </div>");
        }
    );

App::setMode(App::MODE_TYPE_PRODUCTION); // Define Mode

$app        = new App('America/New_York');
$request    = new Request();
$response   = new Response();

$app->run($request, $response);