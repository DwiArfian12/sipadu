<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CrawlApiController extends Controller
{
    public function index()
    {
        $dataTypes = auth()->user()->dataTypes()->with('fields')->get();
        return view('admin.crawl-api.index', compact('dataTypes'));
    }
}