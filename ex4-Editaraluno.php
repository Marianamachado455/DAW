<?php
$msg = "";
$alunoEncontrado = null;

    //Procura por uma matrcula igual a do aluno  ser editado
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

        $arq = fopen("alunos.txt", "r");
        $arq2 = fopen("alunos_temp.txt", "w");

        while (($linha = fgets($arq)) !== false) {
            $dados = explode(";", $linha);
                if ($dados[0] == $matricula) {
                    $linha = $matricula . ";" . $nome . ";" . $email . "\n";
                }

                fwrite($arq2, $linha);
            }

            fclose($arq);
            unlink("alunos.txt");
            rename("alunos_temp.txt", "alunos.txt");
            fclose($arq2);
            $msg = "Aluno Editado com sucesso";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
</head>
    <body>

    <h1>Buscar Aluno</h1>

    <form action="ex4-EditarAluno.php" method="POST">
        Matrícula: <input type="text" name="matricula">
        <br><br>
        <input type="submit" name="buscar" value="Pesquisar">
    </form>

    <br>

    <p><?php echo $msg; ?></p>

    <?php if ($alunoEncontrado != null) { ?>

    <h1>Atualizar Aluno</h1>

    <form action="ex4-EditarAluno.php" method="POST">
        Matrícula: <?php echo $alunoEncontrado[0]; ?> <input type="hidden" name="matricula" value="<?php echo $alunoEncontrado[0]; ?>">
        <br><br>
        Nome: <input type="text" name="nome" value="<?php echo $alunoEncontrado[1]; ?>">
        <br><br>
        Email: <input type="text" name="email" value="<?php echo $alunoEncontrado[2]; ?>">
        <br><br>
        <input type="submit" name="atualizar" value="Atualizar">
    </form>
    <?php } ?><br><br>

      <form action="ex2-IncluirAluno.php" method="get">
        <button type="submit">Voltar</button>
      </form>
    </body>
</html>