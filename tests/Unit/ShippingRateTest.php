<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use ShippingRateCalculate;

class ShippingRateTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testUKLowWeightExample()
    {
        $price = 1;
        $orderWeight = 40;
        $countryCode = "UK";
        $calculatedAmount = ShippingRateCalculate::calculateShipping($price, $orderWeight, $countryCode);

        $orderDetails = [
            'price' => $price,
            'weight' => $orderWeight,
            'country_code' => $countryCode,
            'total' => 57.00,
            'shipping_fee' => 56.00,
        ];

        $this->assertEquals($orderDetails,$calculatedAmount);
    }


    public function testUKHeighWeightExample()
    {
        $price = 50;
        $orderWeight = 70;
        $countryCode = "UK";
        $calculatedAmount = ShippingRateCalculate::calculateShipping($price, $orderWeight, $countryCode);

        $orderDetails = [
            'price' => $price,
            'weight' => $orderWeight,
            'country_code' => $countryCode,
            'total' => 50.00,
            'shipping_fee' => 0.00,
        ];

        $this->assertEquals($orderDetails,$calculatedAmount);
    }


    public function testJPPriceInRangeExample()
    {
        $price = 25;
        $orderWeight = 70;
        $countryCode = "JP";
        $calculatedAmount = ShippingRateCalculate::calculateShipping($price, $orderWeight, $countryCode);

        $orderDetails = [
            'price' => $price,
            'weight' => $orderWeight,
            'country_code' => $countryCode,
            'total' => 95.00,
            'shipping_fee' => 70.00,
        ];

        $this->assertEquals($orderDetails,$calculatedAmount);
    }


    public function testJPPriceOutOfRangeExample()
    {
        $price = 50;
        $orderWeight = 70;
        $countryCode = "JP";
        $calculatedAmount = ShippingRateCalculate::calculateShipping($price, $orderWeight, $countryCode);

        $orderDetails = [
            'price' => $price,
            'weight' => $orderWeight,
            'country_code' => $countryCode,
            'total' => 50.00,
            'shipping_fee' => 0.00,
        ];

        $this->assertEquals($orderDetails,$calculatedAmount);
    }


    public function testUSWeightLessExample()
    {
        $price = 50;
        $orderWeight = 55;
        $countryCode = "US";
        $calculatedAmount = ShippingRateCalculate::calculateShipping($price, $orderWeight, $countryCode);

        $orderDetails = [
            'price' => $price,
            'weight' => $orderWeight,
            'country_code' => $countryCode,
            'total' => 76.00,
            'shipping_fee' => 26.00,
        ];

        $this->assertEquals($orderDetails,$calculatedAmount);
    }


    public function testUSWeightMoreExample()
    {
        $price = 99;
        $orderWeight = 70;
        $countryCode = "US";
        $calculatedAmount = ShippingRateCalculate::calculateShipping($price, $orderWeight, $countryCode);

        $orderDetails = [
            'price' => $price,
            'weight' => $orderWeight,
            'country_code' => $countryCode,
            'total' => 125.00,
            'shipping_fee' => 26.00,
        ];

        $this->assertEquals($orderDetails,$calculatedAmount);
    }

    public function testUSOutOfRangeExample()
    {
        $price = 130;
        $orderWeight = 70;
        $countryCode = "US";
        $calculatedAmount = ShippingRateCalculate::calculateShipping($price, $orderWeight, $countryCode);

        $orderDetails = [
            'price' => $price,
            'weight' => $orderWeight,
            'country_code' => $countryCode,
            'total' => 130.00,
            'shipping_fee' => 00.00,
        ];

        $this->assertEquals($orderDetails,$calculatedAmount);
    }
}
