<?php

namespace App\Services;

use App\Models\Review;
use App\Models\Restaurant;
use Illuminate\Support\Facades\DB;

class ReviewService
{
    public function createReview(array $data): Review
    {
        return DB::transaction(function () use ($data) {
            $review = Review::create($data);
            
            // Update restaurant's average rating
            $restaurant = Restaurant::findOrFail($data['restaurant_id']);
            $restaurant->calculateAverageRating();
            
            return $review;
        });
    }

    public function updateReview(Review $review, array $data): Review
    {
        return DB::transaction(function () use ($review, $data) {
            $review->update($data);
            
            // Update restaurant's average rating
            $restaurant = $review->restaurant;
            $restaurant->calculateAverageRating();
            
            return $review;
        });
    }

    public function approveReview(Review $review): Review
    {
        return DB::transaction(function () use ($review) {
            $review->update(['status' => 'approved']);
            
            // Update restaurant's average rating
            $restaurant = $review->restaurant;
            $restaurant->calculateAverageRating();
            
            return $review;
        });
    }

    public function rejectReview(Review $review): Review
    {
        return DB::transaction(function () use ($review) {
            $review->update(['status' => 'rejected']);
            
            // Update restaurant's average rating
            $restaurant = $review->restaurant;
            $restaurant->calculateAverageRating();
            
            return $review;
        });
    }
} 