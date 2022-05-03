<?php

use Modules\Review\Http\Controllers\ReviewController;

Route::get('can-review-product/{productId}/{customerId}', [ReviewController::class, 'canReviewProduct'])->name('review.can-review-product');
Route::get('product-review/{productId}', [ReviewController::class, 'productReview'])->name('review.product');

Route::middleware('auth:api')->group(function () {
    Route::post('create-review', 'ReviewController@createReview')->name('review.create');
    Route::put('reviews/{review}/publish', 'ReviewPublicationController@store')->name('api.reviews.publish');
    Route::delete('reviews/{review}/unpublish', 'ReviewPublicationController@destroy')->name('api.reviews.unpublish');
});
