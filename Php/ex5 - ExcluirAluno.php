<?php
$msg = "";
$alunoEncontrado = null;
<p><?php echo $msg; ?></p>

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
                    break;
                }
            }

            fclose($arq);
        }

        if ($alunoEncontrado == null) {
            $msg = "Aluno não encontrado";
        }
    }

    //Exclui informações
    if (isset($_POST["excluir"])) {

        $matricula = $_POST["matricula"];
        $nome = $_POST["nome"];
        $email = $_POST["email"];
      
        $arq = fopen("alunos.txt", "r");
        $arq2 = fopen("alunos2.txt", "w");
        
        while (($linha = fgets($arq)) !== false) {

            $dados = explode(";", trim($linha));

            if ($dados[0] == $matricula) {
                continue;
            }

            fwrite($arq2, $linha);
        }

        fclose($arq2);
        fclose($arq);

       rename("alunos.txt", "alunosBackup.txt");
      rename("alunos2.txt", "alunos.txt");

        $msg = "Excluido com sucesso";
        $alunoEncontrado = [$matricula, $nome, $email];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>

<h1>Excluir Aluno</h1>
<h2>1-Forneça a matricula:</h2>

<form method="POST">
    Matrícula: <input type="text" name="matricula">
    <br><br>
    <input type="submit" name="buscar" value="Pesquisar">
</form>

<?php if ($alunoEncontrado != null) { ?>

<h1>Este é o aluno correto? Se não, redigite a matrícula.</h1>

<form method="POST">
    Matrícula: <input type="hidden" name="matricula" value="<?php echo $alunoEncontrado[0]; ?>">
    <br><br>
    Nome: <input type="hidden" name="nome" value="<?php echo $alunoEncontrado[1]; ?>">
    <br><br>
    Email: <input type="hidden" name="email" value="<?php echo $alunoEncontrado[2]; ?>">
    <br><br>
    <input type="submit" name="excluir" value="Confirmar exclusão">
</form>

<?php } ?>

</body>
</html>
