<?php

namespace App\Http\Controllers;
use App\Product;
use App\Price;
use App\Store;
use App\Binding;
use App\User;
use App\Shopping;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Carbon\Carbon;

class ShoppingController extends Controller{

	/**
     * Return a JSON response having all bought products by user.
     *
     * @param int $id
     * @var  Shopping  $items
     * @var  Product  $product
     * @return JSON
     */

	public function show($id)
	{	
		$items = Shopping::where('idUser', '=', $id)->orderBy('created_at', 'desc')->get();
		foreach($items->toArray() as $key => $item)
		{
			$product = Product::find($item['idProduct']);
			$store = Store::find($product->idStore);
			$price = Price::find($product->idPrice);
			unset($items[$key]['idProduct']);
			unset($items[$key]['id']);
			unset($items[$key]['idUser']);
			$items[$key]['ProductName'] = $product->Name;
			$items[$key]['StoreName'] = $store->Name. ", " . $store->Address . ", " . $store->City;
			$items[$key]['NewPrice'] = $price->NewPrice;
		}
		return $this->success($items,200);
	}

}