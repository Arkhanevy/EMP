<?PHP

require_once('../factory/conexao.php');
$conn = new conexao;

session_start();
$_SESSION['erros'] =[];
$_SESSION['cadastro'] = FALSE;
$error = array();

$pagina_anterior = $_SERVER['HTTP_REFERER'] ?? '../view/cadastro.php';

if (isset($_POST['cxproNome'])) {
    
    $campos = [
        'cxproNome'           => $_POST['cxproNome']           ?? '',
        'cxproemail'          => $_POST['cxproemail']          ?? '',
        'cxproUsername'       => $_POST['cxproUsername']       ?? '',
        'cxproSenha'          => $_POST['cxproSenha']          ?? '',
        'cxproBiografia'      => $_POST['cxproBiografia']      ?? '',
        'cxproCPF'            => $_POST['cxproCPF']            ?? '',
        'cep'                 => $_POST['cep']                 ?? '',
        'cxproTelefone'       => $_POST['cxproTelefone']       ?? '',
        'cxgeneroProfissional'=> $_POST['cxgeneroProfissional']?? '',
        'cxproRegistro'       => $_POST['cxproRegistro']       ?? '',
    ];
    
    
    // array_filter remove tudo que for vazio/null/false
    $vazios = array_filter($campos, fn($valor) => trim($valor) === '');
    
    if (!empty($vazios)) {
        $error[] = "nem todos os campos foram preenchidos";
        $_SESSION['erros'] = $error;
        header("Location: $pagina_anterior");
        exit;
    }

    $query = "INSERT INTO profissional 
    (
        pro_nome,
        pro_email,
        pro_username,
        pro_senha,
        pro_biografia,
        pro_foto,
        Pro_CPF,
        Pro_CEP,
        Pro_Telefone,
        Pro_Genero,
        Pro_Registro_Pro
    )

    VALUES
    (
        :nome,
        :email,
        :username,
        sha1(:senha),
        :biografia,
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
        if (count($error) == 0) {

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
    
                $cadastrar->bindParam(':nome', $_POST['cxproNome'], PDO::PARAM_STR);
                $cadastrar->bindParam(':email', $_POST['cxproemail'], PDO::PARAM_STR);
                $cadastrar->bindParam(':username', $_POST['cxproUsername'], PDO::PARAM_STR);
                $cadastrar->bindParam(':senha', $_POST['cxproSenha'], PDO::PARAM_STR);
                $cadastrar->bindParam(':biografia', $_POST['cxproBiografia'], PDO::PARAM_STR);
                $cadastrar->bindParam(':foto', $nome_imagem, PDO::PARAM_STR);
                $cadastrar->bindParam(':CPF', $_POST['cxproCPF'], PDO::PARAM_STR);
                $cadastrar->bindParam(':CEP', $_POST['cep'], PDO::PARAM_STR);
                $cadastrar->bindParam(':telefone', $_POST['cxproTelefone'], PDO::PARAM_STR);
                $cadastrar->bindParam(':genero', $_POST['cxgeneroProfissional'], PDO::PARAM_STR);
                $cadastrar->bindParam(':registro', $_POST['cxproRegistro'], PDO::PARAM_STR);
    
                // ALTERAÇÃO:
                // execute() foi movido antes do rowCount()
    
                try{
                    $cadastrar->execute();
        
                    if ($cadastrar->rowCount()) {
                        $_SESSION['cadastro'] = TRUE;
                        
                        move_uploaded_file($foto["tmp_name"], $caminho_imagem);
                        header("Location: $pagina_anterior");
                        exit;
                    } 
                    else {
                        $error[] = "Cadastro não realizado. Por favor, tente novamente";
                        $_SESSION['erros'] = $error;
                        header("Location: $pagina_anterior");
                        exit;
                        }
                    } 
                catch (PDOException $e) {
                    if ($e->getCode() == 23000) {$error[] = "E-mail ou usuário já cadastrado.";} 
                    else {$error[] = "Erro interno. Tente novamente mais tarde.";}
                    $_SESSION['erros'] = $error;
                    header("Location: $pagina_anterior");
                    exit;
                    }
                }
            }
            else {
                $_SESSION['erros'] = $error;
                header("Location: $pagina_anterior");
                exit;
            }
    }
    else {
        $error[] = 'nenhuma foto de perfil selecionada';
        $_SESSION['erros'] = $error;
        header("Location: $pagina_anterior");
        exit;
    }

}

