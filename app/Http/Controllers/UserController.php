<?php

namespace App\Http\Controllers;

use App\Model\File;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('layouts.mainPage');
    }

    public function showReviewEditor()
    {
        return view('layouts.addReview');
    }
}
