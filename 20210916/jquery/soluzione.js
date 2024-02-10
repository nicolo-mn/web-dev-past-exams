'use strict';
function resetBg(gameTable) {
    for (const row of gameTable.rows) {
        for (const cell of row.cells) {
            if (cell.style.backgroundColor === 'rgb(202, 202, 202)') {
                cell.style.backgroundColor = '';
            }
        }
    }
}

function verifyBg(gameTable) {
    for (const row of gameTable.rows) {
        for (const cell of row.cells) {
            if (cell.style.backgroundColor === 'rgb(202, 202, 202)') {
                return true;
            }
        }
    }
    return false;
}

function getHighlightedCell(gameTable) {
    for (const row of gameTable.rows) {
        for (const cell of row.cells) {
            if (cell.style.backgroundColor === 'rgb(202, 202, 202)') {
                return cell;
            }
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const gameTable = document.querySelector('.tabellone');
    for (const row of gameTable.rows) {
        for (const cell of row.cells) {
            cell.addEventListener('click', function() {
                resetBg(gameTable);
                cell.style.backgroundColor = '#cacaca';
            });
        }
    }

    const logText = document.querySelector(".log");

    const numbersTable = document.createElement("table");
    numbersTable.id = 'numeri';
    const row = document.createElement('row');
    for (let i = 1; i <= 9; i++) {
        const cell = document.createElement('td');
        cell.innerHTML = i;
        cell.addEventListener('click', function() {
            if (verifyBg(gameTable)) {
                const highlightedCell = getHighlightedCell(gameTable);
                highlightedCell.textContent = i;
                highlightedCell.style.backgroundColor = '';
                logText.textContent = "Numero inserito correttamente";
            } else {
                logText.textContent = "Cella non selezionata";
            }
        });
        row.appendChild(cell);
    }
    numbersTable.appendChild(row);
    document.querySelector('main').appendChild(numbersTable);
})