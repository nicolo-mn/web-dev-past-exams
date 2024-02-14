'use strict';
let transposed = false;
function addListenerTo(btn, tbody) {
    btn.addEventListener('click', function() {
        if (!transposed) {
            const parentTr = this.parentElement.parentElement;
            tbody.insertBefore(parentTr, tbody.rows[0]);
        } else {
            const index = btn.parentElement.cellIndex;
            for (let i = 0; i < tbody.rows.length; i++) {
                const first = tbody.rows[i].cells[1];
                const mine = tbody.rows[i].cells[index];
                tbody.rows[i].insertBefore(mine, first);
            }
        }
    });
}

window.onload = function() {
    const buttons = document.querySelectorAll('button');
    buttons[0].addEventListener('click', function() {
        fetch('sw_b.json')
        .then(x => x.json())
        .then(response => {
            const table = document.querySelector('table');
            const thead = document.createElement('thead');
            const tbody = document.createElement('tbody');
            const trhead = document.createElement('tr');
            const elems = Object.keys(response[0]);
            elems.push('Azione');
            elems.map(el => {
                const th = document.createElement('th');
                th.scope = 'col';
                th.innerHTML = el;
                return th;
            }).forEach(cell => trhead.appendChild(cell));
            thead.appendChild(trhead);
            table.appendChild(thead);
            Array.from(response).forEach(obj => {
                const tr = document.createElement('tr');
                Object.values(obj).forEach(x => {
                    const td = document.createElement('td');
                    td.innerHTML = x;
                    tr.appendChild(td);
                });
                const td = document.createElement('td');
                const btn = document.createElement('button');
                btn.textContent = 'Azione';
                addListenerTo(btn, tbody);
                td.appendChild(btn);
                tr.appendChild(td);
                tbody.append(tr);
            });
            table.appendChild(tbody);
            document.querySelector('p').textContent = 'Dati caricati';
        })
        .catch(error => document.querySelector('p').textContent = 'Caricamento dei dati fallito');
    });

    buttons[1].addEventListener('click', function() {
        const table = document.querySelector('table');
        const tbody = document.querySelector('tbody');
        if (!transposed) {
            const thead = document.querySelector('thead');
            const keys = [];
            const newTBody = document.createElement('tbody');
            Array.from(thead.rows[0].cells).forEach(el => {
                keys.push(el.textContent);
            });
            for (let i = 0; i < keys.length; i++) {
                const tr = document.createElement('tr');
                const th = document.createElement('th');
                th.scope = 'row';
                th.innerHTML = keys[i];
                tr.appendChild(th);
                for (let j = 0; j < tbody.rows.length; j++) {
                    const td = document.createElement('td');
                    td.innerHTML = tbody.rows[j].cells[i].innerHTML;
                    tr.appendChild(td);
                }
                newTBody.appendChild(tr);
            }
            tbody.innerHTML = newTBody.innerHTML;
            table.removeChild(thead);
            transposed = true;
        } else {
            const thead = document.createElement('thead');
            const trhead = document.createElement('tr');
            for (let i = 0; i < table.rows.length; i++) {
                trhead.appendChild(table.rows[i].cells[0]);
            }
            Array.from(trhead.cells).forEach(e => e.scope = 'col');
            thead.appendChild(trhead);
            table.insertBefore(thead, tbody);
            const newTBody = document.createElement('tbody');
            for (let i = 0; i < tbody.rows[0].cells.length; i++) {
                const tr = document.createElement('tr');
                for (let j = 0; j < tbody.rows.length; j++) {
                    const td = document.createElement('td');
                    td.innerHTML = tbody.rows[j].cells[i].innerHTML;
                    tr.appendChild(td);
                }
                newTBody.appendChild(tr);
            }
            tbody.innerHTML = newTBody.innerHTML;
            transposed = false;
        }
        tbody.querySelectorAll('button').forEach(b => addListenerTo(b, tbody));
    });
}