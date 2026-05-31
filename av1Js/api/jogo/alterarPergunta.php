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
        $perguntaOriginal = $_POST["pergunta"];
        $novaRespostaCerta = $_POST["respostaCerta"];
        $novaRespostaErrada1 = $_POST["respostaErrada1"];
        $novaRespostaErrada2 = $_POST["respostaErrada2"];
        $novaRespostaErrada3 = $_POST["respostaErrada3"];

        $json = file_get_contents("../../dados/perguntas.json");
        $perguntas = json_decode($json, true);

        if ($perguntas == null) {
            $perguntas = [];
        }

        foreach ($perguntas as &$pergunta) {
            if (trim($pergunta["pergunta"]) == trim($perguntaOriginal)) {
                if ($pergunta["tipo"] === "multiplaEscolha") {
                    $pergunta["respostaCerta"] = $novaRespostaCerta;
                    $pergunta["respostaErrada1"] = $novaRespostaErrada1;
                    $pergunta["respostaErrada2"] = $novaRespostaErrada2;
                    $pergunta["respostaErrada3"] = $novaRespostaErrada3;
                } else {
                    $pergunta["respostaCerta"] = $novaRespostaCerta;
                }
                break;
            }
        }

        file_put_contents(
            "../../dados/perguntas.json",
        json_encode($perguntas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        echo "OK";
        exit;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar pergunta</title>
</head>
<body>
    <div id="formularioPerg"></div>

    <script>
        function exibirForm() {
            document.getElementById("formularioPerg").innerHTML = `
                <h2>Pesquise a pergunta que deseja alterar</h2>
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

            fetch("alterarPergunta.php?pergunta=" + encodeURIComponent(pergunta))
            .then(res => res.json())
            .then(dados => {

            if (dados.encontrado) {
                    perguntaEncontrada = dados.pergunta;
                    if (perguntaEncontrada.tipo === "multiplaEscolha") {
                        document.getElementById("formularioPerg").innerHTML = `
                        <h1>Atualizar Pergunta Múltipla Escolha</h1>
                        <form onsubmit="atualizarPergunta(event)">
                            Pergunta: ${perguntaEncontrada.pergunta}<input type="hidden" name="pergunta" value="${perguntaEncontrada.pergunta}">
                            Resposta Certa:<input type="text" name="respostaCerta" value="${perguntaEncontrada.respostaCerta}">
                            Resposta Errada 1:<input type="text" name="respostaErrada1" value="${perguntaEncontrada.respostaErrada1}">
                            Resposta Errada 2:<input type="text" name="respostaErrada2" value="${perguntaEncontrada.respostaErrada2}">
                            Resposta Errada 3:<input type="text" name="respostaErrada3" value="${perguntaEncontrada.respostaErrada3}">
                            <input type="submit" name="atualizar" value="Atualizar">
                        </form>
                    `;
                    }

                    else {
                        document.getElementById("formularioPerg").innerHTML = `
                        <h1>Atualizar Pergunta Discursiva</h1>
                        <form onsubmit="atualizarPergunta(event)">
                            Pergunta: ${perguntaEncontrada.pergunta}<input type="hidden" name="pergunta" value="${perguntaEncontrada.pergunta}">
                            Resposta:<input type="text" name="respostaCerta" value="${perguntaEncontrada.respostaCerta}">
                            <input type="submit" name="atualizar" value="Atualizar">
                        </form>
                    `;
                    }
                } else {
                    alert("Pergunta não cadastrada.");
                }

            });
        }

        function atualizarPergunta(event) {
            event.preventDefault();
            const form = event.target;

            const pergunta = form.pergunta.value;
            const novaRespostaCerta = form.respostaCerta.value;

            let respostaErrada1, respostaErrada2, respostaErrada3;

            if (form.respostaErrada1) {
                respostaErrada1 = form.respostaErrada1.value;
            } else {
                respostaErrada1 = "";
            }

            if (form.respostaErrada2) {
                respostaErrada2 = form.respostaErrada2.value;
            } else {
                respostaErrada2 = "";
            }

            if (form.respostaErrada3) {
                respostaErrada3 = form.respostaErrada3.value;
            } else {
                respostaErrada3 = "";
            }

            fetch("alterarPergunta.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body:
                    `pergunta=${encodeURIComponent(pergunta)}` +
                    `&respostaCerta=${encodeURIComponent(novaRespostaCerta)}` +
                    `&respostaErrada1=${encodeURIComponent(respostaErrada1)}` +
                    `&respostaErrada2=${encodeURIComponent(respostaErrada2)}` +
                    `&respostaErrada3=${encodeURIComponent(respostaErrada3)}`
            })
            .then(res => res.text())
            .then(data => {
                alert("Pergunta atualizada com sucesso!");
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