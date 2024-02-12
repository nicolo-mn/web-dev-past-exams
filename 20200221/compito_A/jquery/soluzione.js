function rgb2hex(orig){
    let rgb = orig.replace(/\s/g,'').match(/^rgba?\((\d+),(\d+),(\d+)/i);
    return (rgb && rgb.length === 4) ? "#" +
     ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
     ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
     ("0" + parseInt(rgb[3],10).toString(16)).slice(-2) : orig;
}

document.querySelector('button').addEventListener('click', function() {
    document.querySelector('p').textContent = "Caricamento dati in corso...";
    fetch("sw_a.json")
        .then(response => response.json())
        .then(data => {
            const table = document.querySelector('table');
            table.innerHTML = 
            `
                <tr>
                    <th>nome</th>
                    <th>email</th>
                    <th>colore_preferito</th>
                    <th>colore_capelli</th>
                    <th>colore_occhi</th>
                    <th>genere</th>
                    <th>modifica_riga</th>
                </tr>
            `;
            for (let i = 0; i < data.length; i++) {
                const row = document.createElement('tr');
                const btn = document.createElement('button');
                btn.innerHTML = "Modifica riga";
                const td = document.createElement('td');
                td.appendChild(btn);
                row.innerHTML = 
                `
                <td><p>${data[i]["nome"]}</p><label for="nome" hidden>nome: </label><input type="text" id="nome" name="nome" hidden/></td>
                <td><p>${data[i]["email"]}</p><label for="email" hidden>email: </label><input type="email" id="email" name="email" hidden/></td>
                <td style="background: ${data[i]["colore_preferito"]}"><label for="colore" hidden>colore: </label><input type="color" id="colore" name="colore" hidden/></td>
                <td><p>${data[i]["colore_capelli"]}</p><label for="capelli" hidden>capelli: </label><input type="text" id="capelli" name="capelli" hidden/></td>
                <td><p>${data[i]["colore_occhi"]}</p><label for="occhi" hidden>occhi: </label><input type="text" id="occhi" name="occhi" hidden/></td>
                <td><p>${data[i]["genere"]}</p><label for="genere" hidden>genere: </label><input type="text" id="genere" name="genere" hidden/></td>
                `;
                btn.addEventListener('click', function() {
                    if (btn.innerHTML === 'Modifica riga') {
                        btn.innerHTML = "Conferma";
                        const row = btn.parentElement.parentElement;
                        const tds = row.children;
                        for (let i = 0; i < tds.length; i++) {
                            const par = tds[i].querySelector('p');
                            if (par) {
                                par.hidden = true;
                            }
                            const label = tds[i].querySelector('label');
                            if (label) {
                                label.hidden = false;
                            }
                            const input = tds[i].querySelector('input');
                            if (input) {
                                input.hidden = false;
                            }
                        }
                    } else {
                        btn.innerHTML = "Modifica riga";
                        const row = btn.parentElement.parentElement;
                        const tds = row.children;
                        for (let i = 0; i < tds.length; i++) {
                            const par = tds[i].querySelector('p');
                            const label = tds[i].querySelector('label');
                            if (label) {
                                label.hidden = true;
                            }
                            const input = tds[i].querySelector('input');
                            if (input) {
                                input.hidden = true;
                                if (par) {
                                    par.hidden = false;
                                    par.textContent = input.value;
                                    input.value = '';
                                }
                            }
                        }
                    }
                });
                row.appendChild(td);
                table.appendChild(row);
            }
            document.querySelector('p').textContent = "Dati caricati con successo";
        });
});
