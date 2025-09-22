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
        }
        

        .form-group {
            margin: 5px;
            display: flex;
            flex-direction: column;
        }

        .form-label {
            color: #707070ff;
        }

        .login-form {
            min-width: 380px;
            border-radius: 5px;
            padding: 10px;
            box-shadow: 1px 1px 5px #707070ff;
            background-color: white;
        }

        .info-text {
            display: block;
            margin: auto;
            text-align: center;
            font-size: 0.8rem;
            color: #707070ff;
        }       
    </style>
</head>

<body>
    <form class="login-form" action="/login" method="post">
        <h1>Avanti Inventory Management</h1>
        <legend>Entre com sua conta para ter acesso ao estoque.</legend>

        <div class="form-group">
            <label class="form-label" for="iemail">Email:</label>
            <input type="text" name="email" id="iemail" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="ipassword">Senha:</label>
            <input type="password" name="password" id="ipassword" required>
        </div>

        <div class="form-group">
            <button type="submit">Entrar</button>
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