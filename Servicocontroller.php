<?php
$acao = $_POST['acao'] ?? '';
$servico = new servicos();
switch ($acao){
    case "cadastrar":
        $cadastro = $servico->cadastrar(0, $_SESSION['id'], $_POST['nome'], $_POST['tipo'], $_POST['desc'], $_POST['dur'], $_POST['inter'], $_POST['val'], $_POST['stat'], $_POST['dia']);
        echo $cadastro;
        exit;
    case 'MostrarServico':
        $mostrar= $servico->MostrarServico($_SESSION['servico']['ser_id'], $_SESSION['pro_id']);
        
        // Verifica se teve sucesso
        if ($mostrar['sucesso']) {
            // Extrai o ID e salva na sessão
            $_SESSION['servico_id'] = $mostrar['dados'][0]['id'] ?? null;
            $_SESSION['servicos'] = $mostrar['dados'];
            
            echo json_encode([
                'sucesso' => true,
                'dados' => $mostrar['dados']
            ]);
        } else {
            // Teve erro
            echo json_encode([
                'sucesso' => false,
                'erro' => $mostrar['erro']
            ]);
        }
        exit;
    case 'MostrarDias':
        if ($_SESSION['pro_id']) {
            $dia = '01';
            $mes = $_POST['mes'];  
            $ano = $_POST['ano'];
        }else {
            $hoje = new DateTime();
            
            $ano = $hoje->format('Y'); 
            $mes = $hoje->format('m'); 
            $dia = $hoje->format('d');
        };
        $mostrar = $servico->MostrarDatas($_SESSION['servico']['ser_id'],  $_SESSION['servico']['ser_pro'],$ano,$mes,$dia);
        $_SESSION['datas'][$mes] = $mostrar;
        echo $mostrar;
        exit;
    case 'mostrarhorario':
        $mostrar = $servico->PegarHoraVaga($_POST['dia'],$_SESSION['servico']['ser_dur'],$_SESSION['servico']['ser_inter']);
        $_SESSION['horarios'][$_POST['dia']] = $mostrar;
        echo $mostrar;
        exit;
    case 'agendar':
        $agendar = $servico->agendar($_SESSION['servico']['ser_pro'], $_SESSION['id'],$_SESSION['servico']['ser_id'],/*$_SESSION['servico']['ser_sala'],*/ $_POST['dia'], $_POST['inicio'], $_POST['termino']);
        $_SESSION['servico'] = '';
        $_SESSION['datas'] = '';
        $_SESSION['horarios'] = '';
        
        echo $agendar;
        exit;
}