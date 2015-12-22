<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

class BaseController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }
}
