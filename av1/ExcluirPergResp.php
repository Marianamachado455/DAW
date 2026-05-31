<?php
    $perguntaEncontrada = null;
    $dadosEncontrados = [];

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET["pergunta"])) {
            $arqPergunta1 = fopen("pergDiscursiva.txt", "r") or die("erro ao abrir arquivo");
            $arqPergunta2 = fopen("pergMultiplaEscolha.txt", "r") or die("erro ao abrir arquivo");
            $pergunta = $_GET["pergunta"];

            if ($arqPergunta1) {
                while (!feof($arqPergunta1)) {
                    $linha = fgets($arqPergunta1);
                    $dados = explode(";", trim($linha));

                    if ($dados[0] == $pergunta) {
                        $perguntaEncontrada = 1;
                        $dadosEncontrados = $dados;
                        break;
                    }
                }

                fclose($arqPergunta1);
            }

            if ($perguntaEncontrada == null && $arqPergunta2) {
                fgets($arqPergunta2);

                    while (!feof($arqPergunta2)) {
                    $linha = fgets($arqPergunta2);

                    if (trim($linha) == "") {
                        continue;
                    }

                    $dados = explode(";", trim($linha));

                    if ($dados[0] == $pergunta) {
                        $perguntaEncontrada = 2;
                        $dadosEncontrados = $dados;
                        break;
                    }
                }

                fclose($arqPergunta2);
            }

            if ($perguntaEncontrada == null) {
                echo "Pergunta não encontrada.";
            }
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $pergunta = $_POST["pergunta"];
        $perguntaEncontrada = $_POST["tipoPergunta"];
        $arqTemp = fopen("temp.txt", "w");

        if ($perguntaEncontrada == 1) {
            $arqPergunta1 = fopen("pergDiscursiva.txt", "r") or die("erro ao abrir arquivo");

            while (!feof($arqPergunta1)) {
                $linha = fgets($arqPergunta1);
                $dados = explode(";", trim($linha));

                if ($dados[0] == $pergunta) {
                    continue;
                }

                fwrite($arqTemp, $linha);
            }

            fclose($arqPergunta1);
            fclose($arqTemp);

            unlink("pergDiscursiva.txt");
            rename("temp.txt", "pergDiscursiva.txt");
        }

        else if ($perguntaEncontrada == 2) {
            $arqPergunta2 = fopen("pergMultiplaEscolha.txt", "r") or die("erro ao abrir arquivo");

            while (!feof($arqPergunta2)) {
                $linha = fgets($arqPergunta2);
                $dados = explode(";", trim($linha));

                if ($dados[0] == $pergunta) {
                    continue;
                }

                fwrite($arqTemp, $linha);
            }

            fclose($arqPergunta2);
            fclose($arqTemp);

            unlink("pergMultiplaEscolha.txt");
            rename("temp.txt", "pergMultiplaEscolha.txt");
        }

        echo "Pergunta excluída com sucesso.";

        //Impedir de exbir warning ao tentar acessar dados de uma pergunta que já foi excluída
        $perguntaEncontrada = null;
        $dadosEncontrados = [];
    }
?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <h1>Excluir Pergunta</h1>
    <h2>Digite a pergunta que deseja excluir</h2>

    <form action="excluirPergResp.php" method="GET">
        Pergunta: <input type="text" name="pergunta"><br><br>
        <input type="submit" value="Pesquisar">
    </form>

    <?php if ($perguntaEncontrada != null) { ?>
        <h2>Confirmar exclusão da Pergunta</h2>

        <form action="excluirPergResp.php" method="POST">
            <input type="hidden" name="tipoPergunta" value="<?php echo $perguntaEncontrada; ?>">

            <?php if ($perguntaEncontrada == 1) { ?>
                    <p>Pergunta: <?php echo $dadosEncontrados[0]; ?></p>
                    <input type="hidden" name="pergunta" value="<?php echo $dadosEncontrados[0]; ?>">
                    <p>Resposta: <?php echo $dadosEncontrados[1]; ?></p>
            <?php } ?>

            <?php if ($perguntaEncontrada == 2) { ?>
                    <p> Pergunta: <?php echo $dadosEncontrados[0]; ?>
                    <input type="hidden" name="pergunta" value="<?php echo $dadosEncontrados[0]; ?>"></p>
                    <p>Resposta Certa: <?php echo $dadosEncontrados[1]; ?></p>
                    <p>Resposta Errada 1: <?php echo $dadosEncontrados[2]; ?></p>
                    <p>Resposta Errada 2: <?php echo $dadosEncontrados[3]; ?></p>
                    <p>Resposta Errada 3: <?php echo $dadosEncontrados[4]; ?></p>
            <?php } ?>

            <input type="submit" value="Excluir Pergunta">
        </form>
    <?php } ?>

    <br><br>

    <form action="index.php">
        <button>Voltar</button>
    </form>
</body>
</html>