<?php
		require_once('../factory/conexao.php'); 

		if (isset($_POST['cxproNome'])) {

			$conn = new banco();
            $query = "INSERT INTO profissional (pro_nome, pro_email, pro_username,pro_senha,pro_biografia,Pro_CPF,Pro_CEP,Pro_Telefone,Pro_Genero,Pro_Registro_Pro)
            VALUES (:nome,:email,:username,sha1(:senha),:biografia,:CPF,:CEP,:telefone,:genero,:registro)";

            $cadastrar = $conn->getConn()->prepare($query);   
            
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