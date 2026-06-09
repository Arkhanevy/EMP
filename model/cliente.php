<?php 

class cliente {
    private $erros = [];
    
    private function ValidaFtperfil($img){
        
        if (!empty($img["name"])) {
            $error = [];
            
            $largura = 1500;
            $altura = 1800;
            $tamanho = 2048000;
            
            // Verifica tipo da imagem
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime  = $finfo->file($img["tmp_name"]);
            $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp'];
            if (!in_array($mime, $allowedMimes)) {
                $error[] = "Você não enviou uma imagem válida.";
            }
            
            // Pega dimensões
            $dimensoes = getimagesize($img["tmp_name"]);
            
            if ($dimensoes === false) 
                {$error[] = "Arquivo inválido.";}
            else {
                // Verifica largura
                if ($dimensoes[0] > $largura) 
                    {$error[] = "A largura da imagem não deve ultrapassar {$largura} pixels";}
                
                // Verifica altura
                if ($dimensoes[1] > $altura) 
                    {$error[] = "A altura da imagem não deve ultrapassar {$altura} pixels";}  
            }
            
            // Verifica tamanho
            if ($img["size"] > $tamanho) 
                {$error[] = "A imagem deve ter no máximo {$tamanho} bytes";}
            
            // Se não houve erro
            if (empty($error)) {
                
                // Pega extensão
                if (!preg_match("/\.(gif|bmp|png|jpg|jpeg)$/i", $img["name"], $ext)) 
                    {
                    $this->SetErro(["Extensão de arquivo inválida."]);
                    return null;}
                // Gera nome único
                $nome_imagem = md5(uniqid(time())) . "." . $ext[1];
                
                // Caminho da imagem
                $caminho_imagem = "../img/" . $nome_imagem;
                
                return [$nome_imagem,$caminho_imagem,$img["tmp_name"]];
                
            }else
                {
                    $this->SetErro($error);
                    return null;
                }
        } else {
            $this->SetErro(["Nenhuma imagem enviada."]);
            return null;
        }
    }
    
    private function SetErro($erro){
        $this->erros = array_merge($this->erros, (array)$erro);
    }
    public function GetErro(){
        return $this->erros;
    }
    public function ResetErro(){
        $this->erros = [];
    }
    
    public function Setcliente($nome,$email,$telefone,$username,$bio,$dtNas,$cpf,$senha,$genero,$img){
        require_once('../factory/conexao.php');
        $conn = new conexao;
        
        $foto = $this->ValidaFtperfil($_FILES[$img]);
        
        $senhaHash  = password_hash($senha, PASSWORD_BCRYPT);
        $codigo = random_int(100000, 999999);
        
        $query = "INSERT INTO cliente
    (
        cli_nome,
        cli_email,
        cli_username,
        cli_senha,
        cli_biografia,
        cli_foto,
        cli_codVali,
        cli_dtNasc,
        cli_CPF,
        cli_telefone,
        cli_genero
    )
            
            
    VALUES
    (
        :nome,
        :email,
        :username,
        :senha,
        :biografia,
        :foto,
        :codvali,
        :dtNasc,
        :CPF,
        :telefone,
        :genero
    )";
        
        if($foto){
            $cli = $conn->getConn()->prepare($query);
            
            $cli->bindParam(':nome', $nome, PDO::PARAM_STR);
            $cli->bindParam(':email', $email, PDO::PARAM_STR);
            $cli->bindParam(':username', $username, PDO::PARAM_STR);
            $cli->bindParam(':senha', $senhaHash, PDO::PARAM_STR);
            $cli->bindParam(':biografia', $bio, PDO::PARAM_STR);
            $cli->bindParam(':foto', $foto[0], PDO::PARAM_STR);
            $cli->bindParam(':codvali', $codigo, PDO::PARAM_STR);
            $cli->bindParam(':dtNasc', $dtNas, PDO::PARAM_STR);
            $cli->bindParam(':CPF', $cpf, PDO::PARAM_STR);
            $cli->bindParam(':telefone', $telefone, PDO::PARAM_STR);
            $cli->bindParam(':genero', $genero, PDO::PARAM_STR);
            
            try{
                $cli->execute();
                
                if ($cli->rowCount()) {
                    move_uploaded_file($foto[2], $foto[1]);
                    return "sucesso";
                }
                else {
                    $error[] = "Cadastro não realizado. Por favor, tente novamente";
                    $this->erros = $error;
                    return null;
                }
            }
            catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    
                    preg_match("/for key '([^']+)'/", $e->getMessage(), $matches);
                    
                    if (!empty($matches[1])) {
                        
                        switch ($matches[1]) {
                            case 'cli_email':
                                $error[] = "E-mail já cadastrado.";
                                break;
                                
                            case 'cli_username':
                                $error[] = "Usuário já cadastrado.";
                                break;
                            case 'cli_CPF':
                                $error[] = "CPF já cadastrado.";
                                break;
                            default:
                                $error[] = "Registro duplicado.";
                                break;
                        }
                    }
                    
                }else {
                    $error[] = $e;//"Erro interno. Tente novamente mais tarde.";
                }
                $this->erros = $error;
                return null;
            }
        }else {
            return null;
        }
    }
}



?>