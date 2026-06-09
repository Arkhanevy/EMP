<?php 

class profissional {
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
    
    public function SetProfissional($nome,$email,$telefone,$username,$bio,$dtNas,$cep,$registro,$cpf,$senha,$genero,$img){
        require_once('../factory/conexao.php');
        $conn = new conexao;
        
        $foto = $this->ValidaFtperfil($_FILES[$img]);
        
        $senhaHash  = password_hash($senha, PASSWORD_BCRYPT);
        
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
        :senha,
        :biografia,
        :dtNasc,
        :foto,
        :CPF,
        :CEP,
        :telefone,
        :genero,
        :registro
    )";
        if($foto){
            $pro = $conn->getConn()->prepare($query);
            
            $pro->bindParam(':nome', $nome, PDO::PARAM_STR);
            $pro->bindParam(':email', $email, PDO::PARAM_STR);
            $pro->bindParam(':username', $username, PDO::PARAM_STR);
            $pro->bindParam(':senha', $senhaHash, PDO::PARAM_STR);
            $pro->bindParam(':biografia', $bio, PDO::PARAM_STR);
            $pro->bindParam(':dtNasc', $dtNas, PDO::PARAM_STR);
            $pro->bindParam(':foto', $foto[0], PDO::PARAM_STR);
            $pro->bindParam(':CPF', $cpf, PDO::PARAM_STR);
            $pro->bindParam(':CEP', $cep, PDO::PARAM_STR);
            $pro->bindParam(':telefone', $telefone, PDO::PARAM_STR);
            $pro->bindParam(':genero', $genero, PDO::PARAM_STR);
            $pro->bindParam(':registro', $registro, PDO::PARAM_STR);
            
            try{
                $pro->execute();
                
                if ($pro->rowCount()) {
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
                preg_match("/for key '([^']+)'/", $e->getMessage(), $matches);
                
                if (!empty($matches[1])) {
                    
                    switch ($matches[1]) {
                        case 'pro_email':
                            $error[] = "E-mail já cadastrado.";
                            break;
                            
                        case 'pro_username':
                            $error[] = "Usuário já cadastrado.";
                            break;
                        case 'pro_CPF':
                            $error[] = "CPF já cadastrado.";
                            break;
                        default:
                            $error[] = "Registro duplicado.";
                            break;
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
    
    public function InserirCodigo($codigo,$email){
        require_once('../factory/conexao.php');
        require '../control/MailSender.php';
        
        $error = [];
        
        $conn = new conexao();
        $inserir = "UPDATE profissional SET pro_codVali = :codigo WHERE pro_email = :email";
        $resultado = $conn->getConn()->prepare($inserir);
        $resultado->bindParam(':email', $email, PDO::PARAM_STR);
        $resultado->bindParam(':codigo', $codigo, PDO::PARAM_INT);
        try {
            $resultado->execute();
            if ($resultado->rowCount() > 0) {
                $consulta = "select * from profissional where pro_email = :email";
                $resultado = $conn->getConn()->prepare($consulta);
                $resultado->bindParam(':email', $email, PDO::PARAM_STR);
                $resultado->execute();
                $campo = $resultado->fetch(PDO::FETCH_ASSOC);
                $nome = $campo['pro_nome'];
                
                $mailSender = new MailSender();
                $result  = $mailSender->send(
                    "naoresponda@elmo.info", /*E-mail que enviou.*/
                    "ELMO - EMP" ,  //Nome de quem enviou
                    $email, //@ que recebeu.
                    $nome, //Nome que recebeu
                    "validação da sua conta", //Assunto
                    "<html><head><meta charset='utf-8'></head><body><p>seu codigo é: $codigo</p></body></html>", //Mensagem com html
                    true
                    );
                return "codigo enviado";
            }
            
            $this->erros[] = "Nenhum registro foi atualizado.";
            return null;
        } 
        catch (PDOException $e) {
            $error[] = "Não foi possível salvar o código.";
            $this->erros = $error;
            return null;
        }

    }
    
    public function AtivarConta($codigo,$email) {
        require_once('../factory/conexao.php');
        
        $conn = new conexao();
        $consulta = "select * from profissional where pro_email = :email";
        $resultado = $conn->getConn()->prepare($consulta);
        $resultado->bindParam(':email', $email, PDO::PARAM_STR);
        $resultado->execute();
        $campo = $resultado->fetch(PDO::FETCH_ASSOC);
        $cod = $campo['pro_codVali'];
        if ((string)$codigo === (string)$cod) {
            $status = "UPDATE profissional SET pro_status = 'ativado' WHERE pro_email = :email";
            $resultado = $conn->getConn()->prepare($status);
            $resultado->bindParam(':email', $email, PDO::PARAM_STR);
            $resultado->execute();
            return "conta ativada";
        }
        ;
    }
    
    
}



?>