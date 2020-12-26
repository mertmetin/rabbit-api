<?php

namespace Database\Factories;

use App\UserAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserAddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => '8050 Heritage Road, Brampton, ON, Canada', 
            'main_text' => '8050 Heritage Road', 
            'secondary_text' => 'Brampton, ON, Canada', 
            'apt_suite_floor' => 3, 
            'business_or_building_name' => '', 
            'address_type' => 'home', 
            'place_id' => 'ChIJNS1qayJrK4gR3p5kAlXotSE',
            'lng' => '-79.790572',
            'lat' => '43.620396',
            'address_type' => 'home',
            'postal_code' => 'K1S5J6'
        ];
    }
}
