<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogActivity;
class LogController extends Controller
{
    public function index()
    {
        $logs = LogActivity::all();
        return view('log.index',compact('logs'));
    }
}
