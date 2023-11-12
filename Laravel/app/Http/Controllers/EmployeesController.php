<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employees;
use App\Models\Payroll;

class EmployeesController extends Controller
{
    public function index()
    {
        $employees = Employees::all(); // Retrieve all employees from the database
        return view('employees-list', compact('employees'));
    }
    public function addEmployee(){
        return view('addemployees'); 
    }
    public function saveEmployee(Request $request){
        $request->validate([
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'Email' => 'required',
            'position' =>'required',
            'EmployeeID' =>'required',
            'Contact'=>'required',
        ]);

        $first_name = $request->first_name;
        $middle_name = $request->middle_name;
        $last_name = $request->last_name;
        $email = $request->Email;
        $Position = $request->position;
        $empid = $request->EmployeeID;
        $contact = $request->Contact;
    
        $emp = new Employees();
        $emp->FirstName = $first_name;
        $emp->MiddleName = $middle_name;
        $emp->LastName = $last_name;
        $emp->Email = $email;
        $emp->Position = $Position;
        $emp->EmployeeID =$empid;
        $emp->Contact = $contact;
        $emp->save();
    
        return redirect()->back()->with('success', 'Employee Added Successfully');
    
    
    

    }
    public function editEmployee($id){
        $data = Employees::where('id','=', $id)->first();
        return view ('editemployees', compact('data'));
    }

    public function updateEmployees(Request $request){
        $request->validate([
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'Email' => 'required',
            'position' =>'required',
            'EmployeeID' =>'required',
            'Contact'=>'required',
        ]);
        $id = $request->id;
        $first_name = $request->first_name;
        $middle_name = $request->middle_name;
        $last_name = $request->last_name;
        $email = $request->Email;
        $Position = $request->position;
        $empid = $request->EmployeeID;
        $contact = $request->Contact;


        Employees::where('id', '=', $id)->update([
            'FirstName' =>$first_name,
            'MiddleName' =>$middle_name,
            'LastName' =>$last_name,
            'email' =>$email,
            'position' =>$Position,
            'Contact' =>$contact,
            'EmployeeID' =>$empid,
            
        ]);
        return redirect()->back()->with('success', 'Updated Employee Successfully');
    
    }
    public function deleteEmployee($id){
        Employees::where('id', '=',$id)->delete();
        return redirect()->back()->with('success', 'Deleted Employee Successfully');
    }
}

