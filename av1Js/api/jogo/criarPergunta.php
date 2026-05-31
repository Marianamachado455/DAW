<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $dados = json_decode(file_get_contents("php://input"), true);

        $arquivo = "../../dados/perguntas.json";
        
        $perguntas = [];
        if (file_exists($arquivo)) {
            $conteudo = file_get_contents($arquivo);
            $perguntas = json_decode($conteudo, true) ?? [];
        }

        $perguntas[] = $dados;

        file_put_contents(
            $arquivo,
            json_encode($perguntas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

         echo "Pergunta criada com sucesso!";
        exit;//Evita que o restante do código seja executado após a resposta ser enviada e criar um alert estranho
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Pergunta</title>
</head>
<body>
    <h1>Escolha uma opção de tipo de pergunta</h1><br>
    <input type="radio" name="tipo" value="pergMultiplaEscolha" onchange="exibirForm()">Pergunta Multipla Escolha
    <input type="radio" name="tipo" value="pergDiscursiva" onchange="exibirForm()">Pergunta Discursiva<br><br>
    <div id="formularioPerg"></div>

    <script>
        function exibirForm() {
            let selecionado = document.querySelector('input[name="tipo"]:checked').value;

            //Impede erro ao abrir a pág sem marcar uma das opcoes
            if (!selecionado) {
                return;
            }

            const formularioPerg = document.getElementById("formularioPerg");
            
            if (selecionado === "pergMultiplaEscolha") {
                formularioPerg.innerHTML = `
                    <form onsubmit="salvarPergunta('multiplaEscolha', event)">
                        Pergunta: <input type="text" name="pergunta" required><br><br>
                        Resposta Certa:<input type="text"  name="respostaCerta"><br><br>
                        Resposta Errada 1:<input type="text" name="respostaErrada1"><br><br>
                        Resposta Errada 2:<input type="text" name="respostaErrada2"><br><br>
                        Resposta Errada 3:<input type="text" name="respostaErrada3"><br><br>
                        <input type="submit" value="Criar Pergunta Multipla Escolha"><br><br>
                    </form>
                `;
            } else if (selecionado === "pergDiscursiva") {
                formularioPerg.innerHTML = `
                    <form onsubmit="salvarPergunta('discursiva', event)">
                        Pergunta: <input type="text" name="pergunta" required><br><br>
                        Resposta Certa:<input type="text"  name="respostaCerta"><br><br>
                        <input type="submit" value="Criar Pergunta Discursiva"><br><br>
                    </form>
                `;
            }
        }

        async function salvarPergunta(tipo, event) {
            event.preventDefault();

            const form = event.target;
            let dados;

            try {
                if (tipo === 'multiplaEscolha') {
                    dados = {
                        tipo: 'multiplaEscolha',
                        pergunta: form.pergunta.value,
                        respostaCerta: form.respostaCerta.value,
                        respostaErrada1: form.respostaErrada1.value,
                        respostaErrada2: form.respostaErrada2.value,
                        respostaErrada3: form.respostaErrada3.value
                    };

                } 
                
                else if (tipo === 'discursiva') {
                    dados = {   
                        tipo: 'discursiva',
                        pergunta: form.pergunta.value,
                        respostaCerta: form.respostaCerta.value
                    };
                }

                const response = await fetch("criarPergunta.php", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(dados)
                });

                alert(await response.text());
                form.reset();

            } catch (error) {
                console.error('Erro:', error);
                alert('Erro ao criar pergunta.');
            }
        }
    </script>

     <form action="../../index.php">
        <button>Voltar</button>
    </form>
</body>
</html>