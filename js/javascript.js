function implementarOption() {
    var opcao_instrutor = document.getElementById('opcao_instrutor').value;
    var opcao_aluno = document.getElementById('opcao_aluno').value;
    var opcao_veiculo = document.getElementById('opcao_veiculo').value;
    document.getElementById('opcaoInstrutor').value = opcao_instrutor;
    document.getElementById('opcaoAluno').value = opcao_aluno;
    document.getElementById('opcaoVeiculo').value = opcao_veiculo;
}
//$('#pesquisaImprimirAula').datepicker({
//    format: "dd/mm/yyyy",
//    language: "pt-BR",
//    calendarWeeks: true,
//    todayHighlight: true,
//    todayBtn: true
//});

function cliqueAjax() {
    $('form').submit(function () {
        var dados = $(this).serialize();
        $.ajax({
            url: 'processa-aula-cadastrada.php',
            type: 'post',
            dataType: 'html',
            data: dados,
            beforeSend: function () {
                //Aqui adicionas o loader
                $("#resultadoImprimirAula").html(
                        "<center><img src='img/carregando.gif' style='width: 10%'><br><h5>Carregando...</h5></center>");
            },
            success: function (data) {
                $('#resultadoImprimirAula').empty().html(data);
            }
        });
        return false;
    });
    $('form').trigger('submit');
};



////Ajax para pesquisa de aulas
//$(document).ready(function () {
//
//    $('#pesquisaImprimirAula').click(function () {
//        $('form').submit(function () {
//            var dados = $(this).serialize();
//            $.ajax({
//                url: 'processa-aula-cadastrada.php',
//                type: 'post',
//                dataType: 'html',
//                data: dados,
//                beforeSend: function () {
//                    //Aqui adicionas o loader
//                    $("#resultadoImprimirAula").html(
//                            "<center><img src='img/carregando.gif' style='width: 10%'><br><h5>Carregando...</h5></center>");
//                },
//                success: function (data) {
//                    $('#resultadoImprimirAula').empty().html(data);
//                }
//            });
//            return false;
//        });
//        $('form').trigger('submit');
//    });
//});









