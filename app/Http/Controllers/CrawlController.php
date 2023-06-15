<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;
use phpDocumentor\Reflection\Types\Null_;
use Psy\Exception\ErrorException;
use DataTables;
use Session;

use Goutte\Client;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriResolver;
use Psr\Http\Message\UriInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\BrowserKit\Client as BrowserKitClient;
use Symfony\Component\DomCrawler\Crawler;

use Intervention\Image\Facades\Image;


class CrawlController extends Controller
{
    // public function crawlWebsites(Request $request)
    //             {
    //                 $websites = $request->input('websites');
    //                 $imageSize = $request->input('imageSize');
    //                 $submitted = !empty($websites);
    //                 $imageData = [];
                    
    //                 if ($submitted) {
    //                     try {
    //                         $client = new Client();
    //                         $websitesArray = preg_split("/\r\n|\n|\r/", $websites); // Split the input by new lines to get an array of URLs
    //                         $imageData = [];
                    
    //                         foreach ($websitesArray as $website) {
    //                             $crawler = $client->request('GET', $website);
    //                             $imageData = array_merge($imageData, $this->getImagesData($crawler, $imageSize)); // Merge the image data from multiple URLs
    //                         }
                    
    //                         return view('report.crawlWebsites', compact('submitted', 'imageData', 'websitesArray'));
    //                     } catch (\Exception $e) {
    //                         // Log or display the error message
    //                         $errorMessage = $e->getMessage();
    //                         error_log($errorMessage);
    //                         $imageData = [['error' => 'An error occurred while crawling the websites. Error: ' . $errorMessage]];
    //                     }
    //                 }
                    
            
    //                 return view('report.crawlWebsites', compact('submitted', 'imageData', 'websites'));
    //             }
            
                
    //             private function getImagesData($crawler, $threshold)
    //             {
    //                 $imageData = [];
                
    //                 $crawler->filter('img')->each(function ($node) use (&$imageData, $threshold) {
    //                     $imageSrc = $node->attr('src');
                
    //                     try {
    //                         $imageSize = getimagesize($imageSrc);
                
    //                         if ($imageSize && isset($imageSize[0]) && $imageSize[0] > $threshold) {
    //                             $imageUrl = $imageSrc;
    //                             $imageThumbnail = $this->generateThumbnail($imageSrc, 60, 60);
    //                             $imageData[] = [
    //                                 'url' => $imageUrl,
    //                                 'thumbnail' => $imageThumbnail,
    //                                 'size' => $imageSize[0],
    //                             ];
    //                         }
    //                     } catch (\Exception $e) {
    //                         // Log or display the error message
    //                         $errorMessage = $e->getMessage();
    //                         error_log($errorMessage);
    //                     }
    //                 });
                
    //                 return $imageData;
    //             }
                
    //             private function generateThumbnail($imageUrl, $width, $height)
    //             {
    //                 $thumbnail = Image::make($imageUrl)->fit($width, $height)->encode('data-url');
    //                 $thumbnailTag = '<img src="' . $thumbnail . '" alt="Thumbnail" width="' . $width . '" height="' . $height . '">';
                
    //                 return $thumbnailTag;
    //             }



    public function index()
    {
        return view('report.crawlWebsites');
    }

        public function crawlWebsites(Request $request)
        {
            $domain = $request->input('domain');
            $crawlResult = $this->countImagesForDomain($domain);

            $totalImages = $crawlResult['totalImages'];
            $errors = $crawlResult['errors'];

        return view('report.crawlWebsites', compact('domain', 'totalImages', 'errors'));
        }

   
   
      
            private function countImages($url)
            {
                $client = new Client();
                $crawler = $client->request('GET', $url);
                $imgTags = $crawler->filter('img');
            
                return $imgTags->count();
            }
            
            private function countImagesForDomain($domain)
            {
                $totalImages = 0;
                $urls = [$domain];
                $i = 0;
                $errors = [];
                $maxExecutionTime = 60;
                $endTime = time() + $maxExecutionTime;
            
                while ($i < count($urls) && time() <= $endTime) {
                    $url = $urls[$i];
                    $i++;
            
                    try {
                        $client = new Client();
                        $html = file_get_contents($url); // Get the HTML content of the URL
                        $crawler = new Crawler($html);
                        $linkTags = $crawler->filter('a');
            
                        foreach ($linkTags as $linkTag) {
                            $href = $linkTag->getAttribute('href');
            
                            if (strpos($href, $domain) !== false && !in_array($href, $urls)) {
                                $urls[] = $href;
                            }
                        }
            
                        $totalImages += $this->countImages($url);
            
                    } catch (\Exception $e) {
                        // If an exception occurs, store the error message
                        $errors[] = "Error fetching URL '{$url}': " . $e->getMessage();
                    }
                }
            
                return [
                    'totalImages' => $totalImages,
                    'errors' => $errors,
                ];
            }
            





}