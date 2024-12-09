<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorRequest;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Validasi Input
            $request->validate([
                'search' => 'nullable|string|max:255',
                'limit' => 'nullable|numeric'
            ]);

            // Input Search
            $search = $request->search;

            // Inisialisasi
            $doctor = Doctor::with('specialty');

            // Search
            if($search){
                $doctor->where(function($query) use ($search){
                    $query->where('practice_license', 'like', '%' . $search . '%' )
                    ->orWhere('name', 'like', '%' . $search . '%' )
                    ->orWhere('phone_number', 'like', '%' . $search . '%' )
                    ->orWhere('address', 'like', '%' . $search . '%' )
                    ->orWhereHas('specialty',function($query) use ($search){
                        $query->where('specialty_name', 'like', '%' . $search . '%');
                    });
                });
            }

            // Data
            $data = $doctor->paginate($request->limit);

            return response([
                'success' => true,
                'message' => 'Doctor data',
                'data' => $data,
            ],200);

        } catch (\Throwable $e) {
            return response([
                'status' => false,
                'message' => 'An error occurred, please try again.' . $e
            ],500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DoctorRequest $request)
    {
        try {
            DB::beginTransaction();

            // credentials 
            $credentials = [
                'practice_license' => $request->practice_license,
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'specialty_id' => $request->specialty_id,
            ];

            // create to database
            Doctor::create($credentials);

            DB::commit();

            return response([
                'success' => true,
                'message' => 'Doctor data has been successfully added'
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response([
                'status' => false,
                'message' => 'An error occurred, please try again.' . $e
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {

            $doctor = Doctor::with('specialty')->find($id);

            // Cek
            if(!$doctor){
                return response([
                    'success' => true,
                    'message' => 'Doctor data not found'
                ], 404);
            }

            return response([
                'success' => true,
                'message' => 'Doctor data by id',
                'data' => $doctor
            ], 200);

        } catch (\Throwable $e) {
            return response([
                'status' => false,
                'message' => 'An error occurred, please try again.' . $e
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DoctorRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $doctor = Doctor::find($id);

            // Cek
            if(!$doctor){
                return response([
                    'success' => true,
                    'message' => 'Doctor data not found'
                ], 404);
            }

            // credentials 
            $credentials = [
                'practice_license' => $request->practice_license,
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'specialty_id' => $request->specialty_id,
            ];

            // update to database
            $doctor->update($credentials);

            DB::commit();

            return response([
                'success' => true,
                'message' => 'Doctor data has been successfully changed'
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response([
                'status' => false,
                'message' => 'An error occurred, please try again.' . $e
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $doctor = Doctor::find($id);

            // Cek
            if(!$doctor){
                return response([
                    'success' => true,
                    'message' => 'Doctor data not found'
                ], 404);
            }

            // delete to database
            $doctor->delete();

            DB::commit();

            return response([
                'success' => true,
                'message' => 'Doctor data has been successfully deleted'
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response([
                'status' => false,
                'message' => 'An error occurred, please try again.' . $e
            ], 500);
        }
    }
}
