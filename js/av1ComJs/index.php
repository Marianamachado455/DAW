<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Jogo Corporativo</title>
</head>
<body>
	<h1>Bem vindo</h1>
	<h2>Clique em uma das opções abaixo para começar</h2>
    <h2>Opções de Perguntas</h2><br>
	<form action="api/jogo/criarPergunta.php">
		<button>Criar Pergunta</button><br><br>
	</form>

	<form action="api/jogo/alterarPergunta.php">
		<button>Alterar Pergunta</button><br><br>
	</form>
	<form action="api/jogo/listarTodasPergunta.php">
		<button>Listar todas as perguntas</button><br><br>	
	</form>
	<form action="api/jogo/listarUmaPergunta.php">
		<button>Listar uma pergunta</button><br><br>	
	</form>
	<form action="api/jogo/excluirPergunta.php">
		<button>Excluir Pergunta</button><br><br>	
	</form>

    <h2>Opções de Usuário</h2><br>
	<form action="api/usuario/criarUsuario.php">
		<button>Cadastrar Usuario</button><br><br>	
	</form>
</body>
</html>