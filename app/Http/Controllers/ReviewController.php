<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::all();
        $data = ReviewResource::collection($reviews);
        return $this->customeRespone($data, 'Done!', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReviewRequest $request)
    {
        try {
            DB::beginTransaction();

            $review = Review::create([
                'name' => $request->name,
                'bio' => $request->bio,
            ]);
            DB::commit();
            return $this->customeRespone(new ReviewResource($review), 'Review created successfully', 201);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Failed to create Review', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        $data = new ReviewResource($review);
        return $this->customeResponse($data, 'Done!', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReviewRequest $request, Review $review)
    {
        try {
            DB::beginTransaction();
            $review->update([
                'name' => $request->name,
                'bio' => $request->bio,
            ]);
            DB::commit();

            return $this->customeRespone(new ReviewResource($review), 'Review updated successfully', 200);
        }catch (\Throwable $th) {
            Log::error($th);
            return $this->customeRespone(null, 'Failed to update Review', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {

            $review->delete();
            return $this->customeRespone(null, 'Review deleted successfully', 200);

    }
}
