<?PHP
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../factory/conexao.php');
$conn = new conexao;

session_start();
$_SESSION['erros'] =[];
$_SESSION['cadastro'] = FALSE;
$error = array();

$nome = $_POST["nome"];
$email = $_POST["email"];
//$imgperfil = $_POST["imgperfil"];
$telefone = $_POST["telefone"];
$username = $_POST["username"];
$bio = $_POST["bio"];
$dtNas = $_POST["dtNas"];
$CEP = $_POST["CEP"];
$registro = $_POST["registro"];
$CPF = $_POST["CPF"];
$senha = $_POST["senha"];


$pagina_anterior = $_SERVER['HTTP_REFERER'] ?? '../view/cadastro.php';

if (isset($_POST['nome'])) {
    
    $campos = [
        'nome'           => $_POST['nome']           ?? '',
        'email'          => $_POST['email']          ?? '',
        'username'       => $_POST['username']       ?? '',
        'senha'          => $_POST['senha']          ?? '',
        'biografia'      => $_POST['bio']      ?? '',
        'dtNas'            => $_POST['dtNas']            ?? '',
        'CPF'            => $_POST['CPF']            ?? '',
        'CEP'            => $_POST['CEP']            ?? '',
        'telefone'       => $_POST['telefone']       ?? '',
        'genero'         => $_POST['genero']         ?? '',
        'registro'       => $_POST['registro']       ?? '',
    ];
    // array_filter remove tudo que for vazio/null/false
    $vazios = array_filter($campos, fn($valor) => trim($valor) === '');
    
    $vazios = [];

    foreach($campos as $campo => $valor){

        if(trim($valor) === ''){

            $vazios[] = $campo;

        }

    }

    if(!empty($vazios)){

        print_r($vazios);
        exit;

    }


    $query = "INSERT INTO profissional 
    (
        pro_nome,
        pro_email,
        pro_username,
        pro_senha,
        pro_biografia,
        pro_dtNasc,
        pro_foto,
        pro_CPF,
        pro_CEP,
        pro_telefone,
        pro_genero,
        pro_registro
    )


    VALUES
    (
        :nome,
        :email,
        :username,
        sha1(:senha),
        :biografia,
        :dtNasc,
        :foto,
        :CPF,
        :CEP,
        :telefone,
        :genero,
        :registro
    )";

    $foto = $_FILES["cxproFoto"];

    if (!empty($foto["name"])) {

        $largura = 1500;
        $altura = 1800;
        $tamanho = 2048000;

        // Verifica tipo da imagem
        if (!preg_match("/^image\/(jpg|jpeg|png|gif|bmp)$/", $foto["type"])) {

            $error[] = "Isso não é uma imagem.";
        }

        // Pega dimensões
        $dimensoes = getimagesize($foto["tmp_name"]);

        // Verifica largura
        if ($dimensoes[0] > $largura) {

            $error[] = "A largura da imagem não deve ultrapassar {$largura} pixels";
        }

        // Verifica altura
        if ($dimensoes[1] > $altura) {

            $error[] = "A altura da imagem não deve ultrapassar {$altura} pixels";
        }

        // Verifica tamanho
        if ($foto["size"] > $tamanho) {

            $error[] = "A imagem deve ter no máximo {$tamanho} bytes";
        }

        // Se não houve erro
        if (empty($error)) {

            // Pega extensão
            if (!preg_match("/\.(gif|bmp|png|jpg|jpeg)$/i", $foto["name"], $ext)) {
                $error[] = "Extensão de arquivo inválida.";
            } 
            else {preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);

                // Gera nome único
                $nome_imagem = md5(uniqid(time())) . "." . $ext[1];
    
                // Caminho da imagem
                $caminho_imagem = "../img/" . $nome_imagem;
    
                // Prepara query
                $cadastrar = $conn->getConn()->prepare($query);
    
                $cadastrar->bindParam(':nome', $_POST['nome'], PDO::PARAM_STR);
                $cadastrar->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
                $cadastrar->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
                $cadastrar->bindParam(':senha', $_POST['senha'], PDO::PARAM_STR);
                $cadastrar->bindParam(':biografia', $_POST['bio'], PDO::PARAM_STR);
                $cadastrar->bindParam(':dtNasc', $_POST['dtNas'], PDO::PARAM_STR);
                $cadastrar->bindParam(':foto', $nome_imagem, PDO::PARAM_STR);
                $cadastrar->bindParam(':CPF', $_POST['CPF'], PDO::PARAM_STR);
                $cadastrar->bindParam(':CEP', $_POST['CEP'], PDO::PARAM_STR);
                $cadastrar->bindParam(':telefone', $_POST['telefone'], PDO::PARAM_STR);
                $cadastrar->bindParam(':genero', $_POST['genero'], PDO::PARAM_STR);
                $cadastrar->bindParam(':registro', $_POST['registro'], PDO::PARAM_STR);

    
                // ALTERAÇÃO:
                // execute() foi movido antes do rowCount()
    
                try{
                    $cadastrar->execute();

                    if ($cadastrar->rowCount()) {
                        $_SESSION['cadastro'] = TRUE;
                        
                        move_uploaded_file($foto["tmp_name"], $caminho_imagem);
                        echo "sucesso";
                        exit;
                    } 
                    else {
                        $error[] = "Cadastro não realizado. Por favor, tente novamente";
                        $_SESSION['erros'] = $error;
                        //$_SESSION['cadastro'] = "não cadastro";
                        echo "erro";
                        exit;
                        }
                    } 
                catch (PDOException $e) {
                    if ($e->getCode() == 23000) {$error[] = "E-mail ou usuário já cadastrado.";} 
                    else {$error[] = "Erro interno. Tente novamente mais tarde.";}
                    $_SESSION['erros'] = $error;
                    echo $e->getMessage();
                    exit;
                    }
                }
            }
            else {
                $_SESSION['erros'] = $error;
                print_r($_SESSION['erros']);
                exit;
            }
    }
    else {
        $error[] = 'nenhuma foto de perfil selecionada';
        $_SESSION['erros'] = $error;
        echo $_SESSION['erros'];
        exit;
    }

    echo "";
}













