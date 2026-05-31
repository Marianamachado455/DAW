<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $pergunta = $_POST["pergunta"];
        $respostaCerta = $_POST["respostaCerta"];
        $respostaErrada1 = $_POST["respostaErrada1"];
        $respostaErrada2 = $_POST["respostaErrada2"];
        $respostaErrada3 = $_POST["respostaErrada3"];
        
        $arqPerg1 = fopen("pergMultiplaEscolha.txt", "a");

        if (!$arqPerg1) {
            fwrite($arqPerg1, "Pergunta; Resposta Certa; Resposta Errada 1; Resposta Errada 2; Resposta Errada 3;\n");
        }
        
        fwrite($arqPerg1, "$pergunta; $respostaCerta; $respostaErrada1; $respostaErrada2; $respostaErrada3;\n");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Pergunta e Resposta Multipla Escolha</title>
</head>
<body>
    <form action="criarPergRespME.php" method="post">
        Pergunta: <input type="text" name="pergunta" required><br><br>
        Resposta Certa:<input type="text"  name="respostaCerta"><br><br>
        Resposta Errada 1:<input type="text" name="respostaErrada1"><br><br>
        Resposta Errada 2:<input type="text" name="respostaErrada2"><br><br>
        Resposta Errada 3:<input type="text" name="respostaErrada3"><br><br>
        <input type="submit" value="Criar Pergunta Multipla Escolha"><br><br>
    </form>
     <form action="index.php">
        <button>Voltar</button>
    </form>
</body>
</html>