<?php 

class clinica {
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
    
    public function SetClinica($nome,$email,$telefone,$username,$bio,$cep,$cnpj,$senha,$img){
        require_once('../factory/conexao.php');
        $conn = new conexao;
        
        $foto = $this->ValidaFtperfil($_FILES[$img]);
        
        $senhaHash  = password_hash($senha, PASSWORD_BCRYPT);
        $codigo = random_int(100000, 999999);
        
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
        :senha,
        :biografia,
        :foto,
        :codvali,
        :CNPJ,
        :CEP,
        :telefone
    )";
        if($foto){
            $clin = $conn->getConn()->prepare($query);
            
            $clin->bindParam(':nome', $nome, PDO::PARAM_STR);
            $clin->bindParam(':email', $email, PDO::PARAM_STR);
            $clin->bindParam(':username', $username, PDO::PARAM_STR);
            $clin->bindParam(':senha', $senhaHash, PDO::PARAM_STR);
            $clin->bindParam(':biografia', $bio, PDO::PARAM_STR);
            $clin->bindParam(':foto', $foto[0], PDO::PARAM_STR);
            $clin->bindParam(':codvali', $codigo, PDO::PARAM_STR);
            $clin->bindParam(':CNPJ', $cnpj, PDO::PARAM_STR);
            $clin->bindParam(':CEP', $cep, PDO::PARAM_STR);
            $clin->bindParam(':telefone', $telefone, PDO::PARAM_STR);
            
            try{
                $clin->execute();
                
                if ($clin->rowCount()) {
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
                    $error[] = "E-mail ou usuário já cadastrado.";
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