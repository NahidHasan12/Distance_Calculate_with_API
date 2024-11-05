
// file path:  App/Services/GeocodeServiec.php

<?php

namespace App\Services;

use GuzzleHttp\Client;

class GeocodeService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('GOOGLE_MAP_API_KEY'); // Set this in your .env file
    }

    public function getCoordinates($address)
    {
        $response = $this->client->get('https://maps.gomaps.pro/maps/api/geocode/json', [
            'query' => [
                'address' => $address,
                'key' => $this->apiKey,
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        if (isset($data['results'][0])) {
            return [
                'lat' => $data['results'][0]['geometry']['location']['lat'],
                'lng' => $data['results'][0]['geometry']['location']['lng'],
            ];
        }

        return null; // Return null if geocoding fails
    }
}
