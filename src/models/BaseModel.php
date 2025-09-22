<?php

namespace App\models;

use App\Core\Application;
use InvalidArgumentException;

class BaseModel
{
    protected static string $table;
    protected static array $fillable = [];
    protected static \PDO $connection;

    private static function getPDO(): \PDO
    {
        if (!isset(self::$connection)) {
            self::$connection = Application::getDBConnection()->getConnection();
        }

        return self::$connection;
    }

    /**
     * Seleciona todos os registros da tabela.
     * @param string|null $columns As colunas a serem selecionadas, ou null para selecionar todas as colunas.
     * @return array Retorna um array de registros.
     */
    public static function select(?string $columns = null): array
    {
        $query = "SELECT " . ($columns ?? '*') . " FROM " . static::$table;
        $stmt = static::getPDO()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Insere um novo registro na tabela utilizando os campos preenchíveis.
     * @param array $data Os dados a serem inseridos, onde as chaves são os nomes das colunas.
     * @return bool Retorna true se a inserção for bem-sucedida, caso contrário, false.
     * @throws InvalidArgumentException Se nenhum dado válido for fornecido para inserção.
     */
    public static function insert(array $data): bool
    {
        $data = array_intersect_key($data, array_flip(static::$fillable));

        $data = array_filter($data, fn($value) => $value !== null && $value !== '');

        if (empty($data)) {
            throw new InvalidArgumentException("Nothing to insert.");
        }

        $columns = array_keys($data);
        $columnsList = implode(', ', $columns);
        $placeholders = implode(', ', array_map(fn($key) => ":{$key}", $columns));

        $query = "INSERT INTO " . static::$table . " ({$columnsList}) VALUES ({$placeholders})";

        $stmt = static::getPDO()->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }

        return $stmt->execute();
    }

    /**
     * Insere um novo registro na tabela e retorna o ID do registro inserido.
     * @param array $data Os dados a serem inseridos, onde as chaves são os nomes das colunas.
     * @return int Retorna o ID do registro inserido.
     * @throws InvalidArgumentException Se nenhum dado válido for fornecido para inserção.
     */
    public static function insertId(array $data): int
    {
        self::insert($data);
        return static::getPDO()->lastInsertId();
    }

    /**
     * Executa uma consulta SQL personalizada com parâmetros opcionais.
     * @param string $query A consulta SQL a ser executada.
     * @param array $params Os parâmetros para a consulta, onde as chaves são os nomes dos placeholders.
     * @return array Retorna um array de resultados da consulta.
     */
    public static function query(string $query, array $params = []): array
    {
        $stmt = static::getPDO()->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $query = "SELECT * FROM " . static::$table . " WHERE id = ?";
        $stmt = static::getPDO()->prepare($query);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * @param string $column O nome da coluna para a condição WHERE.
     * @param mixed $value O valor a ser comparado na condição WHERE.
     * @return array Retorna um array de registros que correspondem à condição.
     */
    public static function where(string $column, mixed $value): array
    {
        $query = "SELECT * FROM " . static::$table . " WHERE {$column} = ?";
        $stmt = static::getPDO()->prepare($query);
        $stmt->execute([$value]);
        $result = $stmt->fetchAll();
        return count($result) == 1 ? $result[0] : $result;
    }

    /**
     * Atualiza um registro na tabela utilizando os campos preenchíveis.
     * @param int $id O ID do registro a ser atualizado.
     * @param array $data Os dados a serem atualizados, onde as chaves são os nomes das colunas.
     * @return bool Retorna true se a atualização for bem-sucedida, caso contrário, false.
     * @throws InvalidArgumentException Se nenhum dado válido for fornecido para atualização.
     */
    public static function update(int $id, array $data): bool
    {
        $data = array_intersect_key($data, array_flip(static::$fillable));

        $data = array_filter($data, fn($value) => $value !== null && $value !== '');

        if (empty($data)) {
            throw new InvalidArgumentException("Nothing to insert.");
        }

        $columns = array_keys($data);
        $setClause = implode(', ', array_map(fn($key) => "{$key} = :{$key}", $columns));
        $query = "UPDATE " . static::$table . " SET {$setClause} WHERE id = :id";

        $stmt = static::getPDO()->prepare($query);
        $stmt->bindValue(':id', $id);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }
        return $stmt->execute();
    }

    /**
     * Exclui um registro da tabela com base no ID.
     * @param int $id O ID do registro a ser excluído.
     * @return bool Retorna true se a exclusão for bem-sucedida, caso contrário, false.
     */
    public static function delete(int $id): bool
    {
        $query = "DELETE FROM " . static::$table . " WHERE id = ?";
        $stmt = static::getPDO()->prepare($query);
        return $stmt->execute([$id]);
    }

    public static function deleteWhere(string $column, $value): bool
    {
        $query = "DELETE FROM " . static::$table . " WHERE {$column} = ?";
        $stmt = static::getPDO()->prepare($query);
        return $stmt->execute([$value]);
    }
}
