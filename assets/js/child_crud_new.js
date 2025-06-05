// Ajouter un représentant

const result = document.getElementById('result');
const searchBar = document.getElementById('representative');
const firstNameInput = document.getElementById('first_name');
const lastNameInput = document.getElementById('last_name');
const addRepresentativeBtn = document.getElementById('add_representative');
const form = document.querySelector('form[name="child_form"]');
const presenceSection = document.getElementById('presence_section');

searchBar.addEventListener('input', function() {
    result.textContent = '';

    if (searchBar.value.length > 3) {

        searchUser(searchBar.value)
        .then((data) => {
            const ul = document.createElement('ul');
            
            if (data.array_user.length === 0) {
                result.textContent = "Aucun représentant trouvé";
            }
            console.log(data)
            data.array_user.forEach(user => {
                
                const li = document.createElement('li');
                li.textContent = user.first_name + ' ' + user.last_name;
                ul.append(li);
                
                li.addEventListener('mouseover', function() {
                    li.style.cursor = 'pointer';
                })

                li.addEventListener('click', function() {
                    result.innerHTML = '';
                    searchBar.value = '';

                    firstNameInput.value = user.first_name;
                    lastNameInput.value = user.last_name;

                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.setAttribute('name', 'representativeId');
                    hiddenInput.value = user.representativeId;
                    form.append(hiddenInput);

                })
            })

            result.append(ul);
        })
        .catch((err) => {
            console.error(err);
        });
    }
})

addRepresentativeBtn.addEventListener('click', function() {
    
})

async function searchUser(value) {
    
    try {
        const fetchResponse = await fetch(`http://127.0.0.1:8000/admin/search-representative/${value}`)

        if (!fetchResponse.ok) {
            throw new Error(`Http error : ${fetchResponse.status}`);
        }

        const data = await fetchResponse.json();
        return data;

    } catch (err) {
        console.error(err);
    }
}


// Jours de présence

form.append(presenceSection);

const checkBoxArray = document.querySelectorAll('input[type="checkbox"]');

checkBoxArray.forEach(checkbox => {
    checkbox.addEventListener('change', function() {

        if (checkbox.checked === true) {
            const id = this.id.split("_");
            const prefixeId = id[0];

            const entranceInput = document.querySelector(`input[type="time"]#${prefixeId}_entrance_hour`);
            const exitInput = document.querySelector(`input[type="time"]#${prefixeId}_exit_hour`);
            
            entranceInput.removeAttribute('disabled');
            exitInput.removeAttribute('disabled');

        } else {
            const id = this.id.split("_");
            const prefixeId = id[0];

            const entranceInput = document.querySelector(`input[type="time"]#${prefixeId}_entrance_hour`);
            const exitInput = document.querySelector(`input[type="time"]#${prefixeId}_exit_hour`);
            
            entranceInput.setAttribute('disabled', true);
            exitInput.setAttribute('disabled', true);
        }
    })
})