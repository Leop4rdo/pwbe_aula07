<?php

use Slim\Http\Request;
use Slim\Http\Response;
use \Slim\App;

require_once  "vendor/autoload.php";


$app = new App();

$app->get("/contatos/", function (Request $request, Response $response, array $args) {
    require_once "../controller/controllerContatos.php";

    $res = array("data" => listarContato());

    if (!$res) {
        $resJSON = createJSON(array("message" => "no data"));
        $response->withHeader('Content-Type', 'application/json')
                ->write($resJSON)
                ->withStatus(404);

        return $response;
    } 

    $resJSON = createJSON($res);

    $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write($resJSON);

    return $response;
});

$app->run(); // executa todos os endpoint

