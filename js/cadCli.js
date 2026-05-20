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
        
})