<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <title>Cadastro</title>

    <style>
        /* BASE*/

        body {
            margin: 0;
        }

        #cadastroClinica,
        #cadastroProfissional,
        #loginProfissional,
        #loginClinica,
        #esqueciForm,
        #codigoForm,
        .cadastro {
            display: none;
        }

        h1 {
            font-weight: 600;
        }

        p {
            color: #555;
            max-width: 400px;
            margin: auto;
        }


        .vh-100 {
            min-height: 100vh;
        }

        #imgBox {
            display: none;
        }

        #imgBox img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #colForm > div {
            max-width: 420px;
            width: 100%;
        }

        textarea {
            width: 100%;
            height: 250px;
            align-self: center;
        }


        .logo-titulo {
            width: 40%;
            object-fit: contain;
        }

        .avatar-container {
            width: 120px;
            height: 120px;
            margin: auto;
        }

        .avatar-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            cursor: pointer;
        }

        #img_perfil,
        #img_perfil_Clinica {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* TABLET+ (≥ 768px)*/

        @media (min-width: 768px) {

            #cadastroProfissional,
            #cadastroClinica,
            #loginProfissional,
            #loginClinica {
                width: 100%;
                max-width: 420px;
            }

            #imgBox {
                display: block;
                height: 100vh;
            }

            #imgBox img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            #colForm {
                height: 100vh;
                overflow-y: auto;
            }
        }




        /* DESKTOP (≥ 1200px)*/

        @media (min-width: 1200px) {

            #cadastroProfissional,
            #cadastroClinica,
            #loginProfissional,
            #loginClinica {
                width: 100%;
                max-width: 420px;
            }

            .logo-titulo {
                width: 40%;
            }
        }


        .form-esquerda {
            margin-left: 0 !important;
        }
    </style>

</head>

