<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cadastro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container card mt-5 w-25 p-3">
        <h1 class="text-center">Cadastro</h1>
        <form id="cadastroForm" class="mt-4">
            @csrf
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirme a Senha:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
        </form>
        <p id="responseMessage" class="mt-3 text-center text-danger"></p>
        <p class="text-center">Já possui conta? <a href="/login" class="btn btn-link">Faça Login</a></p>
        <a href="/" class="text-center btn-link">Voltar ao Menu</a>
    </div>
    <script>
        document.getElementById('cadastroForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('http://127.0.0.1:8000/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: new URLSearchParams({
                    name: name,
                    email: email,
                    password: password,
                    password_confirmation: passwordConfirmation,
                    _token: csrfToken
                }),
                credentials: 'include'
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return null;
            })
            .then(() => {
                document.getElementById('responseMessage').textContent = 'Cadastro realizado com sucesso!';
                document.getElementById('responseMessage').classList.remove('text-danger');
                document.getElementById('responseMessage').classList.add('text-success');
                setTimeout(() => {
                    window.location.href = '/login';
                }, 2000); 
            })
            .catch(error => {
                if (error.errors) {
                    const errorMessages = Object.values(error.errors).flat().join(', ');
                    document.getElementById('responseMessage').textContent = errorMessages;
                } else {
                    document.getElementById('responseMessage').textContent = "Erro no cadastro: " + (error.message || 'Erro desconhecido');
                }
                document.getElementById('responseMessage').classList.remove('text-success');
                document.getElementById('responseMessage').classList.add('text-danger');
            });
        });
    </script>
</body>
</html>