<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        $senha2 = $_POST["senha2"];
        
        $arqPerg1 = fopen("usuarios.txt", "a");

        if (!$arqPerg1) {
            fwrite($arqPerg1, "Nome; Email; Senha;\n");
        }
        
        fwrite($arqPerg1, "$name; $email; $senha;\n");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuario</title>
</head>
<body>
    <form action="criarPergRespME.php" method="post">
        Nome: <input type="text" name="nome" required><br><br>
        Email:<input type="email"  name="email"><br><br>
        Senha:<input type="password" name="senha"><br><br>
        Confirmar Senha:<input type="password" name="senha2"><br><br>
        <input type="submit" value="Cadastrar Usuario"><br><br>
    </form>
     <form action="index.php">
        <button>Voltar</button>
    </form>
</body>
</html>