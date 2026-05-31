<?php

    $json = file_get_contents("../../dados/perguntas.json");
    $perguntas = json_decode($json, true);

    if ($perguntas == null) {
        $perguntas = [];
    }

    if (isset($_GET["api"])) { //Usar isso quando misturar código de API com código de exibição, para evitar que o código de exibição seja executado quando a intenção for apenas obter os dados
        echo json_encode($perguntas, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }
?>

<!DOCTYPE html>
<html>
<head>
</head>
  <body>
  <h1>Listar Todas as Perguntas e Respostas</h1>
    <table style="border: 2px; color: black; border-collapse: collapse;">
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Pergunta</th>
                <th>Resposta Certa</th>
                <th>Errada 1</th>
                <th>Errada 2</th>
                <th>Errada 3</th>
            </tr>
        </thead>
        <tbody id="tabelaPerguntas"></tbody>
    </table><br>
   <script>
    async function listarPerguntas() {
        try {
            const response = await fetch("listarTodasPergunta.php?api=1");
            const data = await response.json();

            if (data.length === 0) {
                document.body.innerHTML += "<p>Nenhuma pergunta cadastrada.</p>";
                return;
            }

            const tabela = document.getElementById("tabelaPerguntas");
            data.forEach(pergunta => {
                let err1 = "-";
                let err2 = "-";
                let err3 = "-";

                if (pergunta.tipo === "multiplaEscolha") {
                        err1 = pergunta.respostaErrada1;
                        err2 = pergunta.respostaErrada2;
                        err3 = pergunta.respostaErrada3;
                    }

                    tabela.innerHTML += `
                        <tr>
                            <td>${pergunta.tipo}</td>
                            <td>${pergunta.pergunta}</td>
                            <td>${pergunta.respostaCerta}</td>
                            <td>${err1}</td>
                            <td>${err2}</td>
                            <td>${err3}</td>
                        </tr>
                    `;
                });
        } catch (error) {
            console.error("Erro ao listar perguntas:", error);
        }
    }

    listarPerguntas();
    </script>
     <form action="../..//index.php">
        <button>Voltar</button>
    </form>
    </body>
</html>