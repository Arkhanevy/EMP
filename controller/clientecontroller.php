<?php 

$acao = $_POST['acao'] ?? '';

switch ($acao){
    case "cadastrar":
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
        $img = "cxclientefoto";
        
        $cadastrar = new cliente();
        $resultado = $cadastrar->Setcliente($nome,$email,$telefone,$username,$bio,$dtNas,$cpf,$senha,$genero,$img);
        if ($resultado === "sucesso"){echo "sucesso";exit;}
        else {
            $erro = $cadastrar->GetErro();
            echo implode("|", $erro);
            $cadastrar->ResetErro();
            exit;
        }
    case "gerarCodigo":
        require_once('../model/cliente.php');
        $email = $_POST['email'];
        $codigo = $_POST['codigo'];
        $inserir = new cliente();
        $resultado = $inserir->InserirCodigo($codigo, $email);
        if ($resultado === "codigo inserido"){echo "sucesso";exit;}
        else {
            $erro = $inserir->GetErro();
            echo implode("|", $erro);
            $inserir->ResetErro();
            exit;}
    case "ativar":
        require_once('../model/cliente.php');
        $email = $_POST['email'];
        $codigo = $_POST['codigo'];
        $inserir = new cliente();
        $resultado = $inserir->AtivarConta($codigo, $email);
        if ($resultado === "conta ativada"){echo "sucesso";exit;}
        else {
            $erro = $inserir->GetErro();
            echo implode("|", $erro);
            $inserir->ResetErro();
            exit;}

        
}




?>