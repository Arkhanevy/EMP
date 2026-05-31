<?PHP
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../factory/conexao.php');
$conn = new conexao;

session_start();
$_SESSION['erros'] =[];
$_SESSION['cadastro'] = FALSE;
$_SESSION['email'] = "";
$error = array();
$codigo = random_int(100000, 999999);

if (isset($_POST['nome'])) {
    
    $campos = [
        'nome'           => $_POST['nome']           ?? '',
        'email'          => $_POST['email']          ?? '',
        'username'       => $_POST['username']       ?? '',
        'senha'          => $_POST['senha']          ?? '',
        'biografia'      => $_POST['bio']            ?? '',
        'dtNas'          => $_POST['dtNas']          ?? '',
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
        echo implode("|", $vazios);
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
        pro_codVali,
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
        :codvali,
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
                $cadastrar->bindParam(':codvali', $codigo, PDO::PARAM_STR);
                $cadastrar->bindParam(':CPF', $_POST['CPF'], PDO::PARAM_STR);
                $cadastrar->bindParam(':CEP', $_POST['CEP'], PDO::PARAM_STR);
                $cadastrar->bindParam(':telefone', $_POST['telefone'], PDO::PARAM_STR);
                $cadastrar->bindParam(':genero', $_POST['genero'], PDO::PARAM_STR);
                $cadastrar->bindParam(':registro', $_POST['registro'], PDO::PARAM_STR);

                try{
                    $cadastrar->execute();

                    if ($cadastrar->rowCount()) {
                        $_SESSION['cadastro'] = TRUE;
                        $_SESSION['email'] = $_POST['email'];
                        move_uploaded_file($foto["tmp_name"], $caminho_imagem);
                        echo "sucesso";
                        exit;
                    } 
                    else {
                        $error[] = "Cadastro não realizado. Por favor, tente novamente";
                        $_SESSION['erros'] = $error;
                        //$_SESSION['cadastro'] = "não cadastro";
                        //echo "erro";
                        echo implode("|", $_SESSION['erros']);
                        exit;
                        }
                    } 
                catch (PDOException $e) {
                    if ($e->getCode() == 23000) {
                        $error[] = "E-mail ou usuário já cadastrado.";
                    }else {
                        $error[] = $e;//"Erro interno. Tente novamente mais tarde.";
                    }
                    $_SESSION['erros'] = $error;
                    echo implode("|", $_SESSION['erros']);
                    exit;
                    }
                }
            }
            else {
                $_SESSION['erros'] = $error;
                echo implode("|", $_SESSION['erros']);
                exit;
            }
    }
    else {
        $error[] = 'Nenhuma foto de perfil selecionada.';
        $_SESSION['erros'] = $error;
        echo implode("|", $_SESSION['erros']);
        exit;
    }
}


elseif (isset($_POST['nomeClinica'])){
    
    $campos = [
        'nomeClinica'        => $_POST['nomeClinica']        ?? '',
        'emailClinica'       => $_POST['emailClinica']       ?? '',
        'telefoneClinica'    => $_POST['telefoneClinica']    ?? '',
        'usernameClinica'    => $_POST['usernameClinica']    ?? '',
        'bioClinica'         => $_POST['bioClinica']         ?? '',
        'CEPClinica'         => $_POST['CEPClinica']         ?? '',
        'CNPJClinica'        => $_POST['CNPJClinica']        ?? '',
        'senhaClinica'       => $_POST['senhaClinica']       ?? '',
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
        echo implode("|", $vazios);
        exit;

    }
    
    $query = "INSERT INTO clinica
    (
        clin_nome,
        clin_email,
        clin_username,
        clin_senha,
        clin_biografia,
        clin_foto,
        clin_codVali,
        clin_cnpj,
        clin_cep,
        clin_telefone
    )
        
    VALUES
    (
        :nome,
        :email,
        :username,
        sha1(:senha),
        :biografia,
        :foto,
        :codvali,
        :CNPJ,
        :CEP,
        :telefone
    )";
    
    $foto = $_FILES["cxclinFoto"];
    
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
            
            // Prepara query
            $cadastrar = $conn->getConn()->prepare($query);
            
            $cadastrar->bindParam(':nome', $_POST['nomeClinica'], PDO::PARAM_STR);
            $cadastrar->bindParam(':email', $_POST['emailClinica'], PDO::PARAM_STR);
            $cadastrar->bindParam(':username', $_POST['usernameClinica'], PDO::PARAM_STR);
            $cadastrar->bindParam(':senha', $_POST['senhaClinica'], PDO::PARAM_STR);
            $cadastrar->bindParam(':biografia', $_POST['bioClinica'], PDO::PARAM_STR);
            $cadastrar->bindParam(':foto', $nome_imagem, PDO::PARAM_STR);
            $cadastrar->bindParam(':codvali', $codigo, PDO::PARAM_STR);
            $cadastrar->bindParam(':CNPJ', $_POST['CNPJClinica'], PDO::PARAM_STR);
            $cadastrar->bindParam(':CEP', $_POST['CEPClinica'], PDO::PARAM_STR);
            $cadastrar->bindParam(':telefone', $_POST['telefoneClinica'], PDO::PARAM_STR);
            
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
                    echo implode("|", $_SESSION['erros']);
                    exit;
                }
            }
            catch (PDOException $e) {
                if ($e->getCode() == 23000) {$error[] = "E-mail ou usuário já cadastrado.";}
                else {$error[] = "Erro interno. Tente novamente mais tarde.";}
                $_SESSION['erros'] = $error;
                echo implode("|", $_SESSION['erros']);
                exit;
            }
            }
    }
        else {
            $_SESSION['erros'] = $error;
            echo implode("|", $_SESSION['erros']);
            exit;
        }
    }
    else {
        $error[] = 'nenhuma foto de perfil selecionada';
        $_SESSION['erros'] = $error;
        echo implode("|", $_SESSION['erros']);
        exit;
    }
}

else {
    $error[] = 'nenhuma informação enviada';
    $_SESSION['erros'] = $error;
    echo implode("|", $_SESSION['erros']);
    exit;
}

?>