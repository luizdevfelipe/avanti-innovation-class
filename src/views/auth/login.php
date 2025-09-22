<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrada</title>
    <link rel="stylesheet" href="/../resources/style.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100dvh;
            width: 100dvw;
            font-family: "Segoe UI", Roboto, sans-serif;
            background: linear-gradient(135deg, #f0f4f8, #d9e2ec);
        }

        .login-form {
            max-width: 490px;
            border-radius: 12px;
            padding: 30px 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .form-group {
            margin: 15px 0;
            display: flex;
            flex-direction: column;
        }

        .form-label {
            margin-bottom: 5px;
            font-size: 0.9rem;
            color: #555;
        }

        .form-input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            transition: border 0.3s;
        }

        .form-input:focus {
            border-color: #007bff;
            outline: none;
        }

        .login-button {
            display: block;
            padding: 12px;
            margin-top: 15px;
            background-color: #007bff;
            box-shadow: 1px 1px 5px #707070ff;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .login-button:hover {
            background-color: #0056b3;
        }

        .info-text {
            display: block;
            margin: 20px auto 0;
            text-align: center;
            font-size: 0.8rem;
            color: #888;
        }
    </style>
</head>

<body>
    <form class="login-form" action="/login" method="post">
        <div>
            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 13h3.439a.991.991 0 0 1 .908.6 3.978 3.978 0 0 0 7.306 0 .99.99 0 0 1 .908-.6H20M4 13v6a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-6M4 13l2-9h12l2 9M9 7h6m-7 3h8" />
            </svg>

            <h1>Avanti Inventory Management</h1>
        </div>
        <legend>Entre com sua conta para ter acesso ao estoque.</legend>

        <div class="form-group">
            <label class="form-label" for="iemail">Email:</label>
            <input class="form-input" type="email" name="email" id="iemail" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="ipassword">Senha:</label>
            <input class="form-input" type="password" name="password" id="ipassword" required minlength="6">
        </div>

        <div class="form-group">
            <button type="submit" class="login-button">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 18V6h-5v12h5Zm0 0h2M4 18h2.5m3.5-5.5V12M6 6l7-2v16l-7-2V6Z" />
                </svg>
                Entrar
            </button>
        </div>

        <?php if (isset($errors)): ?>
            <?php foreach ($errors as $error): ?>
                <span class="error-text"><?= htmlspecialchars($error) ?></span>
            <?php endforeach; ?>
        <?php endif; ?>

        <span class="info-text">Esqueceu sua senha? Contate um administrador.</span>
    </form>
</body>

</html>