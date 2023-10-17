const caution = document.getElementById('caution');
const cautionClose = document.getElementById('caution-close');

if (caution && cautionClose) {
    cautionClose.addEventListener('click', () => closeCaution(caution));
}

function closeCaution(caution) {
    caution.style.display = "none";
}