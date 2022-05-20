<?php
/*********************************************************\
 * 
 * arquivo responsavel pela criação de constantes do projeto
 * 
 * dev    :     Leonardo Antunes
 * versão :     1.0
 * data   :     25/04/2022
 * 
\*********************************************************/

const MAX_UPLOAD_FILE_SIZE = 5120; // 5120kb -> 5mb
const UPLOAD_FILE_EXTENSIONS = array("image/jpg", "image/png", "image/jpeg", "image/gif");
const UPLOAD_FILE_DIRECTORY = "files/";

define("SRC", $_SERVER["DOCUMENT_ROOT"]."/leonardo/aula07/");

// funções globais
function createJSON($data) {
    if (empty($data)) return false;

    header("content-type: application/json");

    return json_encode($data);
}

?>