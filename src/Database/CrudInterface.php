<?php

namespace Amrudinbalic\Marketplace\Database;

interface CrudInterface
{
    /**
     * Create a new record in the table.
     * 
     * @param array $data
     * @return int
     */
    public function create(array $data): int;

    /**
     * Get a record from the database.
     * 
     * @param int $id
     * @param array $columns
     * @return array
     */
    public function get(int $id, array $columns = ['*']): array;

    /**
     * Update a record in the table.
     * 
     * @param int $id
     * @param array $data
     * @return void
     */
    public function update(int $id, array $data): void;

    /**
     * Delete a record from the table.
     * 
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;
}