<body>
    <div class="container-fluid">
        <div id="alertContainer" class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 9999;">
        </div>
        <div class="row g-0 min-vh-100">

            <div id="imgBox" class="d-none d-md-block col-md-6">
                <img src="img/bannerVertical.jpg" class="img-fluid h-100 w-100 object-fit-cover">
            </div>

            <div id="colForm" class="col-12 col-md-6 d-flex justify-content-center align-items-center">
                <div class="w-75">

                    <!-- CADASTRO PROFISSIONAL -->
                    <div id="cadastroProfissional" class="cadastro">
                        <div class="text-center mt-4">
                            <div class="d-flex align-items-start justify-content-center gap-2">
                                <img src="img/logo_verde.png" class="logo-titulo">
                                <h1 class="m-0">Seja Bem-Vindo!</h1>
                            </div>
                            <p class="text-muted mt-2 mx-auto" style="max-width: 400px;">
                                Faça um cadastro como profissional para que os clientes possam encontrar seus serviços.
                            </p>
                        </div>

                        <div class="avatar-container">
                            <img id="preview" src="img/logo_user.png" alt="Foto de perfil">
                            <input name="cxproFoto" type="file" id="img_perfil" accept="image/*" required>
                        </div>

                        <p class="text-center mt-2" style="font-size: 12px;">
                            Clique na imagem para adicionar foto
                        </p>



                        <form>
                            <div class="form-floating mb-3">
                                <input name="cxproNome" id="nomeProfissional" class="form-control" type="text"
                                    placeholder="Nome" required>
                                <label>Nome completo</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input name="cxproEmail" id="emailCadastro" class="form-control" type="email"
                                    placeholder="E-mail" required>
                                <label>E-mail</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input name="cxproTelefone" id="telProfissional" class="form-control" type="tel"
                                    placeholder="Telfone" required>
                                <label>Telefone</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input name="cxproUsername" id="userProfissional" class="form-control" type="text"
                                    placeholder="Username" required>
                                <label>Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select name="cxgeneroProfissional" id="generoProfissional" class="form-select">
                                    <option value="" selected disabled>Selecione uma opção</option>
                                    <option value="feminino">Feminino</option>
                                    <option value="masculino">Masculino</option>
                                    <option value="naoBinario">Não Binario</option>
                                    <option value="naoIdentificado">Prefiro não dizer</option>
                                </select>
                                <label for="especialidade">Gênero</label>
                            </div>
                            <div class="form-floating mb-3">
                                <label>Biografia</label> <br />
                                <br /><textarea name="cxproBiografia" id="bioProfissional"
                                    placeholder="Escreva sua biografia aqui."></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input name="cep" class="form-control" type="text" id="cep" value=""
                                            placeholder="cep" required> <label>Cep</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input name="rua" class="form-control" type="text" id="rua" placeholder="rua"
                                            required>
                                        <label>Rua</label>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input name="bairro" class="form-control" type="text" id="bairro"
                                            placeholder="bairro" required> <label>Bairro</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input name="cidade" class="form-control" type="text" id="cidade"
                                            placeholder="cidade" required> <label>Cidade</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input name="uf" class="form-control" type="text" id="uf" placeholder="uf"
                                            required>
                                        <label>Estado</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input name="ibge" class="form-control" type="text" id="ibge" placeholder="ibge"
                                            required> <label>IBGE</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <input name="cxproRegistro" id="registroProfissional" class="form-control" type="file"
                                    placeholder="Registro" required>
                                <label>Registro profissional</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input name="cxproCPF" id="CPF" class="form-control" type="text" placeholder="CPF"
                                    required>
                                <label>CPF</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input name="cxproSenha" id="senhaProfissional" class="form-control" type="password"
                                    placeholder="Senha" required>
                                <label>Senha</label>
                            </div>
                        </form>
                        <div class="d-grid mb-3">
                            <button id="btnCadastrar" class="btn btn-success">Cadastrar</button>
                        </div>

                        <p>
                            Já tem uma conta? <a class="logarProfissional" href="#">Faça login</a>
                        </p>


                    </div>


                    <!-- LOGIN PROFISSIONAL-->
                    <div id="loginProfissional">
                        <div class="text-center mt-4">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <img src="img/logo_verde.png" class="logo-titulo">
                                <h1 class="m-0">Seja Bem-Vindo!</h1>
                            </div>
                            <p class="text-muted mt-2 mx-auto" style="max-width: 400px;">
                                Faça um cadastro como profissional para que os clientes possam encontrar seus serviços.
                            </p>
                        </div>

                        <form class="mt-4">

                            <div class="form-floating mt-4 mb-3">
                                <input id="emailLogin" class="form-control" type="text" placeholder="Email">
                                <label>E-mail</label>
                            </div>

                            <div class="form-floating mt-4 mb-3">
                                <input class="form-control" type="password" placeholder="Senha">
                                <label>Senha</label>
                            </div>

                            <!-- <a id="linkEsqueci" href="#">Esqueci a senha</a> -->

                        </form>

                        <div class="d-grid mt-4 mb-3">
                            <button id="btnLogar" class="btn btn-success">Logar</button>
                        </div>

                        <p> Não tem conta? <a class="cadastrarProfissional" href="#">Cadastre-se</a></p>

                        <div id="alertLogin" class="alert alert-danger">E-mail inválido!</div>

                    </div>

                    <!-- CADASTRO CLINICA-->
                    <div id="cadastroClinica" class="cadastro">
                        <div class="text-center mt-4">
                            <div class="d-flex align-items-start justify-content-center gap-2">
                                <img src="img/logo_verde.png" class="logo-titulo">
                                <h1 class="m-0">Seja Bem-Vindo!</h1>
                            </div>
                            <p class="text-muted mt-2 mx-auto" style="max-width: 400px;">
                                Cadastro a clinica em Elmo para que clientes consigam encontra-las!
                            </p>
                        </div>

                        <div class="avatar-container">
                            <img id="previewClinica" src="img/logo_user.png" alt="Foto de perfil">
                            <input name="cxclinFoto" type="file" id="img_perfil_Clinica" accept="image/*" required>
                        </div>

                        <p class="text-center mt-2" style="font-size: 12px;">
                            Clique na imagem para adicionar logo da clinica.
                        </p>

                        <form>
                            <div class="form-floating mb-3">
                                <input name="cxclinicaNome" id="nomeClinica" class="form-control" type="text"
                                    placeholder="Nome" required>
                                <label>Nome da clínica</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input name="exclinEmail" id="emailCadClinica" class="form-control" type="email"
                                    placeholder="E-mail" required>
                                <label>E-mail</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input name="cxclinTelefone" id="telClinica" class="form-control" type="tel"
                                    placeholder="Telfone" required>
                                <label>Telefone</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input name="cxclinUsername" id="userClinica" class="form-control" type="text"
                                    placeholder="Username" required>
                                <label>Username da clínica</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input name="cxclinBiografia" id="bioClinica" class="form-control" type="text"
                                    placeholder="Biografia" required>
                                <label>Biografia</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input name="cxclinCnpj" id="cnpj" class="form-control" type="text" placeholder="CNPJ"
                                    required>
                                <label>CNPJ</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input name="cxclinSenha" id="senhaClinica" class="form-control" type="password"
                                    placeholder="Senha" required>
                                <label>Senha</label>
                            </div>

                        </form>

                        <div class="d-grid mb-3">
                            <button id="btnCadClinica" class="btn btn-success">Cadastrar</button>
                        </div>

                        <p>Já tem conta? <a class="logarClinica" href="#">Faça login</a></p>
                    </div>

                    <!--LOGIN CLINICA-->
                    <div id="loginClinica">
                        <h1>Login Clínica</h1>

                        <form>
                            <div class="form-floating mb-3">
                                <input id="emailLogClinica" class="form-control" type="text">
                                <label>E-mail</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input class="form-control" type="password">
                                <label>Senha</label>
                            </div>
                        </form>

                        <div class="d-grid mb-3">
                            <button id="btnLogClinica" class="btn btn-success">Logar</button>
                        </div>

                        <p>Não tem conta? <a class="cadastrarClinica" href="#">Cadastre-se</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
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
            //PROFISSIONAL
            const inputImgProfissional = document.getElementById("img_perfil");
            const previewProfissional = document.getElementById("preview");

            const btnCadastrar = document.getElementById("btnCadastrar");
            const btnLogar = document.getElementById("btnLogar");

            const alertLogin = document.getElementById("alertLogin");

            const emailCadastro = document.getElementById("emailCadastro");
            const emailLogin = document.getElementById("emailLogin");

            const cadastroForm = document.getElementById("cadastroProfissional");
            const loginForm = document.getElementById("loginProfissional");

            const linkLogin = document.querySelector(".logarProfissional");
            const linkCadastro = document.querySelector(".cadastrarProfissional");

            //DADOS PROFISSIONAL
            const nomeProfissionalInput = document.getElementById("nomeProfissional");
            const emailCadastroInput = document.getElementById("emailCadastro");
            const telProfissionalInput = document.getElementById("telProfissional");
            const userProfissionalInput = document.getElementById("userProfissional");
            const generoProfissionalInput = document.getElementById("generoProfissional");
            const bioProfissionalInput = document.getElementById("bioProfissional");
            const cepProfissionalInput = document.getElementById("cep");
            const ruaProfissionalInput = document.getElementById("rua");
            const bairroProfissionalInput = document.getElementById("bairro");
            const ufProfissionalInput = document.getElementById("uf");
            const ibgeProfissionalInput = document.getElementById("ibge");
            const registroProfissionalInput = document.getElementById("registroProfissional");
            const CPFInput = document.getElementById("CPF");
            const senhaProfissionalInput = document.getElementById("senhaProfissional");


            //CLINICA
            const inputImgClinica = document.getElementById("img_perfil_Clinica");
            const previewClinica = document.getElementById("previewClinica");

            const btnCadClinica = document.getElementById("btnCadClinica");
            const btnLogClinica = document.getElementById("btnLogClinica");

            const emailCadClinica = document.getElementById("emailCadClinica");
            const emailLogClinica = document.getElementById("emailLogClinica");

            const cadFormClinica = document.getElementById("cadastroClinica");
            const logFormClinica = document.getElementById("loginClinica");

            const linkLogClinica = document.querySelector(".logarClinica");
            const linkCadClinica = document.querySelector(".cadastrarClinica");


            //DADOS CLINICA
            const nomeClinicaInput = document.getElementById("nomeClinica");
            const emailCadClinicaInput = document.getElementById("emailCadClinica");
            const telClinicaInput = document.getElementById("telClinica");
            const userClinicaInput = document.getElementById("userClinica");
            const bioClinicaInput = document.getElementById("bioClinica");
            const CNPJInput = document.getElementById("cnpj");
            const senhaClinicaInput = document.getElementById("senhaClinica");

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
            if (linkLogin) {
                linkLogin.addEventListener("click", function (e) {
                    e.preventDefault();
                    cadastroForm.style.display = "none";
                    loginForm.style.display = "block";
                });
            }

            if (linkCadastro) {
                linkCadastro.addEventListener("click", function (e) {
                    e.preventDefault();
                    loginForm.style.display = "none";
                    cadastroForm.style.display = "block";
                });
            }

            // PREVIEW DE IMAGEM
            if (inputImgProfissional && previewProfissional) {
                previewProfissional.addEventListener("click", () => inputImgProfissional.click());

                inputImgProfissional.addEventListener("change", function () {
                    const arquivo = this.files[0];

                    if (arquivo && arquivo.type.startsWith("image/")) {
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            previewProfissional.src = e.target.result;
                        };

                        reader.readAsDataURL(arquivo);
                    } else {
                        alert("Selecione uma imagem válida!");
                    }
                });
            }


            // CADASTRO PROFISSIONAL
            if (btnCadastrar) {
                btnCadastrar.addEventListener("click", function () {
                    const nomeProfissional = nomeProfissionalInput.value;
                    const email = emailCadastroInput.value;
                    const telefone = telProfissionalInput.value;
                    const username = userProfissionalInput.value;
                    const biografia = bioProfissionalInput.value;
                    const CEP = cepProfissionalInput.value;
                    const CPF = CPFInput.value;
                    const senha = senhaProfissionalInput.value;

                    if (nomeProfissional && email && telefone && username && biografia && CEP && CPF && senha) {

                        if (!emailValido(email)) {
                            mostrarAlert("E-mail inválido!", "danger");

                        } else if (!cpfValido(CPF)) {
                            mostrarAlert("CPF inválido!", "danger");
                        } else {
                            mostrarAlert("Cadastro realizado!", "success");
                        }

                    } else {
                        mostrarAlert("Preencha todos os campos!", "danger");
                    }
                });
            }

            // LOGIN
            if (btnLogar) {
                btnLogar.addEventListener("click", function () {
                    const email = emailLogin.value;

                    if (emailValido(email)) {
                        alertLogin.className = "alert alert-success";
                        alertLogin.textContent = "Login realizado!";
                    } else {
                        alertLogin.className = "alert alert-danger";
                        alertLogin.textContent = "E-mail inválido!";
                    }

                    alertLogin.style.display = "block";
                });
            }

            // TROCAR TELAS
            if (linkLogClinica) {
                linkLogClinica.addEventListener("click", function (e) {
                    e.preventDefault();
                    cadFormClinica.style.display = "none";
                    logFormClinica.style.display = "block";
                });
            }

            if (linkCadClinica) {
                linkCadClinica.addEventListener("click", function (e) {
                    e.preventDefault();
                    logFormClinica.style.display = "none";
                    cadFormClinica.style.display = "block";
                });
            }

            // preview Clinica DE IMAGEM
            if (inputImgClinica && previewClinica) {
                previewClinica.addEventListener("click", () => inputImgClinica.click());

                inputImgClinica.addEventListener("change", function () {
                    const arquivo = this.files[0];

                    if (arquivo && arquivo.type.startsWith("image/")) {
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            previewClinica.src = e.target.result;
                        };

                        reader.readAsDataURL(arquivo);
                    } else {
                        alert("Selecione uma imagem válida!");
                    }
                });
            }

            // CADASTRO CLINICA
            if (btnCadClinica) {
                btnCadClinica.addEventListener("click", function () {
                    const nomeClinica = nomeClinicaInput.value;
                    const email = emailCadClinicaInput.value;
                    const telefone = telClinicaInput.value;
                    const username = userClinicaInput.value;
                    const bio = bioClinicaInput.value;
                    const cnpj = CNPJInput.value;
                    const senha = senhaClinicaInput.value;

                    if (nomeClinica && email && telefone && username && bio && cnpj && senha) {

                        if (!cnpjValido(cnpj)) {
                            mostrarAlert("CNPJ inválido!", "danger");

                        }
                        else if (!emailValido(email)) {
                            mostrarAlert("E-mail inválido!", "danger");
                        }
                        else {
                            mostrarAlert("Cadastro realizado!", "success");
                        }

                    } else {
                        mostrarAlert("Preencha todos os campos!", "danger");
                    }

                    alertCadastro.style.display = "block";
                });
            }


            // LOGIN CLINICA
            if (btnLogClinica) {
                btnLogClinica.addEventListener("click", function () {
                    const email = emailLogClinica.value;

                    if (emailValido(email)) {
                        alertLogin.className = "alert alert-success";
                        alertLogin.textContent = "Login realizado!";
                    } else {
                        alertLogin.className = "alert alert-danger";
                        alertLogin.textContent = "E-mail inválido!";
                    }

                    alertLogin.style.display = "block";
                });
            }


            //ALERTAS
            function mostrarAlert(mensagem, tipo = "success") {
                const container = document.getElementById("alertContainer");

                const alert = document.createElement("div");
                alert.className = `alert alert-${tipo} alert-dismissible fade show`;
                alert.role = "alert";

                alert.innerHTML = `
        ${mensagem}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

                container.appendChild(alert);

                // Remove automaticamente depois de 3 segundos
                setTimeout(() => {
                    alert.classList.remove("show");
                    alert.classList.add("hide");
                    setTimeout(() => alert.remove(), 500);
                }, 3000);
            }



            //CEP
            $("#cep").blur(function () {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val()
                    .replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if (validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#rua").val("...");
                        $("#bairro").val("...");
                        $("#cidade").val("...");
                        $("#uf").val("...");
                        $("#ibge").val("...");

                        //Consulta o webservice viacep.com.br/
                        $
                            .getJSON(
                                "https://viacep.com.br/ws/"
                                + cep
                                + "/json/?callback=?",
                                function (
                                    dados) {

                                    if (!("erro" in dados)) {
                                        //Atualiza os campos com os valores da consulta.
                                        $(
                                            "#rua")
                                            .val(
                                                dados.logradouro);
                                        $(
                                            "#bairro")
                                            .val(
                                                dados.bairro);
                                        $(
                                            "#cidade")
                                            .val(
                                                dados.localidade);
                                        $(
                                            "#uf")
                                            .val(
                                                dados.uf);
                                        $(
                                            "#ibge")
                                            .val(
                                                dados.ibge);
                                    } //end if.
                                    else {
                                        //CEP pesquisado não foi encontrado.
                                        limpa_formulário();
                                        alert("CEP não encontrado.");
                                    }
                                });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário();
                }
            });



        });
    </script>
</body>

</html>