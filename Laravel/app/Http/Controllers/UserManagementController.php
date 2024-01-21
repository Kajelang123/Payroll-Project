<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserManagement;
use Illuminate\Support\Facades\Auth;
use Hash;
use Spatie\ActivityLog\Models\Activity;
use Session;

class UserManagementController extends Controller
{
    public function index(Request $request){
        $user = UserManagement::all();
        return view ('usermanagement', compact('user')); 
    }

    public function adduser(Request $request){
            $request->validate([
            'empid' => 'required|min:10|unique:user_management,EmployeeID',
            'fname' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            'mname' => 'regex:/^[a-zA-Z0-9\s]+$/',
            'lname' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            'userrole' => 'required',
            'email' => 'required|email|ends_with:gmail.com,yahoo.com.|unique:user_management,Email',
            'password' => 'required|min:5|max:10',
           
        ]);
        $id = $request->id;
        $empid = $request->empid;
        $fname = ucwords(strtolower($request->fname));
        $mname = ucwords(strtolower($request->mname));
        $lname = ucwords(strtolower($request->lname));
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
        
        activity()
        ->performedOn($user)
        ->causedBy(auth()->user())
        ->withProperties(['action' => 'user_saved'])
        ->log('New User Added Successfully');

        return redirect()->back()->with('success', 'New User Added Successfully');
       
        
    }
    public function edituser($id){
        $data = UserManagement::where('id', '=', $id)-first();

        return view ('', compact('data'));
    }
    public function UpdateUser(Request $request){
        $request->validate([
            'empid' => 'required|min:10|unique:user_management,EmployeeID',
            'fname' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            'mname' => 'regex:/^[a-zA-Z0-9\s]+$/',
            'lname' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            'userrole' => 'required',
            'email' => 'required|email|ends_with:gmail.com,yahoo.com.|unique:user_management,Email',
            'password' => 'required|min:5|max:10',
           
        ]);
        $id = $request->id;
        $empid = $request->empid;
        $fname = ucwords(strtolower($request->fname));
        $mname = ucwords(strtolower($request->mname));
        $lname = ucwords(strtolower($request->lname));
        $userrole = $request->userrole;
        $email = $request->email;
        $password = bcrypt($request->password);


        UserManagement::where('id', $id)->update([
            'EmployeeID' => $empid,
            'FirstName' => $fname,
            'MiddleName' => $mname,
            'LastName' => $lname,
            'UserRole' => $userrole,
            'Email' => $email,
            'Password' => $password,
        ]);
    

        activity()
            ->performedOn(UserManagement::find($id))
            ->causedBy(auth()->user())
            ->withProperties(['action' => 'user_updated'])
            ->log('User Updated Successfully');
    
        return redirect()->back()->with('success', 'User Updated Successfully');
    }


    public function LoginM(Request $request){
        $request->validate([
            'email'=>'required',
            'pass' =>'required',
        ]);
        
        $user = UserManagement::where('email', '=', $request->email)->first();
       

if ($user) {
    if (Hash::check($request->pass, $user->Password)) {
        $request->session()->put('loginid', $user->id);

        if ($user->UserRole === 'Admin') {
            activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->withProperties(['action' => 'user_log'])
            ->log('Welcome, Admin!');
            return redirect('/dashboard')->with('success', 'Welcome, Admin!');
        } else if ($user->UserRole === 'Payroll Master') {
            activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->withProperties(['action' => 'user_log'])
            ->log('Welcome, Payroll Master');
            return redirect('/pmdashboard')->with('success', 'Welcome, Payroll Master!');
        } else if ($user->UserRole === 'Owner') {
            activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->withProperties(['action' => 'user_log'])
            ->log('Welcome, Owner!');
            return redirect('/owdashboard')->with('success', 'Welcome, Owner!');
        } else {
            
            return redirect()->back()->with('failed', 'Invalid User Role');
        }
    } else {
        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->withProperties(['action' => 'user_log'])
            ->log('Password does not match');
        return redirect()->back()->with('failed', 'Password does not match');
        
    }
}   else {
        return redirect()->back()->with('failed', 'Invalid Credentials');
}


    }
}