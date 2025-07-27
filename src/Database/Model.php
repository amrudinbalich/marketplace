<?php

namespace Amrudinbalic\Marketplace\Database;

use PDO;

abstract class Model implements CrudInterface
{
    /**
     * Name of the table to be used for the model.
     * @var string
     */
    protected string $table;

    public function __construct(public PDO $pdo) {}

    /**
     * Create a new record in the table.
     * 
     * @param array $data
     * @return int
     */
    public function create(array $data): int
    {
        $columns = $this->getColumns($data);
        $values = $this->getPlaceholders($data);

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$values})";
        $this->pdo->prepare($sql)->execute(array_values($data));

        return $this->pdo->lastInsertId();
    }

    /**
     * Get a record from the table.
     * 
     * @param int $id
     * @param array $columns
     * @return array
     */
    public function get(int $id, array $columns = ['*']): array
    {
        $columns = implode(', ', $columns);
        $sql = "SELECT {$columns} FROM {$this->table} WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }

    /**
     * Update a record in the table.
     * 
     * @param int $id
     * @param array $data
     * @return void
     */
    public function update(int $id, array $data): void
    {
        $setClause = $this->getSetClause($data);
        $sql = "UPDATE {$this->table} SET {$setClause} WHERE id = :id";
        
        $params = $data;
        $params['id'] = $id;
        
        $this->pdo->prepare($sql)->execute($params);
    }

    /**
     * Delete a record from the table.
     * 
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $this->pdo->prepare($sql, ['id' => $id])->execute();
    }

    /**
     * Get a record from the table based on the conditions.
     * 
     * @param array $conditions eg ['id' => 1, 'name' => 'John']
     * @param array $columns eg ['id', 'name', 'email']
     * @return array|false
     */
    public function where(array $conditions, array $columns = ['*']): array|false {
        $whereClause = $this->getWhereClause(columns: array_keys($conditions));
        $columns = implode(', ', $columns);

        $sql = "SELECT {$columns} FROM {$this->table} {$whereClause}";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($conditions);
        return $stmt->fetch();
    }

    // privates (helpers)
    // todo: refactor this later and move into separate ModelService class
    private function getWhereClause(array $columns): string
    {
        $whereParts = [];
        foreach ($columns as $column) {
            $whereParts[] = "{$column} = :{$column}";
        }
        return 'WHERE ' . implode(' AND ', $whereParts);
    }

    private function getColumns(array $columns): string
    {
        return implode(', ', array_keys($columns));
    }

    private function getPlaceholders(array $values): string
    {
        return implode(', ', array_fill(0, count($values), '?'));
    }

    private function getSetClause(array $data): string
    {
        $setParts = [];
        foreach (array_keys($data) as $column) {
            $setParts[] = "{$column} = :{$column}";
        }
        return implode(', ', $setParts);
    }
}