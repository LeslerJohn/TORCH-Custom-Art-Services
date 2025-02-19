<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index()
    {
        return view('admin.commission.index');
    }


    private function all_commission()
    {

        
        return view('admin.commission.all-commission');
    }
}
