<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Exceptions\NotImplementException;
use App\Services\Interfaces\ActiveRecordsInterface;
use App\Trip;

/**
 * TripService Class include domain logic related to {@see Trip} model like basic CRUD operation
 * @package App\Services
 */
class TripService implements ActiveRecordsInterface
{
    /**
     * {@inheritDoc}
     * @throws NotFoundException throw when given trip's id value was not found
     */
    public function findById(int $id)
    {
        $trip = Trip::find($id);

        if (is_null($trip)) {
            throw new NotFoundException("Given Trip not found");
        }

        return $trip;
    }

    /**
     * {@inheritDoc}
     */
    public function find($criteria, int $count = 50, int $offset = 0)
    {
        $departureCityId = (array_key_exists('departure', $criteria)) ? $criteria['departure'] : null;
        $destinationCityId = (array_key_exists('destination', $criteria)) ? $criteria['destination'] : null;
        $date = (array_key_exists('date', $criteria)) ? $criteria['date'] : null;

        $trips = [];
        if (!is_null($departureCityId) && !is_null($destinationCityId) && !is_null($date)) {
            $trips = Trip::where([
                ['departure_city_id', '=', $departureCityId],
                ['destination_city_id', '=', $destinationCityId],
                ['date', '=', $date]
            ])
            ->limit($count)
            ->offset($offset)
            ->get();
        }

        return $trips;
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

    /**
     * Retrieve all internal trips for trip details
     * @param int $parentId parent trip id value
     * @return mixed
     */
    public function getInternalTrips(int $parentId)
    {
        return Trip::where('parent_trip_id', '=', $parentId)
            ->get();
    }

    /**
     * Decrease the available seats under trip after booking a new seat
     * @param int $tripId trip's id value wanted update
     * @throws NotFoundException throw when given trip's id value was not found
     * TODO: must checking for the seats number internal trips, in case booking full trip
     */
    public function decreaseAvailableSeatForTrip(int $tripId)
    {
        $tripWillUpdate = $this->findById($tripId);

        if ($tripWillUpdate['available_seats_number'] > 0) {
            $tripWillUpdate['available_seats_number'] = $tripWillUpdate['available_seats_number'] - 1;
            $tripWillUpdate->save();
        }
    }
}

