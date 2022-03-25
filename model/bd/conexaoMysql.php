<?php
 ////////////////////////////////////////////////
//                                             //
// Arquivo para criar a conexão com o BD MySQL //
//                                             //
// Autor : Leonardo Antunes                    //
// Data : 25/02/22                             //
// Versão : 1.0                                //
//                                             //
////////////////////////////////////////////////

// Constantes para estabelecer conexão com banco de dados 
// (local do bd, usuario, senha e database)
const SERVER = "localhost";
const USER = "root";
const PASSWORD = "bcd127";
const DATABASE = "db_contatos";

/**
 * Abre a conexão com o banco de dados MySQL
 *
 * @return array	conexão
 */
function abrirConexaoMysql() {        
	$conexao = array();

	// se a conexão for estabelecida com o BD, iremos ter um array
	// de dados sobre a conexão.  
	$conexao = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);

	// validação para verificar se conexão foi realizada com sucesso
	if ($conexao) {
		return $conexao;
	} else {
		return false;
	}
}

// Existem 3 formas de criar conexão com BD MySQL no PHP ->
// 	- mysql_connect() - versão antiga do PHP de fazer conexão,
// 			não oferece performance e segurança.
//  
//  - mysqli_connet - versão mais atualizada de fazer conexão
// 			com bd no PHP, permite ser utilizada para programação
// 			estruturada e POO.
// 	
// 	- PDO() - versão mais completa, segura e eficiente, porem é
// 			utilizada apenas com orientação a objetos. 

/**
 *Fecha a conexão com o BD MySQL
 */
function fecharConexaoMysql($conexao) {
     mysqli_close($conexao);
}

?>
