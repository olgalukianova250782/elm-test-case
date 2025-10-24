<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

/**
 * С помощью этого класса скачиваем все данные, выставляя нужные энжпойнты.
 */
class GetJson implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private int $pageNumber)
    {
        $this->pageNumber = $pageNumber;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $url = env('API_ELM_BASE_NAME').'sales?dateFrom=1970-10-23&dateTo=2035-10-23&limit=500&page='.
                $this->pageNumber.'&key='.env('API_ELM_BASE_KEY');

        $options = [
            CURLOPT_RETURNTRANSFER => true,   // return web page
            CURLOPT_HEADER => false,  // don't return headers
            CURLOPT_FOLLOWLOCATION => true,   // follow redirects
            CURLOPT_ENCODING => '',     // handle compressed
            CURLOPT_USERAGENT => 'test', // name of client
            CURLOPT_AUTOREFERER => true,   // set referrer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
            CURLOPT_TIMEOUT => 120,    // time-out on response
        ];

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response) {

            file_put_contents('json/sale/'.$this->pageNumber.'.json', $response, FILE_APPEND);

        }
    }
}
