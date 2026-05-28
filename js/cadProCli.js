$(document).ready(function () {

    // QUAL FORMULÁRIO ABRIR
    const params = new URLSearchParams(window.location.search);
    const tipo = params.get("tipo");

    if (tipo === "clinica") {
        mostrarFormulario("cadastroClinica");

    } else if (tipo === "profissional") {
        mostrarFormulario("cadastroProfissional");

    } else {
        mostrarFormulario("cadastroProfissional");
    }

    function mostrarFormulario(cadastroId) {

        $(".cadastro").hide();

        $("#" + cadastroId).show();
    }

    //VARIAVEIS
    // PROFISSIONAL
    const $inputImgProfissional = $("#img_perfil");
    const $previewProfissional = $("#preview");

    const $btnCadastrar = $("#btnCadastrar");
    const $btnLogar = $("#btnLogar");

    const $alertLogin = $("#alertLogin");

    const $emailCadastro = $("#emailCadastro");
    const $emailLogin = $("#emailLogin");

    const $cadastroForm = $("#cadastroProfissional");
    const $loginForm = $("#loginProfissional");

    const $linkLogin = $(".logarProfissional");
    const $linkCadastro = $(".cadastrarProfissional");


    // DADOS PROFISSIONAL
    const $nomeProfissional = $("#nomeProfissional");
    const $emailCadastroInput = $("#emailCadastro");
    const $telProfissional = $("#telProfissional");
    const $userProfissional = $("#userProfissional");
    const $generoProfissional = $("#generoProfissional");
    const $bioProfissional = $("#bioProfissional");
    const $dtnPro = $("#dtnPro");
    const $cpf = $("#CPF");
    const $senhaProfissional = $("#senhaProfissional");
    const $cepProfissional = $("#cep");
    const $ruaProfissional = $("#rua");
    const $bairroProfissional = $("#bairro");
    const $ufProfissional = $("#uf");
    const $ibgeProfissional = $("#ibge");
    const $registroProfissional = $("#registroProfissional");
    const $parteCEP = $(".parteCEP");

    // CLÍNICA
    const $inputImgClinica = $("#img_perfil_Clinica");
    const $previewClinica = $("#previewClinica");

    const $btnCadClinica = $("#btnCadClinica");
    const $btnLogClinica = $("#btnLogClinica");

    const $emailCadClinica = $("#emailCadClinica");
    const $emailLogClinica = $("#emailLogClinica");

    const $cadFormClinica = $("#cadastroClinica");
    const $logFormClinica = $("#loginClinica");

    const $linkLogClinica = $(".logarClinica");
    const $linkCadClinica = $(".cadastrarClinica");

    // DADOS CLÍNICA
    const $nomeClinica = $("#nomeClinica");
    const $emailCadClinicaInput = $("#emailCadClinica");
    const $telClinica = $("#telClinica");
    const $userClinica = $("#userClinica");
    const $bioClinica = $("#bioClinica");
    const $cnpj = $("#cnpj");
    const $senhaClinica = $("#senhaClinica");
    const $cepClinica = $("#cepClinica");
    const $ruaClinica = $("#ruaClinica");
    const $bairroClinica = $("#bairroClinica");
    const $ufClinica = $("#ufClinica");
    const $ibgeClinica = $("#ibgeClinica");
    const $parteCEPClinica = $(".parteCEPClinica");


    // FUNÇÃO GLOBAL
    /*function limpa_formulário() {
        $("#emailCadastro").val("");
        $("#nomeProfissional").val("");
        $("#senhaProfissional").val("");
        $("#telProfissional").val("");
        $("#userProfissional").val("");
        $("#CPF").val("");
        $("#generoProfissional").val("");
        $("#bioProfissional").val("");
        $("#registroProfissional").val("");
        $("#img_perfil").val("");
        $("#rua").val("");
        $("#bairro").val("");
        $("#cidade").val("");
        $("#uf").val("");
        $("#ibge").val("");
        $("#emailCadClinica").val("");
        $("#nomeClinica").val("");
        $("#senhaClinica").val("");
        $("#telClinica").val("");
        $("#userClinica").val("");
        $("#bioClinica").val("");
        $("#img_perfil_Clinica").val("");
        $("#cnpj").val("");
        $("#ruaClinica").val("");
        $("#bairroClinica").val("");
        $("#cidadeClinica").val("");
        $("#ufClinica").val("");
        $("#ibgeClinica").val("");
    }*/

    function emailValido(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    function cpfValido(cpf) {
        cpf = cpf.replace(/\D/g, "");

        if (cpf.length !== 11) return false;

        if (/^(\d)\1+$/.test(cpf)) return false;// Elimina CPFs inválidos conhecidos

        // Validação do primeiro dígito
        let soma = 0;
        for (let i = 0; i < 9; i++) {
            soma += Number(cpf[i]) * (10 - i);
        }

        let resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) resto = 0;

        if (resto !== Number(cpf[9])) return false;

        // Validação do segundo dígito
        soma = 0;
        for (let i = 0; i < 10; i++) {
            soma += Number(cpf[i]) * (11 - i);
        }

        resto = (soma * 10) % 11;
        if (resto === 10) resto = 0;

        if (resto !== Number(cpf[10])) return false;

        return true;
    }

    function cnpjValido(cnpj) {
        cnpj = cnpj.replace(/\D/g, "");

        if (cnpj.length !== 14) return false;

        if (/^(\d)\1+$/.test(cnpj)) return false;// Elimina CNPJs inválidos conhecidos

        let tamanho = cnpj.length - 2;
        let numeros = cnpj.substring(0, tamanho);
        let digitos = cnpj.substring(tamanho);

        let soma = 0;
        let pos = tamanho - 7;

        for (let i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) pos = 9;
        }

        let resultado = soma % 11 < 2 ? 0 : 11 - (soma % 11);
        if (resultado != digitos.charAt(0)) return false;

        tamanho = tamanho + 1;
        numeros = cnpj.substring(0, tamanho);

        soma = 0;
        pos = tamanho - 7;

        for (let i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) pos = 9;
        }

        resultado = soma % 11 < 2 ? 0 : 11 - (soma % 11);
        if (resultado != digitos.charAt(1)) return false;

        return true;
    }


    //PROFISSIONAL
    // TROCAR TELAS
    if ($linkLogin.length) {
        $linkLogin.on("click", function (e) {
            e.preventDefault();
            $cadastroForm.hide();
            $loginForm.show();
        });
    }

    if ($linkCadastro.length) {
        $linkCadastro.on("click", function (e) {
            e.preventDefault();
            $loginForm.hide();
            $cadastroForm.show();
        });
    }

    // PREVIEW DE IMAGEM
    if ($inputImgProfissional.length && $previewProfissional.length) {

        $previewProfissional.on("click", function () {
            $inputImgProfissional.trigger("click");
        });

        $inputImgProfissional.on("change", function () {

            const arquivo = this.files[0];

            if (arquivo && arquivo.type.startsWith("image/")) {

                const reader = new FileReader();

                reader.onload = function (e) {
                    $previewProfissional.attr("src", e.target.result);
                };

                reader.readAsDataURL(arquivo);

            } else {
                mostrarAlert("Selecione uma imagem válida!", "danger");
            }

        });
    }


    // CADASTRO PROFISSIONAL
    $btnCadastrar.on("click", function () {
        /*$("#formProfissional").on("submit", function (e) {
            e.preventDefault();*/
        let botao = $(this);
        botao.prop("disabled", true);
        botao.html(`
                    <span class="spinner-border spinner-border-sm"></span>
                    Cadastrando..
                `);

        // limpa erros anteriores
        $(".form-control, .form-select, textarea").removeClass("is-invalid");
        const imgPerfil = $inputImgProfissional.val().trim();
        const nomeProfissional = $nomeProfissional.val().trim();
        const email = $emailCadastroInput.val().trim();
        const telefone = $telProfissional.val().trim();
        const username = $userProfissional.val().trim();
        const biografia = $bioProfissional.val().trim();
        const generoPro = $generoProfissional.val();
        const dtnPro = $dtnPro.val().trim();
        const CEP = $cepProfissional.val().trim();
        const cepLimpo = CEP.replace(/\D/g, "");
        const validaCep = /^[0-9]{8}$/;
        const registro = $registroProfissional.val().trim();
        const CPF = $cpf.val().trim();
        const senha = $senhaProfissional.val().trim();
        let erro = false;


        // VÊ OS CAMPOS VAZIOS
        if (!nomeProfissional) {
            $nomeProfissional.addClass("is-invalid");
            erro = true;
        }

        if (!email) {
            $emailCadastroInput.addClass("is-invalid");
            erro = true;
        }

        if (!telefone) {
            $telProfissional.addClass("is-invalid");
            erro = true;
        }

        if (!username) {
            $userProfissional.addClass("is-invalid");
            erro = true;
        }

        if (!biografia) {
            $bioProfissional.addClass("is-invalid");
            erro = true;
        }

        if (!dtnPro) {
            $dtnPro.addClass("is-invalid");
            erro = true;
        }
        if (!CPF) {
            $cpf.addClass("is-invalid");
            erro = true;
        }

        if (!registro) {
            $registroProfissional.addClass("is-invalid");
            erro = true;
        }

        if (!CEP || !validaCep.test(cepLimpo)) {
            $cepProfissional.addClass("is-invalid");
            $ruaProfissional.addClass("is-invalid");
            $bairroProfissional.addClass("is-invalid");
            $("#cidade").addClass("is-invalid");
            $ufProfissional.addClass("is-invalid");
            $ibgeProfissional.addClass("is-invalid");
            if (!validaCep.test(cepLimpo)) {
                mostrarAlert("Formato de CEP inválido!", "danger");
            }

            erro = true;
        }

        if (!senha) {
            $senhaProfissional.addClass("is-invalid");
            erro = true;
        }

        if (!$generoProfissional.val()) {
            $generoProfissional.addClass("is-invalid");
            erro = true;
        }



        if (erro) {
            botao.prop("disabled", false);
            botao.html("Cadastrar");
            mostrarAlert("Preencha todos os campos!", "danger");
            return;
        }

        //IMAGEM
        if (!imgPerfil) {
            botao.prop("disabled", false);
            botao.html("Cadastrar");
            mostrarAlert("A imagem de perfil é obrigatoria.", "danger");
            return;
        }


        // EMAIL
        if (!emailValido(email)) {

            $emailCadastroInput.addClass("is-invalid");

            botao.prop("disabled", false);
            botao.html("Cadastrar");

            mostrarAlert("E-mail inválido!", "danger");
            return;
        }

        // CPF
        if (!cpfValido(CPF)) {

            $cpf.addClass("is-invalid");

            botao.prop("disabled", false);
            botao.html("Cadastrar");

            mostrarAlert("CPF inválido!", "danger");
            return;
        }

        const cpfLimpo = CPF.replace(/\D/g, "");
        const telLimpo = telefone.replace(/\D/g, "");

        let formData = new FormData();

        formData.append("nome", nomeProfissional);
        formData.append("email", email);
        formData.append("telefone", telLimpo);
        formData.append("username", username);
        formData.append("bio", biografia);
        formData.append("dtNas", dtnPro);
        formData.append("CEP", cepLimpo);
        formData.append("registro", registro);
        formData.append("CPF", cpfLimpo);
        formData.append("senha", senha);
        formData.append("genero", generoPro);
        formData.append("cxproFoto", $("#img_perfil")[0].files[0]);

        $.ajax({
            url: "/EMP/model/caduser.php",
            method: "POST",

            data: formData,

            processData: false,
            contentType: false,

            success: function (resposta) {

                console.log(resposta);

                botao.prop("disabled", false);
                botao.html("Cadastrar");


                if (resposta.trim() == "sucesso") {

                    mostrarAlert("Cadastro realizado!", "success");
                    mostrarFormulario("ativacaoPro");

                } else {
                    let erros = resposta.split("|");
                    console.log(erros);
                    erros.forEach(function (erro) {
                        mostrarAlert(erro, "danger");
                    });

                }

            },

            error: function () {

                botao.prop("disabled", false);
                botao.html("Cadastrar");

                mostrarAlert("Erro na requisição!", "danger");

            }


        });

        setTimeout(function () {


        }, 2000);

    });


    // Remover a borada vermelha
    $(".form-control, .form-select, textarea").on("input change", function () {
        $(this).removeClass("is-invalid");
    });


    //CEP
    $cepProfissional.on("blur", function () {

        let cep = $(this).val().replace(/\D/g, "");

        // se vazio
        if (cep === "") {
            //limpa_formulário();
            return;
        }

        // valida formato
        const validaCep = /^[0-9]{8}$/;

        if (!validaCep.test(cep)) {

            $cepProfissional.addClass("is-invalid");

            //limpa_formulário();
            mostrarAlert("Formato de CEP inválido!", "danger");
            $cepProfissional.addClass("is-invalid");
            $ruaProfissional.addClass("is-invalid");
            $bairroProfissional.addClass("is-invalid");
            $("#cidade").addClass("is-invalid");
            $ufProfissional.addClass("is-invalid");
            $ibgeProfissional.addClass("is-invalid");
            erro = true;
            return;
        }

        // loading nos campos
        $ruaProfissional.val("...");
        $bairroProfissional.val("...");
        $("#cidade").val("...");
        $ufProfissional.val("...");
        $ibgeProfissional.val("...");

        // consulta API ViaCEP
        $.getJSON(
            "https://viacep.com.br/ws/" + cep + "/json/?callback=?",
            function (dados) {

                if (!("erro" in dados)) {

                    $cepProfissional.removeClass("is-invalid");

                    $ruaProfissional.val(dados.logradouro);
                    $bairroProfissional.val(dados.bairro);
                    $("#cidade").val(dados.localidade);
                    $ufProfissional.val(dados.uf);
                    $ibgeProfissional.val(dados.ibge);

                    $($parteCEP).removeClass("is-invalid");

                } else {

                    //limpa_formulário();

                    $cepProfissional.addClass("is-invalid");


                    mostrarAlert("CEP não encontrado!", "danger");
                    $cepProfissional.addClass("is-invalid");
                    $ruaProfissional.addClass("is-invalid");
                    $bairroProfissional.addClass("is-invalid");
                    $("#cidade").addClass("is-invalid");
                    $ufProfissional.addClass("is-invalid");
                    $ibgeProfissional.addClass("is-invalid");
                    erro = true;
                }

            }
        );

    });

    $cepProfissional.on("input", function () {
        $(this).removeClass("is-invalid");
    });






    // LOGIN
    if ($btnLogar.length) {

        $btnLogar.on("click", function () {

            const email = $emailLogin.val().trim();

            // limpa erro anterior
            $emailLogin.removeClass("is-invalid");

            if (!email) {

                $emailLogin.addClass("is-invalid");

                mostrarAlert("Preencha o e-mail!", "danger");
                return;
            }

            if (emailValido(email)) {

                $alertLogin
                    .removeClass("alert-danger")
                    .addClass("alert alert-success")
                    .text("Login realizado!")
                    .show();

            } else {

                $emailLogin.addClass("is-invalid");

                $alertLogin
                    .removeClass("alert-success")
                    .addClass("alert alert-danger")
                    .text("E-mail inválido!")
                    .show();
            }

        });

    }


    // remove vermelho ao digitar
    $emailLogin.on("input", function () {
        $(this).removeClass("is-invalid");
    });


    // CEP 















    //CLINICAS
    // TROCAR TELAS
    if ($linkLogClinica.length) {

        $linkLogClinica.on("click", function (e) {
            e.preventDefault();

            $cadFormClinica.hide();
            $logFormClinica.show();
        });

    }

    if ($linkCadClinica.length) {

        $linkCadClinica.on("click", function (e) {
            e.preventDefault();

            $logFormClinica.hide();
            $cadFormClinica.show();
        });

    }

    // PREVIEW IMAGEM CLÍNICA
    if ($inputImgClinica.length && $previewClinica.length) {

        $previewClinica.on("click", function () {
            $inputImgClinica.trigger("click");
        });

        $inputImgClinica.on("change", function () {

            const arquivo = this.files[0];

            if (arquivo && arquivo.type.startsWith("image/")) {

                const reader = new FileReader();

                reader.onload = function (e) {
                    $previewClinica.attr("src", e.target.result);
                };

                reader.readAsDataURL(arquivo);

            } else {
                mostrarAlert("Selecione uma imagem válida!", "danger");
            }

        });

    }

    // CADASTRO CLÍNICA
    $btnCadClinica.on("click", function () {
        let botao = $(this);
        botao.prop("disabled", true);
        botao.html(`
                    <span class="spinner-border spinner-border-sm"></span>
                    Cadastrando..
                `);

        // limpa erros anteriores
        $(".form-control, .form-select, textarea").removeClass("is-invalid");
        const imgPerfil = $inputImgClinica.val().trim();
        const nomeClinica = $nomeClinica.val().trim();
        const email = $emailCadClinicaInput.val().trim();
        const telefone = $telClinica.val().trim();
        const username = $userClinica.val().trim();
        const bio = $bioClinica.val().trim();
        const CEP = $cepClinica.val().trim();
        const cnpj = $cnpj.val().trim();
        const senha = $senhaClinica.val().trim();
        let erro = false;


        // VÊ OS CAMPOS VAZIOS
        if (!nomeClinica) {
            $nomeClinica.addClass("is-invalid");
            erro = true;
        }

        if (!email) {
            $emailCadClinicaInput.addClass("is-invalid");
            erro = true;
        }

        if (!telefone) {
            $telClinica.addClass("is-invalid");
            erro = true;
        }

        if (!username) {
            $userClinica.addClass("is-invalid");
            erro = true;
        }

        if (!bio) {
            $bioClinica.addClass("is-invalid");
            erro = true;
        }

        if (!CEP) {
            $cepClinica.addClass("is-invalid");
            $ruaClinica.addClass("is-invalid");
            $bairroClinica.addClass("is-invalid");
            $("#cidadeClinica").addClass("is-invalid");
            $ufClinica.addClass("is-invalid");
            $ibgeClinica.addClass("is-invalid");
            erro = true;
        }

        if (!cnpj) {
            $cnpj.addClass("is-invalid");
            erro = true;
        }

        if (!senha) {
            $senhaClinica.addClass("is-invalid");
            erro = true;
        }

        if (erro) {
            botao.prop("disabled", false);
            botao.html("Cadastrar");

            mostrarAlert("Preencha todos os campos!", "danger");
            return;
        }

        //IMAGEM
        if (!imgPerfil) {
            botao.prop("disabled", false);
            botao.html("Cadastrar");
            mostrarAlert("A imagem de perfil é obrigatoria.", "danger");
            return;
        }

        // EMAIL
        if (!emailValido(email)) {

            $emailCadClinicaInput.addClass("is-invalid");

            botao.prop("disabled", false);
            botao.html("Cadastrar");

            mostrarAlert("E-mail inválido!", "danger");
            return;
        }

        // CNPJ
        if (!cnpjValido(cnpj)) {

            $cnpj.addClass("is-invalid");

            botao.prop("disabled", false);
            botao.html("Cadastrar");

            mostrarAlert("CNPJ inválido!", "danger");
            return;
        }


        const telLimpo = telefone.replace(/\D/g, "");
        const cepLimpo = CEP.replace(/\D/g, "");
        const cnpjLimpo = cnpj.replace(/\D/g, "");

        let formData = new FormData();

        formData.append("nome", nomeClinica);
        formData.append("email", email);
        formData.append("telefone", telLimpo);
        formData.append("username", username);
        formData.append("bio", bio);
        formData.append("CEP", cepLimpo);
        formData.append("cnpj", cnpjLimpo);
        formData.append("senha", senha);
        formData.append("cxcliFoto", $("#img_perfil_clinica")[0].files[0]);

        $.ajax({
            url: "/EMP/model/cadclinica.php",
            method: "POST",

            data: formData,

            processData: false,
            contentType: false,

            success: function (resposta) {

                resposta = resposta.trim();

                console.log(resposta);

                botao.prop("disabled", false);
                botao.html("Cadastrar");

                if (resposta === "sucesso") {

                    mostrarAlert("Cadastro realizado!", "success");
                    mostrarFormulario("ativacaoCli");

                }

                else {

                    let erros = resposta.split("|");

                    console.log(erros);

                    erros.forEach(function (erro) {

                        if (erro.trim() != "") {

                            mostrarAlert(erro, "danger");

                        }

                    });

                }

            },

            error: function () {

                botao.prop("disabled", false);
                botao.html("Cadastrar");

                mostrarAlert("Erro na requisição!", "danger");

            }

        });

    });


    // remove vermelho ao digitar
    $(".form-control, .form-select, textarea").on("input change", function () {
        $(this).removeClass("is-invalid");
    });


    // LOGIN CLÍNICA
    if ($btnLogClinica.length) {

        $btnLogClinica.on("click", function () {

            const email = $emailLogClinica.val().trim();

            // limpa erro anterior
            $emailLogClinica.removeClass("is-invalid");

            if (!email) {

                $emailLogClinica.addClass("is-invalid");

                mostrarAlert("Preencha o e-mail!", "danger");
                return;
            }

            if (emailValido(email)) {

                $alertLogin
                    .removeClass("alert-danger")
                    .addClass("alert alert-success")
                    .text("Login realizado!")
                    .show();

            } else {

                $emailLogClinica.addClass("is-invalid");

                $alertLogin
                    .removeClass("alert-success")
                    .addClass("alert alert-danger")
                    .text("E-mail inválido!")
                    .show();
            }

        });

    }


    // remove vermelho ao digitar
    $emailLogClinica.on("input", function () {
        $(this).removeClass("is-invalid");
    });


    // CEP 
    $cepClinica.on("blur", function () {

        let cep = $(this).val().replace(/\D/g, "");

        // se vazio
        if (cep === "") {
            //limpa_formulário();
            return;
        }

        // valida formato
        const validaCep = /^[0-9]{8}$/;

        if (!validaCep.test(cep)) {

            $cepClinica.addClass("is-invalid");

            //limpa_formulário();
            mostrarAlert("Formato de CEP inválido!", "danger");
            return;
        }

        // loading nos campos
        $ruaClinica.val("...");
        $bairroClinica.val("...");
        $("#cidadeClinica").val("...");
        $ufClinica.val("...");
        $ibgeClinica.val("...");

        // consulta API ViaCEP
        $.getJSON(
            "https://viacep.com.br/ws/" + cep + "/json/?callback=?",
            function (dados) {

                if (!("erro" in dados)) {
                    $cepClinica.removeClass("is-invalid");

                    $ruaClinica.val(dados.logradouro);
                    $bairroClinica.val(dados.bairro);
                    $("#cidadeClinica").val(dados.localidade);
                    $ufClinica.val(dados.uf);
                    $ibgeClinica.val(dados.ibge);

                    $($parteCEPClinica).removeClass("is-invalid");

                } else {

                    //limpa_formulário();
                    $cepClinica.addClass("is-invalid");
                    botao.prop("disabled", false);
                    botao.html("Cadastrar");


                    mostrarAlert("CEP não encontrado!", "danger");
                }

            }
        );

    });
    $cepClinica.on("input", function () {
        $(this).removeClass("is-invalid");
    });






    // ALERTAS
    function mostrarAlert(mensagem, tipo = "success") {

        const $container = $("#alertContainer");

        const $alert = $(` <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
            ${mensagem}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            `);

        $container.append($alert);

        setTimeout(function () {

            $alert.removeClass("show").addClass("hide");

            setTimeout(function () {
                $alert.remove();
            }, 500);

        }, 3000);
    }

});