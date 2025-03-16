<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Depositar - Carteira Financeira</title>
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
        <h1 class="text-center">Depósito</h1>
        <div class="form-container">
            <form id="form-deposito" class="mt-4">
                <div class="form-group">
                    <label for="usuario_id">ID do Usuário:</label>
                    <input type="text" id="usuario_id" name="usuario_id" class="form-control" placeholder="Digite o ID do Usuário" required>
                </div>
                <div class="form-group">
                    <label for="valor">Valor do Depósito:</label>
                    <input type="number" id="valor" name="valor" class="form-control" placeholder="Digite o valor" required min="1">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Depositar</button>
            </form>
            <div id="message" class="mt-3 text-center"></div>
        </div>
    </div>

    <script>
        document.getElementById('form-deposito').addEventListener('submit', function(event) {
            event.preventDefault();

            const usuario_id = document.getElementById('usuario_id').value;
            const valor = document.getElementById('valor').value;

            fetch('http://127.0.0.1:8000/api/depositar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    usuario_id: usuario_id,
                    valor: valor,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    document.getElementById('message').textContent = data.message;
                    document.getElementById('message').classList.remove('text-danger');
                    document.getElementById('message').classList.add('text-success');
                }
            })
            .catch(error => {
                document.getElementById('message').textContent = 'Erro ao realizar depósito.';
                document.getElementById('message').classList.remove('text-success');
                document.getElementById('message').classList.add('text-danger');
            });
        });
    </script>
</body>
</html>