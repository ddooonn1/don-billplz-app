<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Csv\Reader;

class PizzaController extends Controller
{
    public function index() {
        return view('/pizza');
    }

    public function calculateBill(Request $request) {
        $csvFile = storage_path('app/data/menu.csv');
        $csv = Reader::createFromPath($csvFile, 'r');
        $csv->setHeaderOffset(0);
        $items = $csv->getRecords();

        $totalPrice = 0;
        $orders = $request->input('orders');

        foreach ($orders as $order) {
            foreach ($items as $item) {
                if ($item['Item'] === ucfirst($order['size'])) {
                    $totalPrice += (float)$item['Price'];
                }
                if ($order['pepperoni'] && $item['Item'] === 'Pepperoni' . ucfirst($order['size'])) {
                    $totalPrice += (float)$item['Price'];
                }
                if ($order['extraCheese'] && $item['Item'] === 'ExtraCheese') {
                    $totalPrice += (float)$item['Price'];
                }
            }
        }

        return response()->json(['total' => $totalPrice]);
    }
}
