<?php

namespace App\Http\Controllers;

use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\SpecialtyRequest;

class SpecialtyController extends Controller
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

            // Inisialisasi data
            $specialty = Specialty::query();

            //  Search
            if ($search) {
                // Ambil semua kolom dari tabel specialty
                $columns = Schema::getColumnListing('specialties');

                $specialty->where(function ($query) use ($columns, $search){
                    foreach($columns as $column){
                        $query->orWhere($column, 'like', '%' . $search . '%');
                    }
                });
            }

            // Data
            $data = $specialty->paginate($request->limit);

            return response([
                'success' => true,
                'message' => 'Specialty data',
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
    public function store(SpecialtyRequest $request)
    {
        try {
            DB::beginTransaction();

            // credentials
            $credentials = [
                'specialty_name' => $request->specialty_name
            ];

            // create
            Specialty::create($credentials);


            DB::commit();

            return response([
                'success' => true,
                'message' => 'Specialty data has been successfully added'
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

            $specialty = Specialty::find($id);

            // Cek
            if(!$specialty){
                return response([
                    'success' => true,
                    'message' => 'Specialty data not found'
                ], 404);
            }

            return response([
                'success' => true,
                'message' => 'Specialty data by id',
                'data' => $specialty
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
    public function edit(Specialty $specialty)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SpecialtyRequest $request, $id)
    {
         try {
            DB::beginTransaction();

            $specialty = Specialty::find($id);

            // Cek
            if(!$specialty){
                return response([
                    'success' => true,
                    'message' => 'Specialty data not found'
                ], 404);
            }

            // credentials 
            $credentials = [
                'specialty_name' => $request->specialty_name,
            ];

            // update to database
            $specialty->update($credentials);

            DB::commit();

            return response([
                'success' => true,
                'message' => 'Specialty data has been successfully changed'
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

            $specialty = Specialty::find($id);

            // Cek
            if(!$specialty){
                return response([
                    'success' => true,
                    'message' => 'Specialty data not found'
                ], 404);
            }

            // delete to database
            $specialty->delete();

            DB::commit();

            return response([
                'success' => true,
                'message' => 'Specialty data has been successfully deleted'
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
