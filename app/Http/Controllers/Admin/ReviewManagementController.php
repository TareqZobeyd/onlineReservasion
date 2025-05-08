<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewManagementController extends Controller
{
    /**
     * Display a listing of the reviews.
     */
    public function index()
    {
        $reviews = Review::with(['user', 'restaurant'])
            ->latest()
            ->paginate(10);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Display the specified review.
     */
    public function show(Review $review)
    {
        $review->load(['user', 'restaurant']);
        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified review.
     */
    public function edit(Review $review)
    {
        return view('admin.reviews.edit', compact('review'));
    }

    /**
     * Update the specified review.
     */
    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $review->update($validated);

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'نظر با موفقیت بروزرسانی شد.');
    }

    /**
     * Remove the specified review.
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'نظر با موفقیت حذف شد.');
    }

    /**
     * Approve the specified review.
     */
    public function approve(Review $review)
    {
        $review->update(['status' => 'approved']);

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'نظر با موفقیت تایید شد.');
    }

    /**
     * Reject the specified review.
     */
    public function reject(Review $review)
    {
        $review->update(['status' => 'rejected']);

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'نظر با موفقیت رد شد.');
    }
} 