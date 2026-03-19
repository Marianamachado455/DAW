<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST["nome"];
    $matricula = $_POST["matricula"];
    $email = $_POST["email"];
    $msg = "";

    echo "nome: " . $nome . " matricula: " . $matricula . " email: " . $email;

    if (!file_exists("alunos.txt")) {
        $arqAluno = fopen("alunos.txt", "w") or die("erro ao criar arquivo");
        $linha = "nome;matricula;email\n";
        fwrite($arqAluno, $linha);
        fclose($arqAluno);
    }

    $arqAluno = fopen("alunos.txt", "a") or die("erro ao abrir arquivo");
    $linha = $nome . ";" . $matricula . ";" . $email . "\n";
    fwrite($arqAluno, $linha);
    fclose($arqAluno);

    $msg = "Deu tudo certo!!!";
}
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>Criar Novo Aluno</h1>
<form action="ex03_IncluirAluno.php" method="POST">
    Nome: <input type="text" name="nome">
    <br><br>
    Matrícula: <input type="text" name="matricula">
    <br><br>
    Email: <input type="text" name="email">
    <br><br>
    <input type="submit" value="Criar Novo Aluno">
</form>
</body>
</html>