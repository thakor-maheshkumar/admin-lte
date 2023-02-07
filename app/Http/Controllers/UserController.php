<?php


namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Image;
class UserController extends Controller
{
    public function index(){
        return view('users.index');
    }
    public function saveToken(Request $request)
    {
        auth()->user()->update(['device_token'=>$request->token]);
        return response()->json(['token saved successfully.']);
    }
    public function sendNotification(Request $request)
    {
        $firebaseToken = User::whereNotNull('device_token')->pluck('device_token');
        //dd($firebaseToken);
        $SERVER_API_KEY = 'AAAANP0-ZG8:APA91bEVVWHQDnXwmiqSoKGNrBP2LMxGD-Qi34nXTU4yI3JRj3vQOvuQSND0m43m2lxLMK5KHkM8ZUY5_Mmd8gIQrbCNKKQvWgAZDWrHiBGWSvpi6jOSV5soalVDXG84Ltm-AtqXClem	';
  
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,  
            ]
        ];
        //dd($data);
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
        //dd($ch);
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        //dd($ch);
        $response = curl_exec($ch);
        
        dd($response);
    }

    /* Upload image form */
    public function createForm(){
        return view('users.image-upload');
    }
    public function images(){

        
        $images = Image::all();
        return view('users.image',compact('images'));
    }
    public function fileUpload(Request $req){
        $req->validate([
          'imageFile' => 'required',
          'imageFile.*' => 'mimes:jpeg,jpg,png,gif,csv,txt,pdf|max:2048'
        ]);
        if($req->hasfile('imageFile')) {
            foreach($req->file('imageFile') as $file)
            {
                $name = $file->getClientOriginalName();
                $file->move(public_path().'/uploads/', $name);  
                $imgData [] = $name;  
            }
            
            $fileModal = new Image();
            $fileModal->name = json_encode($imgData);
            $fileModal->image_path = json_encode($imgData);
            
            $fileModal->save();
            if($fileModal->save()){
            $image = "Image added by ".auth()->user()->name;
            
            $logs = \LogActivity::addToLog($image);
            }
           return back()->with('success', 'File has successfully uploaded!');
        }
      }
      public function userApi(Request $request){
        $search = $request->search;
        //dd($search);
        $search = 1;
        $users = User::with('country')
                        ->whereHas('country', function (Builder $query) use($name){
                            $query->where('name', 'like', '%'.$name.'%');
                        })
                        ->get()
                        ->toArray();
        
        // if($request->has('status')){
        //     $query->where('status', $request->input('status'));
        // }
        // if($request->has('sort')){
        //     $query->orderBy('name',$request->input('sort'));
        // }
        // $users = $query->get();
        return api()->ok(__('Appointment list.'), [
            'count' => $query
        ]);
        //dd($users);
      }
}
