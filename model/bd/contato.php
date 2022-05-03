<?php 
/*==================================================*\                                                 
 *
 * Arquivo responsavel por manipular os dados       
 * dentro do bd (insert, update, select e delete)   
 *                                                  
 * Autor    :   Leonardo                            
 * Data     :   11/03/22                            
 * Versão   :   1.0                                 
 *                                                 
\*==================================================*/

require_once("conexaoMysql.php");


/** Realiza o insert de um contato no DB */
function insertContato($dadosContato) {
    $conexao = abrirConexaoMysql();

    // montando instrução sql que será executada para inserir um contato no DB
    $sqlQuerry = "insert into tbl_contato (nome, telefone, celular, email, obs, foto) 
	                values ('". $dadosContato["nome"] ."', 
                        '". $dadosContato["telefone"] ."', 
                        '". $dadosContato["celular"] ."', 
                        '". $dadosContato["email"] ."', 
                        '". $dadosContato["obs"] ."',
                        '". $dadosContato["foto"]."');";
    
    /** responsavel por guardar o status da resposta do banco */ 
    $statusRes = (boolean) false;

    // executa uma instrução no bd verificando se ela esta correta
    if ( mysqli_query($conexao, $sqlQuerry) ) {
        if ( mysqli_affected_rows($conexao) ) {
            $statusRes = true;
        }
    }


    fecharConexaoMysql($conexao); // fechando conexão

    return $statusRes;
}   

/** atualiza um contato no DB */
function updateContato($contato){
    $conexao = abrirConexaoMysql();

    // montando instrução sql que será executada para inserir um contato no DB
    $sqlQuery = "update tbl_contato set 
                    nome        =   '". $contato["nome"]."', 
                    telefone    =   '". $contato["telefone"] ."', 
                    celular     =   '". $contato["celular"] ."', 
                    email       =   '". $contato["email"] ."',
                    obs         =   '". $contato["obs"] ."',
                    foto        =   '". $contato["foto"] ."'
                    where id_contato=". $contato["id"];
    
    /** responsavel por guardar o status da resposta do banco */ 
    $statusRes = (boolean) false;

    // executa uma instrução no bd verificando se ela esta correta
    if ( mysqli_query($conexao, $sqlQuery) ) {
        if ( mysqli_affected_rows($conexao) ) {
            $statusRes = true;
        }
    }


    fecharConexaoMysql($conexao); // fechando conexão

    return $statusRes;
}

/** Lista todos os contatos do DB */
function selectAllContatos(){
    require_once "modulo/config.php";

    $conexao = abrirConexaoMysql();

    $sqlQuerry = "select * from tbl_contato order by id_contato desc";

    $res = mysqli_query($conexao, $sqlQuerry);
    
    if ( $res ) {
        $cont = 0;
        // convertendo a resposta do BD para array
        while ( $resData = mysqli_fetch_assoc($res) ) {
            $resArray[$cont] = array(
                "id"         => $resData["id_contato"],
                "nome"       => $resData["nome"],
                "telefone"   => $resData["telefone"],
                "celular"    => $resData["celular"],
                "email"      => $resData["email"],
                "obs"        => $resData["obs"],
                "foto"        => UPLOAD_FILE_DIRECTORY . $resData["foto"],
            );

            $cont++;
        }       

        fecharConexaoMysql($conexao); // solicita o fechamento da conexão com o BD

        return $resArray;
    }   
}

/** Realiza o delete de um contato no DB */
function deleteContato($id){
    $conexao = abrirConexaoMysql();

    $sqlQuerry = "delete from tbl_contato where id_contato=$id;";
    
    $statusRes = (boolean) false;

    if ( mysqli_query($conexao, $sqlQuerry) ) {
        if ( mysqli_affected_rows($conexao) ) {
            $statusRes = true;
        }
    }

    fecharConexaoMysql($conexao);

    return $statusRes;
}

/**
 * busca um contato no banco de dados apartir de um id
 *
 * @return  contato
 */
function selectContatoById($id) {
    require_once "modulo/config.php";
    
    $conexao = abrirConexaoMysql();

    $sqlQuery = "select * from tbl_contato where id_contato=$id";

    $res = mysqli_query($conexao, $sqlQuery);

    if ( $res ) {

        if ($resData = mysqli_fetch_assoc($res)) {
            $resArray = array(
                "id"         => $resData["id_contato"],
                "nome"       => $resData["nome"],
                "telefone"   => $resData["telefone"],
                "celular"    => $resData["celular"],
                "email"      => $resData["email"],
                "obs"        => $resData["obs"],
                "foto"       => UPLOAD_FILE_DIRECTORY.$resData["foto"]
            );
        }

        fecharConexaoMysql($conexao);

        return $resArray;
    }    
}

?>
