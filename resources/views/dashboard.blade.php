<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Carteira Financeira</title>
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
        <h1 class="text-center">Bem-vindo ao seu Dashboard</h1>
        <p class="text-center saldo">Saldo disponível: R$ 1.000,00</p>
        
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
            <tbody>
                <!--
                <tr>
                    <td>01/03/2025</td>
                    <td>Transferência para João</td>
                    <td>-R$ 200,00</td>
                </tr>
                <tr>
                    <td>28/02/2025</td>
                    <td>Depósito</td>
                    <td>+R$ 500,00</td>
                </tr>
                -->
            </tbody>
        </table>
    </div>
</body>
</html>