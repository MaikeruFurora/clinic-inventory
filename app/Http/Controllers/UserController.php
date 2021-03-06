<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function user(){
        return view('administrator.user.index');
    }
    
    public function userList(){
        return response()->json([
            'administrator'=>User::where('user_type','administrator')->where('status','activate')->get(),
            'nurse'=>User::where('user_type','nurse')->where('status','activate')->get(),
            'archive'=>User::where('status','deactivate')->get()
        ]);
    }

    public function changeStatus($user,$status){
        return User::whereId($user)->update([
            'status'=>trim($status)
        ]);
    }

    public function store(Request $request){
        return User::updateorcreate(['id'=>$request->id],[
            'first_name' => $request->first_name, 
            'last_name' => $request->last_name,
            'username' => $request->username, 
            'contact_no' => $request->contact_no, 
            'address' => $request->address, 
            'email' => $request->email, 
            'password' => (empty($request->id) ? Hash::make('password') : $this->findUser($request->id)->password),
            'user_type'=> strtolower($request->user_type),
            'privilege'=> (empty($request->id) ? Hash::make('privilege') : $this->findUser($request->id)->privilege),
            'status'=>'activate',
        ]);
    }

    public function findUser($id){
        return User::findorFail($id);
    }

    public function changePassword(Request $request){
        $user=User::find(auth()->user()->id);
        if (Hash::check($request->password,$user->password)) {
            $user->password=Hash::make($request->new_password);
            $user->save();
            Auth::guard('web')->logout();
            // return redirect()->route('auth.form')->with('msg','You change password, Please input your new password');
        } else {
            return response()->json([
                'msg'=>'Invalid Credentials'
            ]);
        }
        
    }

    public function privilegeStatus($id){
        return response()->json(
            User::whereId($id)->select('id','privilege')->first()
        );
    }

    public function privilegeUpdate(Request $request){
        return User::whereId($request->id)
        ->update([
            'privilege'=>$request->privilegeUpdate
        ]);
    }
}