elseif (isset($_POST['nome'])){
    
    $campos = [
        'cxclinNome'        => $_POST['cxclinNome']     ?? '',
        'cxclinEmail'       => $_POST['cxclinEmail']       ?? '',
        'cxclinTelefone'    => $_POST['cxclinTelefone']    ?? '',
        'cxclinUsername'    => $_POST['cxclinUsername']    ?? '',
        'cxclinBiografia'   => $_POST['cxclinBiografia']   ?? '',
        'cxclinCEP'         => $_POST['cxclinCEP']      ?? '',
        'cxclinCnpj'        => $_POST['cxclinCnpj']        ?? '',
        'cxclinSenha'       => $_POST['cxclinSenha']       ?? '',
    ];
    
    
    // array_filter remove tudo que for vazio/null/false
    $vazios = array_filter($campos, fn($valor) => trim($valor) === '');
    
    if (!empty($vazios)) {
        $error[] = "nem todos os campos foram preenchidos";
        $_SESSION['erros'] = $error;
        echo "erro";
        exit;
    }
    
    $query = "INSERT INTO clinica
    (
        clin_Nome,
        clin_Email,
        clin_Username,
        clin_Senha,
        clin_Biografia,
        clin_Cnpj,
        clin_CEP,
        clin_Telefone
    )
        
    VALUES
    (
        :nome,
        :email,
        :username,
        sha1(:senha),
        :biografia,
        :CNPJ,
        :CEP,
        :telefone
    )";
    
    /*$foto = $_FILES["cxclinicaFoto"];
    
    if (!empty($foto["name"])) {
        
        $largura = 1500;
        $altura = 1800;
        $tamanho = 2048000;
        
        // Verifica tipo da imagem
        if (!preg_match("/^image\/(jpg|jpeg|png|gif|bmp)$/", $foto["type"])) {
            
            $error[] = "Isso não é uma imagem.";
        }
        
        // Pega dimensões
        $dimensoes = getimagesize($foto["tmp_name"]);
        
        // Verifica largura
        if ($dimensoes[0] > $largura) {
            
            $error[] = "A largura da imagem não deve ultrapassar {$largura} pixels";
        }
        
        // Verifica altura
        if ($dimensoes[1] > $altura) {
            
            $error[] = "A altura da imagem não deve ultrapassar {$altura} pixels";
        }
        
        // Verifica tamanho
        if ($foto["size"] > $tamanho) {
            
            $error[] = "A imagem deve ter no máximo {$tamanho} bytes";
        }
        
        // Se não houve erro
        if (count($error) == 0) {
            
            // Pega extensão
            if (!preg_match("/\.(gif|bmp|png|jpg|jpeg)$/i", $foto["name"], $ext)) {
                $error[] = "Extensão de arquivo inválida.";
            }
            else {
            
            // Gera nome único
            $nome_imagem = md5(uniqid(time())) . "." . $ext[1];
            
            // Caminho da imagem
            $caminho_imagem = "../img/" . $nome_imagem;
            
            // Prepara query*/
            $cadastrar = $conn->getConn()->prepare($query);
            
            $cadastrar->bindParam(':nome', $_POST['cxclinNome'], PDO::PARAM_STR);
            $cadastrar->bindParam(':email', $_POST['cxclinemail'], PDO::PARAM_STR);
            $cadastrar->bindParam(':username', $_POST['cxclinUsername'], PDO::PARAM_STR);
            $cadastrar->bindParam(':senha', $_POST['cxclinSenha'], PDO::PARAM_STR);
            $cadastrar->bindParam(':biografia', $_POST['cxclinBiografia'], PDO::PARAM_STR);
            //$cadastrar->bindParam(':foto', $nome_imagem, PDO::PARAM_STR);
            $cadastrar->bindParam(':CNPJ', $_POST['cxclinCnpj'], PDO::PARAM_STR);
            $cadastrar->bindParam(':CEP', $_POST['cxclinCEP'], PDO::PARAM_STR);
            $cadastrar->bindParam(':telefone', $_POST['cxproTelefone'], PDO::PARAM_STR);
            
            try{
                $cadastrar->execute();
                
                if ($cadastrar->rowCount()) {
                    $_SESSION['cadastro'] = TRUE;
                    
                    //move_uploaded_file($foto["tmp_name"], $caminho_imagem);
                    echo "sucesso";
                    exit;
                    
                }
                else {
                    $error[] = "Cadastro não realizado. Por favor, tente novamente";
                    $_SESSION['erros'] = $error;
                    echo "erro";
                    exit;
                }
            }
            catch (PDOException $e) {
                if ($e->getCode() == 23000) {$error[] = "E-mail ou usuário já cadastrado.";}
                else {$error[] = "Erro interno. Tente novamente mais tarde.";}
                $_SESSION['erros'] = $error;
                echo $e->getMessage();
                exit;
            }
            /*}
    }
        else {
            $_SESSION['erros'] = $error;
            echo "erro";
            exit;
        }
    }
    else {
        $error[] = 'nenhuma foto de perfil selecionada';
        $_SESSION['erros'] = $error;
        echo "erro";
        exit;
    }*/
}

else {
    $error[] = 'nenhuma informação enviada';
    $_SESSION['erros'] = $error;
    echo "erro";
    exit;
}

?>