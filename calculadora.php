<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $a = $_POST["a"];
        $b = $_POST["b"] ?? null;
        $operacao = $_POST["operacao"];

        if ($operacao == "Somar") {
            $resultado = $a + $b;
        } elseif ($operacao == "Diminuir") {
            $resultado = $a - $b;
        } elseif ($operacao == "Multiplicar") {
            $resultado = $a * $b;
        } elseif ($operacao == "Dividir") {
            $resultado = $a / $b;
        } elseif ($operacao == "Exponenciacao") {
            $resultado = pow($a, $b);
        } elseif ($operacao == "Raiz quadrada") {
            $resultado = sqrt($a);
            $aviso = "Para raiz quadrada, o valor de b é ignorado.";
        }
}
      //  echo 'Resultado: ' . $soma;
    //  http://localhost/daw/soma.php?a=2&b=3
?>
<!DOCTYPE html>
<html>
<body>
<h1><?php echo 'Minha Calculadora!';?></h1>

<form method='POST' action='calculadora.php'>
    a:<input type=text name='a'><br>
    b:<input type=text name='b'><br>
    Escolha a operação que deseja realizar.<br>
    <input type="submit" name="operacao" value="Somar">
    <input type="submit" name="operacao" value="Diminuir">
    <input type="submit" name="operacao" value="Multiplicar">
    <input type="submit" name="operacao" value="Dividir">
    <input type="submit" name="operacao" value="Exponenciacao">
    <input type="submit" name="operacao" value="Raiz quadrada"><br>
    <label>Aviso!! Para a raiz quadrada insira apenas um numero na variavel a, para evitar erros.<label>
    <br><br>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "Resultado: $resultado";
    }
    ?>
    
</body>
</html>