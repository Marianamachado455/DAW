<?php
    if (isset($_GET["pergunta"])) {
        $perguntaPesquisada = $_GET["pergunta"];
        $json = file_get_contents("../../dados/perguntas.json");
        $perguntas = json_decode($json, true);

        if ($perguntas == null) {
            $perguntas = [];
        }

        foreach ($perguntas as $p) {
            if ($p["pergunta"] === $perguntaPesquisada) {
                echo json_encode(["encontrado" => true, "pergunta" => $p]);
                exit;
            }
        }

        echo json_encode(["encontrado" => false]);
    exit;
    }
    else {
        $perguntaPesquisada = "";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $perguntaPesquisada = $_POST["pergunta"];

        $json = file_get_contents("../../dados/perguntas.json");
        $perguntas = json_decode($json, true);

        if ($perguntas == null) {
            $perguntas = [];
        }

        $perguntasAtualizadas = array_filter($perguntas, function($p) use ($perguntaPesquisada) {
            return trim($p["pergunta"]) !== trim($perguntaPesquisada);
        });

        file_put_contents(
            "../../dados/perguntas.json",
            json_encode(array_values($perguntasAtualizadas), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        echo "OK";
        exit;
    }
?> 

<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <h1>Excluir Pergunta</h1>

    <div id="formularioPerg"></div>

    <script>
        function exibirForm() {
            document.getElementById("formularioPerg").innerHTML = `
                <h2>Insira a pergunta que deseja excluir</h2>
                <form onsubmit="pesquisarPergunta(event)">
                    Pergunta: <input type="text" id="perguntaPesquisada"><br><br>
                    <input type="submit" value="Buscar">
                </form>
            `;
        }

        let perguntaEncontrada = null;
        function pesquisarPergunta(event) {
            event.preventDefault();

           const pergunta = document.getElementById("perguntaPesquisada").value.trim();

            fetch("excluirPergunta.php?pergunta=" + encodeURIComponent(pergunta))
            .then(res => res.json())
            .then(dados => {

            if (dados.encontrado) {
                    perguntaEncontrada = dados.pergunta;
                    if (perguntaEncontrada.tipo === "multiplaEscolha") {
                        document.getElementById("formularioPerg").innerHTML = `
                        <h1>Excluir Pergunta Múltipla Escolha</h1>
                        <form onsubmit="excluirPergunta(event)">
                            Pergunta: ${perguntaEncontrada.pergunta}<input type="hidden" name="pergunta" value="${perguntaEncontrada.pergunta}">
                            Resposta Certa:<input type="hidden" name="respostaCerta" value="${perguntaEncontrada.respostaCerta}">
                            Resposta Errada 1: ${perguntaEncontrada.respostaErrada1}<input type="hidden" name="respostaErrada1" value="${perguntaEncontrada.respostaErrada1}"><br>
                            Resposta Errada 2:${perguntaEncontrada.respostaErrada2}<input type="hidden" name="respostaErrada2" value="${perguntaEncontrada.respostaErrada2}"><br>
                            Resposta Errada 3:${perguntaEncontrada.respostaErrada3}<input type="hidden" name="respostaErrada3" value="${perguntaEncontrada.respostaErrada3}"><br>
                            <input type="submit" name="excluir" value="Excluir">
                        </form>
                    `;
                    }

                    else {
                        document.getElementById("formularioPerg").innerHTML = `
                        <h1>Excluir Pergunta Discursiva</h1>
                        <form onsubmit="excluirPergunta(event)">
                            Pergunta: ${perguntaEncontrada.pergunta}<input type="hidden" name="pergunta" value="${perguntaEncontrada.pergunta}"><br>
                            Resposta: ${perguntaEncontrada.respostaCerta}<input type="hidden" name="respostaCerta" value="${perguntaEncontrada.respostaCerta}"><br>
                            <input type="submit" name="excluir" value="Excluir">
                        </form>
                    `;
                    }
                } else {
                    alert("Pergunta não cadastrada.");
                }

            });
        }

        function excluirPergunta(event) {
            event.preventDefault();
            const form = event.target;

            const pergunta = form.pergunta.value;

            fetch("excluirPergunta.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `pergunta=${encodeURIComponent(pergunta)}`
            })
            .then(res => res.text())
            .then(data => {
                alert("Pergunta excluída com sucesso!");
                exibirForm();
            });
        }

        exibirForm();//Pra pag carregar já com o formulário de pesquisa
    </script>
     <form action="../../index.php">
        <br><button>Voltar</button>
    </form>
</body>
</html>