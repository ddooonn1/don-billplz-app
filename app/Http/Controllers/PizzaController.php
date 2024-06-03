<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Csv\Reader;


class PizzaController extends Controller
{

    public function index() {
        return view('pizza');
    }

    public function calculateBill(Request $request) {
        $csvFile = storage_path('app/data/menu.csv');
        $csv = Reader::createFromPath($csvFile, 'r');
        $csv->setHeaderOffset(0);
        $items = $csv->getRecords();

        $totalPrice = 0;

        $size = $request->input('size');
        $includePepperoni = $request->input('pepperoni');
        $includeExtraCheese = $request->input('extra_cheese');

        foreach($items as $item) {
            if ($item['Item'] === ucfirst($size)){
                $totalPrice += (float) $item['Price'];
            }
        if ($includePepperoni && $item['Item'] === 'Pepperoni'.ucfirst($size)) {
                $totalPrice += (float) $item['Price'];
            }
            if($includeExtraCheese && $item['Item'] === 'ExtraCheese'){
                $totalPrice += (float) $item['Price'];
            }
        }

        return view('pizza', ['total_price' => $totalPrice]);
    }
}
