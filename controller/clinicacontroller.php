<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);

$acao = $_POST['acao'] ?? '';

switch ($acao){
    case "cadastrar":
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
    case "gerarCodigo":
        require_once('../model/clinica.php');
        $email = $_POST['email'];
        $codigo = $_POST['codigo'];
        $inserir = new clinica();
        $resultado = $inserir->InserirCodigo($codigo, $email);
        if ($resultado === "codigo inserido"){echo "sucesso";exit;}
        else {
            $erro = $inserir->GetErro();
            echo implode("|", $erro);
            $inserir->ResetErro();
            exit;}
    case "ativar":
        require_once('../model/clinica.php');
        $email = $_POST['email'];
        $codigo = $_POST['codigo'];
        $inserir = new clinica();
        $resultado = $inserir->AtivarConta($codigo, $email);
        if ($resultado === "conta ativada"){echo "sucesso";exit;}
        else {
            $erro = $inserir->GetErro();
            echo implode("|", $erro);
            $inserir->ResetErro();
            exit;}
}
?>