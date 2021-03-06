<?php

namespace App\Http\Controllers;

use App\Author;
use App\Transformer\RatingTransformer;
use Illuminate\Http\Request;

/**
 * Manage an Author's Ratings
 */
class AuthorsRatingsController extends Controller
{
    public function store(Request $request, $authorId)
    {
        $author = Author::findOrFail($authorId);

        $rating = $author->ratings()->create(['value' => $request->get('value')]);
        $data = $this->item($rating, new RatingTransformer());

        return response()->json($data, 201);
    }

    public function destroy($authorId, $ratingId)
    {
        /** @var \App\Author $author */
        $author = Author::findOrFail($authorId);
        $author
            ->ratings()
            ->findOrFail($ratingId)
            ->delete();

        return response(null, 204);
    }
}
