<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserManagement;
use Illuminate\Support\Facades\Auth;
use Hash;
use Session;

class UserManagementController extends Controller
{
    public function index(Request $request){
        $user = UserManagement::all();
        return view ('usermanagement', compact('user')); 
    }

    public function adduser(Request $request){
            $request->validate([
            'empid' => 'required',
            'fname' => 'required',
            'mname' => 'required',
            'lname' => 'required',
            'userrole' => 'required',
            'email' => 'required',
            'password' => 'required',
           
        ]);
        $id = $request->id;
        $empid = $request->empid;
        $fname = $request->fname;
        $mname = $request->mname;
        $lname = $request->lname;
        $userrole = $request->userrole;
        $email = $request->email;
        $password = bcrypt($request->password);

        $user = new UserManagement();
        $user->EmployeeID = $empid;
        $user->FirstName = $fname;
        $user->MiddleName = $mname;
        $user->LastName = $lname;
        $user->UserRole = $userrole;
        $user->Email = $email;
        $user->Password = $password;
        $user->save();
        
        return redirect()->back()->with('success', 'New User Added Successfully');
       
        
    }
    public function LoginM(Request $request){
        $request->validate([
            'email'=>'required',
            'pass' =>'required',
        ]);
        
        $user = UserManagement::where('email', '=', $request->email)->first();
        if ($user){
            if(Hash::check($request->pass, $user->Password)){
                $request->session()->put('loginid', $user->id);
                
                if($user->UserRole ==='Admin'){
                    return redirect('/UserManagement');
                } elseif($user->UserRole ==='Payroll Master'){
                    return redirect('/payroll');
                }
            }
            else{
                return redirect()->back()->with('failed', 'Password Not Matches');
            }
        }
        else{
            return redirect()->back()->with('failed', 'Invalid Credentials');
        }

    }
}