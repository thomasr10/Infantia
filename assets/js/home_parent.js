const childSelect = document.getElementById('child-select');
const programContainer = document.getElementById('program-container');

function displayProgramByChildName(name) {

    window.programs[name].forEach(activity => {
        console.log(activity)
        const activityContainer = document.createElement('div');
        const activityTitle = document.createElement('p');
        const activityDesc = document.createElement('p');

        activityTitle.append(`${activity.activity.name} | ${activity.starting_hour.date.split(' ')[1].slice(0, 5)} - ${activity.ending_hour.date.split(' ')[1].slice(0, 5)}`);
        activityDesc.append(activity.activity.description);

        activityContainer.append(activityTitle);
        activityContainer.append(activityDesc);
        programContainer.append(activityContainer);

    });
}

displayProgramByChildName(childSelect.value);

childSelect.addEventListener('change', () => {
    programContainer.innerHTML = '';
    displayProgramByChildName(childSelect.value);
});