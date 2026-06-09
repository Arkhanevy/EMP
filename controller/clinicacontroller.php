<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);

$acao = $_POST['acao'] ?? '';

if ($acao === "cadastrar") {
    require_once('../model/clinica.php');
    $nome = $_POST['nomeClinica'];
    $email = $_POST['emailClinica'];
    $username = $_POST['usernameClinica'];
    $senha = $_POST['senhaClinica'];
    $bio = $_POST['bioClinica'];
    $cnpj = $_POST['CNPJClinica'];
    $cep = $_POST['CEPClinica'];
    $telefone = $_POST['telefoneClinica'];
    $img = "cxclinFoto";
    
    $cadastrar = new clinica();
    $resultado = $cadastrar->SetClinica($nome,$email,$telefone,$username,$bio,$cep,$cnpj,$senha,$img);
    if ($resultado === "sucesso"){echo "sucesso";exit;}
    else {
        $erro = $cadastrar->GetErro();
        echo implode("|", $erro);
        $cadastrar->ResetErro();
        exit;
    }
    
}
else if ($acao) {
    $erros = ["ação não reconhecida"];
    echo implode("|",$erros);
}




?>