<?php
/*==================================================*\                                                 
 *
 * Arquivo responsavel por manipular os dados       
 * dentro do bd (insert, update, select e delete)   
 *                                                  
 * Autor    :   Leonardo                            
 * Data     :   10/05/22                            
 * Versão   :   1.0                                 
 *                                                 
\*==================================================*/

require_once("conexaoMysql.php");

/** Lista todos os contatos do DB */
function selectAllEstados(){
    $conexao = abrirConexaoMysql();

    $sqlQuerry = "select * from tbl_estado order by nome asc";

    $res = mysqli_query($conexao, $sqlQuerry);
    
    if ( $res ) {
        // convertendo a resposta do BD para array
        while ( $resData = mysqli_fetch_assoc($res) ) {
            $resArray[] = array(
                "id"     => $resData["id_estado"],
                "sigla"  => $resData["sigla"],
                "nome"   => $resData["nome"]
            );
        }       

        fecharConexaoMysql($conexao); // solicita o fechamento da conexão com o BD

        return $resArray;
    }   
}