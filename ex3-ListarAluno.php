<!DOCTYPE html>
<html>
<head>
</head>
  <body>
  <h1>Listar Alunos</h1>

  <table>
      <tr><th>Matricula</th><th>Nome</th><th>Email</th></tr>
  <?php
    $arqAluno = fopen("alunos.txt","r") or die("erro ao abrir arquivo");
    fgets($arqAluno);

    while(($linha = fgets($arqAluno)) !== false) {
          $colunaDados = explode(";", $linha);

          echo "<tr><td>" . $colunaDados[0] . "</td>" .
              "<td>" . $colunaDados[1] . "</td>" .
              "<td>" . $colunaDados[2] . "</td></tr>";
      }
  
    fclose($arqAluno);
      $msg = "Deu tudo certo!!!";
  ?>
  </table>
  <p><?php echo $msg ?></p>
  <br>

  <form action="ex2-IncluirAluno.php" method="get">
      <button type="submit">Voltar</button>
  </body>
</html>