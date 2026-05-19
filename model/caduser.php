<?php
		require_once('../factory/conexao.php'); 

		if (isset($_POST['cxproNome'])) {

			$conn = new banco();
            $query = "INSERT INTO profissional (pro_nome, pro_email, pro_username,pro_senha,pro_biografia,pro_foto,Pro_CPF,Pro_CEP,Pro_Telefone,Pro_Genero,Pro_Registro_Pro)
            VALUES (:nome,:email,:username,sha1(:senha),:biografia,:foto,:CPF,:CEP,:telefone,:genero,:registro)";

            $cadastrar = $conn->getConn()->prepare($query);   
            

            






            $foto = $_FILES["cxproFoto"]; 

			if (!empty($foto["name"])) {
			// Verifica se um arquivo foi enviado, e se o campo nome não está vazio através da condição "empty".	

				$largura = 1500; // Define a largura máxima permitida para a imagem.
				$altura = 1800; // Define a altura máxima permitida para a imagem.
				$tamanho = 2048000; // Define o tamanho máximo permitido para a imagem, em bytes.
				$error = array(); // : Cria um array para armazenar possíveis erros encontrados durante o processo de validação da imagem.


		    	if(!preg_match("/^image\/(jpg|jpeg|png|gif|bmp)$/", $foto["type"])){
				// Verifica se o tipo de arquivo enviado é uma imagem válida (JPEG, PNG, GIF ou BMP).
		     		
					$error[0] = "Isso não é uma imagem."; // Define a mensagem de erro "Isso não é uma imagem." no índice 0 do array $error caso o tipo de arquivo não seja uma imagem válido.
		   	 	} 
			
				$dimensoes = getimagesize($foto["tmp_name"]); // Obtém as dimensões (largura e altura) da imagem enviada.
			
				if($dimensoes[0] > $largura) {
				// Verifica se a largura da imagem excede a largura máxima permitida.

					$error[1] = "A largura da imagem não deve ultrapassar ".$largura." pixels"; // Define a mensagem de erro "A largura da imagem não deve ultrapassar [largura] pixels" no índice 1 do array $error
				}

				if($dimensoes[1] > $altura) {
				// Verifica se a altura da imagem excede a altura máxima permitida.

					$error[2] = "Altura da imagem não deve ultrapassar ".$altura." pixels"; // Define a mensagem de erro "Altura da imagem não deve ultrapassar [altura] pixels" no índice 2 do array $error.
				}
				
				if($foto["size"] > $tamanho) {
				// Verifica se o tamanho do arquivo excede o tamanho máximo permitido.

		   		 	$error[3] = "A imagem deve ter no máximo ".$tamanho." bytes"; // Define a mensagem de erro "A imagem deve ter no máximo [tamanho] bytes" no índice 3 do array $error.
				}

				if (count($error) == 0) {
				// Verifica se não houve erros durante a validação da imagem.

					preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext); // Extrai a extensão do nome do arquivo usando uma expressão regular e armazena-a na variável $ext.

		        	$nome_imagem = md5(uniqid(time())) . "." . $ext[1]; // Gera um nome único para a imagem usando o tempo atual e a extensão extraída, e o armazena na variável $nome_imagem.

		        	$caminho_imagem = "../img/" . $nome_imagem; // Define o caminho onde a imagem será salva, concatenando o diretório "fotos/" com o nome da imagem.

					move_uploaded_file($foto["tmp_name"], $caminho_imagem); // Move o arquivo enviado para o caminho especificado.
				
                   

					//$sqlin = 'INSERT INTO usuarios (nome, senha, foto) VALUES ("'.$nome.'", "'.sha1($senha).'" , "'.$nome_imagem.'");'; // Cria uma string de consulta SQL para inserir os dados do usuário (nome, senha e nome da imagem) na tabela "usuarios".

					//$resul = mysqli_query($conexao, $sqlin); 
                    // Executa a consulta SQL usando a função mysqli_query e armazena o resultado na variável $resul.
                
                   
                    $cadastrar = $conn->getConn()->prepare($query);   
                    
                    $cadastrar->bindParam(':nome',$_POST['nome'],PDO::PARAM_STR);
                    $cadastrar->bindParam(':senha',$_POST['senha'],PDO::PARAM_STR);
                    $cadastrar->bindParam(':nome_imagem',$nome_imagem,PDO::PARAM_STR);

                    $cadastrar->execute();
                         
					//header('../view/telaexibirfotos.php'); // Redireciona o usuário para a página "cadastro.php".

					if ($cadastrar->rowCount())
                    { 
                    echo "
                    <script> alert('Você foi cadastrado com sucessoc') 
                    location.href = '../view/telaexibirfotos.php';
                    
                    </script>";
					// Verifica se a consulta SQL foi executada com sucesso e exibe uma mensagem de sucesso.
                    }
                    else
                    {
                        echo ('<script>Você não foi cadastrado com sucesso.</script>');
                    } 
                
                }

				$totalerro = ""; // Cria uma variável vazia para armazenar mensagens de erro.

				if (count($error) != 0) {
				// Verifica se houve algum erro durante a validação da imagem.

					for($cont = 0; $cont <= sizeof($error); $cont++) {
					// Inicia um loop para percorrer o array de erros.

						if (!empty($error[$cont])) $totalerro = $totalerro.$error[$cont].'\n';
						// Se o erro no índice atual não estiver vazio, concatena a mensagem de erro na variável $totalerro.
					}

					echo('<script>window.alert("'.$totalerro.'");window.location="cadastro.php";</script>'); // Exibe um alerta JavaScript com as mensagens de erro e redireciona o usuário de volta para a página "cadastro.php".
				}
			} else {
			// Se não houve erros durante a validação da imagem.

				echo('<script>window.alert("Você não selecionou nenhuma arquivo!");window.location="../view/cadastro.php";</script>'); // Exibe um alerta JavaScript informando ao usuário que nenhum arquivo foi selecionado e redireciona-o de volta para a página "cadastro.php".
			}
		}

		
		



























       
       
       
            $cadastrar->bindParam(':foto',$_FILES['cxproFoto'],PDO::PARAM_STR);
            
            
            $cadastrar->bindParam(':nome',$_POST['cxproNome'],PDO::PARAM_STR);
            $cadastrar->bindParam(':email',$_POST['cxproEmail'],PDO::PARAM_STR);
            $cadastrar->bindParam(':username',$_POST['cxproUsername'],PDO::PARAM_STR);
            $cadastrar->bindParam(':senha',$_POST['cxproSenha'],PDO::PARAM_STR);
            $cadastrar->bindParam(':biografia',$_POST['cxproBiografia'],PDO::PARAM_STR);
            $cadastrar->bindParam(':CPF',$_POST['cxproCPF'],PDO::PARAM_STR);
            $cadastrar->bindParam(':CEP',$_POST['cep'],PDO::PARAM_STR);
            $cadastrar->bindParam(':telefone',$_POST['cxproTelefone'],PDO::PARAM_STR);
            $cadastrar->bindParam(':genero',$_POST['cxgeneroProfissional'],PDO::PARAM_STR);
            $cadastrar->bindParam(':registro',$_POST['cxproRegistro'],PDO::PARAM_STR);

            $cadastrar->execute();

            if ($cadastrar->rowCount()) {

                echo "
                <script>
                    alert('Você foi cadastrado com sucesso');
                    location.href = '../view/cadastro.php';
                </script>
                ";

            } else {

                echo "
                <script>
                    alert('Você não foi cadastrado.');
                    location.href = '../view/cadastro.php';
                </script>
                ";
            }

        } else {

            echo "
            <script>
                alert('Dados não enviados.');
                location.href = '../view/cadastro.php';
            </script>
            ";
        }
		?>
        
