function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
    document.body.classList.remove('modal-open');
}

function openModal(modalId) {
    document.getElementById(modalId).style.display = 'flex';
    document.body.classList.add('modal-open');
}

function getTranslation(key) {
    const translations = {
        name: 'Nome',
        sku: 'SKU',
        category: 'Categoria',
        price: 'Preço',
        quantity: 'Quantidade',
        supplier: 'Fornecedor',
        description: 'Descrição',
        password: 'Senha',
        email: 'Email',
    }

    return translations[key] || key;
}