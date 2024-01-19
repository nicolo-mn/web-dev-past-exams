'use strict';
document.querySelector('button').onclick = function() {
    const inputContainer = document.querySelector('button').nextElementSibling;
    const n = document.querySelector('input[name="numerocolonne"]').value;
    if (n > 0 && n <= 12 && inputContainer.innerHTML === '') {
        for (let i=0; i<n; i++) {
            const input = document.createElement('input');
            input.classList.add('larghezzacolonna');
            input.type = 'number';
            inputContainer.appendChild(input);
        }
        const btn = document.createElement('button');
        btn.textContent = "Genera Colonne";
        btn.id = "generacolonne";
        btn.onclick = function() {
            let sum = 0;
            const inputColumns = document.querySelectorAll('.larghezzacolonna');
            inputColumns.forEach(
                el => sum += Number(el.value)
            );
            console.log(sum);
            if (sum !== 12) return;
            // supposing neither of the inputs are 0
            const newRow = document.createElement('div');
            newRow.classList.add('row');
            for (let i = 0; i < inputColumns.length; i++) {
                const newColumn = document.createElement('div');
                newColumn.classList.add('col-' + inputColumns[i].value);
                newRow.appendChild(newColumn);
            }
            document.querySelector('.container-fluid').appendChild(newRow);
            this.parentNode.innerHTML = '';
        }
        inputContainer.appendChild(btn);
    }
};
