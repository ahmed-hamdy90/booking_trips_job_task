<?php

namespace App\Http\Controllers;

use App\Services\CityService;
use App\Services\TripService;
use Illuminate\Http\Request;

/**
 * TripsController Class represent controller class of Trips request API
 * @package App\Http\Controllers
 */
class TripsController extends Controller
{
    private $cityService;

    private $tripService;

    /**
     * TripsController constructor.
     * @param CityService $cityService city service instance
     * @param TripService $tripService trip service instance
     */
    public function __construct(CityService $cityService, TripService $tripService)
    {
        $this->cityService = $cityService;
        $this->tripService = $tripService;
    }

    /**
     * Searching for available trip for user
     * @param Request $request request API instance
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchForTrip(Request $request)
    {
        // must search request include three query string [from, to, date]
        $pickupCityQuery = $request->query('from', null);
        $destinationCityQuery = $request->query('to', null);
        $dateQuery = $request->query('date', null);
        if (is_null($pickupCityQuery) || is_null($destinationCityQuery) || is_null($dateQuery)) {
            return response()->json([], 400);
        }

        // getting pickup and destination city details
        $pickupCityCriteria = ["code" => $pickupCityQuery];
        $pickupCities = $this->cityService->find($pickupCityCriteria);
        $pickupCity = null;
        if (count($pickupCities) > 0) {
            $pickupCity = $pickupCities[0];
        }
        $destinationCityCriteria = ["code" => $destinationCityQuery];
        $destinationCities = $this->cityService->find($destinationCityCriteria);
        $destinationCity = null;
        if (count($destinationCities) > 0) {
            $destinationCity = $destinationCities[0];
        }

        // retrieve the available trips according to given query string values
        $availableTrips = [];
        if (!is_null($destinationCity) && !is_null($pickupCity)) {
            $tripsCriteria = [
                'departure' => $pickupCity->id,
                'destination' => $destinationCity->id,
                'date' => $dateQuery
            ];
            $availableTrips = $this->tripService->find($tripsCriteria);
        }

        return response()->json([
            'trips' => $availableTrips
        ]);
    }
}
