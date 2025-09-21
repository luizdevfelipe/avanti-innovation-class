<?php

namespace App\Core;

class Application 
{
    private static ?Container $container = null;
    private static ?DBConnection $DBConnection = null;

    /**
     * Obtém a instância do container de dependências.
     * @return Container
     */
    public static function getContainer(): Container
    {
        if (self::$container === null) {
            self::$container = new Container();
        }

        return self::$container;
    }

    /**
     * Obtém a instância da conexão com o banco de dados.
     * @return DBConnection
     */
    public static function getDBConnection(): DBConnection
    {
        if (self::$DBConnection === null) {
            self::$DBConnection = new DBConnection();
        }

        return self::$DBConnection;
    }
}

