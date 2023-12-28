<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela Responsiva</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/external.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

    <div class="container">

    <div id="mensagem-sucess"></div>
    <div id="mensagem-error"></div>

        <div class="tabs">
            <div class="tab" onclick="showContent('content1')">Adicionar Contrato</div>
            <div class="tab" onclick="showContent('content2')">Adicionar Departamento</div>
            <div class="tab" onclick="showContent('content3')">Adicionar Fornecedor</div>
        </div>

        <div id="content1" class="content active">
            <h2>Adicionar Contrato</h2>

            <form id="addContratoForm">
                @csrf
                <label for="description">Descrição:</label>
                <textarea id="description" name="description" rows="4" ></textarea>

                <label for="type">Tipo do Contrato:</label>
                <input type="text" id="type" name="type" >

                <label for="value">Valor do Contrato:</label>
                <input type="text" id="value" name="value" >

                <label for="start_on">Data de Início:</label>
                <input type="date" id="start_on" name="start_on" >

                <label for="finish_on">Data de Término:</label>
                <input type="date" id="finish_on" name="finish_on" >

                <label for="supplier">Fornecedor:</label>
                <input type="text" id="supplier" name="supplier" >

                <label for="department">Departamentos:</label>
                <div id="departmentsContainer"></div>

                <button type="submit">Adicionar Contrato</button>
            </form>
        </div>
        <div id="content2" class="content">
            <h2>Adicionar Departamento</h2>
            <form id="addDepartamentoForm">
                <label for="name">Nome:</label>
                <input type="text" name="name" required>
                <br>

                <label for="description">Descrição:</label>
                <textarea name="description" required></textarea>
                <br>

                <button type="submit">Adicionar Departamento</button>
            </form>
        </div>
        <div id="content3" class="content">
            <h2>Adicionar Fornecedor</h2>

            <form id="addFornecedorForm">
                <label for="name">Nome:</label>
                <input type="text" name="name" required>

                <label for="description">Descrição:</label>
                <textarea name="description" required></textarea>

                <label for="address">Endereço:</label>
                <input type="text" name="address" required>

                <label for="phone">Telefone:</label>
                <input type="text" name="phone" required>

                <label for="email">E-mail:</label>
                <input type="email" name="email" required>
<br>
                <button type="submit">Adicionar Fornecedor</button>
            </form>
        </div>
    </div>
<hr>

<h2>Grade de Contratos</h2>
<form id="filterForm">
   <div>
        <label for="type">Tipo do Contrato:</label>
        <input type="text" id="type" name="type">
    </div>
    <div>
        <label for="supplier">Fornecedor:</label>
        <input type="text" id="supplier" name="supplier">
    </div>

    <div>
        <label for="start_on">Data de Início:</label>
        <input type="date" id="start_on" name="start_on">
    </div>

    <div>
        <label for="finish_on">Data de Término:</label>
        <input type="date" id="finish_on" name="finish_on">
    </div>

    <button type="submit" class="filter-buttom">Filtrar</button>
</form>


<table>
    <thead>
        <tr>
            <th>Nº</th>
            <th>Tipo do Contrato</th>
            <th>Descrição</th>
            <th>Valor do Contrato</th>
            <th>Fornecedor</th>
            <th>Departamento</th>
            <th>Data de Início</th>
            <th>Data de Término</th>
        </tr>
    </thead>
    <tbody id="contratosTable"></tbody>
</table>

<script>
    function changeValue(value) {
        document.getElementById('rectangle').innerText = value;
    }
</script>

</body>
</html>
