<?php

namespace App\Http\Controllers\Address;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\UserAddress;
use App\AddressType;
use App\User;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    protected function get(User $user)
    {
        $userAddresses = UserAddress::
            with('address_type')->where('user_id', $user->id)->get();

        return $userAddresses;
    }

    protected function add(Request $request, User $user): Response
    {   
        if (!$request->filled('address'))
            throw new \Exception('Invalid request.');

        $address = $request->input('address');
        $placeId = $address['place_id'];

        $userAddress = UserAddress::where('user_id', $user->id)
                ->where('place_id', $placeId)
                ->get()->last();

        if ($userAddress)
            throw new \Exception('This address is already added.');
        
        $type = AddressType::where('type', $address['address_type'])->get()->last();

        $result = UserAddress::create([
            'user_id' => $user->id,
            'place_id' => $placeId,
            'description' => $address['description'],
            'main_text' => $address['main_text'],
            'secondary_text' => $address['secondary_text'],
            'apt_suite_floor' => $address['apt_suite_floor'],
            'business_or_building_name' => $address['business_or_building_name'],
            'address_type' => $type->id,
            'lng' => $address['lng'],
            'lat' => $address['lat']
        ]);

        return new Response([], 201);
    }

    protected function edit(Request $request)
    {   
        if (!$request->filled('userId', 'address'))
            throw new \Exception('Invalid request.');

        $userId = $request->input('userId');
        $address = $request->input('address');

        $dbUser = UserAddress::where('user_id', $userId)->where('place_id', $address['place_id'])->first();
        $address['user_id'] = $userId;

        return $dbUser->update($address);
    }

    protected function delete(Request $request, User $user)
    {
        $addressId = $request->input('addressId');

        if (!$addressId)
            throw new \Exception('Invalid request.');

        $userAddress = UserAddress::where('user_id', $user->id)
                ->where('id', $addressId)
                ->get()->last();

        if (!$userAddress)
            throw new \Exception('This address is already deleted');

        $userAddress = UserAddress::find($addressId);
        $userAddress->delete();

        return new Response([], 204); 
    }
}
