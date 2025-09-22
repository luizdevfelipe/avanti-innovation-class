<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/../resources/style.css">
    <script src="/../resources/script.js" defer></script>
    <style>
        @media screen and (max-width: 600px) {
            #productsH2 {
                display: none;
            }

            section {
                margin-top: 5px;
            }

            #searchContainer {
                max-width: 200px;
            }

            #addProduct {
                padding: 5px 10px;
                font-size: 0.9rem;
            }
        }

        body.modal-open {
            overflow: hidden;
        }

        header {
            background-color: #d6d6d6ff;
            padding: 3px 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #logout {
            padding: 5px;
            border: none;
            border-radius: 5px;
            background-color: #ffa1a1ff;
            color: #000;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        #logout:hover {
            background-color: #e60000;
        }

        section {
            max-width: 900px;
            display: block;
            margin: auto;
        }

        section>div {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #searchContainer {
            width: 300px;
            display: flex;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding-left: 5px;
        }

        #isearch {
            width: 100%;
            padding: 5px;
            border: none;
            border-radius: 6px;
            outline: none;
        }

        #isearch:focus {
            border: 1px solid #4a90e2;
            box-shadow: 0 0 6px rgba(74, 144, 226, 0.4);
        }

        #addProduct {
            border-radius: 5px;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            background-color: #28a745;
            color: white;
            transition: background-color 0.3s ease;
        }

        table {
            width: 90dvw;
            max-width: 900px;
            margin: 20px auto;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            font-family: "Segoe UI", Roboto, sans-serif;
        }

        thead {
            background-color: #cce4f6;
        }

        thead th:last-child,
        tbody td:last-child {
            text-align: right;
        }

        thead th:nth-child(2),
        thead th:nth-child(3),
        tbody td:nth-child(2),
        tbody td:nth-child(3) {
            text-align: center;
        }

        thead th {
            padding: 14px 16px;
            text-align: left;
            font-size: 0.9rem;
            font-weight: 600;
            color: #333;
        }

        tbody td {
            padding: 6px 16px;
            font-size: 0.95rem;
            color: #444;
            border-bottom: 1px solid #eee;
        }

        tbody tr:nth-child(even) {
            background-color: #f3fbffff;
        }

        tbody tr:hover {
            background-color: #e2e2e2ff;
            transition: background 0.2s ease-in-out;
        }

        .button {
            padding: 4px;
            margin: 5px 0px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button.deleteButton {
            background-color: #ff4d4d;
            color: white;
        }

        #saveProduct,
        #cancelAddProduct,
        #clearForm {
            padding: 10px 15px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            margin-right: 10px;
            transition: opacity 0.2s ease;
        }

        #clearForm {
            color: #525252ff;
        }

        #saveProduct {
            background: #28a745;
            color: #fff;
        }

        #cancelAddProduct {
            background: #ccc;
            color: #000;
        }

        #saveProduct:hover,
        #cancelAddProduct:hover {
            opacity: 0.9;
        }

        .buttonGroup {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
        }

        .buttonGroup.form-buttons {
            justify-content: space-between;
        }

        .buttonGroup.form-buttons .right-buttons {
            display: flex;
            gap: 10px;
        }

        #content div {
            display: flex;
            justify-content: space-around;
        }

        #iimage {
            display: none;
        }

        .form-group label[for="iimage"] {
            padding: 10px;
            display: inline-block;
            background-color: #57a5ffff;
            color: white;
            border-radius: 6px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .form-group label[for="iimage"]:hover {
            background-color: #357ab8;
            transform: translateY(-1px);
        }

        .form-group label[for="iimage"]:active {
            background-color: #2a5d91;
            transform: translateY(0);
        }
    </style>
</head>

<body>
    <header>
        <div>
            <svg style="color: #000;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path d="M5 3a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H5Zm14 18a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h4ZM5 11a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2H5Zm14 2a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h4Z" />
            </svg>
            <h1>Avanti Inventory Management</h1>
        </div>
        <nav>
            <form action="/logout" method="post">
                <button type="submit" id="logout">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2" />
                    </svg>
                    Sair
                </button>
            </form>
        </nav>
    </header>

    <main>
        <section>
            <div>
                <h2 id="productsH2">Produtos</h2>
                <div id="searchContainer">
                    <label for="isearch">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                        </svg>
                    </label>
                    <input type="text" name="search" id="isearch" placeholder="Buscar produtos..." oninput="searchProducts()">
                </div>
                <button id="addProduct">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Adicionar Produto
                </button>
            </div>
        </section>
        <table>
            <?php if (isset($products) && !empty($products)): ?>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td id="product-name-<?= $product['id'] ?>"><?= htmlspecialchars($product['name']) ?></td>
                            <td id="product-quantity-<?= $product['id'] ?>"><?= htmlspecialchars($product['quantity'] ?? 0) ?></td>
                            <td id="product-price-<?= $product['id'] ?>">R$ <?= htmlspecialchars(number_format($product['price'] ?? 0, 2, ',', '.')) ?></td>
                            <td>
                                <button class="editProduct button" data-id="<?= $product['id'] ?>">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                    </svg>
                                    Editar
                                </button>
                                <button class="deleteProduct button deleteButton" data-sku="<?= $product['SKU'] ?>" data-id="<?= $product['id'] ?>">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                    </svg>
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            <?php else: ?>
                <tr>
                    <td colspan="4">Nenhum produto encontrado.</td>
                </tr>
            <?php endif; ?>
        </table>
    </main>

    <div class="modal-container" id="modalAddProduct">
        <div class="modal-container-content">
            <form action="/products" method="post">
                <h2 id="modalTitle">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9V4a1 1 0 0 0-1-1H8.914a1 1 0 0 0-.707.293L4.293 7.207A1 1 0 0 0 4 7.914V20a1 1 0 0 0 1 1h4M9 3v4a1 1 0 0 1-1 1H4m11 6v4m-2-2h4m3 0a5 5 0 1 1-10 0 5 5 0 0 1 10 0Z" />
                    </svg>
                    Adicionar Produto
                </h2>
                <div class="form-group">
                    <label for="iname" class="form-label">Nome: *</label>
                    <input type="text" id="iname" name="name" placeholder="Camiseta" required>
                </div>

                <div class="half-form-group">
                    <div class="form-group">
                        <label for="isku" class="form-label">SKU: *</label>
                        <input type="text" id="isku" name="sku" placeholder="SKU123" required>
                    </div>
                    <div class="form-group">
                        <label for="icategory" class="form-label">Categoria:</label>
                        <input type="text" id="icategory" name="category" placeholder="Categoria do Produto">
                    </div>
                </div>

                <div class="half-form-group">
                    <div class="form-group">
                        <label for="iprice" class="form-label">Preço:</label>
                        <input type="number" step="0.01" id="iprice" name="price" placeholder="19.99">
                    </div>
                    <div class="form-group">
                        <label for="iquantity" class="form-label">Quantidade:</label>
                        <input type="number" id="iquantity" name="quantity" placeholder="10">
                    </div>
                </div>

                <div class="form-group">
                    <label for="isupplier" class="form-label">Fornecedor:</label>
                    <input type="text" id="isupplier" name="supplier" placeholder="Fornecedor do Produto">
                </div>

                <div class="form-group">
                    <label for="idescription" class="form-label">Descrição:</label>
                    <textarea id="idescription" name="description" placeholder="Descrição do Produto: material, cor, tamanho..." maxlength="1000"></textarea>
                </div>

                <div class="form-group">
                    <label for="iimage" class="form-label">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m3 16 5-7 6 6.5m6.5 2.5L16 13l-4.286 6M14 10h.01M4 19h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />
                        </svg>
                        Clique para adicionar uma imagem
                    </label>
                    <input type="file" id="iimage" name="image" accept="image/*">
                </div>

                <div class="buttonGroup form-buttons">
                    <button type="reset" id="clearForm">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                        </svg>
                        Limpar
                    </button>
                    <div class="right-buttons">
                        <button type="submit" id="saveProduct">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 0 1 1-1h11.586a1 1 0 0 1 .707.293l2.414 2.414a1 1 0 0 1 .293.707V19a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5Z" />
                                <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M8 4h8v4H8V4Zm7 10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            Salvar</button>
                        <button type="button" id="cancelAddProduct" onclick="closeModal('modalAddProduct')">Cancelar</button>
                    </div>
                </div>

                <?php if (isset($_SESSION['errors'])): ?>
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <span class="error-text"><?= htmlspecialchars($error) ?></span>
                    <?php endforeach; ?>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="modal-container" id="modalDeleteProduct">
        <div class="modal-container-content">
            <form action="/products/{id}/delete" method="post" id="formDeleteProduct">
                <h2>Excluir Produto</h2>
                <p>Tem certeza que deseja excluir este produto?</p>
                <div id="content"></div>
                <div class="buttonGroup">
                    <button type="submit" id="confirmDelete" class="button deleteButton" onclick="confirmDelete()">Sim, Excluir</button>
                    <button type="button" id="cancelDeleteProduct" class="button" onclick="closeModal('modalDeleteProduct')">Cancelar</button>
                </div>
            </form>
            <div class="error-text">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5.464V3.099m0 2.365a5.338 5.338 0 0 1 5.133 5.368v1.8c0 2.386 1.867 2.982 1.867 4.175C19 17.4 19 18 18.462 18H5.538C5 18 5 17.4 5 16.807c0-1.193 1.867-1.789 1.867-4.175v-1.8A5.338 5.338 0 0 1 12 5.464ZM6 5 5 4M4 9H3m15-4 1-1m1 5h1M8.54 18a3.48 3.48 0 0 0 6.92 0H8.54Z" />
                </svg>
                Essa ação não poderá ser desfeita.
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.deleteProduct').forEach(button => {
            button.addEventListener('click', function() {
                const div = document.getElementById('content');
                const id = this.getAttribute('data-id');
                const sku = this.getAttribute('data-sku');
                const name = document.getElementById('product-name-' + id).innerText;
                const quantity = document.getElementById('product-quantity-' + id).innerText;
                const price = document.getElementById('product-price-' + id).innerText;

                div.innerHTML = `
                <div>
                    <p>Nome <br> <strong>${name}</strong></p>
                    <p>SKU <br> <strong>${sku}</strong></p>
                </div>
                <div>
                    <p>Quantidade <br> <strong>${quantity}</strong></p>
                    <p>Preço <br> <strong>${price}</strong></p>
                </div>
                
                `;

                document.getElementById('formDeleteProduct').action = `/products/${id}/delete`;

                openModal('modalDeleteProduct');
            });
        });

        // Abrir modal de editar produto
        document.querySelectorAll('.editProduct').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('modalTitle').innerHTML = `<svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"> <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9V4a1 1 0 0 0-1-1H8.914a1 1 0 0 0-.707.293L4.293 7.207A1 1 0 0 0 4 7.914V20a1 1 0 0 0 1 1h4M9 3v4a1 1 0 0 1-1 1H4m11 6v4m-2-2h4m3 0a5 5 0 1 1-10 0 5 5 0 0 1 10 0Z" /> </svg>Editar Produto`;
                const id = this.getAttribute('data-id');

                fetch(`/products/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data) {
                            document.getElementById('iname').value = data.name || '';
                            document.getElementById('isku').value = data.SKU || '';
                            document.getElementById('icategory').value = data.category || '';
                            document.getElementById('iprice').value = data.price || '';
                            document.getElementById('iquantity').value = data.quantity || '';
                            document.getElementById('isupplier').value = data.supplier || '';
                            document.getElementById('idescription').value = data.description || '';

                            // Mudar a ação do formulário para editar
                            const form = document.querySelector('#modalAddProduct form');
                            form.action = `/products/${id}/edit`;

                            // Mudar o texto do botão salvar
                            document.getElementById('saveProduct').innerHTML = `<svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 0 1 1-1h11.586a1 1 0 0 1 .707.293l2.414 2.414a1 1 0 0 1 .293.707V19a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5Z"/> <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M8 4h8v4H8V4Zm7 10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>Salvar Alterações`;

                            openModal('modalAddProduct');
                        } else {
                            alert('Erro ao carregar dados do produto.');
                        }
                    });
            });
        });

        // Abrir modal de adicionar produto
        document.getElementById('addProduct').addEventListener('click', function() {
            document.getElementById('modalTitle').innerHTML = `<svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"> <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9V4a1 1 0 0 0-1-1H8.914a1 1 0 0 0-.707.293L4.293 7.207A1 1 0 0 0 4 7.914V20a1 1 0 0 0 1 1h4M9 3v4a1 1 0 0 1-1 1H4m11 6v4m-2-2h4m3 0a5 5 0 1 1-10 0 5 5 0 0 1 10 0Z" /> </svg>Adicionar Produto`;
            const form = document.querySelector('#modalAddProduct form');
            form.reset();
            form.action = '/products'; // Resetar a ação do formulário para adicionar

            // Mudar o texto do botão salvar
            document.getElementById('saveProduct').innerHTML = `<svg class="w-6 h-6 text-gray-800 ark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"> <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 0 1 1-1h11.586a1 1 0 0 1 .707.293l2.414 2.414a1 1 0 0 1 .293.707V19a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5Z"/> <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M8 4h8v4H8V4Zm7 10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg> Salvar`;

            openModal('modalAddProduct');
        });

        // Função para buscar produtos via API
        function searchProducts() {
            const query = document.getElementById('isearch').value;
            fetch('/products?q=' + query)
                .then(response => response.json())
                .then(data => {
                    // Atualizar a tabela com os produtos filtrados
                    if (data.length === 0) {
                        document.querySelector('table').innerHTML = '<div style="padding: 10px; text-align:center;">Nenhum produto encontrado.</div>';
                        return;
                    }
                    // Adiciona os dados na tabela
                    document.querySelector('table').innerHTML = `   
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>`;
                    data.forEach(product => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                        <td id="product-name-${product.id}">${product.name}</td>
                        <td id="product-quantity-${product.id}">${product.quantity ?? 0}</td>
                        <td id="product-price-${product.id}">R$ ${Number(product.price ?? 0).toFixed(2).replace('.', ',')}</td>
                        <td>
                            <button class="editProduct" data-id="${product.id}">Editar</button>
                            <button class="deleteProduct" data-sku="${product.SKU}" data-id="${product.id}">Excluir</button>
                        </td>
                    `;
                        document.querySelector('table tbody').appendChild(row);
                    });
                });
        }
    </script>
</body>

</html>