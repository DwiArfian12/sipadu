<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\DataType;
use App\Models\DataRecord;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDataTypes = DataType::count();
        $totalRecords = DataRecord::count();
        $totalUsers = User::count();
        $recentDataTypes = DataType::with('creator')->latest()->take(5)->get();

        return view('superadmin.dashboard', compact(
            'totalDataTypes',
            'totalRecords',
            'totalUsers',
            'recentDataTypes'
        ));
    }
}