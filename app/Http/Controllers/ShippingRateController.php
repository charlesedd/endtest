<?php

namespace App\Http\Controllers;

use App\ShippingRate;
use Illuminate\Http\Request;
use ShippingRateCalculate;

class ShippingRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $shippingRate = new ShippingRate;

        $shippingRate->name = $request->input('name');
        $shippingRate->country_code  = $request->input('country_code');
        $shippingRate->from_value  = $request->input('from_value');
        $shippingRate->to_value  = $request->input('to_value');
        $shippingRate->weight  = $request->input('weight');
        $shippingRate->shipping_fee   = $request->input('shipping_fee');

        $shippingRate->save();
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ShippingRate  $shippingRate
     * @return \Illuminate\Http\Response
     */
    public function show(ShippingRate $shippingRate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ShippingRate  $shippingRate
     * @return \Illuminate\Http\Response
     */
    public function edit(ShippingRate $shippingRate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ShippingRate  $shippingRate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShippingRate $shippingRate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ShippingRate  $shippingRate
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShippingRate $shippingRate)
    {
        //
    }

    public function calculate(Request $request)
    {
        $countryCode = $request->input('country_code');
        $price = $request->input('price');
        $orderWeight = $request->input('weight');


        $calculatedAmount = ShippingRateCalculate::calculateShipping($price, $orderWeight, $countryCode);
        return $calculatedAmount;
    }
}
