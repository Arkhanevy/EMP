
document.addEventListener("DOMContentLoaded", function () {


    //QUAL FORMULARI ABRIR
    const params = new URLSearchParams(window.location.search);
    const tipo = params.get("tipo");

    if (tipo === "clinica") {
        mostrarFormulario('cadastroClinica');
    } else if (tipo === "profissional") {
        mostrarFormulario('cadastroProfissional');
    } else {
        mostrarFormulario('cadastroProfissional');
    }

    function mostrarFormulario(cadastroId) {
        var cadastros = document.querySelectorAll('.cadastro');

        cadastros.forEach(function (form) {
            form.style.display = 'none';
        });

        var formParaMostrar = document.getElementById(cadastroId);

        if (formParaMostrar) {
            formParaMostrar.style.display = 'block';
        } else {
            console.error("Formulário não encontrado:", cadastroId);
        }
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
    const $cepProfissional = $("#cep");
    const $ruaProfissional = $("#rua");
    const $bairroProfissional = $("#bairro");
    const $ufProfissional = $("#uf");
    const $ibgeProfissional = $("#ibge");
    const $registroProfissional = $("#registroProfissional");
    const $cpf = $("#CPF");
    const rua = $ruaProfissional.val().trim();
    const bairro = $bairroProfissional.val().trim();
    const cidade = $("#cidade").val().trim();
    const estado = $ufProfissional.val().trim();
    const ibge = $ibgeProfissional.val().trim();
    const $senhaProfissional = $("#senhaProfissional");
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


    // FUNÇÃO GLOBAL
    function limpa_formulário() {
        $("#emailCadastro").val("");
        $("#nome").val("");
        $("#senha").val("");
        $("#rua").val("");
        $("#bairro").val("");
        $("#cidade").val("");
        $("#uf").val("");
        $("#ibge").val("");
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
        let botao = $(this);
        botao.prop("disabled", true);
        botao.html(`
                    <span class="spinner-border spinner-border-sm"></span>
                    Cadastrando..
                `);

        // limpa erros anteriores
        $(".form-control, .form-select, textarea").removeClass("is-invalid");
        const nomeProfissional = $nomeProfissional.val().trim();
        const email = $emailCadastroInput.val().trim();
        const telefone = $telProfissional.val().trim();
        const username = $userProfissional.val().trim();
        const biografia = $bioProfissional.val().trim();
        const CEP = $cepProfissional.val().trim();
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
        if (!CPF) {
            $cpf.addClass("is-invalid");
            erro = true;
        }

        if (!registro) {
            $registroProfissional.addClass("is-invalid");
            erro = true;
        }

        if (!CEP) {
            $cepProfissional.addClass("is-invalid");
            erro = true;
        }

        if (!rua) {
            $ruaProfissional.addClass("is-invalid");
            erro = true;
        }

        if (!bairro) {
            $bairroProfissional.addClass("is-invalid");
            erro = true;
        }

        if (!cidade) {
            $("#cidade").addClass("is-invalid");
            erro = true;
        }

        if (!estado) {
            $ufProfissional.addClass("is-invalid");
            erro = true;
        }

        if (!ibge) {
            $ibgeProfissional.addClass("is-invalid");
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

    // TROCAR TELAS CLÍNICA
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
    if ($btnCadClinica.length) {

        $btnCadClinica.on("click", function () {

            let botao = $(this);

            botao.prop("disabled", true);
            botao.html(`
        <span class="spinner-border spinner-border-sm"></span>
        Cadastrando...
    `);

            // limpa erros anteriores
            $(".form-control").removeClass("is-invalid");

            const nomeClinica = $nomeClinica.val().trim();
            const email = $emailCadClinicaInput.val().trim();
            const telefone = $telClinica.val().trim();
            const username = $userClinica.val().trim();
            const bio = $bioClinica.val().trim();
            const cnpj = $cnpj.val().trim();
            const senha = $senhaClinica.val().trim();

            let erro = false;

            // CAMPOS VAZIOS
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

            // SUCESSO
            setTimeout(function () {

                botao.prop("disabled", false);
                botao.html("Cadastrar");

                mostrarAlert("Cadastro realizado!", "success");

            }, 2000);

        });

    }


    // remove vermelho ao digitar
    $(
        "#nomeClinica, #emailCadClinica, #telClinica, #userClinica, #bioClinica, #cnpj, #senhaClinica"
    ).on("input", function () {
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



    // ALERTAS
    function mostrarAlert(mensagem, tipo = "success") {

        const $container = $("#alertContainer");

        const $alert = $(`
    <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
        ${mensagem}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
`);

        $container.append($alert);

        // remove automaticamente depois de 3 segundos
        setTimeout(function () {

            $alert.removeClass("show").addClass("hide");

            setTimeout(function () {
                $alert.remove();
            }, 500);

        }, 3000);
    }



    // CEP
    $cepProfissional.on("blur", function () {

        let cep = $(this).val().replace(/\D/g, "");

        // se vazio
        if (cep === "") {
            limpa_formulário();
            return;
        }

        // valida formato
        const validaCep = /^[0-9]{8}$/;

        if (!validaCep.test(cep)) {

            $cepProfissional.addClass("is-invalid");

            limpa_formulário();
            mostrarAlert("Formato de CEP inválido!", "danger");
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

                    limpa_formulário();

                    $cepProfissional.addClass("is-invalid");

                    mostrarAlert("CEP não encontrado!", "danger");
                }

            }
        );

    });


    // remove vermelho ao digitar
    $cepProfissional.on("input", function () {
        $(this).removeClass("is-invalid");
    });


    mostrarFormulario("cadastroProfissional");

});