
window.onload = function() {
    let people = [];

    class Persona {
        constructor(nome, cognome, dataNascita) {
            this.nome = nome;
            this.cognome = cognome;
            this.dataNascita = dataNascita;
        }
    
        infoPersonaConsole() {
            console.log(`Nome: ${this.nome}, Cognome: ${this.cognome}, Data di nascita: ${this.dataNascita}`);
        }
    
        infoPersonaDOM() {
            const fatherDiv = document.querySelector(".people");
            const myDiv = document.createElement("div");
            const h2 = document.createElement("h2");
            h2.textContent = this.nome + " " + this.cognome;
            const p = document.createElement('p');
            p.textContent = this.dataNascita;
            const span = document.createElement('span');
            span.addEventListener('click', function() {
                const index = people.indexOf(this);
                people.splice(index, 1);
                fatherDiv.removeChild(myDiv);
            });
            span.textContent = 'x';
            myDiv.appendChild(h2);
            myDiv.appendChild(p);
            myDiv.appendChild(span);
            fatherDiv.appendChild(myDiv);
        }
    }

    document.querySelector('button').addEventListener('click', function(event) {
        event.preventDefault();
        const nome = document.querySelector('input[name="nome"]');
        const cognome = document.querySelector('input[name="cognome"]');
        const dataNascita = document.querySelector('input[name="data_nascita"]');
        if (nome.value.length < 2 || cognome.value.length < 2 || dataNascita.value === '') {
            alert("Dati insufficienti");
        } else {
            const person = new Persona(nome.value, cognome.value, dataNascita.value);
            people.push(person);
            person.infoPersonaConsole();
            person.infoPersonaDOM();
        }
    });
    
};