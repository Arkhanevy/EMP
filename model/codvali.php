<?php 
require_once('../factory/conexao.php');
require '../control/MailSender.php';

session_start();
$email = $_SESSION['email'];

$conn = new conexao();
$consulta = "select * from profissional where pro_email = :email";
$resultado = $conn->getConn()->prepare($consulta);
$resultado->bindParam(':email', $email, PDO::PARAM_STR);
$resultado->execute();
$campo = $resultado->fetch(PDO::FETCH_ASSOC);
$cod = $campo['pro_codVali'];
$nome = $campo['pro_nome'];

$mailSender = new MailSender();
$result  = $mailSender->send(
    "naoresponda@elmo.info", /*E-mail que enviou.*/
    "ELMO - EMP" ,  //Nome de quem enviou
    $email, //@ que recebeu.
    $nome, //Nome que recebeu
    "validação da sua conta", //Assunto
    "<html><head><meta charset='utf-8'></head><body><p>seu codigo é: .$cod</body></html>", //Mensagem com html
    true
    );
?>