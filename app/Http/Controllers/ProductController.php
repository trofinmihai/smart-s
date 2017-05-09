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
     * Insert new product into database. 
     *
     * @param Request $request
     * @var string $ProductName
     * @var int $Type
     * @var string $StoreName
     * @var string $Address
     * @var string $City
     * @var float $Price
     * @var Store $store
     * @var Price $price
     * @var Shopping $shopping
     * @var Binding $binding
     * @var Product $product
     * @return JSON
     */

	public function insert(Request $request)
	{	
		$ProductName = strtolower($request->get('ProductName'));
		$Type = $request->get('Type');
		$StoreName = $request->get('StoreName');
		$Address = $request->get('Address');
		$City = $request->get('City');
		$Price = $request->get('Price');

		$idStore = $this->idStore($request);
		$idProduct = $this->idProduct($request, $idStore);

		if($idStore == 0)
		{
			$store = Store::create([
					'Name' => $StoreName,
					'Address' => $Address,
					'City' => $City
			]);
			$idStore = $store->id;
		}

		if($idProduct == 0)
		{
			$price = Price::create([
					'OldPrice' => $Price,
					'OldPriceDate' => Carbon::now(),
					'NewPrice' => $Price,
					'NewPriceDate' => Carbon::now()
			]);

			$product = Product::create([
					'Name' => $ProductName,
					'Type' => $Type,
					'idStore' => $idStore,
					'idPrice' => $price->id
			]);

			$idProduct = $product->id;

		}
		else
		{
			$product = Product::find($idProduct);
			$price = Price::find($product->idPrice);
			$this->updatePrice($price, $request);
		}

		$shopping = Shopping::create([
					'idUser' => $request->get('idUser'),
					'idProduct' => $idProduct,
					'Price'=> $Price
				]);

		$binding = Binding::create([
					'idUser' => $request->get('idUser'),
					'idProduct' => $product->id
			]);

		return $this->success("The product was inserted!", 201);
	}

	/**
     * Update price.
     *
     * @param Price $price
     * @return 
     */

	public function updatePrice($price, $request)
	{	

		if($price->NewPrice != $request->get('Price'))
		{
			$price->OldPrice = $price->NewPrice;
			$price->OldPriceDate = $price->NewPriceDate;
		}

		$price->NewPrice = $request->get('Price');
		$price->NewPriceDate = Carbon::now();

		$price->save();
	}

	/**
     * Return the id of specified ProductName
     *
     * @param Request $request, $idStore
     * @var string $ProductName
     * @var int $Type
     * @var Product $product
     * @return int 
     */

	public function idProduct(Request $request, $idStore)
	{	

		$ProductName = $request->get('ProductName');
		$Type = $request->get('Type');

		$product = Product::where('Name', '=', $ProductName)->where('Type', '=', $Type)->where('idStore', '=', $idStore)->first();

		if(isset($product))
			return $product->id;
		return 0;
	}

	/**
     * Return the id of specified StoreName
     *
     * @param Request $request
     * @var string $StoreName
     * @var string $Address
     * @var string $City
     * @var Store $store
     * @return int 
     */

	public function idStore(Request $request)
	{	

		$StoreName = $request->get('StoreName');
		$Address = $request->get('Address');
		$City = $request->get('City');

		$store = Store::where('Name', '=', $StoreName)->where('Address', '=', $Address)->where('City', '=', $City)->first();

		if(isset($store))
			return $store->id;
		return 0;
	}

	/**
     * Update price of product in database only if the product, bought from a specified store, already exists
     *
     * @param Request $request
     * @var string $ProductName
     * @var int $idUser
     * @var string $StoreName
     * @var Product $product
     * @var Binding $bindings
     * @var int $key
     * @var object $binding
     * @var int $ProidStore
     * @var Price $price
     * @var Shopping $shopping
     * @return JSON
     */

	public function checkProduct(Request $request)
	{	
		$ProductName = strtolower($request->get('ProductName'));
		$idUser = $request->get('idUser');
		$StoreName = $request->get('StoreName');

		$product = Product::where('Name', '=' , $ProductName)->get();
		
		foreach($product as $item)
		{
			$bindings = Binding::where('idProduct', '=', $item["id"])->get();

			foreach($bindings as $key => $binding)
			{	
				$idStore = $this->idStore($request);
				// var_dump($binding->idProduct == $item->id, $binding->idUser == $idUser, $item->idStore, $idStore);exit;
				if($binding->idProduct == $item->id && $binding->idUser == $idUser && $item->idStore == $idStore)
				{
					// update price
					$price = Price::find($item->idPrice);
					$this->updatePrice($price, $request);

					$shopping = Shopping::create([
						'idUser' => $idUser,
						'idProduct' => $item->id,
						'Price'=> $request->get('Price')
					]);

					return $this->success("The product was updated!", 201);		
				}
			}
			
		}		
		$this->insert($request);
		return $this->success("The product was inserted!", 201);
		
	}
}
