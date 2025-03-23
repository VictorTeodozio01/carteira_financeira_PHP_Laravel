<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Carteira Financeira</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    @include('menu')
    
    <div class="container">
        @yield('content')
    </div>

    <div class="container mt-5">
        <h1 class="text-center">Bem-vindo ao seu Dashboard</h1>
        <p class="text-center saldo">Saldo disponível: R$ {{ number_format(Auth::user()->saldo, 2, ',', '.') }}</p>
        
        <div class="actions text-center mt-4 ">
            <a href="/transacoes" class="btn btn-primary">Ver Transações</a>
            <a href="/depositar" class="btn btn-success">Depositar</a>
            <a href="/transferir" class="btn btn-warning">Transferir</a>
        </div>
        
        <h3 class="mt-5">Suas transações recentes:</h3>
        <table class="table table-striped ">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody id="transacoes-recentes">
            </tbody>
        </table>
    </div>

    <script>
        function formatarData(data) {
            return new Date(data).toLocaleString('pt-BR');
        }

        function formatarValor(valor) {
            return new Intl.NumberFormat('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            }).format(valor);
        }

        function carregarTransacoesRecentes() {
            fetch('/transacoes', {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao carregar transações');
                }
                return response.json();
            })
            .then(data => {
                const tableBody = document.querySelector('#transacoes-recentes');
                tableBody.innerHTML = '';

                data.transacoes.slice(0, 5).forEach(transacao => {
                    const row = document.createElement('tr');
                    const descricao = transacao.tipo === 'deposito' ? 
                        'Depósito' : 
                        `Transferência para ${transacao.destinatario ? transacao.destinatario.name : 'Usuário'}`;
                    
                    row.innerHTML = `
                        <td>${formatarData(transacao.created_at)}</td>
                        <td>${descricao}</td>
                        <td>${transacao.tipo === 'deposito' ? '+' : '-'}${formatarValor(transacao.valor)}</td>
                    `;
                    tableBody.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Erro ao carregar transações:', error);
            });
        }

        window.onload = carregarTransacoesRecentes;
    </script>

    <style>
        .saldo-disponivel {
            margin: 20px 0;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }
        .saldo-disponivel h2 {
            margin: 10px 0;
            font-size: 2.5em;
        }
        .actions .btn {
            margin: 0 10px;
            padding: 10px 20px;
        }
        .actions .btn i {
            margin-right: 5px;
        }
    </style>
</body>
</html>