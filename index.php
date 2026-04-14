<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <title>Cadastro</title>

</head>

<body>

    <div class="container-fluid p-0">
        <nav>
            <div class="d-flex flex-row-reverse bg-success mt-0">
                <div class="p-2 text-light">Login</div>
            </div>
        </nav>
        <div class="row g-0 vh-100">
            <div id="imgBox" class="col-12 col-sm-6 col-md-6 d-none d-sm-block d-md-block bg-success">
                <img src="img/logo.png">
            </div>

            <div id="colForm" class="col-12 col-sm-6 col-md-6 d-flex justify-content-center">

                <div style="width: 80%">

                    <!-- CADASTRO -->
                    <div id="cadastroForm">

                        <div class="d-flex justify-content-between mt-4">
                            <h1>Seja Bem-Vindo!</h1>
                            <img class="logo" src="img/logo_verde.png">
                        </div>

                        <div class="avatar-container">

                            <img id="preview" src="img/logo_user.png" alt="Foto de perfil"  class="mx-auto d-block" style="width:50%">

                            <input type="file" id="img_perfil" accept="image/*">

                        </div>

                        <p class="text-center mt-2" style="font-size: 12px;">
                            Clique na imagem para adicionar foto
                        </p>


                        <form>
                            <div class="form-floating mb-3">
                                <input id="nome" class="form-control" type="text" placeholder="Nome"> <label>Nome
                                    completo</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input id="CPF" class="form-control" type="text" placeholder="CPF"> <label>CPF</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input id="dataNascimento" class="form-control" type="date"
                                    placeholder="Data de nascimento">
                                <label>Data de nascimento</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input id="email" class="form-control" type="email" placeholder="E-mail">
                                <label>E-mail</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input id="telefone" class="form-control" type="tel" placeholder="Telfone">
                                <label>Telefone</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input id="senha" class="form-control" type="password" placeholder="Senha">
                                <label>Senha</label>
                            </div>

                            <!-- Profissional -->
                            <div class="form-floating mb-3">
                                <select id="categoria" class="form-select">
                                    <option value="" selected disabled>Selecione uma opção</option>
                                    <option value="Podologiageral">Podologia geral</option>
                                    <option value="Unhaencravada">Unha encravada</option>
                                    <option value="Micose">Micose</option>
                                    <option value="Calosecalosidades">Calos e calosidades</option>
                                    <option value="Fissuras">Fissuras nos pés</option>
                                    <option value="PeDiabetico">Pé diabético</option>
                                    <option value="Podologiaesportiva">Podologia esportiva</option>
                                    <option value="Podologiageriatrica">Podologia geriátrica</option>
                                    <option value="Podologiainfantil">Podologia infantil</option>
                                    <option value="Ortopodologia">Ortopodologia</option>
                                    <option value="Verrugasplantares">Verrugas plantares</option>
                                    <option value="Unhasdeformadas">Unhas deformadas</option>
                                    <option value="Esteticadospes">Estética dos pés</option>
                                </select>
                                <label for="especialidade">Especialidade</label>
                            </div>

                        </form>

                        <div class="d-grid mb-3">
                            <button id="btnCadastrar" class="btn btn-success">Cadastrar</button>
                        </div>

                        <p>
                            Já tem uma conta? <a class="linkLogar" href="#">Faça login</a>
                        </p>

                        <div id="alertCadastro" class="alert alert-danger">E-mail
                            inválido!</div>

                    </div>

                </div>

            </div>

        </div>

    </div>































































    <script>
        //expressão regular (RegEx)
        $(document)
            .ready(
                function () {

                    function limpa_formulário() {
                        $("#emailCadastro").val("");
                    }

                    $("#alertCadastro")
                        .hide()

                    function emailValido(email) {
                        let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
                        return regex.test(email)
                    }

/*                    document.getElementById("trabalhaClinica").addEventListener("change", function () {
                        const container = document.getElementById("clinicasContainer");

                        if (this.value === "sim") {
                            container.style.display = "block";
                        } else {
                            container.style.display = "none";
                        }
                    });
                    document.getElementById("addServico").addEventListener("click", function () {
                        const container = document.getElementById("servicosContainer");

                        const div = document.createElement("div");
                        div.classList.add("servico", "mb-3", "border", "p-3", "rounded");

                        div.innerHTML = `
                            <input type="text" class="form-control mb-2" placeholder="Nome do serviço">
                            <input type="text" class="form-control mb-2" placeholder="Descrição">

                            <div class="row">
                                <div class="col-md-4">
                                    <input type="number" class="form-control mb-2" placeholder="Duração (min)">
                                </div>

                                <div class="col-md-4">
                                    <input type="number" class="form-control mb-2" placeholder="Valor (R$)">
                                </div>

                                <div class="col-md-4">
                                    <input type="text" class="form-control mb-2" placeholder="Categoria (opcional)">
                                </div>
                            </div>
                        `;

                        container.appendChild(div);
                    });
*/

                    const input = document.getElementById("img_perfil");
                    const preview = document.getElementById("preview");
                    const cameraIcon = document.querySelector(".camera-icon");

                    preview.addEventListener("click", () => input.click());
                    cameraIcon.addEventListener("click", () => input.click());

                    input.addEventListener("change", function () {
                        const arquivo = this.files[0];

                        if (arquivo && arquivo.type.startsWith("image/")) {
                            const reader = new FileReader();

                            reader.onload = function (e) {
                                preview.src = e.target.result;
                            };

                            reader.readAsDataURL(arquivo);
                        }
                    });

                    //VERIFICAR E-MAIL
                    $("#btnCadastrar").click(
                        function () {

                            let email = $("#email").val()

                            if (emailValido(email)) {
                                $("#alertCadastro").removeClass(
                                    "alert-danger").addClass(
                                        "alert-success").text(
                                            "Cadastro realizado!")
                                    .show()

                            } else {
                                $("#alertCadastro").removeClass(
                                    "alert-success").addClass(
                                        "alert-danger").text(
                                            "E-mail inválido!").show()
                            }
                        })




                })
    </script>

</body>

</html>
