<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $dados = json_decode(file_get_contents("php://input"), true);

        $arquivo = "../../dados/usuarios.json";
        
        $usuarios = [];
        if (file_exists($arquivo)) {
            $conteudo = file_get_contents($arquivo);
            $usuarios = json_decode($conteudo, true) ?? [];
        }

        $usuarios[] = $dados;

        file_put_contents(
            $arquivo,
            json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

         echo "Usuario criado com sucesso!";
        exit;//Evita que o restante do código seja executado após a resposta ser enviada e criar um alert estranho
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Usuario</title>
</head>
<body>
    <div id="formularioUsuario"></div>

    <script>
        function exibirForm() {
              const formularioUsuario = document.getElementById("formularioUsuario");
            
                formularioUsuario.innerHTML = `
                    <form onsubmit="salvarUsuario(event)">
                        Nome: <input type="text" name="nome" required><br><br>
                        Email:<input type="email"  name="email" required><br><br>
                        Senha:<input type="password" name="senha" required><br><br>
                        Confirmar Senha:<input type="password" name="confirmarSenha" required><br><br>
                        <input type="submit" value="Criar Usuario"><br><br>
                    </form>
                `;
    }
        
        async function salvarUsuario(event) {
            event.preventDefault();

            const form = event.target;
            let dados;


            const nome = form.nome.value.trim();
            const email = form.email.value.trim();
            const senha = form.senha.value;
            const confirmarSenha = form.confirmarSenha.value;

            //Garantir nome, emails e senhas validas
            const regexNome = /^[a-zA-Z\s]{2,50}$/;
            const regexEmail = /.+@.+\..+/;
            const regexSenha = /^.{6,}$/;
            if (!regexNome.test(form.nome.value)) {
                alert("Nome deve conter apenas letras e espaços, entre 2 e 50 caracteres.");
                return;
            }
            if (!regexEmail.test(form.email.value)) {
                alert("Email inválido.");
                return;
            }
            if (!regexSenha.test(form.senha.value) || form.senha.value !== form.confirmarSenha.value) {
                alert("Senha deve ter pelo menos 6 caracteres e ser igual à confirmação.");
                return;
            }

            const dadosUsuario = {nome,email, senha};
            try {
                dados = {
                    nome: form.nome.value,
                    email: form.email.value,
                    senha: form.senha.value,
                };

                const response = await fetch("criarUsuario.php", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(dadosUsuario)
                });

                alert(await response.text());
                form.reset();

            } catch (error) {
                console.error('Erro:', error);
                alert('Erro ao criar pergunta.');
            }
        }
        exibirForm();
    </script>

     <form action="../../index.php">
        <button>Voltar</button>
    </form>
</body>
</html>