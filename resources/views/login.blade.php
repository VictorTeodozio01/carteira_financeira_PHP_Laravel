<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Carteira Financeira</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container card mt-5 w-25 p-3">
        <h1 class="text-center">Login</h1>
        <form id="loginForm" class="mt-4">
            @csrf
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
        </form>
        <p id="responseMessage" class="mt-3 text-center text-danger"></p>
        <p class="text-center">Ainda não tem uma conta? <a href="/cadastrar" class="btn btn-link">Cadastre-se aqui</a></p>
        <a href="/" class="text-center btn-link">Voltar ao Menu</a>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('http://127.0.0.1:8000/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: new URLSearchParams({
                    email: email,
                    password: password,
                    _token: csrfToken
                }),
                credentials: 'include'
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { 
                        if (err.errors && err.errors.email) {
                            throw new Error(err.errors.email[0]);
                        }
                        throw new Error(err.message || 'Erro no login');
                    });
                }
                return response.json();
            })
            .then(() => {
                document.getElementById('responseMessage').textContent = 'Login realizado com sucesso!';
                document.getElementById('responseMessage').classList.remove('text-danger');
                document.getElementById('responseMessage').classList.add('text-success');
                setTimeout(() => {
                    window.location.href = '/dashboard';
                }, 2000); 
            })
            .catch(error => {
                document.getElementById('responseMessage').textContent = "Erro no login: " + error.message;
                document.getElementById('responseMessage').classList.remove('text-success');
                document.getElementById('responseMessage').classList.add('text-danger');
            });
        });
    </script>
</body>
</html>