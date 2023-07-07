import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

var retangulo = document.getElementById('retangulo');
retangulo.addEventListener('mouseover', function() {
retangulo.style.backgroundColor = 'red';
});
retangulo.addEventListener('mouseout', function() {
retangulo.style.backgroundColor = 'blue';
});
