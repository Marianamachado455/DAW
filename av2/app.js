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

function escolherServicoeTipo(event) {
  event.preventDefault();
  var servico = event.currentTarget.getAttribute("servico");
  console.log(servico);


}

// Carregar itens
// function loadItems() {
//   ajax("GET", "api/read.php", null, function (res) {
//     var data = JSON.parse(res);
//     var list = document.getElementById("list");

//     list.innerHTML = "";

//     for (var i = 0; i < data.length; i++) {
//       list.innerHTML +=
//         "<li>" +
//         data[i].name +
//         " " +
//         "<button onclick='deleteItem(" + data[i].id + ")'>X</button>" +
//         " <button onclick='updateItem(" + data[i].id + ")'>Editar</button>" +
//         "</li>";
//     }
//   });
// }

// Atualizar itens
// function updateItem(id) {
//   var name = prompt("Novo nome:");

//   ajax(
//     "POST",
//     "api/update.php",
//     "id=" + encodeURIComponent(id) + "&name=" + encodeURIComponent(name),
//     function () {
//       loadItems();
//     }
//   );
// }

// // Deletar itens
// function deleteItem(id) {
//   ajax("POST", "api/delete.php", "id=" + encodeURIComponent(id), function () {
//     loadItems();
//   });
// }