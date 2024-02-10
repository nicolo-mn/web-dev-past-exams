'use strict';
document.querySelector('button').addEventListener('click', function() {
    fetch('data.json')
    .then(response => response.json())
    .then(data => {
        const dataValues = data.data;
        const main = document.querySelector('main');
        dataValues.forEach(el => {
            const elDiv = document.createElement('div');
            elDiv.innerHTML =
            `
                <ul>
                    <li>${el.id}</li>
                    <li>${el.name}</li>
                    <li>${el.type}</li>
                </ul>
            `;
            const upBtn = document.createElement('button');
            upBtn.textContent = "sposta su";
            upBtn.addEventListener('click', function() {
                const parent = this.parentNode;
                const sibling = parent.previousElementSibling;
                if (sibling !== null) {
                    main.insertBefore(parent, sibling);
                }
            });
            elDiv.appendChild(upBtn);
            const downBtn = document.createElement('button');
            downBtn.addEventListener('click', function() {
                const parent = this.parentNode;
                const sibling = parent.nextSibling;
                if (sibling !== null) {
                    main.insertBefore(sibling, parent);
                }
            });
            downBtn.textContent = "sposta giù";
            elDiv.appendChild(downBtn);
            main.appendChild(elDiv);
        })
    });
})
