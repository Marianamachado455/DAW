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
function criarConta() {
  window.location.href = "../index.html";
  var nome = document.getElementById("nome").value;
  var email = document.getElementById("email").value;
  var cpf = document.getElementById("cpf").value;
  var dta_nascimento = document.getElementById("data_nascimento").value;
  var telefone = document.getElementById("telefone").value;
  var senha = document.getElementById("senha").value;
  var confirmacaoSenha = document.getElementById("confirmacao_senha").value;

  if (senha !== confirmacaoSenha) {
    alert("As senhas não coincidem!");
    return;
  }

  ajax("POST", "api/createUsuario.php", "nome=" + encodeURIComponent(nome) + 
    "&email=" + encodeURIComponent(email) + "&cpf=" + encodeURIComponent(cpf) + 
    "&dta_nascimento=" + encodeURIComponent(dta_nascimento) + 
    "&telefone=" + encodeURIComponent(telefone) + 
    "&senha=" + encodeURIComponent(senha), 
    function(res){
      alert("Usuário cadastrado!");
      window.location.href = "../index.html";
  });
}