//Ajax para pesquisa instantânea de cadastrar aula do veiculo
$(document).ready(function () {

    $('#pesquisaVeiculoAula').keyup(function () {

        $('.veiculoAula').submit(function () {
            var dados = $(this).serialize();
            $.ajax({
                url: 'processa-veiculo-aula.php',
                type: 'post',
                dataType: 'html',
                data: dados,
                beforeSend: function () {
                    //Aqui adicionas o loader
                    $("#resultadoVeiculoAula").html(
                            "<center><img src='img/carregando.gif' style='width: 10%'><br><h5>Carregando...</h5></center>");
                },
                success: function (data) {
                    $('#resultadoVeiculoAula').empty().html(data);
                }
            });
            return false;
        });
        $('.veiculoAula').trigger('submit');
    });
});
//Ajax para pesquisa instantânea de cadastrar aula do aluno
$(document).ready(function () {

    $('#pesquisaAlunoAula').keyup(function () {

        $('.alunoAula').submit(function () {
            var dados = $(this).serialize();
            $.ajax({
                url: 'processa-aluno-aula.php',
                type: 'post',
                dataType: 'html',
                data: dados,
                beforeSend: function () {
                    //Aqui adicionas o loader
                    $("#resultadoAlunoAula").html(
                            "<center><img src='img/carregando.gif' style='width: 10%'><br><h5>Carregando...</h5></center>");
                },
                success: function (data) {
                    $('#resultadoAlunoAula').empty().html(data);
                }
            });
            return false;
        });
        $('.alunoAula').trigger('submit');
    });
});
//Ajax para pesquisa instantânea de cadastrar aula instrutor
$(document).ready(function () {

    $('#pesquisaInstrutorAula').keyup(function () {

        $('.instrutorAula').submit(function () {
            var dados = $(this).serialize();
            $.ajax({
                url: 'processa-instrutor-aula.php',
                type: 'post',
                dataType: 'html',
                data: dados,
                beforeSend: function () {
                    //Aqui adicionas o loader
                    $("#resultadoInstrutorAula").html(
                            "<center><img src='img/carregando.gif' style='width: 10%'><br><h5>Carregando...</h5></center>");
                },
                success: function (data) {
                    $('#resultadoInstrutorAula').empty().html(data);
                }
            });
            return false;
        });
        $('.instrutorAula').trigger('submit');
    });
});
//Ajax para pesquisa instantânea do veículo
$(document).ready(function () {

    $('#pesquisaVeiculo').keyup(function () {

        $('form').submit(function () {
            var dados = $(this).serialize();
            $.ajax({
                url: 'processa-veiculo.php',
                type: 'post',
                dataType: 'html',
                data: dados,
                beforeSend: function () {
                    //Aqui adicionas o loader
                    $("#resultadoVeiculo").html(
                            "<center><img src='img/carregando.gif' style='width: 10%'><br><h5>Carregando...</h5></center>");
                },
                success: function (data) {
                    $('#resultadoVeiculo').empty().html(data);
                }
            });
            return false;
        });
        $('form').trigger('submit');
    });
});
//Ajax para pesquisa instantânea do secretaria
$(document).ready(function () {

    $('#pesquisaSecretaria').keyup(function () {

        $('form').submit(function () {
            var dados = $(this).serialize();
            $.ajax({
                url: 'processa-secretaria.php',
                type: 'post',
                dataType: 'html',
                data: dados,
                beforeSend: function () {
                    //Aqui adicionas o loader
                    $("#resultadoSecretaria").html(
                            "<center><img src='img/carregando.gif' style='width: 10%'><br><h5>Carregando...</h5></center>");
                },
                success: function (data) {
                    $('#resultadoSecretaria').empty().html(data);
                }
            });
            return false;
        });
        $('form').trigger('submit');
    });
});
//Ajax para pesquisa instantânea do instrutor
$(document).ready(function () {

    $('#pesquisaInstrutor').keyup(function () {

        $('form').submit(function () {
            var dados = $(this).serialize();
            $.ajax({
                url: 'processa-instrutor.php',
                type: 'post',
                dataType: 'html',
                data: dados,
                beforeSend: function () {
                    //Aqui adicionas o loader
                    $("#resultadoInstrutor").html(
                            "<center><img src='img/carregando.gif' style='width: 10%'><br><h5>Carregando...</h5></center>");
                },
                success: function (data) {
                    $('#resultadoInstrutor').empty().html(data);
                }
            });
            return false;
        });
        $('form').trigger('submit');
    });
});
//Ajax para pesquisa instantânea do Aluno
$(document).ready(function () {

    $('#pesquisa').keyup(function () {

        $('form').submit(function () {
            var dados = $(this).serialize();
            $.ajax({
                url: 'processa.php',
                method: 'post',
                dataType: 'html',
                data: dados,
                beforeSend: function () {
                    //Aqui adicionas o loader
                    $("#resultado").html(
                            "<center><img src='img/carregando.gif' style='width: 10%'><br><h5>Carregando...</h5></center>");
                },
                success: function (data) {
                    $('#resultado').empty().html(data);
                }
            });
            return false;
        });
        $('form').trigger('submit');
    });
});
$(document).ready(function () {
    $("#btn_visualizar").click(function () {
//Recupere o Id do registro e passe para o seu modal
        var trid = $(this).closest('tr').attr('id');
        $("#myModal").attr("class", trid);
    });
});
// pesquisacep
function limpa_formulário_cep() {
    //Limpa valores do formulário de cep.
    document.getElementById('logradouro').value = ("");
    document.getElementById('bairro').value = ("");
    document.getElementById('cidade').value = ("");
}

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
//Atualiza os campos com os valores.
        document.getElementById('logradouro').value = (conteudo.logradouro);
        document.getElementById('bairro').value = (conteudo.bairro);
        document.getElementById('cidade').value = (conteudo.localidade);
    } //end if.
    else {
//CEP não Encontrado.
        limpa_formulário_cep();
        alert("CEP não encontrado.");
    }
}



