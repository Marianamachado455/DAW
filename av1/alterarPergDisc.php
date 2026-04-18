<?php
    $perguntaEncontrada = null;
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $pergunta = $_GET["pergunta"];

        $arqPergunta1 = fopen("pergDiscursiva.txt", "r");
        if ($arqPergunta1) {
            while (!feof($arqPergunta1)) {
                $linha = fgets($arqPergunta1);
                $dados = explode(";", trim($linha));

                if ($dados[0] == $pergunta) {
                    $perguntaEncontrada = $dados;
                }
            }

            if ($perguntaEncontrada == NULL) {
                echo "Pergunta não encontrada.";
            }

            fclose($arqPergunta1);
        }

        else {
            echo "Arquivo não existe.";
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $pergunta = $_POST["pergunta"];
        $resposta = $_POST["resposta"];

        $arqPergunta1 = fopen("pergDiscursiva.txt", "r");
        $arqTemp = fopen("temp.txt", "w");

        while (!feof($arqPergunta1)) {
            $linha = fgets($arqPergunta1);
            $dados = explode(";", trim($linha));

            if ($dados[0] == $pergunta) {
                $linha = "$pergunta; $resposta;\n";
            }

            fwrite($arqTemp, $linha);
        }

        fclose($arqPergunta1);
        fclose($arqTemp);

        unlink("pergDiscursiva.txt");
        rename("temp.txt", "pergDiscursiva.txt");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar pergunta discursiva</title>
</head>
<body>
    <h1>Alterar perguntas discursivas</h1>
    <h2>Digite a pergunta que deseja editar</h2>
    <form action="alterarPergDisc.php" method="GET">
        Pergunta: <input type="text" name="pergunta"><br><br>
        <input type="submit" value="Pesquisar">
    </form>

    <?php if ($perguntaEncontrada != null) { ?>

    <h1>Atualizar Pergunta</h1>

    <form action="alterarPergDisc.php" method="POST">
        Pergunta: <?php echo $perguntaEncontrada[0]; ?> <input type="hidden" name="pergunta" value="<?php echo $perguntaEncontrada[0]; ?>">
        <br><br>
        Resposta: <input type="text" name="resposta" value="<?php echo $perguntaEncontrada[1]; ?>">
        <br><br>
        <input type="submit" name="atualizar" value="Atualizar">
    </form>
    <?php } ?><br><br>  
     <form action="index.php">
        <button>Voltar</button>
    </form>
</body>
</html>