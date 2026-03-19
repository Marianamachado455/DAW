<?php
$msg = "";
$alunoEncontrado = null;

//Procura por uma matrcula igual
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST["buscar"])) {

        $matricula = $_POST["matricula"];

        if (file_exists("alunos.txt")) {

            $arq = fopen("alunos.txt", "r");

            while (($linha = fgets($arq)) !== false) {

                $dados = explode(";", trim($linha));

                if ($dados[0] == $matricula) {
                    $alunoEncontrado = $dados;
                }
            }

            fclose($arq);
        }

        if ($alunoEncontrado == null) {
            $msg = "Aluno não encontrado";
        }
    }

    //Atualiza as informações ao editar
    if (isset($_POST["atualizar"])) {

        $matricula = $_POST["matricula"];
        $nome = $_POST["nome"];
        $email = $_POST["email"];

        $linhas = file("alunos.txt");

        $arq = fopen("alunos.txt", "w");

        foreach ($linhas as $linha) {

            $dados = explode(";", trim($linha));

            if ($dados[0] == $matricula) {
                $linha = $matricula . ";" . $nome . ";" . $email . "\n";
            }

            fwrite($arq, $linha);
        }

        fclose($arq);

        $msg = "Atualizado com sucesso";
        $alunoEncontrado = [$matricula, $nome, $email];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>

<h1>Buscar Aluno</h1>

<form method="POST">
    Matrícula: <input type="text" name="matricula">
    <br><br>
    <input type="submit" name="buscar" value="Pesquisar">
</form>

<br>

<p><?php echo $msg; ?></p>

<?php if ($alunoEncontrado != null) { ?>

<h1>Atualizar Aluno</h1>

<form method="POST">
    Matrícula: <input type="text" name="matricula" value="<?php echo $alunoEncontrado[0]; ?>">
    <br><br>
    Nome: <input type="text" name="nome" value="<?php echo $alunoEncontrado[1]; ?>">
    <br><br>
    Email: <input type="text" name="email" value="<?php echo $alunoEncontrado[2]; ?>">
    <br><br>
    <input type="submit" name="atualizar" value="Atualizar">
</form>

<?php } ?>

</body>
</html>
