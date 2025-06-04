const burgerBtn = document.getElementById('burger-btn');
const burgerMenu = document.getElementById('burger-menu');
const burgerClose = document.getElementById('burger-close');

burgerBtn.addEventListener('click', function() {

    burgerMenu.classList.toggle('open');

})