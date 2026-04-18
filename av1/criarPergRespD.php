<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $pergunta = $_POST["pergunta"];
        $resposta = $_POST["resposta"];
        
        $arqPerg2 = fopen("pergDiscursiva.txt", "a");

        if (!$arqPerg2) {
            fwrite($arqPerg2, "Pergunta; Resposta;\n");
        }
        
        fwrite($arqPerg2, "$pergunta; $resposta\n");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Pergunta e Resposta Discursiva</title>
</head>
<body>
    <form action="criarPergRespD.php" method="post">
        Pergunta: <input type="text" name="pergunta" required><br><br>
        Resposta:<input type="text" name="resposta"><br><br>
        <input type="submit" value="Criar Pergunta Discursiva"><br><br>
    </form>
     <form action="index.php">
        <button>Voltar</button>
    </form>
</body>
</html>