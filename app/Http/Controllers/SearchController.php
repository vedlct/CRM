<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Client as GoogleClient;
use Google\Service\Customsearch;


class SearchController extends Controller
{
    public function searchResults (Request $request)
    {
        // Validate the search term from the request
        $request->validate([
            'searchTerm' => 'required|string',
        ]);

        // Get the search term from the request
        $searchTerm = $request->input('searchTerm');

        // Define the maximum number of search results to display
        $maxResults = 5;

        // Create a new instance of the Google Client
        $client = new GoogleClient();
        $client->setDeveloperKey(config('services.google.search.api_key'));

        // Create a new instance of the Google Customsearch service
        $service = new Customsearch($client);

        // Make the API request to Google Custom Search
        $response = $service->cse->listCse($searchTerm, [
            'cx' => config('services.google.search.cx'),
            'num' => $maxResults,
        ]);

        // Get the search results
        $results = $response->getItems() ?? [];

        // Pass the search results to the view
        return view('report.searchResults', compact('results'));
    }
}
