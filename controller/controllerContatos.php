<?php
 /////////////////////////////////////////////////////
//                                                  //
// Arquivo responsavel pela manipulação de dados de //
// contato                                          //
// Obs: este arquivo fará a ponte entre a view e a  //
//   model                                          //
//                                                  //
// Autor  :  Leonardo Antunes                       //
// Data   :  04/03/22                               //
// Versão :  1.0                                    //
/////////////////////////////////////////////////////


/**
 * Inserir novos contatos atravez dos dados recebidos pela view
 */
function inserirContato( $dadosContato, $file ){
    $imgName = (string) null;

    // impede a execução desta função quando $dadosContato for vazio
    if ( !empty($dadosContato) ) {

        // verifica se os campos obrigatorios foram preenchidos, não permitindo a execução caso não foram
        if ( !empty($dadosContato["txtNome"]) && !empty($dadosContato["txtCelular"]) && !empty($dadosContato["txtEmail"]) ) {
            
            // identificando se um arquivo foi enviado para upload
            if ($file["fileFoto"]["name"] != null) {
                require_once "modulo/uploadFile.php";

                $imgName = uploadFile($file["fileFoto"]);

                // se o retorno da função uploadFile() for uma mensagem de erro:
                if ( is_array($imgName) ) return $imgName;
                
            }
            
            // array que sera encaminhado para a model para ser inserido no DB.
            $contato = array(
                "nome"      => $dadosContato["txtNome"],
                "telefone"  => $dadosContato["txtTelefone"],
                "celular"   => $dadosContato["txtCelular"],
                "email"     => $dadosContato["txtEmail"],
                "obs"       => $dadosContato["txtObs"], 
                "foto"      => $imgName
            );
            


            // import do arquivo de modelagem para manipular o BD
            require_once("model/bd/contato.php");

            // Chama a função que fara o insert no BD apartir da camada Model
            if ( insertContato($contato) ) {
                return true;
            } else {
                // retornando mensagem de erro
                return array(
                    "idErro" => 1,
                    "message" => "não foi possivel inserir os dados no banco de dados"
                );
            }
        } else {

            // retornando mensagem de erro de dados incompletos
            return array(
                "idErro"    => 2,
                "message"   => "Impossivel realizar inserção por causa da falta dos dados obrigatorios"
            );
        }
    }
}

/**
 * Atualizar os contatos atravez dos dados recebidos pela view
 */
function atualizarContato($dadosContato, $body){
    $id     =   $body["id"];
    $foto   =   $body["foto"];
    $file   =   $body["file"];

    // impede a execução desta função quando $dadosContato for vazio
    if ( !empty($dadosContato) ) {

        // verifica se os campos obrigatorios foram preenchidos, não permitindo a execução caso não foram
        if ( !empty($dadosContato["txtNome"]) && !empty($dadosContato["txtCelular"]) && !empty($dadosContato["txtEmail"])) {
            if (!empty($id) && is_numeric($id) && $id > 0) {

                // identificando se um arquivo foi enviado para upload
                if ($file["fileFoto"]["name"] != null) {
                    require_once "modulo/uploadFile.php";

                    $newImgName = uploadFile($file["fileFoto"]);

                    // se o retorno da função uploadFile() for uma mensagem de erro:
                    if ( is_array($newImgName) ) return $newImgName;    

                    @unlink($foto);
                } else {
                    $newImgName = $foto;
                }

                // array que sera encaminhado para a model para ser inserido no DB.
                $contato = array(
                    "id"        => $id,
                    "nome"      => $dadosContato["txtNome"],
                    "telefone"  => $dadosContato["txtTelefone"],
                    "celular"   => $dadosContato["txtCelular"],
                    "email"     => $dadosContato["txtEmail"],
                    "obs"       => $dadosContato["txtObs"] ,
                    "foto"      => $newImgName
                );


                // import do arquivo de modelagem para manipular o BD
                require_once("model/bd/contato.php");

                // Chama a função que fara o insert no BD apartir da camada Model
                if ( updateContato($contato) ) {
                    return true;
                } else {
                    // retornando mensagem de erro
                    return array(
                        "idErro" => 1,
                        "message" => "não foi possivel editar os dados no banco de dados"
                    );
                }
            } else {
                return array(
                    "idErro" => 4,
                    "message" => "não foi possivel editar os dados sem informar um id valido"
                );
            }
        } else {

            // retornando mensagem de erro de dados incompletos
            return array(
                "idErro"    => 2,
                "message"   => "Impossivel realizar edição por causa da falta dos dados obrigatorios"
            );
        }
    }
}

/**
 * Excluir contatos atravez dos dados recebidos pela view
 */
function excluirContato($body){
    $id = (int) $body["id"];
    $foto = (string) $body["foto"];


    // impedindo a execução da função caso o id seja igual a 0, inexistente ou não-numerico
    if ( $id == 0 || empty($id) || !is_numeric($id) ) {
        return array(
            "idErro"    => 4,
            "message"   => "Impossivel deletar contato com id Invalido"
        );
    }


    // import do arquivo de modelagem para manipulação do BD
    require_once("model/bd/contato.php");

    if ( deleteContato($id) ) {
        if ($foto != null) {
            if (unlink($foto)) {
                return true;
            } else {
                return array(
                    "idErro"    => 5,
                    "message"   => "Contato excluido com sucesso, porem a imagem não foi excluída do servidor"
                );  
            }
        }
  
    } else {
        return array(
            "idErro"    => 3,
            "message"   => "Impossivel deletar contato"
        );     
    };    
}

/**
 * Solicita os dados de contato da model e encaminha para a view
 */
function listarContato(){
    require_once("model/bd/contato.php"); // importando model de contatos
    
    $res = selectAllContatos();

    if ( !empty($res) ) {
        return $res;
    } else {
        return false;
    }
}

/** busca um contato atravez do id */
function buscarContato($id) {
    // impedindo a execução da função caso o id seja igual a 0, inexistente ou não-numerico
    if ( $id == 0 || empty($id) || !is_numeric($id) ) {
        return array(
            "idErro"    => 4,
            "message"   => "Impossivel buscar contato com id Invalido"
        );
    }    

    require_once("model/bd/contato.php");

    $res =  selectContatoById($id);
    
    if ( !empty($res) ) {
        return $res;
    } else {
        return false;
    }
}

?>
