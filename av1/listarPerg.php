<?php
    $perguntaEncontrada = null;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["pesquisar"])) {
            $arqPergunta1 = fopen("pergDiscursiva.txt","r") or die("erro ao abrir arquivo");
            $arqPergunta2 = fopen("pergMultiplaEscolha.txt","r") or die("erro ao abrir arquivo");
            $pergunta = $_POST["pergunta"];

            //Pesquisar no 1 arquivo
            if ($arqPergunta1) {
                $arqPergunta1 = fopen("pergDiscursiva.txt", "r");

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

            //Pesquisar no 2 arquivo
            if ($perguntaEncontrada == NULL && $arqPergunta2) {
            $arqPerg2 = fopen("pergMultiplaEscolha.txt","r") or die("erro ao abrir arquivo");
                fgets($arqPerg2);

                while(!feof($arqPerg2)) {
                    $linha = fgets($arqPerg2);
                    $dados = explode(";", $linha);

                    if ($dados[0] == $pergunta) {
                        $perguntaEncontrada = 2;
                        $dadosEncontrados = $dados;
                        break;
                    }
                }
                fclose($arqPerg2);
            }

            if ($perguntaEncontrada == NULL) {
                echo "Pergunta não encontrada.";
            }
        }   
    }
?>

<!DOCTYPE html>
<html>
<head>
</head>
  <body>
  <h1>Listar Uma pergunta</h1>
  <h2>Escolher pergunta para listar</h2>
  <form action="listarPerg.php" method="post">
        Pergunta: <input type="text" name="pergunta"><br><br>
        <input type="submit" name="pesquisar" value="Pesquisar">
    </form>

   <?php if($perguntaEncontrada == 1) { ?>
    <table>
        <tr><th>Pergunta</th><th>Resposta</th></tr>
        <tr>
            <td><?php echo $dadosEncontrados[0]; ?></td>
            <td><?php echo $dadosEncontrados[1]; ?></td>
        </tr>
    </table>
    <?php } ?>

 <?php if($perguntaEncontrada == 2) { ?>
    <table>
        <tr>
            <th>Pergunta</th>
            <th>Resposta Certa</th>
            <th>Resposta Errada 1</th>
            <th>Resposta Errada 2</th>
            <th>Resposta Errada 3</th>
        </tr>
        <tr>
            <td><?php echo $dadosEncontrados[0]; ?></td>
            <td><?php echo $dadosEncontrados[1]; ?></td>
            <td><?php echo $dadosEncontrados[2]; ?></td>
            <td><?php echo $dadosEncontrados[3]; ?></td>
            <td><?php echo $dadosEncontrados[4]; ?></td>
        </tr>
    </table>
    <?php } ?>
    <form action="index.php">
        <button>Voltar</button>
    </form>
  </body>
</html>