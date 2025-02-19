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

    public function show()
    {
        return view('admin.commission.show');
    }

    public function refund()
    {
        return view('admin.commission.refund');
    }

    public function cancel()
    {
        return view('admin.commission.cancel');
    }

}
