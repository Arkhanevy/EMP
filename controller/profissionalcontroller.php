<?php 

$acao = $_POST['acao'] ?? '';

if ($acao === "cadastrar") {
    require_once('../model/profissional.php');
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $senha = $_POST['senha'];
    $bio = $_POST['bio'];
    $dtNas = $_POST['dtNas'];
    $cpf = $_POST['CPF'];
    $cep = $_POST['CEP'];
    $telefone = $_POST['telefone'];
    $genero = $_POST['genero'];
    $registro = $_POST['registro'];
    $img = "cxproFoto";
    
    $cadastrar = new profissional();
    $resultado = $cadastrar->SetProfissional($nome,$email,$telefone,$username,$bio,$dtNas,$cep,$registro,$cpf,$senha,$genero,$img);
    if ($resultado === "sucesso"){echo "sucesso";exit;}
    else {
        $erro = $cadastrar->GetErro();
        echo implode("|", $erro);
        $cadastrar->ResetErro();
        exit;
    }
    
}
else if ($acao) {
    echo implode("|","ação não reconhecida");
}




?>