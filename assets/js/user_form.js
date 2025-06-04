const roleCheckbox = document.querySelectorAll('input[name="user_form[roles][]"]');
const form = document.getElementById('user_form');

roleCheckbox.forEach(check => {
    check.addEventListener('change', function() {

        if(check.checked === true) {
            if(check.value === 'ROLE_PARENT') {

            const parentFieldsContainer = document.createElement('div');
            parentFieldsContainer.setAttribute('id', 'parent_fields');

            const adressDiv = document.createElement('div');
            const adressLabel = document.createElement('label');
            const adressInput = document.createElement('input');


            adressLabel.setAttribute('for', 'user_form_adress');
            adressLabel.textContent = 'Adresse';

            adressInput.type = 'text';
            adressInput.setAttribute('required', true);
            adressInput.setAttribute('id', 'user_form_adress');
            adressInput.setAttribute('name', 'user_form[adress]');

            adressDiv.append(adressLabel);
            adressDiv.append(adressInput);

            parentFieldsContainer.append(adressDiv);


            const postalCodeDiv = document.createElement('div');
            const postalCodeLabel = document.createElement('label');
            const postalCodeInput = document.createElement('input');


            postalCodeLabel.setAttribute('for', 'user_form_postalCode');
            postalCodeLabel.textContent = 'Code Postal';

            postalCodeInput.type = 'text';
            postalCodeInput.setAttribute('required', true);
            postalCodeInput.setAttribute('id', 'user_form_postal_code');
            postalCodeInput.setAttribute('name', 'user_form[postal_code]');

            postalCodeDiv.append(postalCodeLabel);
            postalCodeDiv.append(postalCodeInput);

            parentFieldsContainer.append(postalCodeDiv);


            const cityDiv = document.createElement('div');
            const cityLabel = document.createElement('label');
            const cityInput = document.createElement('input');


            cityLabel.setAttribute('for', 'user_form_city');
            cityLabel.textContent = 'Ville';

            cityInput.type = 'text';
            cityInput.setAttribute('required', true);
            cityInput.setAttribute('id', 'user_form_city');
            cityInput.setAttribute('name', 'user_form[city]');

            cityDiv.append(cityLabel);
            cityDiv.append(cityInput);

            parentFieldsContainer.append(cityDiv);

            form.append(parentFieldsContainer);
        }
        } else {
            if (check.value === 'ROLE_PARENT') {
                const parentFields = document.getElementById('parent_fields');
                if (parentFields) {
                    form.removeChild(parentFields);
                }
            }
        }

    })
})