function ajax(method, url, data, callback) {
  var xhr = new XMLHttpRequest();
  xhr.open(method, url, true);
  if (method === "POST") {
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  }

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      callback(xhr.responseText);
    }
  };

  xhr.send(data || null);
}

// Adicionar Usuario
function criarConta(event) {
  event.preventDefault();
  var nome = document.getElementById("nome").value;
  var email = document.getElementById("email").value;
  var cpf = document.getElementById("cpf").value;
  var dta_nascimento = document.getElementById("data_nascimento").value;
  var telefone = document.getElementById("telefone").value;
  var senha = document.getElementById("senha").value;
  var confirmacaoSenha = document.getElementById("confirmar-senha").value;

  if (senha != confirmacaoSenha) {
    alert("As senhas não coincidem!");
    return;
  }

  ajax("POST", "../api/createUsuario.php", "nome=" + encodeURIComponent(nome) + 
    "&email=" + encodeURIComponent(email) + "&cpf=" + encodeURIComponent(cpf) + 
    "&dta_nascimento=" + encodeURIComponent(dta_nascimento) + 
    "&telefone=" + encodeURIComponent(telefone) + 
    "&senha=" + encodeURIComponent(senha), 
    function(res){
      window.location.href = "../index.html";
      console.log("Usuário criado com sucesso!");
  });
}

function login() {
  const email = document.getElementById("email").value;
  const senha = document.getElementById("senha").value;

   if (!email || !senha) {
    alert("Preencha email e senha!");
    return;
  }
  
  const data =
    "email=" + encodeURIComponent(email) +
    "&senha=" + encodeURIComponent(senha);

  //Passa pro php autenticar, garantindo segurança
  ajax("POST", "api/login.php", data, function(resposta) {
    const json = JSON.parse(resposta);

    if (json.status === "ok") {
      sessionStorage.setItem("usuarioNome", json.nome);
      window.location.href = "pages/pagInicial.html";
    } 
    
    else {
      alert(json.msg);
    }
  });
}

function voltarInicio() {
  window.location.href = "pagInicial.html";
}

function escolherServicoeTipo(event) {
  event.preventDefault();
  var servico = event.currentTarget.getAttribute("servico");
  console.log(servico);

  ajax("GET","../api/listarServico.php",null,
    function(res){
        dadosServicos = JSON.parse(res);
        var tipos = dadosServicos.filter(s => s.nome == servico);

      if(tipos.length > 1){
        mostrarModal(servico);
      }

      else{
        var tipo = tipos[0];

        sessionStorage.setItem("servicoSelecionado", tipo.nome);
        sessionStorage.setItem("tipoSelecionado", tipo.tipo);
        sessionStorage.setItem("preco", tipo.preco);
        sessionStorage.setItem("profissionais",JSON.stringify(tipo.profissionais.split(",")));

        window.location.href="../pages/confirmarAgendamento.html";
    }
    }
  );
}

function mostrarModal(servico, dados) {
    document.getElementById("tituloModal").innerHTML = servico;
    var lista = document.getElementById("listaTipos");
    lista.innerHTML = "";
    var tipos = dadosServicos.filter(s => s.nome == servico);

    for(var i = 0; i < tipos.length; i++){
        lista.innerHTML +=
        "<button class='tipoServico' onclick=\"escolherTipo('" + servico + "'," + i + ")\">" +
            "<span>" + tipos[i].tipo + "</span>" +
            "<span>R$ " + tipos[i].preco + "</span>" +
        "</button>";
    }

    document.getElementById("modalServico").style.display = "flex";
}

function fecharModal() {
    document.getElementById("modalServico").style.display = "none";
}

function escolherTipo(servico, index) {
  var tipos = dadosServicos.filter(s => s.nome == servico);
  var tipo = tipos[index];

  sessionStorage.setItem("servicoSelecionado", tipo.nome);
  sessionStorage.setItem("tipoSelecionado", tipo.tipo);
  sessionStorage.setItem("preco", tipo.preco);
  sessionStorage.setItem("profissionais",JSON.stringify(tipo.profissionais.split(","))
);

  window.location.href = "../pages/confirmarAgendamento.html";
}

function mostrarInformacoesAgendamento() {
  const servico = sessionStorage.getItem("servicoSelecionado");
  const tipo = sessionStorage.getItem("tipoSelecionado");
  const preco = sessionStorage.getItem("preco");
  const profissionais = JSON.parse(sessionStorage.getItem("profissionais")) || [];

  document.getElementById("servicoSelecionado").innerHTML = `Serviço: ${servico}`;

  if (tipo) {
      document.getElementById("tipoContainer").style.display = "block";
      document.getElementById("tipo").innerHTML = `Tipo: ${tipo}`;
  } 
  else {
      document.getElementById("tipoContainer").style.display = "none";
  }
  const selectProf = document.getElementById("profissionais");
  selectProf.innerHTML = "";
  const placeholder = document.createElement("option");
  placeholder.value = "";
  placeholder.textContent = "Escolha um profissional";
  placeholder.disabled = true;
  placeholder.selected = true;
  placeholder.hidden = true;
  selectProf.appendChild(placeholder);

  profissionais.forEach(p => {
    const option = document.createElement("option");
    option.value = p;
    option.textContent = p;
    selectProf.appendChild(option);
  });

  const qualquer = document.createElement("option");
  qualquer.value = "qualquer";
  qualquer.textContent = "Qualquer profissional disponível";
  selectProf.appendChild(qualquer);

  document.getElementById("preco").innerHTML = `Preço: R$ ${preco}`;
}

function agendar() {
  const usuario = sessionStorage.getItem("usuarioNome") || "";
  const profissional = document.getElementById("profissionais").value;
  const data = document.getElementById("data").value;
  const hora = document.getElementById("hora").value;
  const servico = sessionStorage.getItem("servicoSelecionado");
  const tipo = sessionStorage.getItem("tipoSelecionado");
  const data_horario = data + " " + hora;
  const pagamento = document.getElementById("pagamento").value;

   if (!profissional || !data || !hora || !pagamento) {
    alert("Preencha todos os campos!");
    return;
  }

  const dados =
    "usuario=" + encodeURIComponent(usuario) +
    "&servico=" + encodeURIComponent(servico) +
    "&tipo=" + encodeURIComponent(tipo) +
    "&profissional=" + encodeURIComponent(profissional) +
    "&data_horario=" + encodeURIComponent(data_horario) +
    "&pagamento=" + encodeURIComponent(pagamento);
  console.log("ENVIANDO:", dados);

  ajax("POST", "../api/createAgendamento.php", dados, function(resposta) {
    console.log("RESPOSTA BRUTA:", resposta);
    if (!resposta || resposta.trim() === "") {
      alert("PHP não retornou nada!");
      return;
    }
    const json = JSON.parse(resposta);

    if (json.status === "ok") {
       mostrarModalSucesso();
    } else {
      alert(json.msg);
      window.location.href = "../pages/pagInicial.html";
    }
  });
}

function mostrarModalSucesso() {
  document.getElementById("modalSucesso").style.display = "flex";
}

function irInicio() {
  window.location.href = "../pages/pagInicial.html";
}

//garante exibicao das informacoes do agendamento na tela de confirmacao
window.addEventListener("DOMContentLoaded", mostrarInformacoesAgendamento);