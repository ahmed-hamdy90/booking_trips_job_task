<?php

namespace App\Services;

use App\City;
use App\Exceptions\NotImplementException;
use App\Services\Interfaces\ActiveRecordsInterface;

/**
 * CityService Class include domain logic related to {@see City} model like basic CRUD operation
 * @package App\Services
 */
class CityService implements ActiveRecordsInterface
{

    /**
     * {@inheritDoc}
     * @throws NotImplementException as method not implemented, not need now
     */
    public function findById(int $id)
    {
        throw new NotImplementException('not implemented');
    }

    /**
     * {@inheritDoc}
     */
    public function find($criteria, int $count = 50, int $offset = 0)
    {
        $cityName = (array_key_exists('name', $criteria)) ? $criteria['name'] : null;
        $cityCode = (array_key_exists('code', $criteria)) ? $criteria['code'] : null;

        $cities = [];
        if (!is_null($cityName) && !is_null($cityCode)) {
            // TODO: check how to add offset and from using laravel query builder
            $cities = City::where([
                ['name', '=', $cityName],
                ['code', '=', $cityName]
            ])
            ->limit($count)
            ->offset($offset)
            ->get();
        } elseif (!is_null($cityName)) {
            $cities = City::where('name', '=', $cityName)
                ->limit($count)
                ->offset($offset)
                ->get();
        } elseif (!is_null($cityCode)) {
            $cities = City::where('code', '=', $cityCode)
                ->limit($count)
                ->offset($offset)
                ->get();
        }

        return $cities;
    }

    /**
     * {@inheritDoc}
     * @throws NotImplementException as method not implemented, not need now
     */
    public function create($model)
    {
        throw new NotImplementException('not implemented');
    }

    /**
     * {@inheritDoc}
     * @throws NotImplementException as method not implemented, not need now
     */
    public function update($model)
    {
        throw new NotImplementException('not implemented');
    }

    /**
     * {@inheritDoc}
     * @throws NotImplementException as method not implemented, not need now
     */
    public function delete(int $id)
    {
        throw new NotImplementException('not implemented');
    }
}

