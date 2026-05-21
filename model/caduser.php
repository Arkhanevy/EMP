<?PHP
require_once('../factory/conexao.php');

if (isset($_POST['cxproNome'])) {

    $conn = new banco();

    $query = "INSERT INTO profissional 
    (
        pro_nome,
        pro_email,
        pro_username,
        pro_senha,
        pro_biografia,
        pro_foto,
        Pro_CPF,
        Pro_CEP,
        Pro_Telefone,
        Pro_Genero,
        Pro_Registro_Pro
    )

    VALUES
    (
        :nome,
        :email,
        :username,
        sha1(:senha),
        :biografia,
        :foto,
        :CPF,
        :CEP,
        :telefone,
        :genero,
        :registro
    )";

    $foto = $_FILES["cxproFoto"];

    if (!empty($foto["name"])) {

        $largura = 1500;
        $altura = 1800;
        $tamanho = 2048000;

        $error = array();

        // Verifica tipo da imagem
        if (!preg_match("/^image\/(jpg|jpeg|png|gif|bmp)$/", $foto["type"])) {

            $error[] = "Isso não é uma imagem.";
        }

        // Pega dimensões
        $dimensoes = getimagesize($foto["tmp_name"]);

        // Verifica largura
        if ($dimensoes[0] > $largura) {

            $error[] = "A largura da imagem não deve ultrapassar {$largura} pixels";
        }

        // Verifica altura
        if ($dimensoes[1] > $altura) {

            $error[] = "A altura da imagem não deve ultrapassar {$altura} pixels";
        }

        // Verifica tamanho
        if ($foto["size"] > $tamanho) {

            $error[] = "A imagem deve ter no máximo {$tamanho} bytes";
        }

        // Se não houve erro
        if (count($error) == 0) {

            // Pega extensão
            preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);

            // Gera nome único
            $nome_imagem = md5(uniqid(time())) . "." . $ext[1];

            // Caminho da imagem
            $caminho_imagem = "../img/" . $nome_imagem;

            // Move arquivo
            move_uploaded_file($foto["tmp_name"], $caminho_imagem);

            // Prepara query
            $cadastrar = $conn->getConn()->prepare($query);

            $cadastrar->bindParam(':nome', $_POST['cxproNome'], PDO::PARAM_STR);
            $cadastrar->bindParam(':email', $_POST['cxproEmail'], PDO::PARAM_STR);
            $cadastrar->bindParam(':username', $_POST['cxproUsername'], PDO::PARAM_STR);
            $cadastrar->bindParam(':senha', $_POST['cxproSenha'], PDO::PARAM_STR);
            $cadastrar->bindParam(':biografia', $_POST['cxproBiografia'], PDO::PARAM_STR);
            $cadastrar->bindParam(':foto', $nome_imagem, PDO::PARAM_STR);
            $cadastrar->bindParam(':CPF', $_POST['cxproCPF'], PDO::PARAM_STR);
            $cadastrar->bindParam(':CEP', $_POST['cep'], PDO::PARAM_STR);
            $cadastrar->bindParam(':telefone', $_POST['cxproTelefone'], PDO::PARAM_STR);
            $cadastrar->bindParam(':genero', $_POST['cxgeneroProfissional'], PDO::PARAM_STR);
            $cadastrar->bindParam(':registro', $_POST['cxproRegistro'], PDO::PARAM_STR);

            // ALTERAÇÃO:
            // execute() foi movido antes do rowCount()
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

            $totalerro = "";

            for ($cont = 0; $cont < sizeof($error); $cont++) {

                $totalerro .= $error[$cont] . '\n';
            }

            echo "
            <script>
                alert('$totalerro');
                location.href = '../view/cadastro.php';
            </script>
            ";
        }

    } else {

        echo "
        <script>
            alert('Você não selecionou nenhuma imagem!');
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