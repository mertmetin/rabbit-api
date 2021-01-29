<?php

namespace App\Http\Controllers\Address;

use App\User;
use App\AddressType;
use App\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    protected function get(User $user): Response
    {
        $userAddresses = UserAddress::
            with('address_type')->where('user_id', $user->id)->get();

        $userAddress = $userAddresses->last();

        if ($userAddress)
            $this->authorize('view', $userAddress);

        return new Response($userAddresses);
    }

    protected function store(Request $request, User $user): Response
    {   
        if ($request->user()->cannot('create', UserAddress::class))
            abort(403);

        $data = $request->validate([
            'address' => 'required'
        ]);

        $address = $data['address'];
        // $placeId = $address['place_id'];

        // $userAddress = UserAddress::where('user_id', $user->id)
        //         ->where('place_id', $placeId)
        //         ->get()->last();

        // if ($userAddress)
        //     throw new \Exception('This address is already added.');
        
        $type = AddressType::where('type', 
            $address['address_type'])->get()->last();

        $address['user_id'] = $user->id;
        $address['address_type'] = $type->id;
        $result = UserAddress::create($address);

        return new Response($result->id, 201);
    }

    protected function edit(Request $request)
    {   
        if (!$request->filled('userId', 'address'))
            throw new \Exception('Invalid request.');

        $userId = $request->input('userId');
        $address = $request->input('address');

        $dbUser = UserAddress::where('user_id', $userId)
            ->where('place_id', $address['place_id'])->first();
        $address['user_id'] = $userId;

        return $dbUser->update($address);
    }

    protected function destroy(Request $request, User $user, $addressId)
    {
        // error_log(json_encode($addressId));
        // $data = $request->validate([
        //     'address_id' => 'required'
        // ]);

        // $addressId = $data['address_id'];
        $userAddress = UserAddress::where(['id' => $addressId, 
            'user_id' => $user->id])
                ->get()->last();

        if (!$userAddress)
            throw new \Exception('This address is already deleted');

        if ($request->user()->cannot('delete', $userAddress))
            abort(403);

        $userAddress = UserAddress::find($addressId);
        $userAddress->delete();

        return new Response(null, 204); 
    }
}
