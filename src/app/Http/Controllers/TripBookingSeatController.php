<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Services\TripBookingSeatService;
use App\Services\TripService;
use Illuminate\Http\Request;

/**
 * TripBookingSeatController Class represent controller class of TripBookingSeat request API
 * @package App\Http\Controllers
 */
class TripBookingSeatController extends Controller
{
    private $tripService;

    private $tripBookingSeatService;

    /**
     * TripBookingSeatController constructor.
     * @param TripService $tripService trip service instance
     * @param TripBookingSeatService $tripBookingSeatService trip booking seats service instance
     */
    public function __construct(TripService $tripService, TripBookingSeatService $tripBookingSeatService)
    {
        $this->tripService = $tripService;
        $this->tripBookingSeatService = $tripBookingSeatService;
    }

    /**
     * Booking a Seat under exists Trip for user
     * @param Request $request request API instance
     * @return \Illuminate\Http\JsonResponse
     * @throws NotFoundException may be not throw exception, as decreaseAvailableSeatForTrip method called with ids are exists
     */
    public function bookingSeat(Request $request)
    {
        $tripId = $request->input('tripId', null);
        $userName = $request->input('user.name', null);
        $userEmail = $request->input('user.email', null);

        // Must
        if (is_null($tripId) || is_null($userName) || is_null($userEmail)) {
            return response()->json([], 400);
        }

        // get details for trip wanted to book
        $trip = null;
        try {
            $trip = $this->tripService->findById(intval($tripId));
        } catch (NotFoundException $exception) {
            return response()->json([], 404);
        }
        // check first is there available seats
        if (intval($trip['available_seats_number']) === 0) {
            return response()->json([], 403);
        }
        // booking an new seat
        $bookingSeat = new \StdClass();
        $bookingSeat->tripId = $trip->id;
        $bookingSeat->seatNumber = $this->tripBookingSeatService->getTheLatestBookedSeatNumber($trip->id) + 1;
        $bookingSeat->bookingName = $userName;
        $bookingSeat->bookingEmail = $userEmail;
        // TODO: check if operation failed
        $bookedSeat = $this->tripBookingSeatService->create($bookingSeat);

        // decrease booked trip first
        $this->tripService->decreaseAvailableSeatForTrip($trip->id);
        // check if given trip want to booking was internal trip or full trip
        if (is_null($trip['parent_trip_id'])) {
            // this mean booked trip was full trip so must decrease available seats for the internal trip if exists
            $internalTrips = $this->tripService->getInternalTrips($tripId);
            foreach ($internalTrips as $internalTrip) {
                $this->tripService->decreaseAvailableSeatForTrip($internalTrip->id);
            }
        } else {
            // this mean booked trip was internal trio so must decrease available seat of parent trip too
            $this->tripService->decreaseAvailableSeatForTrip($trip['parent_trip_id']);
        }

        return  response()->json([
            'bookedTrip' => $bookedSeat
        ], 201);
    }
}
