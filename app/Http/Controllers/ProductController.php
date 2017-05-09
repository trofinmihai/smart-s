<?php

namespace App\Http\Controllers;
use App\Product;
use App\Price;
use App\Store;
use App\Bindings;
use App\User;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Carbon\Carbon;

class ProductController extends Controller{

	/**
     * Return a JSON response having all products.
     *
     * @var  JSON  $products
     * @return JSON
     */

	public function show()
	{	
		$products = Product::all();
		return $this->success($products, 200);
	}

	/**
     * 
     * @param Request $request
     * @var  
     * @return 
     */

	public function insert(Request $request)
	{	
		$ProductName = $request->get('ProductName');
		$Type = $request->get('Type');
		$StoreName = $request->get('StoreName');
		$Address = $request->get('Address');
		$City = $request->get('City');
		$Price = $request->get('Price');


		$store = Store::create([
					'Name' => $StoreName,
					'Address' => $Address,
					'City' => $City
			]);

		$price = Price::create([
					'OldPrice' => $Price,
					'OldPriceDate' => Carbon::now(),
					'NewPrice' => $Price,
					'NewPriceDate' => Carbon::now()
			]);

		$product = Product::create([
					'Name' => $ProductName,
					'Type' => $Type,
					'idStore' => $store->id,
					'idPrice' => $price->id
			]);

		

		

		return $this->success("The product was inserted!", 201);
	}
}