elseif (isset($_POST['cxclinicaNome'])){
    
    $campos = [
        'cxclinicaNome'     => $_POST['cxclinicaNome']     ?? '',
        'cxclinemail'       => $_POST['cxclinemail']       ?? '',
        'cxclinTelefone'    => $_POST['cxclinTelefone']    ?? '',
        'cxclinUsername'    => $_POST['cxclinUsername']    ?? '',
        'cxclinBiografia'   => $_POST['cxclinBiografia']   ?? '',
        'cxclinCEP'      => $_POST['cxCEPClinica']      ?? '',
        'cxclinCnpj'        => $_POST['cxclinCnpj']        ?? '',
        'cxclinSenha'       => $_POST['cxclinSenha']       ?? '',
    ];
    
    
    // array_filter remove tudo que for vazio/null/false
    $vazios = array_filter($campos, fn($valor) => trim($valor) === '');
    
    if (!empty($vazios)) {
        $error[] = "nem todos os campos foram preenchidos";
        $_SESSION['erros'] = $error;
        header("Location: $pagina_anterior");
        exit;
    }
    
    $query = "INSERT INTO clinica
    (
        Clin_Nome,
        Clin_email,
        Clin_Username,
        Clin_Senha,
        Clin_Biografia,
        Clin_Cnpj,
        Clin_cep,
        Clin_Telefone
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
            
            $cadastrar->bindParam(':nome', $_POST['cxclinicaNome'], PDO::PARAM_STR);
            $cadastrar->bindParam(':email', $_POST['cxclinemail'], PDO::PARAM_STR);
            $cadastrar->bindParam(':username', $_POST['cxclinUsername'], PDO::PARAM_STR);
            $cadastrar->bindParam(':senha', $_POST['cxclinSenha'], PDO::PARAM_STR);
            $cadastrar->bindParam(':biografia', $_POST['cxclinBiografia'], PDO::PARAM_STR);
            //$cadastrar->bindParam(':foto', $nome_imagem, PDO::PARAM_STR);
            $cadastrar->bindParam(':CNPJ', $_POST['cxclinCnpj'], PDO::PARAM_STR);
            $cadastrar->bindParam(':CEP', $_POST['cxCEPClinica'], PDO::PARAM_STR);
            $cadastrar->bindParam(':telefone', $_POST['cxproTelefone'], PDO::PARAM_STR);
            
            try{
                $cadastrar->execute();
                
                if ($cadastrar->rowCount()) {
                    $_SESSION['cadastro'] = TRUE;
                    
                    //move_uploaded_file($foto["tmp_name"], $caminho_imagem);
                    header("Location: $pagina_anterior");
                    exit;
                    
                }
                else {
                    $error[] = "Cadastro não realizado. Por favor, tente novamente";
                    $_SESSION['erros'] = $error;
                    header("Location: $pagina_anterior");
                    exit;
                }
            }
            catch (PDOException $e) {
                if ($e->getCode() == 23000) {$error[] = "E-mail ou usuário já cadastrado.";}
                else {$error[] = "Erro interno. Tente novamente mais tarde.";}
                $_SESSION['erros'] = $error;
                header("Location: $pagina_anterior");
                exit;
            }
            /*}
    }
        else {
            $_SESSION['erros'] = $error;
            header("Location: $pagina_anterior");
            exit;
        }
    }
    else {
        $error[] = 'nenhuma foto de perfil selecionada';
        $_SESSION['erros'] = $error;
        header("Location: $pagina_anterior");
        exit;
    }*/
}

else {
    $error[] = 'nenhuma informação enviada';
    $_SESSION['erros'] = $error;
    header("Location: $pagina_anterior");
    exit;
}

?>