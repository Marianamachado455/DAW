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
    $linha = $matricula . ";" . $nome . ";" . $email . "\n";
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
<form action="ex2-IncluirAluno.php" method="POST">
    Nome: <input type="text" name="nome">
    <br><br>
    Matrícula: <input type="text" name="matricula">
    <br><br>
    Email: <input type="text" name="email">
    <br><br>
    <input type="submit" value="Criar Novo Aluno">
</form>

<br><br>
<form action="ex3-ListarAluno.php" method="get">
    <button type="submit">Página de Listagem</button>
</form><br>

<form action="ex4-EditarAluno.php" method="get">
    <button type="submit">Página de Edição</button>
</form><br>

<form action="ex5-ExcluirAluno.php" method="get">
    <button type="submit">Página de Exclusão</button>
</form><br>
</body>
</html>