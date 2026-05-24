<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\DataType;
use Illuminate\Http\Request;

class CrawlApiController extends Controller
{
    public function index()
    {
        $dataTypes = DataType::with('fields')->get();
        return view('superadmin.crawl-api.index', compact('dataTypes'));
    }
}