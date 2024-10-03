<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function index(Request $request){
        $user = $request->session()->get('user', 'default')[0];
        $temp = array();
        $all = array();
        $selected = DB::table('Record')->where("STU_num","=",$user->STU_num)->join('Course','Record.CS_num','=','Course.CS_num')->get();
        foreach($selected as $s)array_push($temp, $s->CS_num);
        $unselected = DB::table('Course')->whereNotIn("CS_num", $temp)->get();
        $list = DB::table('Course')->orderBy('CS_num')->get();
        foreach($list as $l){
            if(in_array($l->CS_num, $temp)){
                $grade = DB::table('Record')->where("STU_num","=",$user->STU_num)->where("CS_num","=",$l->CS_num)->first()->Grade;
                $add = array("CS" => $l->CS,"CS_num" => $l->CS_num,"Credit" => $l->Credit,"status" => "已選修","Grade" => ($grade==null)?"未考核":$grade);
            }
            else{
                $add = array("CS" => $l->CS,"CS_num" => $l->CS_num,"Credit" => $l->Credit,"status" => "未選修","Grade" => "未考核");
            }
            $all[] = $add;
        }
        return view("/student/homepage")->with(["user"=>$user, "all"=>$all, "selected"=>$selected, "unselected"=>$unselected]);
    }
    //加選頁面
    public function add_CS(Request $request){
        $user = $request->session()->get('user', 'default')[0];
        if(session()->has('msg'))
            $check = session()->get('msg');
        else $check = null;
        $temp = DB::table('Record')->where("STU_num","=",$user->STU_num)->get();
        $unselected = array();
        foreach($temp as $t) array_push($unselected, $t->CS_num);
        $list = DB::table('Course')
                ->whereNotIn("CS_num", $unselected)->get();
        return view("/student/add_CS")->with(["user"=>$user, "list"=>$list, "check"=>$check]);
    }
    //加選操作
    public function add_submit(Request $request){
        $user = $request->session()->get('user', 'default')[0];
        if(is_null($request->select)) return redirect()->back();
        foreach($request->select as $s)
            DB::table('Record')->insert(['STU_num' => $user->STU_num, 'CS_num' => $s]);
        return redirect('/student/add_CS')->with(["msg"=>"加選成功"]);
    }

    //退選頁面
    public function drop_CS(Request $request){
        $user = $request->session()->get('user', 'default')[0];
        if(session()->has('msg'))
            $check = session()->get('msg');
        else $check = null;
        $list = DB::table('Record')->where("STU_num","=",$user->STU_num)->join('Course','Record.CS_num','=','Course.CS_num')->get();
        return view("/student/drop_CS")->with(["user"=>$user, "list"=>$list, "check"=>$check]);
    }
    //退選操作
    public function drop_submit(Request $request){
        $user = $request->session()->get('user', 'default')[0];
        if(is_null($request->select)) return redirect()->back();
        foreach($request->select as $s){
            DB::table('Record')
                ->where("STU_num","=",$user->STU_num)
                ->where("CS_num","=",$s)
                ->delete();
        }
        return redirect('/student/add_CS')->with(["msg"=>"退選成功"]);
    }
}
