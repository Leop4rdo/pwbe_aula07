<?php
/*==================================================*\                                                 
 *
 * Arquivo responsavel por manipular os dados       
 * do estado e fazer a ponte entre a view e a model   
 *                                                  
 * Autor    :   Leonardo                            
 * Data     :   10/05/22                            
 * Versão   :   1.0                                 
 *                                                 
\*==================================================*/

/**
 * Solicita os dados de contato da model e encaminha para a view
 */
function listarEstados(){
    require_once("model/bd/estado.php");

    $res = selectAllEstados();

    if ( !empty($res) ) {
        return $res;
    } else {
        return false;
    }
}
