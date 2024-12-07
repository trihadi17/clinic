<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Requests\PatientRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PatientController extends Controller
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
            
            // Query Awal (Inisialisasi data tanpa Mengambil langsung data dari database/ belum di eksekusi)
            $patient = Patient::query();

            // Search
            if ($search) {

                // MANUAL MENDAFTARKAN KOLOM (SATU PERSATU)
                // $patient->where(function($query) use ($search){
                //     $query->orWhere('national_id', 'like', '%' . $search . '%' )
                //     ->orWhere('name', 'like', '%' . $search . '%' )
                //     ->orWhere('gender', 'like', '%' . $search . '%' )
                //     ;
                // });

                // Ambil semua kolom dari tabel
                $columns = Schema::getColumnListing('patients');

                $patient->where(function($query) use ($columns, $search){
                    foreach($columns as $column){
                        $query->orWhere($column, 'like', '%' . $search . '%');
                    }
                });
            }

            // Data
            $data = $patient->paginate($request->limit);
        
            return response([
                'success' => true,
                'message' => 'Patient data',
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
    public function store(PatientRequest $request)
    {
        try {
            DB::beginTransaction();

            // credentials 
            $credentials = [
                'national_id' => $request->national_id,
                'name' => $request->name,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
            ];

            // create to database
            Patient::create($credentials);

            DB::commit();

            return response([
                'success' => true,
                'message' => 'Patient data has been successfully added'
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

            $patient = Patient::find($id);

            // Cek
            if(!$patient){
                return response([
                    'success' => true,
                    'message' => 'Patient data not found'
                ], 404);
            }

            return response([
                'success' => true,
                'message' => 'Patient data by id',
                'data' => $patient
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
    public function edit(Patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $patient = Patient::find($id);

            // Cek
            if(!$patient){
                return response([
                    'success' => true,
                    'message' => 'Patient data not found'
                ], 404);
            }

            // credentials 
            $credentials = [
                'national_id' => $request->national_id,
                'name' => $request->name,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
            ];

            // update to database
            $patient->update($credentials);

            DB::commit();

            return response([
                'success' => true,
                'message' => 'Patient data has been successfully changed'
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

            $patient = Patient::find($id);

            // Cek
            if(!$patient){
                return response([
                    'success' => true,
                    'message' => 'Patient data not found'
                ], 404);
            }

            // delete to database
            $patient->delete();

            DB::commit();

            return response([
                'success' => true,
                'message' => 'Patient data has been successfully deleted'
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
