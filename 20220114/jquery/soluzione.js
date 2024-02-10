'use strict';
document.addEventListener('DOMContentLoaded', function() {
    let matrix = [];
    for (let i = 0; i < 6; i++) {
        matrix[i] = [];
        for(let j = 0; j < 7; j++) {
            matrix[i][j] = Math.floor(Math.random() * 2 + 1);
        }
    }
    let table = document.querySelector('table');
    for (let i = 0; i < 6; i++) {
        const row = document.createElement('tr');
        for(let j = 0; j < 7; j++) {
            const cell = document.createElement('td');
            cell.style.background = matrix[i][j] == 1 ? 'red' : 'blue';
            cell.addEventListener('click', function() {
                cell.style.background = cell.parentElement.style.backgroundColor;
                matrix[i][j] = 0;
                console.log(matrix);
            });
            row.appendChild(cell); 
        }
        table.appendChild(row);
    }
    const copyTab = document.querySelector('.copia').querySelector('table');
    console.log(copyTab);
    document.querySelector('button').addEventListener('click', function() {
        copyTab.innerHTML = '';   
        for (let i = 0; i < 6; i++) {
            const row = document.createElement('tr');
            for(let j = 0; j < 7; j++) {
                const cell = document.createElement('td');
                cell.textContent = matrix[i][j];
                row.appendChild(cell); 
            }
            copyTab.appendChild(row);
        }
    });
})