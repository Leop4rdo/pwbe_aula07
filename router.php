<?php 
 ///////////////////////////////////////////////////////////////////
//                                                                //
// Arquivo que recebe as requisições e realiza chamadas na camada // 
// de controller                                                  //
//                                                                //
// Autor:   Leonardo Antunes                                      //
// Data:    04/03/22                                              //
// Versão:  1.0                                                   //
//                                                                //
///////////////////////////////////////////////////////////////////

$action = (string) null; // qual ação deve ser realizada
$component = (string) null; // quem esta fazendo a requisição


// validação para verificar se a requisição é um POST de um formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "GET") {
    
    // recebendo dados da url para saber quem esta solicitando e qual ação deve ser realizado
    $component = strtoupper($_GET["component"]); 
    $action = strtoupper($_GET["action"]);
    

    // Estrutura para validar quem esta solicitando algo para o router
    switch ($component) {
        case "CONTATOS":
            require_once("./controller/controllerContatos.php");

            
            // validação para indentificar o tipo de ação que será realizada 
            if ($action == "INSERIR") {
                $res = inserirContato($_POST);
                
                if ( is_bool($res) && $res == true ) { 
                    echo "<script>
                            alert('Contato inserido com sucesso');
                            window.location.href = 'index.php';
                          </script>";

                } else if ( is_array($res) ) {
                     echo "<script>
                            alert('Erro: " . $res["message"] . "');
                            window.history.back();
                          </script>";                   

                } 
            } else if ($action == "DELETAR") {
                $idContato = (int) $_GET["id"];
                
                // chama a função de excluir na controller 
                $res = excluirContato($idContato);

                if (is_bool($res) && $res == true) {
                    echo "<script>
                            alert('Contato excluido com sucesso');
                            window.location.href = 'index.php';
                          </script>"; 
                } else if ( is_array($res) ) {
                     echo "<script>
                            alert('Erro: " . $res["message"] . "');
                            window.history.back();
                          </script>";                   

                } 
            } else if ($action == "BUSCAR") {
                $idContato = $_GET["id"];
                 
                $res = buscarContato($idContato);
                                 
                // ativando recurso de variavel de sessão
                // pois o apache deixa ela desativada por padrão
                //
                // essa variavel de sessão vai ser usada para 
                // popular o formulario da index.php
                 
                session_start(); // inicia o recurso
                 
                $_SESSION["dadosContato"] = $res; // cria uma nova variavel de sessão com o nome "dadosContato".

                require_once("index.php");
            } 

            break;
    } 
}
