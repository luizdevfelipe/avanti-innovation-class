<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/../resources/style.css">
    <script src="/../resources/script.js" defer></script>
    <style>
        body.modal-open {
            overflow: hidden;
        }

        .modal-container {
            display: none;
            position: fixed;
            inset: 0;
            justify-content: center;
            align-items: center;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .modal-container-content {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            max-width: 490px;
            width: 90%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .modal-container-content h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            max-width: 95%;
            margin-bottom: 15px;
        }

        .half-form-group {
            display: flex;
            justify-content: space-between;
            width: 95%;
            gap: 15px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
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
            display: grid;
            grid-template-columns: 80px 2fr 1fr;
            justify-items: right;
        }

        #content div {
            display: flex;
            justify-content: space-around;
        }
    </style>
</head>

<body>
    <header>
        <h1>Avanti Inventory Management</h1>
        <nav>
            <form action="/logout" method="post">
                <button type="submit" id="logout">Sair</button>
            </form>
        </nav>
    </header>

    <main>
        <section>
            <h2>Produtos</h2>
            <input type="text" name="search" id="isearch" placeholder="Buscar produtos..." oninput="searchProducts()">
            <button id="addProduct">Adicionar Produto</button>
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
                                <button class="editProduct" data-id="<?= $product['id'] ?>">Editar</button>
                                <button class="deleteProduct" data-sku="<?= $product['SKU'] ?>" data-id="<?= $product['id'] ?>">Excluir</button>
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
                <h2>Adicionar Produto</h2>
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
                    <label for="iimage" class="form-label">Imagem:</label>
                    <input type="file" id="iimage" name="image" accept="image/*">
                </div>


                <div class="buttonGroup">
                    <button type="reset" id="clearForm">Limpar</button>
                    <button type="submit" id="saveProduct">Salvar</button>
                    <button type="button" id="cancelAddProduct" onclick="closeModal('modalAddProduct')">Cancelar</button>
                </div>

                <?php if (isset($errors)): ?>
                    <?php foreach ($errors as $error): ?>
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
                    <button type="submit" id="confirmDelete" onclick="confirmDelete()">Sim, Excluir</button>
                    <button type="button" id="cancelDeleteProduct" onclick="closeModal('modalDeleteProduct')">Cancelar</button>
                </div>
            </form>
            <div class="error-text">Essa ação não poderá ser desfeita.</div>
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

        document.querySelectorAll('.editProduct').forEach(button => {
            button.addEventListener('click', function() {
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
                            document.getElementById('saveProduct').innerText = 'Salvar Alterações';

                            openModal('modalAddProduct');
                        } else {
                            alert('Erro ao carregar dados do produto.');
                        }
                    });
            });
        });

        document.getElementById('addProduct').addEventListener('click', function() {
            // Resetar o formulário
            const form = document.querySelector('#modalAddProduct form');
            form.reset();
            form.action = '/products'; // Resetar a ação do formulário para adicionar

            // Mudar o texto do botão salvar
            document.getElementById('saveProduct').innerText = 'Salvar';

            openModal('modalAddProduct');
        });

        document.getElementById('isearch').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            document.querySelectorAll('table tbody tr').forEach(row => {
                const name = row.cells[0].textContent.toLowerCase();
                if (name.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        function searchProducts() {
            const query = document.getElementById('isearch').value;
            fetch('/products?q=' + query)
                .then(response => response.json())
                .then(data => {
                    // Atualizar a tabela com os produtos filtrados
                    if (data.length === 0) {
                        document.querySelector('table').innerHTML = '<tr><td colspan="4">Nenhum produto encontrado.</td></tr>';
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