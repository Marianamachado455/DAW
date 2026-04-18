<?php
    $perguntaEncontrada = null;
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $pergunta = $_GET["pergunta"];

        $arqPergunta1 = fopen("pergMultiplaEscolha.txt", "r");
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
        $respCerta = $_POST["respCerta"];
        $respErrada1 = $_POST["respErrada1"];
        $respErrada2 = $_POST["respErrada2"];
        $respErrada3 = $_POST["respErrada3"];

        $arqPergunta1 = fopen("pergMultiplaEscolha.txt", "r");
        $arqTemp = fopen("temp.txt", "w");

        while (!feof($arqPergunta1)) {
            $linha = fgets($arqPergunta1);
            $dados = explode(";", trim($linha));

            if ($dados[0] == $pergunta) {
                $linha = "$pergunta; $respCerta; $respErrada1; $respErrada2; $respErrada3;\n";
            }

            fwrite($arqTemp, $linha);
        }

        fclose($arqPergunta1);
        fclose($arqTemp);

        unlink("pergMultiplaEscolha.txt");
        rename("temp.txt", "pergMultiplaEscolha.txt");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar perguntas multipla escolha</title>
</head>
<body>
    <h1>Alterar perguntas multipla escolha</h1>
    <h2>Digite a pergunta que deseja editar</h2>
    <form action="alterarPergMultEscolha.php" method="GET">
        Pergunta: <input type="text" name="pergunta"><br><br>
        <input type="submit" value="Pesquisar">
    </form>

    <?php if ($perguntaEncontrada != null) { ?>

    <h1>Atualizar Pergunta</h1>

    <form action="alterarPergMultEscolha.php" method="POST">
        Pergunta: <?php echo $perguntaEncontrada[0]; ?> <input type="hidden" name="pergunta" value="<?php echo $perguntaEncontrada[0]; ?>">
        <br><br>
        Resposta Certa: <input type="text" name="respCerta" value="<?php echo $perguntaEncontrada[1]; ?>">
        <br><br>
        Resposta Errada 1: <input type="text" name="respErrada1" value="<?php echo $perguntaEncontrada[2]; ?>">
        <br><br>
        Resposta Errada 2: <input type="text" name="respErrada2" value="<?php echo $perguntaEncontrada[3]; ?>">
        <br><br>
        Resposta Errada 3: <input type="text" name="respErrada3" value="<?php echo $perguntaEncontrada[4]; ?>">
        <br><br>
        <input type="submit" name="atualizar" value="Atualizar">
    </form>
    <?php } ?><br><br>  
     <form action="index.php">
        <button>Voltar</button>
    </form>
</body>
</html>