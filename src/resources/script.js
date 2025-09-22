function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
    document.body.classList.remove('modal-open');
}

function openModal(modalId) {
    document.getElementById(modalId).style.display = 'flex';
    document.body.classList.add('modal-open');
}