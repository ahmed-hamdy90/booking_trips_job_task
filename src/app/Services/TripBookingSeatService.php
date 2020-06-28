<?php

namespace App\Services;

use App\Exceptions\NotImplementException;
use App\Services\Interfaces\ActiveRecordsInterface;
use App\TripBookingSeat;

/**
 * TripBookingSeatService Class include domain logic related to {@see TripBookingSeat} model like basic CRUD operation
 * @package App\Services
 */
class TripBookingSeatService implements ActiveRecordsInterface
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
        $tripId = (array_key_exists('trip', $criteria)) ? $criteria['trip'] : null;
        $bookingEmail = (array_key_exists('email', $criteria)) ? $criteria['email'] : null;

        $bookedSeats = [];
        if (!is_null($tripId) && !is_null($bookingEmail)) {
            $bookedSeats = TripBookingSeat::where([
                ['trip_id', '=', $tripId],
                ['booking_user_email', '=', $bookingEmail]
            ])
             ->get();
        } elseif (!is_null($tripId)) {
            $bookedSeats = TripBookingSeat::where('trip_id', '=', $tripId)
                ->get();
        } elseif (!is_null($bookingEmail)) {
            $bookedSeats = TripBookingSeat::where('booking_user_email', '=', $bookingEmail)
                ->get();
        }

        return $bookedSeats;
    }

    /**
     * {@inheritDoc}
     */
    public function create($model)
    {
        TripBookingSeat::create([
            'trip_id' => $model->tripId,
            'seat_number' => $model->seatNumber,
            'booking_user_name'=> $model->bookingName,
            'booking_user_email'=> $model->bookingEmail
        ]);

        $bookedSeat = $this->find(['trip' => $model->tripId, 'email' => $model->bookingEmail]);

        return $bookedSeat[0];
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
     * Retrieve the latest seat number has been booked into given trip
     * @param int $tripId trip id value wanted to get the latest seat number
     * @return int
     */
    public function getTheLatestBookedSeatNumber(int $tripId)
    {
        $bookedSeats = $this->find(['trip' => $tripId]);

        return (count($bookedSeats) == 0) ? 0 : intval(($bookedSeats[count($bookedSeats) - 1])['seat_number']);
    }
}
