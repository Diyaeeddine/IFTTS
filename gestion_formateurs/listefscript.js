
const toggleButton = document.getElementById('darkModeToggle');
const body = document.body;

toggleButton.addEventListener('click', function() {
  body.classList.toggle('dark-mode');
  toggleButton.innerHTML = body.classList.contains('dark-mode') ? `<img src="moon-stars.svg" id="imgsvg" alt="Moon and Stars"> Désactiver le mode sombre` : `<img src="moon-stars.svg" id="imgsvg" alt="Moon and Stars"> Activer le mode sombre`;

});

