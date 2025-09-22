<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERROR 500</title>
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

        .error-div {
            max-width: 490px;
            border-radius: 12px;
            padding: 30px 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .link-button {
            display: block;
            padding: 12px;
            margin-top: 15px;
            background-color: #bfffd8ff;
            box-shadow: 1px 1px 5px #707070ff;
            border: none;
            border-radius: 6px;
            color: #000;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .link-button:hover {
            background-color: #98cca3ff;
        }
    </style>
</head>

<body>
    <div class="error-div">

        <?php if (isset($errors)): ?>
            <span class="error-text">
            Error interno do Servidor: 
            <?php foreach ($errors as $error): ?>
                <br>
                <?= htmlspecialchars($error) ?>
            <?php endforeach; ?>
            </span>
        <?php endif; ?>

        <a class="link-button" href="/dashboard">Voltar para a página principal</a>
    </div>
</body>

</html>