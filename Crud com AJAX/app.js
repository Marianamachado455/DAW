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

// Criar itens
function createItem() {
  var name = document.getElementById("name").value;

  ajax("POST", "api/create.php", "name=" + encodeURIComponent(name), function () {
    loadItems();
  });
}

// Carregar itens
function loadItems() {
  ajax("GET", "api/read.php", null, function (res) {
    var data = JSON.parse(res);
    var list = document.getElementById("list");

    list.innerHTML = "";

    for (var i = 0; i < data.length; i++) {
      list.innerHTML +=
        "<li>" +
        data[i].name +
        " " +
        "<button onclick='deleteItem(" + data[i].id + ")'>X</button>" +
        " <button onclick='updateItem(" + data[i].id + ")'>Editar</button>" +
        "</li>";
    }
  });
}

// Atualizar itens
function updateItem(id) {
  var name = prompt("Novo nome:");

  ajax(
    "POST",
    "api/update.php",
    "id=" + encodeURIComponent(id) + "&name=" + encodeURIComponent(name),
    function () {
      loadItems();
    }
  );
}

// Deletar itens
function deleteItem(id) {
  ajax("POST", "api/delete.php", "id=" + encodeURIComponent(id), function () {
    loadItems();
  });
}
