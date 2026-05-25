<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <title>Cadastro do Cliente</title>
</head>
<style>
    html,
    body {
        height: 100%;
        margin: 0;
    }

    body {
        background-image: url("../img/bannerVertical.jpg");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }

    /* CARD DO CADASTRO */
    #cadastroCliente {
        width: 100%;
        max-width: 500px;
        max-height: 90vh;
        overflow-y: auto;
        padding: 30px;
        box-sizing: border-box;
    }

    /* FOTO */
    #preview {
        width: 100px;
        height: 100px;
        object-fit: cover;
    }

    /* BIOGRAFIA */
    textarea {
        width: 100%;
        min-height: 150px;
        resize: none;
    }
</style>

<body>
    <nav
        class="navbar navbar-expand-sm navbar-expand-md navbar-expand-lg navbar-expand-xl navbar-expand-xxl bg-success navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Logo</a>
        </div>
    </nav>

    <div class="container d-flex justify-content-center mt-3 min-vh-100">
    
        <div class="img-thumbnail bg-light border border-success p-4 rounded-4 shadow"
             id="cadastroCliente">
        <h1>Seja Bem-Vindo!</h1>
        <p class="text-muted mt-2 mx-auto"> Cadastre-se para poder agendar suas consultas.</p>

        <form action="../model/caduser.php" method="POST">
            <div class="text-center">
                <img class="img-fluid rounded-circle" id="preview" src="../img/logo_user.png" alt="Foto de perfil">
                <input name="cxcliFoto" class="form-control" type="file" id="img_perfil" accept="image/*" required>
            </div>

            <p class="text-center mt-2" style="font-size: 12px;">Clique na imagem para adicionar foto</p>

            <div class="form-floating mb-3">
                <input name="cxcliNome" id="nomeCliente" class="form-control" type="text" placeholder="Nome" required>
                <label>Nome completo</label>
            </div>
            <div class="form-floating mb-3">
                <input name="cxcliUsername" id="userCliente" class="form-control" type="text" placeholder="Username"
                    required>
                <label>Username</label>
            </div>
            <div class="form-floating mb-3">
                <input name="cxcliEmail" id="emailCadastro" class="form-control" type="email" placeholder="E-mail"
                    required>
                <label>E-mail</label>
            </div>
            <div class="form-floating mb-3">
                 <select name="cxcliGenero" id="generoCliente" class="form-select">
                    <option value="" selected disabled>Selecione uma opção</option>
                    <option value="feminino">Feminino</option>
                    <option value="masculino">Masculino</option>
                    <option value="naoBinario">Não Binario</option>
                    <option value="naoIdentificado">Prefiro não dizer</option>
                </select>
                <label for="especialidade">Gênero</label>
            </div> 
            <div class="form-floating mb-3">
                <input name="cxcliTelefone" id="telCliente" class="form-control" type="tel" placeholder="Telfone"
                    required>
                <label>Telefone</label>
            </div>
            <div class="form-floating mb-3">
                <input name="cxcliDtn" id="dtnCli" class="form-control" type="date" placeholder="Data de Nascimento"
                    required>
                <label>Data de Nascimento</label>
            </div>
            <div class="form-floating mb-3">
                <select name="cxcliGenero" id="generoCliente" class="form-select">
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
                <br /><textarea name="cxcliBiografia" id="bioCliente"
                    placeholder="Escreva sua biografia aqui."></textarea>
            </div>
            <div class="form-floating mb-3">
                <input name="cxcliCPF" id="CPF" class="form-control" type="text" placeholder="CPF" required>
                <label>CPF</label>
            </div>

            <div class="form-floating mb-3">
                <input name="cxcliSenha" id="senhaCliente" class="form-control" type="password" placeholder="Senha"
                    required>
                <label>Senha</label>
            </div>
            <div class="d-grid mb-3">
                <button type="submit" id="btnCadastrar" class="btn btn-success">Cadastrar</button>
            </div>
        </form>

        <p>Já tem uma conta? <a class="logarCliente" href="#">Faça login</a></p>

    </div>
    </div>

    <script src="../js/cadCli.js"></script>

</body>

</html>