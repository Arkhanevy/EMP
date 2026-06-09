<?php 

$acao = $_POST['acao'] ?? '';

if ($acao === "cadastrar") {
    require_once('../model/cliente.php');
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $genero = $_POST['genero'];
    $telefone = $_POST['telefone'];
    $dtNas = $_POST['dtNas'];
    $bio = $_POST['bio'];
    $senha = $_POST['senha'];
    $cpf = $_POST['CPF'];
    $img = "cxcliFoto";
    
    $cadastrar = new cliente();
    $resultado = $cadastrar->Setcliente($nome,$email,$telefone,$username,$bio,$dtNas,$cpf,$senha,$genero,$img);
    if ($resultado === "sucesso"){echo "sucesso";exit;}
    else {
        $erro = $cadastrar->GetErro();
        echo implode("|", $erro);
        $cadastrar->ResetErro();
        exit;
    }
    
}
else if ($acao) {
    $erro = ["ação não reconhecida"];
    echo implode("|", $erro); 
}




?>