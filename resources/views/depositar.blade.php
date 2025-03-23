<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    <label for="valor">Valor do Depósito:</label>
                    <input type="number" id="valor" name="valor" class="form-control" placeholder="Digite o valor" required min="1" step="0.01">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Depositar</button>
            </form>
            <div id="message" class="mt-3 text-center"></div>
        </div>
    </div>

    <script>
        document.getElementById('form-deposito').addEventListener('submit', function(event) {
            event.preventDefault();

            const valor = document.getElementById('valor').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('http://127.0.0.1:8000/depositar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: new URLSearchParams({
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
                document.getElementById('message').textContent = data.message;
                document.getElementById('message').classList.remove('text-danger');
                document.getElementById('message').classList.add('text-success');
            })
            .catch(error => {
                if (error.errors) {
                    const errorMessages = Object.values(error.errors).flat().join(', ');
                    document.getElementById('message').textContent = errorMessages;
                } else {
                    document.getElementById('message').textContent = "Erro ao realizar depósito: " + (error.message || 'Erro desconhecido');
                }
                document.getElementById('message').classList.remove('text-success');
                document.getElementById('message').classList.add('text-danger');
            });
        });
    </script>
</body>
</html>