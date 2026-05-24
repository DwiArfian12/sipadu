<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataRecord;
use App\Models\DataType;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $dataTypes = auth()->user()->dataTypes()->withCount('records')->get();
        $totalRecords = DataRecord::whereIn('data_type_id', $dataTypes->pluck('id'))->count();

        return view('admin.dashboard', compact('dataTypes', 'totalRecords'))->with('assignedDataTypes', $dataTypes);
    }
}