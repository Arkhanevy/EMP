<?php 

use core\database\DBQuery;
use core\utils\CodeGenerator;
use app\core\utils\Mail;

$acao = $_POST['acao'] ?? '';

$camposclin =[
    'clin_id',
    'clin_nome',
    'clin_email',
    'clin_username',
    'clin_senha',
    'clin_biografia',
    'clin_foto',
    'clin_codVali',
    'clin_dtCad',
    'clin_dtDell',
    'clin_status',
    'clin_cnpj',
    'clin_cep',
    'clin_telefone',
    'clin_notificacao',];

    
switch ($acao){
        case "cadastrar":
            $generator = new CodeGenerator();
            $cod = $generator->run(6);
            /*$assunto = 'codigo de validação';
            $body = "!DOCTYPE html>
                    <html lang='pt-BR'>
                    <head>
                        <meta charset='UTF-8'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    </head>
                    <body>
                    </body>
                    </html>";*/
            
            $dados =[
                0,
                $_POST['nome'],
                $_POST['email'],
                $_POST['username'],
                password_hash($_POST['senha'],PASSWORD_BCRYPT),
                $_POST['bio'],
                'cxfoto',//$_POST['cxproFoto'],
                $cod,
                date('Y-m-d H:i:s'),
                '',
                "desativo",
                $_POST['CNPJ'],
                $_POST['CEP'],
                $_POST['telefone'],
                $_POST['notificacao'] ?? 1,
            ];
                $camposclin = implode(',',$camposclin);
            
            try {
                $cadastrar = new DBQuery("clinica", $camposclin, ['clin_id']);
                $resultado = $cadastrar->insert($dados);
                
                if ($resultado) {
                    echo "sucesso";
                    /*$email = new Mail($dados[2], $assunto, $body);
                    $email ->send();*/
                } else {
                    echo "erro ao inserir";
                }
            } catch (InvalidArgumentException $e) {
                echo "Erro de validação: " . $e->getMessage();
            } catch (\Exception $e) {
                echo "Erro no banco: " . $e->getMessage();
            };
            exit;
                
        case "ReGerarCodigo":
            $generator = new CodeGenerator();
            $cod = $generator->run(6);
            $dados = [$_POST['email'],$cod];
            $camposclin = implode(',',[$camposclin[2], $camposclin[7]]);
            try {
                $codigo = new DBQuery("clinica", $camposclin, ['clin_email']);
                $resultado = $codigo->update($dados);
                if ($resultado) {
                    echo "sucesso";
                } else {
                    echo "erro ao inserir";
                }
            } catch (InvalidArgumentException $e){
                echo "Erro de validação: " . $e->getMessage();
            }catch (\Exception $e) {
                echo "Erro no banco: " . $e->getMessage();
            };
            exit;
        case "ativar": //ALERTA DE CAMBIARRA
                  
            $email = $_POST['email'];
            $cod = $_POST['codigo'];
            
            $select = $camposclin[7];
            $db = new DBQuery("clinica", $select, '');
            $where = " where clin_email = '" . $email . "'";
            $resultado = $db->selectWhere($where);
            $registro = $resultado->fetch(PDO::FETCH_ASSOC);
            
            if (!$registro) {
                echo "e-mail não encontrado";
                exit;
            }
            
            $codVali = $registro['clin_codVali'];
            
            if ($cod !== $codVali) {
                echo "código inválido";
                exit;
            }
            
            $camposclin = implode(',',[$camposclin[11], $camposclin[2]]);
            $dados = [
                "ativo",
                $email
            ];
            
            try {
                $ativar = new DBQuery("clinica", $camposclin,'clin_email');
                $Update = $ativar->update($dados);
                if ($Update) {
                    echo "sucesso";
                } else {
                    echo "erro ao atualizar";
                }
            } catch (InvalidArgumentException $e) {
                echo "Erro de validação: " . $e->getMessage();
            } catch (\Exception $e) {
                echo "Erro no banco: " . $e->getMessage();
            }
            exit;
}
?>