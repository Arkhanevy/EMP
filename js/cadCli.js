document.addEventListener("DOMContentLoaded", function () {
    const forms = {
        profissionalCad: "cadastroProfissional",
        clinicaCad: "cadastroClinica",
        ativacao: "ativacao",
        profissionalLog: "loginProfissional",
        clinicaLog: "loginClinica"
    };

    function mostrarTela(nomeTela) {
        Object.values(telas).forEach(tela => tela.hide());

        if (telas[nomeTela]) {
            telas[nomeTela].show();
        } else {
            console.warn("Tela não encontrada:", nomeTela);
        }
    }
    
    mostrarTela(forms[tipo] || forms.profissionalCad);
   /* //VARIAVEIS
    const $inputImgCliente = $("#img_perfil");
    const $previewCliente = $("#preview");

    //CADASTRO
    const $btnCadastrar = $("#btnCadastrar");
    const $cadastroForm = $("#cadastroCliente");
    const $linkCadastro = $(".cadastrarCliente");

    //ATIVAÇÃO
    const $btnAtivar = $("#btnAtivar");
    const $btnCodigo = $("#btnCodigo");


    //LOGIN
    const $btnLogar = $("#btnLogar");
    const $emailLogin = $("#emailLogin");
    const $senhaLogin = $("#senhaLogin");
    const $loginForm = $("#loginCliente");
    const $linkLogin = $(".logarCliente");*/


    //Objetos-Dados dos usuarios

    const prof = {
        img: $("#img_perfil"),
        preview: $("#preview"),
        nome: $("#nomeCliente"),
        email: $("#emailCadastro"),
        tel: $("#telCliente"),
        user: $("#userCliente"),
        genero: $("#generoCliente"),
        bio: $("#bioCliente"),
        data: $("#dtnCli"),
        cpf: $("#CPF"),
        senha: $("#senhaCliente"),
        form: $("#cadastroCliente"),
        login: $("#login"),
        loginEmail: $("#emailLog"),
        loginSenha: $("#senhaLog"),
        emailAtivacao: $("#emailAtivar"),
        codigo: $("#codigoCliente")
    };

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


    // CADASTRO
    $btnCadastrar.on("click", function (e) {
        e.preventDefault();
        let botao = $(this);
        botao.prop("disabled", true);
        botao.html(`<span class="spinner-border spinner-border-sm"></span>Cadastrando..`);

        // limpa erros anteriores
        $(".form-control, .form-select, textarea").removeClass("is-invalid");
        const imgPerfil = $inputImgCliente.val().trim();
        const nome = $nomeCliente.val().trim();
        const username = $userCliente.val().trim();
        const email = $emailCliente.val().trim();
        const genero = $generoCliente.val();
        const telefone = $telCliente.val().trim();
        const dtn = $dataNascimetnoCli.val().trim();
        const biografia = $bioCliente.val().trim();
        const CPF = $cpfCliente.val().trim();
        const senha = $senhaCliente.val().trim();
        let erro = false;


        // VÊ OS CAMPOS VAZIOS
        const camposObrigatorios = [
            { valor: nome, elemento: $nomeCliente },
            { valor: username, elemento: $userCliente },
            { valor: genero, elemento: $generoCliente },
            { valor: telefone, elemento: $telCliente },
            { valor: dtn, elemento: $dataNascimetnoCli },
            { valor: biografia, elemento: $bioCliente },
            { valor: senha, elemento: $senhaCliente },
        ];

        camposObrigatorios.forEach(campo => {
            if (!campo.valor) {
                campo.elemento.addClass("is-invalid");
                erro = true;
            }
        });


        //E-MAIL
        if (!email) {
            $emailCliente.addClass("is-invalid");
            erro = true;
        } else if (!emailValido(email)) {
            $emailCliente.addClass("is-invalid");
            botao.prop("disabled", false);
            botao.html("Cadastrar");
            mostrarAlert("E-mail inválido!", "danger");
            return;
        }

        //CPF
        if (!CPF) {
            $cpfCliente.addClass("is-invalid");
            erro = true;
        } else if (!cpfValido(CPF)) {
            $cpfCliente.addClass("is-invalid");
            botao.prop("disabled", false);
            botao.html("Cadastrar");
            mostrarAlert("CPF inválido!", "danger");
            return;
        }

        //IMAGEM
        if (!imgPerfil) {
            botao.prop("disabled", false);
            botao.html("Cadastrar");
            mostrarAlert("A imagem de perfil é obrigatoria.", "danger");
            return;
        }

        if (erro) {
            botao.prop("disabled", false);
            botao.html("Cadastrar");
            mostrarAlert("Preencha todos os campos!", "danger");
            return;
        }


        const cpfLimpo = CPF.replace(/\D/g, "");
        const telLimpo = telefone.replace(/\D/g, "");

        let formData = new FormData();

        formData.append("nome", nome);
        formData.append("email", email);
        formData.append("username", username);
        formData.append("genero", genero);
        formData.append("telefone", telLimpo);
        formData.append("dtNas", dtn);
        formData.append("bio", biografia);
        formData.append("senha", senha);
        formData.append("CPF", cpfLimpo);
        formData.append("cxcliFoto", $("#img_perfil")[0].files[0]);
        formData.append("acao", "cadastrar");
        $.ajax({
            url: "../controller/clientecontroller.php",
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
                    mostrarFormulario("ativacao");

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

    });
    // Remover a borada vermelha
    $(".form-control, .form-select, textarea").on("input change", function () {
        $(this).removeClass("is-invalid");
    });

    // LOGIN
    $btnLogar.on("click", function (e) {
        e.preventDefault();
        let botao = $(this);
        botao.prop("disabled", true);
        botao.html(`<span class="spinner-border spinner-border-sm"></span>Logando..`);
        // limpa erros anteriores
        $(".form-control").removeClass("is-invalid");
        const emailLogin = $emailLogin.val().trim();
        const senhaLogin = $senhaLogin.val().trim();
        let erro = false;

        // VÊ OS CAMPOS VAZIOS
        if (!emailLogin) {
            $emailLogin.addClass("is-invalid");
        }
        if (!senhaLogin) {
            $senhaLogin.addClass("is-invalid");
            erro = true;
        }

        if (erro) {
            botao.prop("disabled", false);
            botao.html("Logar");
            mostrarAlert("Preencha todos os campos!", "danger");
            return;
        }

        if (erro) {
            botao.prop("disabled", false);
            botao.html("Logar");
            mostrarAlert("Preencha todos os campos!", "danger");
            return;
        }

        if (!emailValido(emailLogin)) {
            $emailLogin.addClass("is-invalid");
            botao.prop("disabled", false);
            botao.html("Logar");
            mostrarAlert("E-mail inválido!", "danger");
            return;
        }
    });
    // Remover a borada vermelha
    $(".form-control").on("input change", function () {
        $(this).removeClass("is-invalid");
    });



    function mostrarFormulario(cadastroId) {

        $(".cadastro").hide();

        $("#" + cadastroId).show();
    }



    const codigo = 0;

    // ATIVAÇÃO
    $btnCodigo.on("click", function (e) {
        e.preventDefault();
        let botao = $(this);
        botao.prop("disabled", true);
        botao.html(`<span class="spinner-border spinner-border-sm"></span>Codigo enviado, espere`);
        const gerarCodigo = (min, max) => {
            return Math.random() * (max - min) + min
        }
        codigo = gerarCodigo(1000, 9999)
        console.log(codigo)
    });

    $btnAtivar.on("click", function (e) {
        e.preventDefault();
        let botao = $(this);
        botao.prop("disabled", true);
        botao.html(`<span class="spinner-border spinner-border-sm"></span>Ativando conta..`);
        // limpa erros anteriores
        $(".form-control").removeClass("is-invalid");
        const codigoCliente = $codigoCliente.val().trim();

        codigo
        
        // VÊ OS CAMPOS VAZIOS
        if (!codigoCliente) {
            $codigoCliente.addClass("is-invalid");
            botao.prop("disabled", false);
            botao.html("Ativar");
            mostrarAlert("Preencha o campo com o código de acesso para finalizar o cadastro!", "danger");
        } else if (!codigoValido(codigoCliente)) {
            $codigoCliente.addClass("is-invalid");
            botao.prop("disabled", false);
            botao.html("Ativar");
            mostrarAlert("Código inválido!", "danger");
            return;
        }
    });
    // Remover a borada vermelha
    $(".form-control").on("input change", function () {
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