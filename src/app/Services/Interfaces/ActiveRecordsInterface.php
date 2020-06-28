<?php

namespace App\Services\Interfaces;

use stdClass;

/**
 * ActiveRecordsInterface Interfaces include main method of active records design pattern
 * for any service deal with data source(like Mysql into our case)
 * @package App\Services\Interfaces
 */
interface ActiveRecordsInterface {

    /**
     * find a row into data source using it's id value
     * @param int $id row id value
     * @return mixed
     */
    public function findById(int $id);

    /**
     * Searching for rows which apply given criteria array
     * @param array $criteria criteria associative array matched with our need from rows under data source
     * @param int $count the total number for retrieve rows under data source
     * @param int $offset the begining set under data source will search into for matched rows
     * @return mixed
     */
    public function find($criteria, int $count = 50, int $offset = 0);

    /**
     * Create new row under data source
     * @param stdClass $model eloquent model instance which represent row data want to add
     * @return mixed
     */
    public function create($model);

    /**
     * Update an exists row under data source
     * @param stdClass $model eloquent model instance which represent row data want to edit
     * @return mixed
     */
    public function update($model);

    /**
     * Delete an exists row under data source
     * @param int $id row id value which want to delete
     * @return mixed
     */
    public function delete(int $id);
}
