document.addEventListener("DOMContentLoaded", function () {
    //VARIAVEIS
    const $inputImgCliente = $("#img_perfil");
    const $previewCliente = $("#preview");

    const $btnCadastrar = $("#btnCadastrar");
    const $btnLogar = $("#btnLogar");

    //const $alertLogin = $("#alertLogin");

    const $emailCadastro = $("#emailCadastro");
    const $emailLogin = $("#emailLogin");

    const $cadastroForm = $("#cadastroCliente");
    const $loginForm = $("#loginCliente");

    const $linkLogin = $(".logarCliente");
    const $linkCadastro = $(".cadastrarCliente");


    //dados
    const $nomeCliente = $("#nomeCliente");
    const $userCliente = $("#userCliente");
    const $emailCadastroInput = $("#emailCadastro");
    const $telCliente = $("#telCliente");
    const $dataNascimetnoCli = $("dtnCli");
    const $generoCliente = $("#generoCliente");
    const $bioCliente = $("#bioCliente");
    const $cpf = $("#CPF");
    const $senhaCliente = $("#senhaCliente");


    // FUNÇÃO GLOBAL
    function limpa_formulário() {
        $("#nomeCliente").val("");
        $("#userCliente").val("");
        $("#emailCadastro").val("");
        $("#telCliente").val("");
        $("#dtnCli").val("");
        $("#generoCliente").val("");
        $("#bioCliente").val("");
        $("#CPF").val("");
        $("#senhaCliente").val("");
    }

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
            soma += parseInt(cpf[i]) * (10 - i);
        }

        let resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) resto = 0;

        if (resto !== parseInt(cpf[9])) return false;

        // Validação do segundo dígito
        soma = 0;
        for (let i = 0; i < 10; i++) {
            soma += parseInt(cpf[i]) * (11 - i);
        }

        resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) resto = 0;

        if (resto !== parseInt(cpf[10])) return false;

        return true;
    }



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
    if ($inputImgCliente.length && $previewCliente.length) {

        $previewCliente.on("click", function () {
            $inputImgCliente.trigger("click");
        });

        $inputImgCliente.on("change", function () {

            const arquivo = this.files[0];

            if (arquivo && arquivo.type.startsWith("image/")) {

                const reader = new FileReader();

                reader.onload = function (e) {
                    $previewCliente.attr("src", e.target.result);
                };

                reader.readAsDataURL(arquivo);

            } else {
                mostrarAlert("Selecione uma imagem válida!", "danger");
            }

        });
    }

    
    // CADASTRO PROFISSIONAL
    $btnCadastrar.on("click", function () {
        let botao = $(this);
        botao.prop("disabled", true);
        botao.html(`<span class="spinner-border spinner-border-sm"></span>`);

        // limpa erros anteriores
        $(".form-control, .form-select, textarea").removeClass("is-invalid");
        const imgPerfil = $inputImgCliente.val().trim();
        const nomeProfissional = $nomeCliente.val().trim();
        const email = $emailCadastroInput.val().trim();
        const telefone = $telCliente.val().trim();
        const username = $userCliente.val().trim();
        const generoCliente = $generoCliente.val().trim();
        const biografia = $bioCliente.val().trim();
        const dtnPro = $dataNascimetnoCli.val().trim();
        const CPF = $cpf.val().trim();
        const senha = $senhaCliente.val().trim();
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

        if(!dtnPro){
            $dtnPro.addClass("is-invalid");
            erro = true;
        }
        if (!CPF) {
            $cpf.addClass("is-invalid");
            erro = true;
        }

        if (!senha) {
            $senhaProfissional.addClass("is-invalid");
            erro = true;
        }

        if (!generoCliente.val()) {
            $generoCliente.addClass("is-invalid");
            erro = true;
        }
        
        
        if (erro) {
            botao.prop("disabled", false);
            botao.html("Cadastrar");
            mostrarAlert("Preencha todos os campos!", "danger");
            return;
        }

        //IMAGEM
        if(!imgPerfil){
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


        setTimeout(function () {

            botao.prop("disabled", false);
            botao.html("Cadastrar");

            mostrarAlert("Cadastro realizado!", "success");

        }, 2000);

    });


    // Remover a borada vermelha
    $(".form-control, .form-select, textarea").on("input change", function () {
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

})