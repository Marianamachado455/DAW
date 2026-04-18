<!DOCTYPE html>
<html>
<head>
</head>
  <body>
  <h1>Listar Todas as Perguntas e Respostas</h1>
  <h2>Perguntas Discursivas</h2>
   <table>
      <tr><th>Pergunta</th><th>Resposta</th></tr>
        <?php
            $arqPerg2 = fopen("pergDiscursiva.txt","r") or die("erro ao abrir arquivo");
            fgets($arqPerg2);

            while(($linha = fgets($arqPerg2)) !== false) {
                $colunaDados = explode(";", $linha);

                echo "<tr><td>" . $colunaDados[0] . "</td>" .
                    "<td>" . $colunaDados[1] . "</td></tr>";
            }
        
            fclose($arqPerg2);
        ?>
        </table>
        <p><?php echo $msg ?></p>
        <br>
    
    <h2>Perguntas Multipla Escolha</h2>
    <table>
      <tr><th>Pergunta</th><th>Resposta Certa</th><th>Resposta Errada 1</th><th>Resposta Errada 2</th><th>Resposta Errada 3</th></tr>
        <?php
            $arqPerg1 = fopen("pergMultiplaEscolha.txt","r") or die("erro ao abrir arquivo");
            fgets($arqPerg1);

            while(($linha = fgets($arqPerg1)) !== false) {
                $colunaDados = explode(";", $linha);

                echo "<tr><td>" . $colunaDados[0] . "</td>" .
                    "<td>" . $colunaDados[1] . "</td>" .
                    "<td>" . $colunaDados[2] . "</td>" .
                    "<td>" . $colunaDados[3] . "</td>" .
                    "<td>" . $colunaDados[4] . "</td></tr>";
            }
        
            fclose($arqPerg1);
        ?>
        </table>
        <p><?php echo $msg ?></p>
     <form action="index.php">
        <button>Voltar</button>
    </form>
</html>