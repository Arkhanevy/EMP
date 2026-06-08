$(document).ready(function () {

    const params = new URLSearchParams(window.location.search);
    const tipo = params.get("tipo") || "profissional";

    const forms = {
        profissional: "cadastroProfissional",
        clinica: "cadastroClinica"
    };

    mostrarFormulario(forms[tipo] || forms.profissional);

    function mostrarFormulario(id) {
        $(".cadastro").hide();
        $("#" + id).show();
    }


    //Objetos-Dados dos usuarios

    const prof = {
        img: $("#img_perfil"),
        preview: $("#preview"),
        nome: $("#nomeProfissional"),
        email: $("#emailCadastro"),
        tel: $("#telProfissional"),
        user: $("#userProfissional"),
        genero: $("#generoProfissional"),
        bio: $("#bioProfissional"),
        data: $("#dtnPro"),
        cpf: $("#CPF"),
        senha: $("#senhaProfissional"),
        cep: $("#cep"),
        rua: $("#rua"),
        bairro: $("#bairro"),
        uf: $("#uf"),
        ibge: $("#ibge"),
        registro: $("#registroProfissional"),
        form: $("#cadastroProfissional"),
        login: $("#loginProfissional")
    };

    const cli = {
        img: $("#img_perfil_Clinica"),
        preview: $("#previewClinica"),
        nome: $("#nomeClinica"),
        email: $("#emailCadClinica"),
        tel: $("#telClinica"),
        user: $("#userClinica"),
        bio: $("#bioClinica"),
        cnpj: $("#cnpj"),
        senha: $("#senhaClinica"),
        cep: $("#cepClinica"),
        rua: $("#ruaClinica"),
        bairro: $("#bairroClinica"),
        uf: $("#ufClinica"),
        ibge: $("#ibgeClinica"),
        form: $("#cadastroClinica"),
        login: $("#loginClinica")
    };

    const telas = {
        cadastroProfissional: $("#cadastroProfissional"),
        loginProfissional: $("#loginProfissional"),
    
        cadastroClinica: $("#cadastroClinica"),
        loginClinica: $("#loginClinica"),
    
        ativacao: $("#ativacao"),
        perfilUser: $("#perfilUser"),
        perfilClinica: $("#perfilClinica")
    };

    //Funções
    function mostrarTela(nomeTela) {

        // esconde todas
        Object.values(telas).forEach(tela => tela.hide());
    
        // mostra a escolhida
        if (telas[nomeTela]) {
            telas[nomeTela].show();
        } else {
            console.warn("Tela não encontrada:", nomeTela);
        }
    }

    function mostrarAlert(mensagem, tipo = "success") {
        const $container = $("#alertContainer");

        const $alert = $(`
            <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
                ${mensagem}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);

        $container.append($alert);

        setTimeout(() => {
            $alert.fadeOut(200, () => $alert.remove());
        }, 3000);
    }

    function emailValido(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function apenasNumeros(v) {
        return v.replace(/\D/g, "");
    }

    function limparInvalid($els) {
        $els.removeClass("is-invalid");
    }

    function validarCampos(campos) {
        let erro = false;

        campos.forEach(c => {
            if (!c.valor) {
                c.el.addClass("is-invalid");
                erro = true;
            }
        });

        return erro;
    }

    function cpfValido(cpf) {
        cpf = cpf.replace(/\D/g, "");
    
        if (cpf.length !== 11) return false;
        if (/^(\d)\1+$/.test(cpf)) return false;
    
        let soma = 0;
    
        for (let i = 0; i < 9; i++) {
            soma += parseInt(cpf[i]) * (10 - i);
        }
    
        let resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) resto = 0;
    
        if (resto !== parseInt(cpf[9])) return false;
    
        soma = 0;
    
        for (let i = 0; i < 10; i++) {
            soma += parseInt(cpf[i]) * (11 - i);
        }
    
        resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) resto = 0;
    
        return resto === parseInt(cpf[10]);
    }

    function cnpjValido(cnpj) {
        cnpj = cnpj.replace(/\D/g, "");
    
        if (cnpj.length !== 14) return false;
        if (/^(\d)\1+$/.test(cnpj)) return false;
    
        let tamanho = 12;
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
    
        tamanho = 13;
        numeros = cnpj.substring(0, tamanho);
    
        soma = 0;
        pos = tamanho - 7;
    
        for (let i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) pos = 9;
        }
    
        resultado = soma % 11 < 2 ? 0 : 11 - (soma % 11);
    
        return resultado == digitos.charAt(1);
    }

    //IMG
    function configurarPreview(input, preview) {

        preview.on("click", () => input.trigger("click"));

        input.on("change", function () {

            const file = this.files[0];

            if (!file || !file.type.startsWith("image/")) {
                mostrarAlert("Selecione uma imagem válida!", "danger");
                return;
            }

            const reader = new FileReader();

            reader.onload = e => preview.attr("src", e.target.result);
            reader.readAsDataURL(file);
        });
    }

    //CEP

    function configurarCEP(config) {

        config.cep.on("blur", function () {

            const cep = apenasNumeros($(this).val());

            if (!/^[0-9]{8}$/.test(cep)) {
                mostrarAlert("CEP inválido!", "danger");
                return;
            }

            config.rua.val("...");
            config.bairro.val("...");
            config.cidade.val("...");
            config.uf.val("...");
            config.ibge.val("...");

            $.getJSON(`https://viacep.com.br/ws/${cep}/json/?callback=?`, function (dados) {

                if (dados.erro) {
                    mostrarAlert("CEP não encontrado!", "danger");
                    return;
                }

                config.rua.val(dados.logradouro);
                config.bairro.val(dados.bairro);
                config.cidade.val(dados.localidade);
                config.uf.val(dados.uf);
                config.ibge.val(dados.ibge);

            });
        });

        config.cep.on("input", function () {
            $(this).removeClass("is-invalid");
        });
    }

    //Funções-Estrutura

    configurarPreview(prof.img, prof.preview);
    configurarPreview(cli.img, cli.preview);

    configurarCEP({
        cep: prof.cep,
        rua: prof.rua,
        bairro: prof.bairro,
        cidade: $("#cidade"),
        uf: prof.uf,
        ibge: prof.ibge
    });

    configurarCEP({
        cep: cli.cep,
        rua: cli.rua,
        bairro: cli.bairro,
        cidade: $("#cidadeClinica"),
        uf: cli.uf,
        ibge: cli.ibge
    });

    $(document).on("input change", ".form-control, .form-select, textarea", function () {
        $(this).removeClass("is-invalid");
    });


    //PROFISSIONAL
    //Troca de telas
    $(".logarProfissional").on("click", function (e) {
        e.preventDefault();
        mostrarTela("loginProfissional");
    });
    
    $(".cadastrarProfissional").on("click", function (e) {
        e.preventDefault();
        mostrarTela("cadastroProfissional");
    });

    //CADASTRO PROFISSIONAL

    $("#btnCadastrar").on("click", function () {

        const btn = $(this);
        btn.prop("disabled", true).html("Cadastrando...");

        limparInvalid($(".form-control, .form-select, textarea"));
        const campos = [
            { valor: prof.nome.val(), el: prof.nome },
            { valor: prof.tel.val(), el: prof.tel },
            { valor: prof.user.val(), el: prof.user },
            { valor: prof.bio.val(), el: prof.bio },
            { valor: prof.data.val(), el: prof.data },
            { valor: prof.registro.val(), el: prof.registro },
            { valor: prof.senha.val(), el: prof.senha },
            { valor: prof.genero.val(), el: prof.genero }
        ];

        if (validarCampos(campos)) {
            btn.prop("disabled", false).html("Cadastrar");
            mostrarAlert("Preencha todos os campos!", "danger");
            return;
        }

        const email = prof.email.val();

        if (!emailValido(email)) {
            prof.email.addClass("is-invalid");
            btn.prop("disabled", false).html("Cadastrar");
            mostrarAlert("E-mail inválido!", "danger");
            return;
        }

        const imgFile = prof.img[0].files[0];

        if (!imgFile) {
            btn.prop("disabled", false).html("Cadastrar");
            mostrarAlert("A imagem de perfil é obrigatória.", "danger");
            return;
        }
        const cpfLimpo = prof.cpf.val().replace(/\D/g, "");
        const CEPLimpo = prof.cep.val().replace(/\D/g, "");



        const formData = new FormData();
        formData.append("nome", prof.nome.val());
        formData.append("email", prof.email.val());
        formData.append("telefone", prof.tel.val());
        formData.append("username", prof.user.val());
        formData.append("bio", prof.bio.val());
        formData.append("dtNas", prof.data.val());
        formData.append("registro", prof.registro.val());
        formData.append("senha", prof.senha.val());
        formData.append("genero", prof.genero.val());
        formData.append("CEP", CEPLimpo);
        formData.append("CPF", cpfLimpo);
        formData.append("acao", "cadastrar");
        formData.append("cxproFoto", imgFile);

        $img = "cxproFoto";
        $.ajax({
            url: "../controller/profissionalcontroller.php",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (r) {
                btn.prop("disabled", false).html("Cadastrar");

                if (r.trim() === "sucesso") {
                    mostrarAlert("Cadastro realizado!", "success");
                    mostrarFormulario("ativacao");
                } else {
                    mostrarAlert(r, "danger");
                }
            },
            error: function () {
                btn.prop("disabled", false).html("Cadastrar");
                mostrarAlert("Erro na requisição!", "danger");
            }
        });
    });

    //LOGIN

    $("#btnLogar").on("click", function (e) {

        e.preventDefault();

        const btn = $(this);
        btn.prop("disabled", true).html("Entrando...");

        const email = $("#emailLogin").val();
        const senha = $("#senhaLogin").val();

        if (!email || !senha) {
            mostrarAlert("Preencha todos os campos!", "danger");
            btn.prop("disabled", false).html("Logar");
            return;
        }

        if (!emailValido(email)) {
            mostrarAlert("E-mail inválido!", "danger");
            btn.prop("disabled", false).html("Logar");
            return;
        }

        const fd = new FormData();
        fd.append("email", email);
        fd.append("senha", senha);
        fd.append("acao", "login");

        $.ajax({
            url: "../controller/profissionalcontroller.php",
            method: "POST",
            data: fd,
            processData: false,
            contentType: false,
            success: function (r) {
                btn.prop("disabled", false).html("Logar");

                if (r.trim() === "sucesso") {
                    window.location.href = "../view/perfilProfissional.php";
                } else {
                    mostrarAlert(r, "danger");
                }
            }
        });
    });

    let codigoProf = null;

    /* GERAR CÓDIGO */

    $("#btnCodigo").on("click", function (e) {

        e.preventDefault();

        const btn = $(this);
        btn.prop("disabled", true);

        let tempo = 60;
        btn.text(`Aguarde ${tempo}s`);

        const interval = setInterval(() => {

            tempo--;
            btn.text(`Aguarde ${tempo}s`);

            if (tempo <= 0) {
                clearInterval(interval);
                btn.prop("disabled", false);
                btn.text("Gerar código");
            }

        }, 1000);

        codigoProf = Math.floor(Math.random() * 9000) + 1000;

        console.log("Código profissional:", codigoProf);

        $.post("../controller/profissionalcontroller.php", {
            acao: "gerarCodigo",
            codigo: codigoProf
        });
    });


    //ATIVACAO

    $("#btnAtivar").on("click", function (e) {

        e.preventDefault();

        const btn = $(this);
        btn.prop("disabled", true).html("Ativando...");

        const inputCodigo = $("#codigoCliente").val().trim();

        if (codigoProf === null) {
            mostrarAlert("Gere um código primeiro!", "danger");
            btn.prop("disabled", false).html("Ativar");
            return;
        }

        if (!inputCodigo) {
            mostrarAlert("Digite o código enviado!", "danger");
            $("#codigoCliente").addClass("is-invalid");
            btn.prop("disabled", false).html("Ativar");
            return;
        }

        if (inputCodigo != codigoProf) {
            mostrarAlert("Código inválido!", "danger");
            $("#codigoCliente").addClass("is-invalid");
            btn.prop("disabled", false).html("Ativar");
            return;
        }
        $.ajax({
            url: "../controller/profissionalcontroller.php",
            method: "POST",
            data: { acao: "ativar", codigo: inputCodigo },

            success: function (resposta) {

                btn.prop("disabled", false).html("Ativar");

                if (resposta.trim() === "sucesso") {
                    mostrarAlert("Conta ativada com sucesso!", "success");

                    // fluxo correto pós-ativação
                    mostrarFormulario("perfilUser");
                } else {
                    mostrarAlert(resposta, "danger");
                }
            },

            error: function (xhr, status, error) {
                console.log("STATUS:", status);
                console.log("ERRO:", error);
                console.log("RESPOSTA:", xhr.responseText);
            
                mostrarAlert("Erro na requisição!", "danger");
            }
        });
    });



    //CLINICA

    //troca de telas
    $(".logarClinica").on("click", function (e) {
        e.preventDefault();
        mostrarTela("loginClinica");
    });
    
    $(".cadastrarClinica").on("click", function (e) {
        e.preventDefault();
        mostrarTela("cadastroClinica");
    });

    //cadastro
    $("#btnCadClinica").on("click", function () {

        const btn = $(this);
        btn.prop("disabled", true).html("Cadastrando...");

        limparInvalid($(".form-control, .form-select, textarea"));

        const campos = [
            { valor: cli.nome.val(), el: cli.nome },
            { valor: cli.tel.val(), el: cli.tel },
            { valor: cli.user.val(), el: cli.user },
            { valor: cli.bio.val(), el: cli.bio },
            { valor: cli.senha.val(), el: cli.senha }
        ];

        if (validarCampos(campos)) {
            btn.prop("disabled", false).html("Cadastrar");
            mostrarAlert("Preencha todos os campos!", "danger");
            return;
        }

        const email = cli.email.val();
        const cnpj = cli.cnpj.val();
        const cep = apenasNumeros(cli.cep.val());

        // EMAIL
        if (!emailValido(email)) {
            cli.email.addClass("is-invalid");
            btn.prop("disabled", false).html("Cadastrar");
            mostrarAlert("E-mail inválido!", "danger");
            return;
        }

        // CNPJ
        if (!cnpj || !cnpjValido(cnpj)) {
            cli.cnpj.addClass("is-invalid");
            btn.prop("disabled", false).html("Cadastrar");
            mostrarAlert("CNPJ inválido!", "danger");
            return;
        }

        // IMAGEM
        if (!cli.img.val()) {
            btn.prop("disabled", false).html("Cadastrar");
            mostrarAlert("Imagem obrigatória!", "danger");
            return;
        }

        const formData = new FormData();

        formData.append("nomeClinica", cli.nome.val());
        formData.append("emailClinica", email);
        formData.append("telefoneClinica", apenasNumeros(cli.tel.val()));
        formData.append("usernameClinica", cli.user.val());
        formData.append("bioClinica", cli.bio.val());
        formData.append("CEPClinica", cep);
        formData.append("CNPJClinica", apenasNumeros(cnpj));
        formData.append("senhaClinica", cli.senha.val());
        formData.append("cxclinFoto", cli.img[0].files[0]);
        formData.append("acao", "cadastrar");

        $.ajax({
            url: "../controller/clinicacontroller.php",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,

            success: function (resposta) {

                btn.prop("disabled", false).html("Cadastrar");

                if (resposta.trim() === "sucesso") {
                    mostrarAlert("Cadastro realizado!", "success");
                    mostrarFormulario("ativacao");
                } else {
                    mostrarAlert(resposta, "danger");
                }
            },

            error: function () {
                btn.prop("disabled", false).html("Cadastrar");
                mostrarAlert("Erro na requisição!", "danger");
            }
        });
    });


    //Login
    $("#btnLogClinica").on("click", function (e) {

        e.preventDefault();

        const btn = $(this);
        btn.prop("disabled", true).html("Entrando...");

        const email = $("#emailLogClinica").val();
        const senha = $("#senhaLogClinica").val();

        if (!email || !senha) {
            mostrarAlert("Preencha todos os campos!", "danger");
            btn.prop("disabled", false).html("Logar");
            return;
        }

        if (!emailValido(email)) {
            mostrarAlert("E-mail inválido!", "danger");
            btn.prop("disabled", false).html("Logar");
            return;
        }

        const fd = new FormData();
        fd.append("email", email);
        fd.append("senha", senha);
        fd.append("acao", "login");

        $.ajax({
            url: "../controller/clinicacontroller.php",
            method: "POST",
            data: fd,
            processData: false,
            contentType: false,

            success: function (resposta) {

                btn.prop("disabled", false).html("Logar");

                if (resposta.trim() === "sucesso") {
                    window.location.href = "../view/perfilClinica.php";
                } else {
                    mostrarAlert(resposta, "danger");
                }
            },

            error: function () {
                btn.prop("disabled", false).html("Logar");
                mostrarAlert("Erro na requisição!", "danger");
            }
        });
    });


    let codigoCli = null;

    // GERAR CÓDIGO
    $("#btnCodigoCli").on("click", function (e) {

        e.preventDefault();

        const btn = $(this);
        btn.prop("disabled", true);

        let tempo = 60;
        btn.text(`Aguarde ${tempo}s`);

        const interval = setInterval(() => {

            tempo--;
            btn.text(`Aguarde ${tempo}s`);

            if (tempo <= 0) {
                clearInterval(interval);
                btn.prop("disabled", false);
                btn.text("Gerar código");
            }

        }, 1000);

        codigoCli = Math.floor(Math.random() * 9000) + 1000;

        $.post("../controller/clinicacontroller.php", {
            acao: "gerarCodigo",
            codigo: codigoCli
        });
    });


    // ATIVAÇÃO
    $("#btnAtivarCli").on("click", function (e) {

        e.preventDefault();

        const btn = $(this);
        btn.prop("disabled", true).html("Ativando...");

        const inputCodigo = $("#codigoCli").val().trim();

        if (codigoCli === null) {
            mostrarAlert("Gere um código primeiro!", "danger");
            btn.prop("disabled", false).html("Ativar");
            return;
        }

        if (!inputCodigo) {
            mostrarAlert("Digite o código!", "danger");
            btn.prop("disabled", false).html("Ativar");
            return;
        }

        if (inputCodigo != codigoCli) {
            mostrarAlert("Código inválido!", "danger");
            btn.prop("disabled", false).html("Ativar");
            return;
        }

        $.ajax({
            url: "../controller/clinicacontroller.php",
            method: "POST",
            data: {
                acao: "ativar",
                codigo: inputCodigo
            },

            success: function (resposta) {

                btn.prop("disabled", false).html("Ativar");

                if (resposta.trim() === "sucesso") {
                    mostrarAlert("Conta ativada!", "success");
                    mostrarFormulario("perfilClinica");
                } else {
                    mostrarAlert(resposta, "danger");
                }
            },

            error: function () {
                btn.prop("disabled", false).html("Ativar");
                mostrarAlert("Erro na requisição!", "danger");
            }
        });
    });


});