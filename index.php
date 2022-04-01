<?php

$id = (int) 0;
$nome = (string) "";
$telefone = (string) "";
$celular = (string) "";
$email = (string) "";
$obs = (string) "";

// verifica se o recurso de variaveis de sessão esta ativado
// e se a variavel "dadosContato" existe
// apartir disso ele preenche as variaveis locais
if ( session_status() &&  !empty($_SESSION["dadosContato"]) ) {
    $id         =   $_SESSION["dadosContato"]["id"];
    $nome       =   $_SESSION["dadosContato"]["nome"];
    $telefone   =   $_SESSION["dadosContato"]["telefone"];
    $celular    =   $_SESSION["dadosContato"]["celular"];
    $email      =   $_SESSION["dadosContato"]["email"];
    $obs        =   $_SESSION["dadosContato"]["obs"];
}

?>

<!DOCTYPE>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title> Cadastro </title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
       
        <div id="cadastro"> 
            <div id="cadastroTitulo"> 
                <h1> Cadastro de Contatos </h1>
                
            </div>
            <div id="cadastroInformacoes">
                <form  action="router.php?component=contatos&action=inserir" name="frmCadastro" method="post" >
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Nome: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input autocomplete="off" type="text" name="txtNome" 
                                value="<?= $nome ?>" placeholder="Digite seu Nome" maxlength="100">
                        </div>
                    </div>
                                     
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Telefone: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                        <input autocomplete="off" type="tel" name="txtTelefone" value="<?= $telefone ?>">
                        </div>
                    </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Celular: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input autocomplete="off" type="tel" name="txtCelular" value="<?= $celular ?>">
                        </div>
                    </div>
                   
                    
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Email: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input autocomplete="off" type="email" name="txtEmail" value="<?= $email ?>">
                        </div>
                    </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Observações: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                        <textarea name="txtObs" cols="50" rows="7" ><?= $obs ?></textarea>
                        </div>
                    </div>
                    <div class="enviar">
                        <div class="enviar">
                            <input type="submit" name="btnEnviar" value="Salvar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="consultaDeDados">
            <table id="tblConsulta" >
                <tr>
                    <td id="tblTitulo" colspan="6">
                        <h1> Consulta de Dados.</h1>
                    </td>
                </tr>
                <tr id="tblLinhas">
                    <td class="tblColunas destaque"> Nome </td>
                    <td class="tblColunas destaque"> Celular </td>
                    <td class="tblColunas destaque"> Email </td>
                    <td class="tblColunas destaque"> Opções </td>
                </tr>
                
                <?php 
                    // Import da controller para a listagem de contatos
                    require_once("controller/controllerContatos.php");

                    // recebe os contatos
                    $listContato = listarContato();
                    
                    // retira os dados do array $listContato e printa na tela
                    foreach($listContato as $item) {
                ?>               

                <tr id="tblLinhas">
                <td class="tblColunas registros"><?= $item["nome"] ?></td>
                    <td class="tblColunas registros"><?= $item["celular"] ?></td>
                    <td class="tblColunas registros"><?= $item["email"] ?></td>
                   
                    <td class="tblColunas registros">
                        <a href="router.php?component=contatos&action=buscar&id=<?= $item["id"] ?>">
                                <img src="img/edit.png" alt="Editar" title="Editar" class="editar">
                        </a>                            

                        <a onclick="return confirm('Deseja mesmo excluir o contato?')" 
                            href="router.php?component=contatos&action=deletar&id=<?= $item["id"] ?>">
                            <img src="img/trash.png" alt="Excluir" title="Excluir" class="excluir">
                        </a>

                        <img src="img/search.png" alt="Visualizar" title="Visualizar" 
                            class="pesquisar">
                    </td>
                </tr>

                <?php 
                    // fechamento do foreach
                    }    
                ?>
            </table>
        </div>
    </body>
</html>
