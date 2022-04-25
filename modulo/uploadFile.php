<?php
/*********************************************************\
 * 
 * arquivo responsavel por realizar upload de arquivos 
 * 
 * dev    :     Leonardo Antunes
 * versão :     1.0
 * data   :     25/04/2022
 * 
\*********************************************************/

function uploadFile($arrayFile) {
    require_once "modulo/config.php";

    $file = $arrayFile;

    // enviando msg de erro se o arquivo não existir e impedindo o upload
    if ($file["size"] <= 0 || $file["type"] == "") return array("idErro" => 10, "message" => "Arquivo não encontrado");

    $fileSize = (int) $file["size"] / 1024; // convertendo tamanho do arquivo de bytes para kilobytes
    $fileType = (string) $file["type"];
    $fileName = (string) $file["name"];

    // enviando msg de erro se o arquivo ultrapassar o limite de tamanho e impedindo o upload
    if ($fileSize > MAX_UPLOAD_FILE_SIZE) return array("idErro" => 11, "message" => "Tamanho de arquivo inválido");

    if ( !in_array($fileType, UPLOAD_FILE_EXTENSIONS) ) return array("idErro" => 12, "message" => "A extensão do arquivo selecionado não é permitido no upload");

    // separando o nome do arquivo em <name> e <extension>
    $name = pathinfo($fileName, PATHINFO_FILENAME);
    $extension = pathinfo($fileName, PATHINFO_EXTENSION);


    // algoritimos de criptografia ->
    //      - md5
    //      - sha1
    //      - hash

    // gerando um nome criptografado e unico para o arquivo
    // uniqid() - gera uma sequencia numerica unica com base no hardware
    // time() - pega a hora atual
    $nameCript = md5($name . uniqid(time()));

    $newFile = $nameCript.".".$extension; 

    $tempFile = $file["tmp_name"];

    if ( move_uploaded_file($tempFile, UPLOAD_FILE_DIRECTORY . $newFile) ) {
        return $newFile;
    } else {
        return array("idErro" => 13, "message" => "não foi possivel mover arquivo para o servidor");
    }
}   

?>