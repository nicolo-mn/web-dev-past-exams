'use strict';
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('button');
    let newGameBtn, evaluateBtn, addBtn;
    buttons.forEach(x => {
        if (x.textContent === 'Nuova partita') {
            newGameBtn = x;
        } else if (x.textContent === 'Valuta Soluzione') {
            evaluateBtn = x;
            x.style.display = 'none';
        }
    });
    addBtn = document.querySelector('input[type=submit]');
    document.querySelectorAll('span').forEach(el => el.style.display = 'none');
    document.querySelector('form').style.display = 'none';

    newGameBtn.addEventListener('click', function() {
        const data = new FormData();
        data.append('message', 'newGame');
        fetch('index.php', {
                method: 'POST',
                credentials: 'include', 
                body: data,
            })
            .then(response => response.json())
            .then(data => {
                let table = document.querySelector('table');
                for (let i = 0; i < 9; i++) {
                    let row = document.createElement('tr');
                    for (let j = 0; j < 9; j++) {
                        let cell = document.createElement('td');
                        cell.innerHTML = data[i*9 + j];
                        row.appendChild(cell);
                    }
                    table.appendChild(row);
                }
                let form = document.querySelector('form');
                form.style.display = 'block';
                form.querySelectorAll('input').forEach(el => el.textContent = '');
                evaluateBtn.style.display = 'block';
            });  
    });

    addBtn.addEventListener('click', function(event) {
        event.preventDefault();
        const val = document.getElementById('valore').value;
        const riga = document.getElementById('riga').value;
        const colonna = document.getElementById('colonna').value;
        if (riga < 1 || riga > 9 || colonna < 1 || colonna > 9 || valore < 1 || valore > 9) {
            console.log("errori indici non validi");
        } else {
            let table = document.querySelector('table');
            let cell = table.rows[riga-1].cells[colonna-1];
            cell.textContent = val;
        }
    });

    evaluateBtn.addEventListener('click', function() {
        let res = '';
        let rows = document.querySelector('table').rows;
        Array.from(rows).forEach(row => {
            Array.from(row.cells).forEach(cell => res += cell.textContent);
        });
        console.log(res);
        const formdata = new FormData();
        formdata.append('message', 'evaluate');
        formdata.append('result', res);
        fetch('index.php', {
            method: 'POST',
            credentials: 'include',
            body: formdata
        })
        .then(response => response.text())
        .then(data => {
            if (data) {
                document.getElementById('win').style.display = 'block';
            } else {
                document.getElementById('lose').style.display = 'block';
            }
        })

    });

})




