<?php

namespace App\Http\Controllers;

use App\Services\DistanceService;
use App\Services\GeocodeService;
use Illuminate\Http\Request;

class DistanceController extends Controller
{
    protected $geocodeService;
    protected $distanceService;

    public function __construct(GeocodeService $geocodeService, DistanceService $distanceService)
    {
        $this->geocodeService = $geocodeService;
        $this->distanceService = $distanceService;
    }

    public function calculateDistance(Request $request)
    {
        $address1 = $request->address1;
        $address2 = $request->address2;

        $coords1 = $this->geocodeService->getCoordinates($address1);
        $coords2 = $this->geocodeService->getCoordinates($address2);

        if ($coords1 && $coords2) {
            $distance = $this->distanceService->haversineGreatCircleDistance(
                $coords1['lat'], $coords1['lng'],
                $coords2['lat'], $coords2['lng']
            );

            // return response()->json(['distance' => $distance]);
            return $this->HandleSuccessResponse("Distance", $distance .' KM');
        }

        return response()->json(['error' => 'Unable to geocode addresses'], 400);
    }
}
