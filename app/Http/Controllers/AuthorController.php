<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthorController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::all();
        $data = AuthorResource::collection($authors);
        return $this->customeRespone($data, 'Done!', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AuthorRequest $request)
    {
        try {
            DB::beginTransaction();

            $author = Author::create([
                'name' => $request->name,
                'bio' => $request->bio,
            ]);
            DB::commit();
            return $this->customeRespone(new AuthorResource($author), 'Author created successfully', 201);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Failed to create Author', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        $data = new AuthorResource($author);
        return $this->customeResponse($data, 'Done!', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AuthorRequest $request, Author $author)
    {
        try {
            DB::beginTransaction();
            $author->update([
                'name' => $request->name,
                'bio' => $request->bio,
            ]);
            DB::commit();

            return $this->customeRespone(new AuthorResource($author), 'Author updated successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeRespone(null, 'Failed to update Author', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {

            $author->delete();
            return $this->customeRespone(null, 'Author deleted successfully', 200);

    }

    private function customResponse($data, $message, $status)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
        ], $status);
    }
}
