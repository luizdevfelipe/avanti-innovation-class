<?php 

namespace App\Core;

class View 
{
    /**
     * Renderiza um arquivo "view" com as variáveis fornecidas.
     * @param string $viewPath Caminho relativo do arquivo de view (sem extensão).
     * @param array $variables Variáveis a serem extraídas para o escopo da view.
     * @return string O conteúdo renderizado da view.
     */
    public static function render(string $viewPath, array $variables = []): string
    {
        $fullPath = __DIR__ . '/../views/' . $viewPath . '.php';

        if (!file_exists($fullPath)) {
            throw new \Exception('View file not found: ' . $fullPath);
        }

        // Transforma as chaves do array em variáveis individuais locais
        extract($variables);

        // Inicia o buffer de saída para capturar o conteúdo da view, retornando-o como string
        ob_start();
        include $fullPath;
        return ob_get_clean();
    }
}