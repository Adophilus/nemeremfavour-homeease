<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blogger;
use Illuminate\Support\Facades\DB;

class LeagueController extends Controller
{
     public function groupBloggersByEngagement()
    {
        $bloggers = Blogger::withCount('likes', 'comments')
            ->orderBy('likes_count', 'desc')
            ->orderBy('comments_count', 'desc')
            ->get();

        $leagues = [];

        foreach ($bloggers as $blogger) {
            $likes = $blogger->likes_count;
            $comments = $blogger->comments_count;

            if (!isset($leagues[$likes])) {
                $leagues[$likes] = [];
            }

            $leagues[$likes][$comments][] = $blogger;
        }

        return response()->json($leagues);
    }
}
