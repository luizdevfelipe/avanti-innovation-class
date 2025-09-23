<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\View;
use App\Services\UserService;

class AuthController
{
    public function __construct(
        private readonly Request $request,
        private readonly UserService $userService
    ) {}

    /**
     * Renderiza a view de login.
     */
    public function loginView()
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: /dashboard');
            exit;
        }
        return View::render('auth/login');
    }

    /**
     * Verifica as credenciais do usuário e inicia a sessão.
     */
    public function checkCredentials()
    {
        $data = $this->request->input();
        $errors = $this->request->validate($data, [
            'email' => ['required', 'email'],
            'password' => ['required', 'string']
        ]);

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: /login');
            exit;
        }

        $user = $this->userService->getUserDataByEmail($data['email']);

        if ($user && $data['password'] === $user['password']) {
            // Credenciais válidas, iniciar sessão
            session_regenerate_id();
            $_SESSION['user_id'] = $user['id'];
            header('Location: /dashboard');
            exit;
        }

        $_SESSION['errors'] = ['Credenciais inválidas, verifique seu usuário e senha.'];
        header('Location: /login');
        exit;
    }

    /**
     * Encerra a sessão do usuário.
     */
    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: /login');
        exit;
    }
}
