const searchOnhold = document.getElementById('searchOnhold');
const searchHistory = document.getElementById('searchHistory');

function filterTable(input, tableBodyId, className)
{
    if (!input) return;

    input.addEventListener('input', function () {

        const keyword = this.value.toLowerCase();

        document
            .querySelectorAll(`#${tableBodyId} tr`)
            .forEach(function (row) {

                const column = row.querySelector(`.${className}`);

                if (!column) return;

                row.style.display =
                    column.textContent
                        .toLowerCase()
                        .includes(keyword)
                    ? ''
                    : 'none';

            });

    });
}

filterTable(
    searchOnhold,
    'onholdBody',
    'transaction-customer'
);

filterTable(
    searchHistory,
    'historyBody',
    'transaction-customer'
);