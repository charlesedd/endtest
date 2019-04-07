<?php

namespace App\Helpers\ShippingRate;

use Illuminate\Support\Facades\DB;
use App\ShippingRate;
use ShippingRateCalculate;

/**
 * Class Calculate
 * @package App\Helpers\ShippingRate
 */
class Calculate {


    /**
     * @param $price
     * @param $orderWeight
     * @param $countryCode
     * @return array|string
     * Calculates the shipping and returns the order amounts including this
     */
    public static function calculateShipping($price, $orderWeight, $countryCode){

        //- if country_code = "JP", apply shipping fee only if price is from_value > price <= to_value, weight is ignored.
        //- if country_code = "UK", apply shipping fee only if provided order weight < ShippingRate weight, price is ignored.
        //- if any other country_code, apply shipping fee if from_value > price <= to_value or provided order weight < ShippingRate weight.
        //- Raise an exception if the specified country_code doesn't have any ShippingRate. For example country_code = "PL" doesn't have any shipping rates but "FR" or "UK" do have at least one.

        try {
            $rate = ShippingRate::where('country_code', $countryCode) ->get();
            if( $rate->count() === 0){
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'The given data was invalid.' => ['no rate for this country code'],
                ]);
                throw $error;
            }

        }
        catch (\Exception $e){
            return $e->getMessage();
        }
        $orderDetails = ShippingRateCalculate::calculateShippingRate($price, $orderWeight, $countryCode, $rate);

        return $orderDetails;

    }

    /**
     * @param $price
     * @param $orderWeight
     * @param $countryCode
     * @param $rate
     * @return array
     */
    public static function calculateShippingRate($price, $orderWeight, $countryCode, $rate){

        //- if country_code = "JP", apply shipping fee only if price is from_value > price <= to_value, weight is ignored.
        //- if country_code = "UK", apply shipping fee only if provided order weight < ShippingRate weight, price is ignored.
        //- if any other country_code, apply shipping fee if from_value > price <= to_value or provided order weight < ShippingRate weight.

        $calculatedFeeBasedOnPrice = 0;
        $calculatedFeeBasedOnWeight = 0;
        if ($countryCode === 'UK') {
            $calculatedFeeBasedOnWeight = ShippingRateCalculate::calculateShippingRateOnWeight($orderWeight,$rate);
        } elseif ($countryCode === 'JP') {
            $calculatedFeeBasedOnPrice = ShippingRateCalculate::calculateShippingRateOnPrice($price,$rate);
        }else{
            $calculatedFeeBasedOnPrice = ShippingRateCalculate::calculateShippingRateOnPrice($price,$rate);
            $calculatedFeeBasedOnWeight = ShippingRateCalculate::calculateShippingRateOnWeight($orderWeight,$rate);
        }

        $calculatedFee = max($calculatedFeeBasedOnWeight,$calculatedFeeBasedOnPrice);

        $orderDetails = [
            'price' => $price,
            'weight' => $orderWeight,
            'country_code' => $countryCode,
            'total' => $price + $calculatedFee,
            'shipping_fee' => $calculatedFee,
        ];

        return $orderDetails;

    }


    /**
     * @param $price
     * @param $rate
     * @return int
     * Calculates the shipping based on the prise rules
     */
    public static function calculateShippingRateOnPrice($price, $rate){
        $calculatedFeeBasedOnPrice = 0;
        $from = $rate[0]['from_value'];
        $to = $rate[0]['to_value'];
        $shippingFee = $rate[0]['shipping_fee'];
        if ($price > $from && $price < $to) {
            $calculatedFeeBasedOnPrice = $shippingFee;
        }
        return $calculatedFeeBasedOnPrice;

    }


    /**
     * @param $orderWeight
     * @param $rate
     * @return int
     * Calculates the shipping based on the weight rules
     */
    public static function calculateShippingRateOnWeight($orderWeight, $rate){
        $calculatedFeeBasedOnWeight = 0;
        $shippingFee = $rate[0]['shipping_fee'];
        $shippingWeight = $rate[0]['weight'];

        if($orderWeight < $shippingWeight) {
            $calculatedFeeBasedOnWeight = $shippingFee;
        }
        return $calculatedFeeBasedOnWeight;

    }
}