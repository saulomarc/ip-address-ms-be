<?php

namespace App\Services;

use App\Models\IpAddress;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class IpAddressService implements GenericService
{
    function fetchData(Request $request) {
        $ip_addresses = IpAddress::filter($request);

        if ($request->has('items')) {
            $ip_addresses = $ip_addresses->paginate($request->items);
        } else {
            $ip_addresses = $ip_addresses->get();
        }
        
        return response()->json(
            [
             'ip_addresses' => $ip_addresses,
            ], 200
        );
    }

    function addData(Request $request)
    {
        DB::beginTransaction();

        try {

            IpAddress::create([
                'ip_address' => $request->ip_address,
                'label' => $request->label,
                'comment' => $request->comment,
                'user_id' => JWTAuth::user()->id,
            ]);

            DB::commit();

            return response()->json(
                [
                    'message' => 'IP Address Successfully Added',
                    'status' => 'Ok'
                ],
                200
            );
        } catch (Exception $ex) {
            DB::rollBack();

            return response()->json(
                [
                    'message' => $ex->getMessage()
                ],
                500
            );
        }
    }

    function fetchOneResouce(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $ip_address = IpAddress::where('id', $id)->first();

            DB::commit();

            return response()->json(
                [
                    'ip_address' => $ip_address,
                    'status' => 'Ok'
                ],
                200
            );

        } catch (Exception $ex) {
            DB::rollBack();

            return response()->json(
                [
                    'message' => $ex->getMessage()
                ],
                500
            );            
        }
    }

    function editData(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $ip_address = IpAddress::find($id);

            $ip_address->label = $request->label;
            
            $ip_address->save();

            DB::commit();

            return response()->json(
                [
                    'message' => 'IP Address Successfully Edited',
                    'status' => 'Ok'
                ],
                200
            );
        } catch (Exception $ex) {
            DB::rollBack();

            return response()->json(
                [
                    'message' => $ex->getMessage()
                ],
                500
            );
        }
    }

    function deleteData(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $ip_address = IpAddress::destroy($id);

            DB::commit();

            return response()->json(
                [
                    'message' => 'IP Address Successfully Deleted',
                    'status' => 'Ok'
                ],
                200
            );

        } catch (Exception $ex) {
            DB::rollBack();

            return response()->json(
                [
                    'message' => $ex->getMessage()
                ],
                500
            );            
        }
    }
}
