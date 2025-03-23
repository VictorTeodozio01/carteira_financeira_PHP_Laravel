<meta name="csrf-token" content="{{ csrf_token() }}">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/">
            <i class="fas fa-wallet"></i> Carteira Financeira
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/transferir">
                            <i class="fas fa-exchange-alt"></i> Transferir
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/depositar">
                            <i class="fas fa-money-bill-wave"></i> Depositar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/transacoes">
                            <i class="fas fa-history"></i> Transações
                        </a>
                    </li>
                @endauth
            </ul>
            <ul class="navbar-nav">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <div class="dropdown-item-text">
                                <small>ID do usuário:</small>
                                <div class="text-secondary">{{ Auth::user()->id }}</div>
                            </div>
                            <div class="dropdown-item-text">
                                <small>Saldo atual:</small>
                                <div class="text-primary">R$ {{ number_format(Auth::user()->saldo, 2, ',', '.') }}</div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <form action="/logout" method="POST" class="d-inline" id="logoutForm">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt"></i> Sair
                                </button>
                            </form>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="/login">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/cadastrar">
                            <i class="fas fa-user-plus"></i> Cadastro
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<style>
.navbar {
    box-shadow: 0 2px 4px rgba(0,0,0,.1);
}

.navbar-brand i {
    margin-right: 5px;
}

.nav-link i {
    margin-right: 5px;
}

.dropdown-menu {
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,.1);
    border-radius: 8px;
    padding: 10px 0;
}

.dropdown-item {
    padding: 8px 20px;
    color: #333;
}

.dropdown-item i {
    width: 20px;
    text-align: center;
    margin-right: 10px;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
    color: #007bff;
}

.dropdown-item.text-danger:hover {
    background-color: #fff5f5;
    color: #dc3545;
}

.dropdown-divider {
    margin: 5px 0;
}

.dropdown-item-text {
    padding: 8px 20px;
    color: #666;
}

.dropdown-item-text .text-primary {
    font-size: 1.2em;
    font-weight: bold;
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
document.getElementById('logoutForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const token = document.querySelector('meta[name="csrf-token"]')?.content || 
                 document.querySelector('input[name="_token"]')?.value;
    
    if (!token) {
        console.error('Token de segurança não encontrado');
        window.location.href = '/login';
        return;
    }
    
    fetch('/logout', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro ao fazer logout');
        }
        return response.json();
    })
    .then(data => {
        window.location.href = '/login';
    })
    .catch(error => {
        console.error('Erro ao fazer logout:', error);
        window.location.href = '/login';
    });
});
</script>