function reloadPageAfterDelay(delayInSeconds) {
    setTimeout(function() {
        window.location.reload();
    }, delayInSeconds * 500);
}

function showContent(contentId) {
    $('.content').removeClass('active');
    $('#' + contentId).addClass('active');
}

async function fillContractForm() {
    return new Promise(function(resolve, reject) {
        $.ajax({
            url: '/departments',
            method: 'GET',
            success: function(response) {
                resolve(response);
            },
            error: function(error) {
                reject(error);
            }
        });
    });
};


async function getAllContracts() {
    return new Promise(function(resolve, reject) {
        $.ajax({
            url: '/contracts',
            method: 'GET',
            success: function(response) {
                resolve(response);
            },
            error: function(error) {
                reject(error);
            }
        });
    });
};

async function getAllFornecedores() {
    return new Promise(function(resolve, reject) {
        $.ajax({
            url: "./suppliers",
            type: 'GET',
            contentType: 'application/json',
        }).done(function (data) {
            $("#supplier").autocomplete({
                source: data.map(function (item) {
                    return {
                        label: item.name,
                        value: item.name,
                        supplierId: item.id,
                    };
                }),
                select: function (event, ui) {
                    $("#supplier").attr("data-supplier-id", ui.item.supplierId);
                },
            });
        }).fail(function (error) {
            reject(error);
        });
    })
}



function sortContracts(response) {
    $('#contratosTable').empty();

    var contracts = Array.isArray(response) ? response : Object.values(response);
    contracts.forEach(function (contract) {
        var row = `
        <tr>
            <td>${contract.id}</td>
            <td>${contract.type}</td>
            <td>${contract.description}</td>
            <td>R$ ${contract.value}</td>
            <td>${contract.supplier.name}</td>
            <td>
                <select class="full-width">`;

            contract.department.forEach(function (department) {
                var departamentoInfo = department.department;
                row += `<option value="${departamentoInfo.id}">${departamentoInfo.name}</option>`;
            });

        row += `
                    </select>
                </td>
                <td>${contract.start_on}</td>
                <td>${contract.finish_on}</td>
            </tr>`;

        $('#contratosTable').append(row);

    });
};


function solveForm() {
    fillContractForm().then( function (response) {
        $('#departmentsContainer').empty();

        Object.values(response).forEach(function (department) {
            var checkbox = `
            <div style="width: 33%;">
                <input type="checkbox" name="departments[]" value="${department.id}" id="${department.name}" />
                <label for="${department.name}" title="${department.description}">${department.name}</label>
            </div>
        `;

            $('#departmentsContainer').append(checkbox);
        });
    });
};


getAllContracts().then( function (response) {
    document.body.style.height = "auto";
    sortContracts(response);
    solveForm();
}).catch(function(error) {
    document.body.style.height = "auto";
    console.error(error);
});


getAllFornecedores();