function pesquisacep(valor) {

//Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');
    //Verifica se campo cep possui valor informado.
    if (cep != "") {

//Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;
        //Valida o formato do CEP.
        if (validacep.test(cep)) {

//Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('logradouro').value = "...";
            document.getElementById('bairro').value = "...";
            document.getElementById('cidade').value = "...";
            //Cria um elemento javascript.
            var script = document.createElement('script');
            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';
            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);
        } //end if.
        else {
//cep é inválido.
            limpa_formulário_cep();
            alert("Formato de CEP inválido.");
        }
    } //end if.
    else {
//cep sem valor, limpa formulário.
        limpa_formulário_cep();
    }
}



// Validações de cpf etc -->


function fone(obj, prox) {
    switch (obj.value.length) {
        case 1:
            obj.value = "(" + obj.value;
            break;
        case 3:
            obj.value = obj.value + ")";
            break;
        case 8:
            obj.value = obj.value + "-";
            break;
        case 13:
            prox.focus();
            break;
    }
}
function formata_data(obj, prox) {
    switch (obj.value.length) {
        case 2:
            obj.value = obj.value + "/";
            break;
        case 5:
            obj.value = obj.value + "/";
            break;
        case 9:
            prox.focus();
            break;
    }
}
function Apenas_Numeros(caracter)
{
    var nTecla = 0;
    if (document.all) {
        nTecla = caracter.keyCode;
    } else {
        nTecla = caracter.which;
    }
    if ((nTecla > 47 && nTecla < 58)
            || nTecla == 8 || nTecla == 127
            || nTecla == 0 || nTecla == 9  // 0 == Tab
            || nTecla == 13) { // 13 == Enter
        return true;
    } else {
        return false;
    }
}
function validaCPF(cpf)
{
    erro = new String;
    if (cpf.value.length == 11)
    {
        cpf.value = cpf.value.replace('.', '');
        cpf.value = cpf.value.replace('.', '');
        cpf.value = cpf.value.replace('-', '');
        var nonNumbers = /\D/;
        if (nonNumbers.test(cpf.value))
        {
            erro = "A verificacao de CPF suporta apenas números!";
        } else
        {
            if (cpf.value == "00000000000" ||
                    cpf.value == "11111111111" ||
                    cpf.value == "22222222222" ||
                    cpf.value == "33333333333" ||
                    cpf.value == "44444444444" ||
                    cpf.value == "55555555555" ||
                    cpf.value == "66666666666" ||
                    cpf.value == "77777777777" ||
                    cpf.value == "88888888888" ||
                    cpf.value == "99999999999") {

                erro = "Número de CPF inválido!"
            }

            var a = [];
            var b = new Number;
            var c = 11;
            for (i = 0; i < 11; i++) {
                a[i] = cpf.value.charAt(i);
                if (i < 9)
                    b += (a[i] * --c);
            }

            if ((x = b % 11) < 2) {
                a[9] = 0
            } else {
                a[9] = 11 - x
            }
            b = 0;
            c = 11;
            for (y = 0; y < 10; y++)
                b += (a[y] * c--);
            if ((x = b % 11) < 2) {
                a[10] = 0;
            } else {
                a[10] = 11 - x;
            }

            if ((cpf.value.charAt(9) != a[9]) || (cpf.value.charAt(10) != a[10])) {
                erro = "Número de CPF inválido.";
            }
        }
    } else
    {
        if (cpf.value.length == 0)
            return false
        else
            erro = "Número de CPF inválido.";
    }
    if (erro.length > 0) {
        alert(erro);
        cpf.focus();
        return false;
    }
    return true;
}

//envento onkeyup
function maskCPF(CPF) {
    var evt = window.event;
    kcode = evt.keyCode;
    if (kcode == 8)
        return;
    if (CPF.value.length == 3) {
        CPF.value = CPF.value + '.';
    }
    if (CPF.value.length == 7) {
        CPF.value = CPF.value + '.';
    }
    if (CPF.value.length == 11) {
        CPF.value = CPF.value + '-';
    }
}

// evento onBlur
function formataCPF(CPF)
{
    with (CPF)
    {
        value = value.substr(0, 3) + '.' +
                value.substr(3, 3) + '.' +
                value.substr(6, 3) + '-' +
                value.substr(9, 2);
    }
}
function retiraFormatacao(CPF)
{
    with (CPF)
    {
        value = value.replace(".", "");
        value = value.replace(".", "");
        value = value.replace("-", "");
        value = value.replace("/", "");
    }
}