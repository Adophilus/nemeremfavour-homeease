<?php

namespace App\Http\Controllers;
use App\Models\Blogger;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function updateVerificationStatus($bloggerId, $verifiedStatus)
    {
        $blogger = Blogger::findOrFail($bloggerId);
        $blogger->verified = $verifiedStatus;
        $blogger->save();

        return response()->json(['message' => 'Verification status updated']);
    }
}