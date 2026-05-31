<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $msg = "";
        $alunoEncontrado = null;

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
        }   

        if (isset($_POST["excluir"])) {
            $matricula = $_POST["matricula"];
            $arq = fopen("alunos.txt", "r");
            $arq2 = fopen("alunos_temp.txt", "w");

            while (($linha = fgets($arq)) !== false) {
                $dados = explode(";", trim($linha));

                if ($dados[0] == $matricula) {
                    continue;
                }

                fwrite($arq2, $linha);
            }

            fclose($arq);
            unlink("alunos.txt");
            rename("alunos_temp.txt", "alunos.txt");
            fclose($arq2);
            $msg = "Aluno excluído com sucesso";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Aluno</title>
</head>
<body>
    <form action="ex5-ExcluirAluno.php" method="POST">
        Matrícula do Aluno a Excluir: <input type="text" name="matricula">
        <br><br>
        <input type="submit" value="Excluir Aluno" name="buscar">
    </form>
</body>
</html>

<?php if ($alunoEncontrado != NULL) { ?>
    <h1>Aluno Encontrado</h1>

    <form action="ex5-ExcluirAluno.php" method="POST">
        Matrícula: <?php echo $alunoEncontrado[0]; ?> <input type="hidden" name="matricula" value="<?php echo $alunoEncontrado[0]; ?>"><br><br>
        Nome: <?php echo $alunoEncontrado[1]; ?> <input type="hidden" name="nome" value="<?php echo $alunoEncontrado[1]; ?>">
        <br><br>
        Email: <?php echo $alunoEncontrado[2]; ?> <input type="hidden" name="email" value="<?php echo $alunoEncontrado[2]; ?>">
        <br><br>
        Deseja exclui-lo?<input type="submit" name="excluir" value="Sim">
    </form>
<?php } ?>