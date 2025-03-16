<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transferir</title>
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
                <label for="usuario_destino">Usuário Destino:</label>
                <input type="text" id="usuario_destino" name="usuario_destino" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="valor_transferencia">Valor a Transferir:</label>
                <input type="number" id="valor_transferencia" name="valor_transferencia" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Transferir</button>
        </form>
        <p id="responseMessage" class="mt-3 text-center"></p>
    </div>

    <script>
        document.getElementById('transferirForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const usuarioDestino = document.getElementById('usuario_destino').value;
            const valorTransferencia = document.getElementById('valor_transferencia').value;

            fetch('http://127.0.0.1:8000/transferir', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    usuario_destino: usuarioDestino,
                    valor_transferencia: valorTransferencia,
                }),
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('responseMessage').textContent = data.message;
            })
            .catch(error => {
                document.getElementById('responseMessage').textContent = "Erro na transferência!";
            });
        });
    </script>
</body>
</html>