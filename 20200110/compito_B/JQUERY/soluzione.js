'use strict';
window.onload = function() {
    const btn = document.querySelector('button');
    const inputDiv = btn.nextElementSibling;
    btn.addEventListener('click', function() {
        inputDiv.innerHTML = '';
        const nline = document.querySelector('input[name="posizioneriga"]').value;
        const row = document.querySelectorAll('.row')[nline];
        if (nline > 0 && row) {
            const colsNum = row.querySelectorAll('div').length;
            inputDiv.innerHTML = '';
            for (let i = 0; i < colsNum; i++) {
                const input = document.createElement('input');
                input.type = 'number';
                input.classList.add('input-col');
                inputDiv.appendChild(input);
            }
            const modifyBtn = document.createElement('button');
            modifyBtn.textContent = 'Modifica Riga';
            modifyBtn.addEventListener('click', function() {
                const inputs = inputDiv.querySelectorAll('.input-col');
                let res = 0;
                Array.from(inputs).forEach(el => res += Number(el.value));
                if (res === 12) {
                    row.innerHTML = '';
                    Array.from(inputs).forEach(el => {
                        const newCol = document.createElement('div');
                        newCol.classList.add('col-' + el.value);
                        row.appendChild(newCol);
                    });
                    inputDiv.innerHTML = '';
                }
            });
            inputDiv.appendChild(modifyBtn);
        }
    });
}