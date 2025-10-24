<?php

use App\Models\Income;
use App\Models\Order;
use App\Models\Sale;
use App\Models\Stock;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Queue\Queue;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/**
 * Скрипт для запуска очередей
 */
Route::get('/job', function (
    Queue $queue,
    Dispatcher $dispatcher,
) {
    $pageCount = 221;

    for ($i = 1; $i <= $pageCount; $i++) {

        $job = new \App\Jobs\GetJson($i);
        echo 'Sales. Задача №'.$i;
        echo '<br>';

        dispatch($job);

    }

    return new \Illuminate\Http\Response('Задачи отправлены');

});

/**
 * Скрипт для скачивания по одному json-файлу
 */
Route::get('/json/{id}', function ($id,
    Queue $queue,
    Dispatcher $dispatcher,
) {
    $url = env('API_ELM_BASE_NAME').'orders?dateFrom=1970-10-23&dateTo=2035-10-23&limit=500&page='.
        $id.'&key='.env('API_ELM_BASE_KEY');

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

        file_put_contents('json/order/'.$id.'.json', $response, FILE_APPEND);
        echo 'Write page '.$id;
    }
});

Route::get('/stock', function () {
    $isFile = true;
    $i = 0;
    do {
        $i++;
        if (file_exists('json/stock/'.$i.'.json')) {
            $file = file_get_contents('json/stock/'.$i.'.json');
            $data = json_decode($file)->data;

            foreach ($data as $item) {

                Stock::create([
                    'date' => $item->date,
                    'last_change_date' => $item->last_change_date,
                    'supplier_article' => $item->supplier_article,
                    'tech_size' => $item->tech_size,
                    'barcode' => $item->barcode,
                    'quantity' => $item->quantity,
                    'is_supply' => $item->is_supply,
                    'is_realization' => $item->is_realization,
                    'quantity_full' => $item->quantity_full,
                    'warehouse_name' => $item->warehouse_name,
                    'in_way_to_client' => $item->in_way_to_client,
                    'in_way_from_client' => $item->in_way_from_client,
                    'nm_id' => $item->nm_id,
                    'subject' => $item->subject,
                    'category' => $item->category,
                    'brand' => $item->brand,
                    'sc_code' => $item->sc_code,
                    'price' => $item->price,
                    'discount' => $item->discount,
                ]);
            }
            echo 'Обработан файл '.'json/stock/'.$i.'.json';
            echo '<br>';
        } else {
            $isFile = false;
        }
    } while ($isFile);

});

Route::get('/income', function () {
    $isFile = true;
    $i = 0;
    do {
        $i++;
        if (file_exists('json/income/'.$i.'.json')) {
            $file = file_get_contents('json/income/'.$i.'.json');
            $data = json_decode($file)->data;

            foreach ($data as $item) {

                Income::create([
                    'income_id' => $item->income_id,
                    'number' => $item->number,
                    'date' => $item->date,
                    'last_change_date' => $item->last_change_date,
                    'supplier_article' => $item->supplier_article,
                    'tech_size' => $item->tech_size,
                    'barcode' => $item->barcode,
                    'quantity' => $item->quantity,
                    'total_price' => $item->total_price,
                    'date_close' => $item->date_close,
                    'warehouse_name' => $item->warehouse_name,
                    'nm_id' => $item->nm_id,
                ]);
            }
            echo 'Обработан файл '.'json/income/'.$i.'.json';
            echo '<br>';
        } else {
            $isFile = false;
        }
    } while ($isFile);

});

Route::get('/sale', function () {
    $isFile = true;
    $i = 0;
    do {
        $i++;
        if (file_exists('json/sale/'.$i.'.json')) {
            $file = file_get_contents('json/sale/'.$i.'.json');
            if (is_null(json_decode($file)) || is_null(json_decode($file)->data)) {
                continue;
            }

            $data = json_decode($file)->data;

            foreach ($data as $item) {
                // var_dump($item);
                // exit();
                Sale::create([
                    'g_number' => $item->g_number,
                    'date' => $item->date,
                    'last_change_date' => $item->last_change_date,
                    'supplier_article' => $item->supplier_article,
                    'tech_size' => $item->tech_size,
                    'barcode' => $item->barcode,
                    'total_price' => $item->total_price,
                    'discount_percent' => $item->discount_percent,
                    'is_supply' => $item->is_supply,
                    'is_realization' => $item->is_realization,
                    'promo_code_discount' => $item->promo_code_discount,
                    'warehouse_name' => $item->warehouse_name,
                    'country_name' => $item->country_name,
                    'oblast_okrug_name' => $item->oblast_okrug_name,
                    'region_name' => $item->region_name,
                    'income_id' => $item->income_id,
                    'sale_id' => $item->sale_id,
                    'odid' => $item->odid,
                    'spp' => $item->spp,
                    'for_pay' => $item->for_pay,
                    'finished_price' => $item->finished_price,
                    'price_with_disc' => $item->price_with_disc,
                    'nm_id' => $item->nm_id,
                    'subject' => $item->subject,
                    'category' => $item->category,
                    'brand' => $item->brand,
                    'is_storno' => $item->is_storno,
                ]);
            }
            echo 'Обработан файл '.'json/sale/'.$i.'.json';
            echo '<br>';
        } else {
            $isFile = false;
        }
    } while ($isFile && $i < 50);

});

Route::get('/order', function () {
    $isFile = true;
    $i = 0;
    do {
        $i++;
        if (file_exists('json/order/'.$i.'.json')) {
            $file = file_get_contents('json/order/'.$i.'.json');
            if (is_null(json_decode($file)) || is_null(json_decode($file)->data)) {
                continue;
            }

            $data = json_decode($file)->data;

            foreach ($data as $item) {
                // var_dump($item);
                // exit();
                Order::create([
                    'g_number' => $item->g_number,
                    'date' => $item->date,
                    'last_change_date' => $item->last_change_date,
                    'supplier_article' => $item->supplier_article,
                    'tech_size' => $item->tech_size,
                    'barcode' => $item->barcode,
                    'total_price' => $item->total_price,
                    'discount_percent' => $item->discount_percent,
                    'warehouse_name' => $item->warehouse_name,
                    'oblast' => $item->oblast,
                    'income_id' => $item->income_id,
                    'odid' => $item->odid,
                    'nm_id' => $item->nm_id,
                    'subject' => $item->subject,
                    'category' => $item->category,
                    'brand' => $item->brand,
                    'is_cancel' => $item->is_cancel,
                    'cancel_dt' => $item->cancel_dt,
                ]);
            }
            echo 'Обработан файл '.'json/order/'.$i.'.json';
            echo '<br>';
        } else {
            $isFile = false;
        }
    } while ($isFile && $i < 5);

});
