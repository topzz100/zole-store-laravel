<?php

namespace App\Http\Controllers;

use App\Http\Requests\Address\StoreAddressRequest;
use App\Http\Requests\Address\UpdateAddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AddressController extends Controller
{
    //
    public function index(Request $request)
    {
        $addresses  = $request->user()->addresses()->latest()->get();

        return AddressResource::collection($addresses)->response();
    }


    public function show(Address $address)
    {
        // Eager load variants to include them in the response
        // $product->load('variants');
        return (new AddressResource($address))->response();
    }

    public function store(StoreAddressRequest $request)
    {
        $validatedData = $request->validated();
        try {
            $user = $request->user();

            // If this is the user's first address, make it default
            if ($user->addresses()->count() === 0) {
                $validatedData['is_default'] = true;
            } elseif (!isset($validatedData['is_default'])) {
                // If not first address and is_default not provided, default to false
                $validatedData['is_default'] = false;
            }

            // If setting this address as default, set all others to false
            if (isset($validatedData['is_default']) && $validatedData['is_default'] === true) {
                $user->addresses()->update(['is_default' => false]);
            }

            $address = $user->addresses()->create($validatedData);
            return response()->json([
                'message' => 'Address created successfully.',
                'data' => new AddressResource($address)
            ], 200);
        } catch (\Exception $e) {

            Log::error('Address creation failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to create address due to an internal error.',
            ], 500);
        }
    }

    public function update(UpdateAddressRequest $request, Address $address)
    {
        $validatedData = $request->validated();

        try {
            // If setting this address as default, set all other addresses to false
            if (isset($validatedData['is_default']) && $validatedData['is_default'] === true) {
                $address->user->addresses()
                    ->where('id', '!=', $address->id)
                    ->update(['is_default' => false]);
            }

            $address->update($validatedData);
            return response()->json([
                'message' => 'Address updated successfully',
                'data' => new AddressResource($address->fresh())
            ], 200);
        } catch (\Exception $e) {
            Log::error('Address update failed: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to update address.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Address $address)
    {
        try {

            $address->delete();

            return response()->json([
                'message' => 'Address deleted successfully'
            ], 200);
        } catch (\Exception $e) {

            Log::error("Product deletion failed: " . $e->getMessage());

            return response()->json([
                'message' => 'Failed to delete address due to an internal server error.'
            ], 500);
        }
    }
}
