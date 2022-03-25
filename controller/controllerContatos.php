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
function inserirContato( $dadosContato ){
    
    // impede a execução desta função quando $dadosContato for vazio
    if ( !empty($dadosContato) ) {

        // verifica se os campos obrigatorios foram preenchidos, não permitindo a execução caso não foram
        if ( !empty($dadosContato["txtNome"]) && !empty($dadosContato["txtCelular"]) && !empty($dadosContato["txtEmail"]) ) {
            // array que sera encaminhado para a model para ser inserido no DB.
            $contato = array(
                "nome"      => $dadosContato["txtNome"],
                "telefone"  => $dadosContato["txtTelefone"],
                "celular"   => $dadosContato["txtCelular"],
                "email"     => $dadosContato["txtEmail"],
                "obs"       => $dadosContato["txtObs"] 
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
function atualizarContato(){
}

/**
 * Excluir contatos atravez dos dados recebidos pela view
 */
function excluirContato($id){
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
        return true;     
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

?>
