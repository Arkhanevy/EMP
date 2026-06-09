<?php 

$acao = $_POST['acao'] ?? '';
    
switch ($acao){
        case "cadastrar":
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
                exit;}
        case "gerarCodigo":
            require_once('../model/profissional.php');
            $email = $_POST['email'];
            $codigo = $_POST['codigo'];
            $inserir = new profissional();
            $resultado = $inserir->InserirCodigo($codigo, $email);
            if ($resultado === "codigo inserido"){echo "sucesso";exit;}
            else {
                $erro = $inserir->GetErro();
                echo implode("|", $erro);
                $inserir->ResetErro();
                exit;}
        case "ativar":
            require_once('../model/profissional.php');
            $email = $_POST['email'];
            $codigo = $_POST['codigo'];
            $inserir = new profissional();
            $resultado = $inserir->AtivarConta($codigo, $email);
            if ($resultado === "conta ativada"){echo "sucesso";exit;}
            else {
                $erro = $inserir->GetErro();
                echo implode("|", $erro);
                $inserir->ResetErro();
                exit;}
}
?>