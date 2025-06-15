const childSelect = document.getElementById('child-select');
const programContainer = document.getElementById('program-container');

function displayProgramByChildName(name) {
console.log(window.programs);
    if (window.programs[name].length > 0) {

        window.programs[name].forEach(activity => {

            const activityContainer = document.createElement('div');
            const activityTitle = document.createElement('p');
            const activityDesc = document.createElement('p');

            activityTitle.classList.add('title');
            activityDesc.classList.add('desc');  

            activityTitle.append(`${activity.activity.name} | ${activity.starting_hour.date.split(' ')[1].slice(0, 5)} - ${activity.ending_hour.date.split(' ')[1].slice(0, 5)}`);
            activityDesc.append(activity.activity.description);

            activityContainer.append(activityTitle);
            activityContainer.append(activityDesc);
            programContainer.append(activityContainer);
        });            
    } else {
        programContainer.innerHTML = 'Votre enfant n\'est pas présent aujourd\'hui';
        programContainer.classList.add('no-program');
    }   
}

displayProgramByChildName(childSelect.value);

childSelect.addEventListener('change', () => {
    programContainer.innerHTML = '';
    displayProgramByChildName(childSelect.value);
});