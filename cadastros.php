<?php

function cadastrar_aluno() {
    $html = '<a type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal" data-whatever="@mdo">Cadastrar Aluno</a>

            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Cadastrar Aluno</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <form action="banco/cadastrando-aluno.php" method="POST">
                                        <div class="form-group">
                                            <label for="nome" class="control-label">Nome:</label>
                                            <input type="text" class="form-control" id="nome" name="nome"maxlength="30" required="">
                                        </div>
                                        <div class="form-group">
                                            <label for="cpf" class="control-label">CPF:</label>
                                            <input type="text" name="cpf" onkeydown="javascript:fMasc(this, cpf);" class="form-control" id="cpf" maxlength="11" required="">
                                        </div>
                                        <div class="form-group">
                                            <label for="rg" class="control-label">RG:</label>
                                            <input type="text" class="form-control" id="rg" name="rg" maxlength="11" required="">
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="control-label">E-Mail:</label>
                                            <input type="email" class="form-control" id="email" name="email" maxlength="30" required="">
                                        </div>
                                        <div class="form-group">
                                            <label for="telefone" class="control-label">Telefone:</label>
                                            <input type="text" class="form-control" id="telefone" name="telefone" maxlength="18" required="">
                                        </div>
                                        <div class="form-group">
                                            <label for="sexo" class="control-label">Sexo:</label>
                                            <select id="sexo" name="sexo" required>

                                                <option value="">Selecione</option>
                                                <option value="masculino">Masculino</option>
                                                <option value="feminino">Feminino</option> </select>
                                        </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="logradouro" class="control-label">Rua:</label>
                                        <input type="text" class="form-control" id="logradouro" name="logradouro" maxlength="30" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="numero" class="control-label">Número:</label>
                                        <input type="text" class="form-control" id="numero" name="numero" maxlength="10" placeholder="S/Nº">
                                    </div>
                                    <div class="form-group">
                                        <label for="bairro" class="control-label">Bairro:</label>
                                        <input type="text" class="form-control" name="bairro" id="bairro" maxlength="30 required="" >
                                    </div>
                                    <div class="form-group">
                                        <label for="complemento" class="control-label">Complemento:</label>
                                        <input type="text" class="form-control" id="complemento" name="complemento" maxlength="30" placeholder="Opcional">
                                    </div>
                                    <div class="form-group">
                                        <label for="cidade" class="control-label">Cidade:</label>
                                        <input type="text" class="form-control" id="cidade" name="cidade" maxlength="30" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="cep" class="control-label">CEP:</label>
                                        <input type="text" onblur="pesquisacep(this.value);" class="form-control" id="cep" name="cep" maxlength="30" required="">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </form>

                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>';
    return $html;
}
