<?php
/*************************************************************\
 * 
 * Arquivo principal da API que irá receber url requisitada
 * 
 * Autor    :   Leonardo
 * data     :   19/05
 * versão   :   1.0
 * 
\*************************************************************/


header("Access-Control-Allow-Origin: *"); // define quais origens podem fazer requisições para a API
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // define quais metodos HTTP que poderão ser usados
header("Access-Control-Allow-Headers: Content-Type"); // permite liberar o content type utilizado na API
header("Content-Type: application/json"); // define a resposta da API como um arquivo JSON

$baseUrl = (string)  $_GET["url"];

$url = explode('/', $baseUrl);

require_once "../modulo/config.php";

// roteamento dos endpoint's da API
switch(strtolower($url[0])) {
    case "contatos":
        require_once "contatos/index.php";
        break;

    default:
        $res = array(
            "status" => 404,
            "message" => "Not Found!"
        );

        echo json_encode($res);
        break;
}
