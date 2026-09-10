<?php 

use core\database\DBQuery;
use core\utils\CodeGenerator;
use app\core\utils\Mail;

class servicos { // a classe que vai fazer todas as operações relacionadas a serviços, mas nãa herda nada pq nem sei como faz mas pretendo fazer herdar
    private $camposServ =[
        'ser_id',
        'ser_pro',
        'ser_nome',
        'ser_tipo',
        'ser_desc',
        'ser_dur',
        'ser_inter',
        'ser_val',
        'ser_stat',
        'ser_dia'
    ];//campos do servico
    private $pimarykey =['ser_id'];
    private $table = 'servico';
    private $valser = ''; // nem sei se vou usar
    
    public function cadastrar($id,$pro,$nome,$tipo,$desc,$dur,$inter,$val,$stat,$dia) {
        $camposServ = implode(',',$this->camposServ); // isso é só pra enviar no formato que o banco de dados pede, necessario?pode ser que não, assunto para depois
        $dados =[
            $id,
            $pro,
            $nome,
            $tipo,
            $desc,
            $dur,
            $inter,
            $val,
            $stat,
            $dia
        ];
        try {
            $cadastrar = new DBQuery($this->table, $camposServ,$this->pimarykey );
            $resultado = $cadastrar->insert($dados);
            
            if ($resultado) {
                return "sucesso";
            } else {
                return "erro ao inserir";
            }
        } catch (InvalidArgumentException $e) {
            return "Erro de validação: " . $e->getMessage();
        } catch (\Exception $e) {
            return "Erro no banco: " . $e->getMessage();
        };
    }
    public function MostrarServico($id,$pro) {//tá porco mas não tô fazendo a parte de pesquisa ainda é só pra o agendamento que estou fazendo agr possa funcionar
        $cod = $id??$pro; // se o id do servico tiver vazio então procura os servicos de um profissional se não procura o serviço. 
        $condicao = isset($id) ? 'ser_id = ':'ser_pro = ';
            try {
                $mostrar = new DBQuery($this->table, $this->camposServ,$this->pimarykey );
                $where = "WHERE ".$condicao.$cod;
                $resultado = $mostrar->selectWhere($where);
                
                if ($resultado) {
                    return [
                        'sucesso' => true,
                        'dados' => $resultado->fetch_all(MYSQLI_ASSOC)
                    ];
                } else {
                    return [
                        'sucesso' => false,
                        'erro' => 'Erro ao resgatar informação'
                    ];
                }
            } catch (InvalidArgumentException $e) {
                return [
                    'sucesso' => false,
                    'erro' => 'Erro de validação: ' . $e->getMessage()
                ];
            } catch (\Exception $e) {
                return [
                    'sucesso' => false,
                    'erro' => 'Erro no banco: ' . $e->getMessage()
                ];
            }
    }
       private function GetDiaTrabalho($pro){
           try {
               $mostrar = new DBQuery('hr_servico', 'hrser_dia','hrser_pro' );// pega os dias que trabalha
               $where = "WHERE hrser_pro = ".$pro;
               $resultado = $mostrar->selectWhere($where);
               
               if ($resultado) {
                   return  json_encode($resultado->fetch_all(MYSQLI_ASSOC));;
               } else {
                   return json_encode("erro ao resgatar a informação");
               }
           } catch (InvalidArgumentException $e) {
               return json_encode("Erro de validação: " . $e->getMessage());
           } catch (\Exception $e) {
               return json_encode("Erro no banco: " . $e->getMessage());
           }
       }
       private function GetExcecaotrabalho($pro) {
           try {
               $mostrar = new DBQuery('hr_excecao', 'hr_excecao_dia,hr_excecao_ini','hr_excecao_pro' );//pega os dias de exeção
               $where = "WHERE hr_excecao_pro = ".$pro;
               $resultado = $mostrar->selectWhere($where);
               
               if ($resultado) {
                   return  json_encode($resultado->fetch_all(MYSQLI_ASSOC));
               } else {
                   return json_encode("erro ao resgatar a informação");
               }
           } catch (InvalidArgumentException $e) {
               return json_encode("Erro de validação: " . $e->getMessage());
           } catch (\Exception $e) {
               return json_encode("Erro no banco: " . $e->getMessage());
           }
       }
       private function dias($ano,$mes,$dia){
           $data = new DateTime("$ano-$mes-$dia");//volta uma lista dos dias
           $ultimoDia = $data->format('t');
           $dias = [];
           for ($i = 1; $i <= $ultimoDia; $i++) {
               
               $data->setDate($ano, $mes, $i);
               
               $dias[] = [
                   'data' => $data->format('Y-m-d'),
               ];
           }
           return json_encode($dias);
       }
       private function PegarPeriodo($dia) {
           try {
               $dia = $dia->format('D');
               $rotina = new DBQuery('hr_servico', 'hrser_hora_inic,hrser_hora_term','hrser_dia' );
               $where = "WHERE hrser_dia = ".$dia;
               $resultado = $rotina->selectWhere($where);
                   if ($resultado) {
                       $dados = $resultado->fetch_assoc();
                       $dados = ['inicio' => $dados['hrser_hora_inic'],'fim' => $dados['hrser_hora_term']];
                       return json_encode($dados);
                   } else {
                       $excecao = new DBQuery('hr_excecao', 'hr_excecao_ini,hr_excecao_term','hr_excecao_dia' );
                       $where = "WHERE hrser_dia = ".$dia;
                       $resultado = $excecao->selectWhere($where);
                       if ($resultado) {
                           $dados = $resultado->fetch_all(MYSQLI_ASSOC);
                           $dados = array_map(fn($row) => ['inicio' => $row['hr_excecao_ini'],'fim' => $row['hr_excecao_term'] ], $dados);
                           return json_encode($dados);
                       } else {
                           return json_encode("erro ao resgatar a informação");
                       }
                   }
               } catch (InvalidArgumentException $e) {
                   return json_encode("Erro de validação: " . $e->getMessage());
               } catch (\Exception $e) {
                   return json_encode("Erro no banco: " . $e->getMessage());
               };
        }
        private function Agenda($dia){
            try {
                $mostrar = new DBQuery('agenda', 'agnd_hrIni,agnd_hrTerm','agnd_dt' );
                $where = "WHERE agnd_dt = ".$dia;
                $resultado = $mostrar->selectWhere($where);
                
                if ($resultado) {
                    return json_encode($resultado->fetch_all(MYSQLI_ASSOC));
                    
                } else {
                    return json_encode("erro ao resgatar a informação");
                }
            } catch (InvalidArgumentException $e) {
                return json_encode("Erro de validação: " . $e->getMessage());
            } catch (\Exception $e) {
                return json_encode("Erro no banco: " . $e->getMessage());
            };
        }
        
