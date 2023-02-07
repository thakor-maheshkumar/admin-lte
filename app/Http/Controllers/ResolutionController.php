<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resolution;

class ResolutionController extends Controller
{
    public function index(){
        $resolutions = Resolution::all();
        return view('resolution.list',compact('resolutions'));
    }
    public function create()
    {
        return view('resolution.create');
    }
    public function store(Request $request){
       
        $create = Resolution::create($request->only('language','title','link','description'));
        return redirect('resolution');
    }
    public function getSolution(Request $request){
       
        if($request->ajax()){
            $query = Resolution::query();
            if($request->language==null){
                $list = (clone $query)->get();
                if($request->search){
                    $list=(clone $query)->where('title','LIKE','%'.$request->search.'%')->get();
                    return response()->json($list); 
                }
                return response()->json($list);    
            }else{
                $language = $request->language;
                if($request->search){
                    $list = (clone $query)->where('title','LIKE','%'.$request->search.'%')->get();
                }
                $list = (clone $query)->where('language',$language)->get();
                return response()->json($list);
            }
        }
    }
}
