<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Redirect;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /**
     *
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */

    public function show(){
        return view("login");
    }
    public function login(Request $request){
        $choice = $request->input("choice");
        $id = $request->input("id");
        if($choice == "stu"){
            $user = DB::table('Student')
                ->where('STU_num', '=', $id)
                ->get();
            session(["user"=>$user]);
            if (!$user->isEmpty())return redirect()->route("student");
            else return redirect()->back();
        }
        else if($choice == "tr") {
            $user = DB::table('Department')
                ->where('DP_num', '=', $id)
                ->get();
            session(["user"=>$user]);
            if (!$user->isEmpty())return redirect()->route("admin");
            else return redirect()->back();
        }
        else return redirect()->back();
    }
}