        public function MostrarDatas($id,$pro,$ano,$mes,$dia) {
            $hrser = json_decode($this->GetDiaTrabalho($pro));
            $exce = json_decode($this->GetExcecaotrabalho($pro));
            $dias = json_decode($this->dias($ano,$mes,$dia));
            $atual = new DateTime("$ano-$mes-$dia");
            
            $disponivel = [];
            $folga = [];
            $indisponivel = [];
            $exceF = [];
            $exceT = [];
            
            $exceT = array_map(fn($e) => $e['hr_excecao_dia'], array_filter($exce, fn($e) => $e['hr_excecao_ini']));
            $exceF = array_map(fn($e) => $e['hr_excecao_dia'], array_filter($exce, fn($e) => !$e['hr_excecao_ini']));
            $hrser = array_map(fn($e) => $e['hr_ser_dia'], $hrser);
            
            foreach ($dias as $data) {
                $dt = new DateTime($data);
                $dtsemana = $dt->format('w');
                
                if ($dt < $atual) {
                    $indisponivel[] = $dt;
                    continue;
                }
                if (in_array($dt, $exceF)) {
                    $folga[] = $dt;
                    continue;
                }
                if (in_array($dt, $exceT)) {
                    $disponivel[] = $dt;
                    continue;
                }
                
                if (in_array($dtsemana, $hrser)) {
                    $disponivel[] = $dt;
                    continue;
                }
            }
            return json_encode([
                'disponivel' => $disponivel,
                'folga' => $folga,
                'indisponivel' => $indisponivel,
            ]);
        }
        
        public function PegarHoraVaga($dia,$dur,$inter){
            $periodo = json_decode($this->PegarPeriodo($dia));
            $agenda = json_decode($this->Agenda($dia));
            $agenda = array_map(fn($e) => [
                'agnd_hrIni' => substr($e->agnd_hrIni, 0, 5),  
                'agnd_hrTerm' => substr($e->agnd_hrTerm, 0, 5)
            ], $agenda);
            $horarios = [];
            $duracao = new DateInterval('PT'.($dur + $inter).'M'); 
            $intervalo = new DateInterval('PT'.($inter).'M'); 
            
            $Inper = DateTime::createFromFormat('H:i', $periodo[0]['inicio']);
            $termper = DateTime::createFromFormat('H:i', $periodo[0]['fim']);
            
            $hr = $Inper;
            
            while ($hr < $termper) {
                $hrProximo = clone $hr;
                $hrProximo->add($duracao); 
                
                if ($hrProximo <= $termper) {
                    $horarios[] = [
                        'inicio' => $hr->format('H:i'),
                        'termino' => $hrProximo->format('H:i')
                    ];
                    $hr = $hrProximo;
                } else {
                    break; 
                }
                
            }
            $horarios = array_filter($horarios, function($slot) use ($agenda, $intervalo) {
                foreach ($agenda as $agnd) {
                    $agnd_ini = DateTime::createFromFormat('H:i', $agnd['agnd_hrIni']);
                    $agnd_term = DateTime::createFromFormat('H:i', $agnd['agnd_hrTerm']);
                   
                    
                    $agnd_ini->sub($intervalo); 
                    $agnd_term->add($intervalo); 
                    
                    $slot_ini = DateTime::createFromFormat('H:i', $slot['inicio']);
                    $slot_term = DateTime::createFromFormat('H:i', $slot['termino']);
                    
                    $naoColide = ($slot_term <= $agnd_ini || $slot_ini >= $agnd_term);
                    
                    if (!$naoColide) {
                        return false; 
                    }
                }
                return true; 
            });
            
            return json_encode($horarios);
        }
        public function agendar($pro,$cli,$ser,$sala,$dia,$inicio,$termino) {
            $camposagnd =[
                'agnd_id',
                'agnd_pro',
                'agnd_cli',
                'agnd_ser',
                'agnd_sala',
                'agnd_dt',
                'agnd_hrIni',
                'agnd_hrTerm'
            ]; 
            $dados =[
                0,
                $pro,
                $cli,
                $ser,
                $sala,
                $dia,
                $inicio,
                $termino
            ];
            try {
                $agendar = new DBQuery('agenda', $camposagnd,'agnd_id' );
                $resultado = $agendar->insert($dados);
                
                if ($resultado) {
                    return  "sucesso";
                } else {
                    return "erro ao inserir";
                }
            } catch (InvalidArgumentException $e) {
                return "Erro de validação: " . $e->getMessage();
            } catch (\Exception $e) {
                return "Erro no banco: " . $e->getMessage();
            };
        }
       
      
    
}
?>