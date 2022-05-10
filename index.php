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

/** carrega o nome da fotodo banco de dados */
$foto = (string) null;
$idEstado = (string) null;


$actionFormCadastro = (string) "router.php?component=contatos&action=inserir";

// verifica se o recurso de variaveis de sessão esta ativado
// e se a variavel "dadosContato" existe
// apartir disso ele preenche as variaveis locais
if ( session_status()) {
    if ( !empty($_SESSION["dadosContato"]) ) {
        $id         =   $_SESSION["dadosContato"]["id"];
        $nome       =   $_SESSION["dadosContato"]["nome"];
        $telefone   =   $_SESSION["dadosContato"]["telefone"];
        $celular    =   $_SESSION["dadosContato"]["celular"];
        $email      =   $_SESSION["dadosContato"]["email"];
        $obs        =   $_SESSION["dadosContato"]["obs"];
        $foto       =   $_SESSION["dadosContato"]["foto"];
        $idEstado   =   $_SESSION["dadosContato"]["idEstado"];

        $actionFormCadastro = "router.php?component=contatos&action=editar&id=$id&foto=$foto";

        //destroy uma variavel
        unset($_SESSION["dadosContato"]);
    }

    
}

function renderOptionsEstados($idEstado) {
    $options = "";

    require_once "./controller/controllerEstados.php";

    $estados = listarEstados();

    foreach ($estados as $estado) {
        $selected =  ($estado["id"] == $idEstado) ? "selected" : null;
        $options .= "<option value='". $estado["id"]. "' ". $selected .">". $estado["nome"]. "</option>";
    }

    return $options;
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
                <!-- enctype="multipart/form-data" é obrigatorio para enviar arquivos do formulario para o servidor -->
                <form  action="<?= $actionFormCadastro ?>" name="frmCadastro" method="post"  enctype="multipart/form-data" >
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Nome: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input autocomplete="off" type="text" name="txtNome" 
                                value="<?= isset($nome)?$nome:null ?>" placeholder="Digite seu Nome" maxlength="100">
                        </div>
                    </div>

                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Nome: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <select name="sltEstado">
                                <option value="">Selecione um item</option>
                                <?= renderOptionsEstados($idEstado) ?>
                            </select>
                        </div>
                    </div>
                                     
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Telefone: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input autocomplete="off" type="tel" name="txtTelefone" value="<?= isset($telefone)?$telefone:null ?>">
                        </div>
                    </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Celular: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input autocomplete="off" type="tel" name="txtCelular" value="<?= isset($celular)?$celular:null ?>">
                        </div>
                    </div>
                   
                    
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Email: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input autocomplete="off" type="email" name="txtEmail" value="<?= isset($email)?$email:null ?>">
                        </div>
                    </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Escolha um arquivo: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            
                            <input type="file" name="fileFoto" value="<?= isset($foto)? $foto : null ?>"accept=".jpg, .jpeg, .png, .gif,">
                        </div>
                    </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Observações: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                        <textarea name="txtObs" cols="50" rows="7" ><?= isset($obs)?$obs:null ?></textarea>
                        </div>
                    </div>
                    
                    <div class="campos">
                        <img src="<?= $foto ?>" alt="foto do contato" class="contato-img">
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
                    <td class="tblColunas destaque"> Foto </td>
                    <td class="tblColunas destaque"> Opções </td>
                </tr>
                
                <?php 
                    // Import da controller para a listagem de contatos
                    require_once("controller/controllerContatos.php");

                    // recebe os contatos
                    $listContato = listarContato();
                    
                    // retira os dados do array $listContato e printa na tela
                    foreach($listContato as $item) {
                        $foto = $item["foto"];
                ?>               

                <tr id="tblLinhas">
                <td class="tblColunas registros"><?= $item["nome"] ?></td>
                    <td class="tblColunas registros"><?= $item["celular"] ?></td>
                    <td class="tblColunas registros"><?= $item["email"] ?></td>
                    <td class="tblColunas registros"><img src="<?= $foto ?>" class="foto"alt="img"></td>
                   
                    <td class="tblColunas registros">
                        <a href="router.php?component=contatos&action=buscar&id=<?= $item["id"] ?>">
                                <img src="img/edit.png" alt="Editar" title="Editar" class="editar">
                        </a>                            

                        <a onclick="return confirm('Deseja mesmo excluir o contato?')" 
                            href="router.php?component=contatos&action=deletar&id=<?= $item["id"] ?>&foto=<?= $foto ?>">
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
