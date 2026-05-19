<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/cadProCli.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Cadastro</title>
</head>

<body>
    <div class="container-fluid">
        <div id="alertContainer" class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 9999;">
        </div>
        <div class="row g-0 min-vh-100">

            <div id="imgBox" class="d-none d-md-block col-md-6">
                <img src="../img/bannerVertical.jpg" class="img-fluid h-100 w-100 object-fit-cover">
            </div>

            <div id="colForm" class="col-12 col-md-6 d-flex justify-content-center align-items-start">
                <div class="form-wrapper">

                    <!-- CADASTRO PROFISSIONAL -->
                    <div id="cadastroProfissional" class="cadastro">
                        <div class="text-center mt-4">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <img src="../img/logo_verde.png" class="logo-titulo">
                                <h1 class="m-0">Seja Bem-Vindo!</h1>
                            </div>
                            <p class="text-muted mt-2 mx-auto" style="max-width: 400px;">
                                Faça um cadastro como profissional para que os clientes possam encontrar seus serviços.
                            </p>
                        </div>

                        <div class="avatar-container">
                            <img id="preview" src="../img/logo_user.png" alt="Foto de perfil">
                            <input name="cxproFoto" type="file" id="img_perfil" accept="image/*" required>
                        </div>

                        <p class="text-center mt-2" style="font-size: 12px;">
                            Clique na imagem para adicionar foto
                        </p>



                        <form action="../model/caduser.php" method="POST">
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
                                        <input name="rua" class="parteCEP form-control" type="text" id="rua" placeholder="rua"
                                            required>
                                        <label>Rua</label>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input name="bairro" class="parteCEP form-control" type="text" id="bairro"
                                            placeholder="bairro" required> <label>Bairro</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input name="cidade" class="parteCEP form-control" type="text" id="cidade"
                                            placeholder="cidade" required> <label>Cidade</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input name="uf" class=" parteCEP form-control" type="text" id="uf" placeholder="uf"
                                            required>
                                        <label>Estado</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input name="ibge" class="parteCEP form-control" type="text" id="ibge" placeholder="ibge"
                                            required> <label>IBGE</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <input name="cxproRegistro" id="registroProfissional" class="form-control" type="text"
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
                            <div class="d-grid mb-3">
                                <button type="submit" id="btnCadastrar" class="btn btn-success">Cadastrar</button>
                            </div>
                        </form>

                        <p>
                            Já tem uma conta? <a class="logarProfissional" href="#">Faça login</a>
                        </p>


                    </div>


                    <!-- LOGIN PROFISSIONAL-->
                    <div id="loginProfissional">
                        <div class="text-center mt-4">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <img src="../img/logo_verde.png" class="logo-titulo">
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
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <img src="../img/logo_verde.png" class="logo-titulo">
                                <h1 class="m-0">Seja Bem-Vindo!</h1>
                            </div>
                            <p class="text-muted mt-2 mx-auto" style="max-width: 400px;">
                                Cadastro a clinica em Elmo para que clientes consigam encontra-las!
                            </p>
                        </div>

                        <div class="avatar-container">
                            <img id="previewClinica" src="../img/logo_user.png" alt="Foto de perfil">
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

    <script src="../js/cadProCli.js"></script>
    
</body>

</html>