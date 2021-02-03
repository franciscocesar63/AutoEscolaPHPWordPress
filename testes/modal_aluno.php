<?php

if (isset($_SESSION['banco'])) {
    if ($_SESSION['banco'] == 'primeiro') {
        include_once './banco/conexao_primeiro.php';
    } else {
        include_once './banco/conexao_segunda.php';
    }
}

function pbd_modal_aluno($id) {

    if (isset($id)) {
//var_dump($cpf);

        $pdo = pbd_connectar();
        $query = $pdo->prepare("SELECT * FROM pessoa WHERE id = '$id' LIMIT 1");
        $query->execute();
        $dado = $query->fetch(PDO::FETCH_ASSOC);

        $query_endereco = $pdo->prepare("SELECT * FROM endereco WHERE id = '$id' LIMIT 1");
        $query_endereco->execute();
        $dado_endereco = $query_endereco->fetch(PDO::FETCH_ASSOC);
    }


    $masculino = $feminino = "";
    switch ($dado['sexo']) {

        case "masculino": {
                $masculino = "selected";
                break;
            }
        case "feminino": {
                $feminino = "selected";
                break;
            }
    }

    $html = '<a type="button"class="btn btn-default" '
            . 'data-toggle="modal" data-target="#myModal' . $id . '" data-whatever="@mdo">Editar</a>';
    echo '<div class="modal fade" id="myModal' . $id . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
    echo '<div class="modal-dialog modal-lg">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header">';
    echo '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
    echo '<h4 class="modal-title" id="myModalLabel">Editar Aluno</h4>';
    echo '</div>';
    echo '<div class="modal-body">';
    echo '<div class="row">';
    echo '<div class="col-md-6">';

    echo '<form action="../atualizando-pessoa?id=' . $id . '" method="POST">'; //formulario
    echo '<div class="form-group">';
    echo '<label for="nome" class="control-label">Nome:</label>';
    echo '<input type="text" value="' . $dado['nome'] . '" class="form-control" name="nome" id="nome" maxlength="30" required="">';
    echo '</div>';
    echo '<div class="form-group">';
    echo '<label for="cpf" class="control-label">CPF:</label>';
    echo '<input type="text" name="cpf"  value="' . $dado['cpf'] . '" onkeydown="javascript:fMasc(this, cpf);" class="form-control" id="cpf" maxlength="11" disabled="disabled">';
    echo '</div>';
    echo '<div class="form-group">';
    echo '<label for="rg" class="control-label">RG:</label>';
    echo '<input type="text"value ="' . $dado['rg'] . '" class="form-control" id="rg" name="rg" maxlength="11" disabled="disabled">';
    echo '</div>';
    echo '<div class="form-group">';
    echo '<label for="email" class="control-label">E-Mail:</label>';
    echo '<input type="email" required="" class="form-control" value="' . $dado['email'] . '" id="email" name="email" maxlength="30">';
    echo '</div>';
    echo '<div class="form-group">';
    echo '<label for="telefone" class="control-label">Telefone:</label>';
    echo '<input type="text" required="" class="form-control" value="' . $dado['telefone'] . '" id="telefone" name="telefone" maxlength="18">';
    echo '</div>';
    echo '<div class="form-group">';
    echo '<label for="nome" class="control-label">Nome:</label>';
    echo '<select name="sexo">'
    . '<option value="masculino" ' . $masculino . '>Masculino</option>'
    . '<option value="feminino" ' . $feminino . '>Feminino</option> '
    . '</select>';
    echo '</div>';
    echo '</div>';
    echo '<div class="col-md-6">';
    echo '<div class="form-group">';
    echo '<label for="logradouro" class="control-label">Rua:</label>';
    echo '<input type="text" required="" value="' . $dado_endereco['logradouro'] . '" class="form-control" id="logradouro" name="logradouro" maxlength="30">';
    echo '</div>';
    echo '<div class="form-group">';
    echo '<label for="numero" class="control-label">Número:</label>';
    echo '<input type="text" required="" value="' . $dado_endereco['numero'] . '" class="form-control" id="numero" name="numero" maxlength="10>';
    echo '</div>';
    echo '<div class="form-group">';
    echo '<label for="bairro" class="control-label">Bairro:</label>';
    echo '<input type="text" required="" value="' . $dado_endereco['bairro'] . '" class="form-control" name="bairro" id="bairro" maxlength="30>';
    echo '</div>';
    echo '<div class="form-group">';
    echo '<label for="complemento" class="control-label">Complemento:</label>';
    echo '<input type="text" value="' . $dado_endereco['complemento'] . '" class="form-control" id="complemento" name="complemento" maxlength="30">';
    echo '</div>';
    echo '<div class="form-group">';
    echo '<label for="cidade" class="control-label">Cidade:</label>';
    echo '<input type="text" required="" value="' . $dado_endereco['cidade'] . '" class="form-control" id="cidade" name="cidade" maxlength="30">';
    echo '</div>';
    echo '<div class="form-group">';
    echo '<label for="cep" class="control-label">CEP:</label>';
    echo '<input type="text" required="" value="' . $dado_endereco['cep'] . '" class="form-control" id="cep" name="cep" maxlength="30">';
    echo '</div>';
    echo '<button type="submit" class="btn btn-primary" >Salvar</button>';
    echo '<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>';
    echo '</form>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<div class="modal-footer">';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

    return $html;
}

function modal_visualizar_aluno($id) {

    $query = $pdo->prepare("SELECT * FROM pessoa p INNER JOIN aluno a ON p.id=a.id WHERE a.id=$id "
            . "AND a.excluido=0");
    $query->execute();
    $dado = $query->fetch(PDO::FETCH_ASSOC);
}
