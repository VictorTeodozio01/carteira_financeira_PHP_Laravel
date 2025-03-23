<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Transferir - Carteira Financeira</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    @include('menu')
    <div class="container">
        @yield('content')
    </div>

    <div class="container card mt-5 w-25 p-3">
        <h1 class="text-center">Transferir</h1>
        <form id="transferirForm" class="mt-4">
            <div class="form-group">
                <label for="usuario_para">ID do Usuário Destino:</label>
                <input type="number" id="usuario_para" name="usuario_para" class="form-control" placeholder="Digite o ID do usuário destino" required>
            </div>
            <div class="form-group">
                <label for="valor">Valor a Transferir:</label>
                <input type="number" id="valor" name="valor" class="form-control" placeholder="Digite o valor" required min="1" step="0.01">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Transferir</button>
        </form>
        <div id="responseMessage" class="mt-3 text-center"></div>
    </div>

    <script>
        document.getElementById('transferirForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const usuarioPara = document.getElementById('usuario_para').value;
            const valor = document.getElementById('valor').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('http://127.0.0.1:8000/transferir', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: new URLSearchParams({
                    usuario_para: usuarioPara,
                    valor: valor,
                    _token: csrfToken
                }),
                credentials: 'include'
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                document.getElementById('responseMessage').textContent = data.message;
                document.getElementById('responseMessage').classList.remove('text-danger');
                document.getElementById('responseMessage').classList.add('text-success');
            })
            .catch(error => {
                if (error.errors) {
                    const errorMessages = Object.values(error.errors).flat().join(', ');
                    document.getElementById('responseMessage').textContent = errorMessages;
                } else {
                    document.getElementById('responseMessage').textContent = "Erro na transferência: " + (error.message || 'Erro desconhecido');
                }
                document.getElementById('responseMessage').classList.remove('text-success');
                document.getElementById('responseMessage').classList.add('text-danger');
            });
        });
    </script>
</body>
</html>