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
        return View::render('auth/login');
    }

    /**
     * Verifica as credenciais do usuário e inicia a sessão.
     */
    public function checkCredentials()
    {
        $data = $this->request->input();
        $validatedData = $this->request->validate($data, [
            'email' => ['required', 'email'],
            'password' => ['required', 'string']
        ]);

        if (!empty($validatedData)) {
            return View::render('auth/login', ['errors' => $validatedData]);
        }

        $user = $this->userService->getUserDataByEmail($data['email']);

        if ($user && $data['password'] === $user['password']) {
            // Credenciais válidas, iniciar sessão
            $_SESSION['user_id'] = $user['id'];
            header('Location: /dashboard');
            exit;
        }

        return View::render('auth/login', ['errors' => ['Credenciais inválidas.']]);
    }
}
