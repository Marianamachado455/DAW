<?php

    $json = file_get_contents("../../dados/perguntas.json");
    $perguntas = json_decode($json, true);

    $perguntaPesquisada = $_GET["pergunta"] ?? "";

    foreach ($perguntas as $perguntaEncontrada) {
        if ($perguntaEncontrada["pergunta"] === $perguntaPesquisada) {
            echo json_encode([
                "encontrado" => true,
                "pergunta" => $perguntaEncontrada
            ]);
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar pergunta</title>
</head>
<body>
    <div id="formularioPerg"></div>
    <div id="resultadoPerg"></div>

    <script>
        function exibirForm() {
            document.getElementById("formularioPerg").innerHTML = `
                <h2>Pesquise a pergunta que deseja visualizar</h2>
                <form onsubmit="exibirPergunta(event)">
                    Pergunta: <input type="text" id="perguntaPesquisada"><br><br>
                    <input type="submit" value="Buscar">
                </form>
            `;
        }

        let perguntaEncontrada = null;
        function exibirPergunta(event) {
            event.preventDefault();

           const pergunta = document.getElementById("perguntaPesquisada").value.trim();

            fetch("listarUmaPergunta.php?pergunta=" + encodeURIComponent(pergunta))
            .then(res => res.json())
            .then(dados => {

            if (dados.encontrado) {
                perguntaEncontrada = dados.pergunta;

                if (perguntaEncontrada.tipo === "multiplaEscolha") {
                        let err1 = perguntaEncontrada.respostaErrada1;
                        let err2 = perguntaEncontrada.respostaErrada2;
                        let err3 = perguntaEncontrada.respostaErrada3;

                        document.getElementById("resultadoPerg").innerHTML = `
                        <h2>Pergunta encontrada</h2>
                        <p><b>Pergunta:</b> ${perguntaEncontrada.pergunta}</p>
                        <p><b>Resposta certa:</b> ${perguntaEncontrada.respostaCerta}</p>
                        <p><b>Errada 1:</b> ${err1}</p>
                        <p><b>Errada 2:</b> ${err2}</p>
                        <p><b>Errada 3:</b> ${err3}</p>
                        `;
                }

                else if (perguntaEncontrada.tipo === "discursiva") {
                    document.getElementById("resultadoPerg").innerHTML = `
                    <h2>Pergunta encontrada</h2>
                    <p><b>Pergunta:</b> ${perguntaEncontrada.pergunta}</p>
                    <p><b>Resposta certa:</b> ${perguntaEncontrada.respostaCerta}</p>
                    `;
                }
            }
            else {
                alert("Pergunta não cadastrada.");
            }

            });
        }
        exibirForm();
    </script>
     <form action="../..//index.php"><br>
        <button>Voltar</button>
    </form>
    </body>
</html>