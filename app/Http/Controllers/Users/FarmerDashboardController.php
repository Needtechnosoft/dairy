<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FarmerDashboardController extends Controller
{
    public function index(){
        return 'Hi ! from user dashboard';
    }
}
