<?php 

use core\database\DBQuery;
use core\utils\CodeGenerator;
use app\core\utils\Mail;

$acao = $_POST['acao'] ?? '';

$camposServ =[
    'ser_id',
    'ser_pro',
    'ser_nome', 
    'ser_tipo',
    'ser_desc',
    'ser_tempo',
    'ser_val',
    'ser_status'];

    
switch ($acao){
        case "cadastrar":

            $dados =[
                0,
                $_SESSION['id'],
                $_POST['nome'],
                $_POST['tipo'],
                $_POST['desc'],
                $_POST['dtNas'],
                $_POST['tempo'],
                $_POST['val'],
                "ativado"
            ];
                $camposServ = implode(',',$camposServ);
            
            try {
                $cadastrar = new DBQuery("servico", $camposServ, ['ser_id']);
                $resultado = $cadastrar->insert($dados);
                
                if ($resultado) {
                    echo "sucesso";
                } else {
                    echo "erro ao inserir";
                }
            } catch (InvalidArgumentException $e) {
                echo "Erro de validação: " . $e->getMessage();
            } catch (\Exception $e) {
                echo "Erro no banco: " . $e->getMessage();
            };
            exit;
                
}
?>