const API_URL = "http://127.0.0.1:8000/api";
let usuarioId = null;

function registrar() {
    let nome = document.getElementById("nome").value;
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;

    fetch(`${API_URL}/registrar`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ nome, email, password })
    })
    .then(res => res.json())
    .then(data => {
        usuarioId = data.id;
        document.getElementById("usuarioNome").innerText = data.nome;
        document.getElementById("cadastroLogin").style.display = "none";
        document.getElementById("painelUsuario").style.display = "block";
        atualizarSaldo();
    });
}

function atualizarSaldo() {
    fetch(`${API_URL}/usuario/${usuarioId}/saldo`)
    .then(res => res.json())
    .then(data => {
        document.getElementById("saldo").innerText = data.saldo.toFixed(2);
    });
}
