<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transações</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    @include('menu')
    <div class="container">
        @yield('content')
    </div>

    <div class="container mt-5">
        <h1 class="text-center">Histórico de Transações</h1>
        <table id="transacoesTable" class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Tipo</th>
                    <th>Valor</th>
                    <th>Usuário Destino</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <script>
        window.onload = function() {
            fetch('http://127.0.0.1:8000/transacoes')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector('#transacoesTable tbody');
                    data.transacoes.forEach(transacao => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${transacao.data}</td>
                            <td>${transacao.tipo}</td>
                            <td>${transacao.valor}</td>
                            <td>${transacao.usuario_destino}</td>
                        `;
                        tableBody.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error('Erro ao carregar transações:', error);
                });
        };
    </script>
</body>
</html>