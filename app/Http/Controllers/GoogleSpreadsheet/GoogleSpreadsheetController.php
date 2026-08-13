<?php

// 

namespace App\Http\Controllers\GoogleSpreadsheet;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class GoogleSpreadsheetController extends Controller
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // $this->middleware('auth'); //logged users only
    }

    public function index()
    {
        
        return view('google-spreadsheet.index', []);
    }

    
}
