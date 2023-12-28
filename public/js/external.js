$(document).ready(function () {
    $('#dataInicioFilter, #dataTerminoFilter').inputmask({
        alias: 'datetime',
        inputFormat: 'yyyy-mm-dd',
        placeholder: 'yyyy-mm-dd',
    });

    $( document ).tooltip();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#addDepartamentoForm').submit(function (event) {
        event.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            url: '/departments',
            method: 'POST',
            data: formData,
            success: function (response) {
                $('#mensagem-sucess').html('<p>Novo Departamento salvo com sucesso</p>');
                reloadPageAfterDelay(1);
            },
            error: function (error) {
                $('#mensagem-error').html('<p>Erro ao processar a solicitação.</p>');
                reloadPageAfterDelay(1);
            }
        });
    });

    $('#addFornecedorForm').submit(function (event) {
        event.preventDefault();

        var formData = $(this).serialize();
        $.ajax({
            url: '/suppliers',
            method: 'POST',
            data: formData,
            success: function (response) {
                $('#mensagem-sucess').html('<p>Novo Fornecedor salvo com sucesso</p>');
                reloadPageAfterDelay(1);
            },
            error: function (error) {
                $('#mensagem-error').html('<p>Erro ao processar a solicitação.</p>');
                reloadPageAfterDelay(1);
            }
        });
    });

    $('#addContratoForm').submit(function (event) {
        event.preventDefault();

        var supplierId = $("#supplier").data("supplier-id");

        var formData = $('#addContratoForm').serialize();

        formData += '&supplier_id=' + supplierId;

        $.ajax({
            url: '/contracts',
            method: 'POST',
            data: formData,
            processData: false,
            success: function (response) {
                $('#mensagem-sucess').html('<p>Novo Fornecedor salvo com sucesso</p>');
                reloadPageAfterDelay(1);
            },
            error: function (error) {
                $('#mensagem-error').html('<p>Erro ao processar a solicitação.</p>');
                reloadPageAfterDelay(1);
            }
        });
    });

    $('#filterForm').submit(function (event) {
        event.preventDefault();
        var formData = $('#filterForm').serialize();
        $.ajax({
            url: '/contracts',
            method: 'PUT',
            data: formData,
            processData: false,
            success: function (response) {
                sortContracts(response);
            },
            error: function (error) {
                $('#mensagem-filter-error').html('<p>Erro ao processar a solicitação.</p>');
                reloadPageAfterDelay(3);
            }
        });
    });
});
