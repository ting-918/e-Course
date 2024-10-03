<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    //主頁內容
    public function index(Request $request){
        $user = $request->session()->get('user', 'default')[0];
        if(session()->has('msg'))
            $check = session()->get('msg');
        else $check = null;
        $temp = DB::table('Student')->where("DP_num","=",$user->DP_num)->orderBy('STU_num')->get();
        $list = Array();
        foreach($temp as $t)
            $list[] = array( "Name" => $t->Name, "STU_num" => $t->STU_num, "DP" => $user->DP);
        return view("/admin/homepage")->with(["user"=>$user, "list"=>$list, 'check'=>$check, "current"=>null, "popup"=>null]);
    }
    //主頁查詢
    public function search(Request $request){
        $user = $request->session()->get('user', 'default')[0];
        $search = $request->id;
        $result = DB::table('Student')->where("DP_num","=",$user->DP_num)->where("STU_num","=",$search)->first();
        if($result == null || $search == null) return redirect('/admin')->with(["msg"=>"學生不存在，請重新操作"]);
        else{
            $temp = DB::table('Student')->where("DP_num","=",$user->DP_num)->orderBy('STU_num')->get();
            $list = Array();
            foreach($temp as $t)
                $list[] = array( "Name" => $t->Name, "STU_num" => $t->STU_num, "DP" => $user->DP);
            return view("/admin/homepage")->with(["user"=>$user, "list"=>$list, 'check'=>null,"current"=>$result, "popup"=>"1"]);
        }
    }
    //課程管理
    public function Course(Request $request){
        $user = $request->session()->get('user', 'default')[0];
        if(session()->has('msg'))
            $check = session()->get('msg');
        else $check = null;
        $list = DB::table('Course')->orderBy('CS_num')->get();
        if($list->isEmpty())$current = null;
        else $current = $list[0];
        return view("/admin/Course")->with(['user'=>$user, 'list'=>$list, 'check'=>$check, 'current'=>$current,'popup'=>null]);
    }
    public function Course_search(Request $request){
        $user = $request->session()->get('user', 'default')[0];
        $search = $request->course;
        $result = DB::table('Course')->where("CS_num","=",$search)->orWhere("CS","=",$search)->get();
        if($result->isEmpty()) return redirect('/admin/Course')->with(["msg"=>"課程不存在，請重新操作"]);
        else return view("/admin/Course")->with(['user'=>$user, 'list'=>$result, 'check'=>null, 'current'=>$result,'popup'=>null]);
    }
    public function Course_origin(Request $request){
        $user = $request->session()->get('user', 'default')[0];
        $list = DB::table('Course')->orderBy('CS_num')->get();
        $o = $request->origin;
        $origin = DB::table('Course')->where("CS_num","=",$o)->first();
        if($origin != "null")$current = $origin;
        else $current = null;
        return view("/admin/Course")->with(['user'=>$user, 'list'=>$list, 'check'=>null, 'current'=>$current, 'popup'=>"1"]);
    }
    public function Course_update(Request $request){
        $origin = $request->origin;
        if($origin == "null"){
            if($request->CS == null || $request->Credit == null || $request->CS_num == null)
                return redirect('/admin/Course')->with(["msg"=>"課程信息輸入不完整，請重新操作"]);
            else{
                $unique = DB::table('Course')->where("CS_num","=",$request->CS_num)->get();
                if($unique->isEmpty()){
                    DB::table('Course')->insert(['CS'=>$request->CS,'CS_num'=>$request->CS_num,'Credit'=>$request->Credit]);
                    return redirect('/admin/Course')->with(["msg"=>"課程新增成功"]);
                }
                else return redirect('/admin/Course')->with(["msg"=>"輸入課號已存在，請重新操作"]);
            }
        }
        else{
            if($request->CS != null)
                DB::table('Course')->where("CS_num","=",$origin)->update(['CS'=> $request->CS]);
            if($request->Credit != null)
                DB::table('Course')->where("CS_num","=",$origin)->update(['Credit'=> $request->Credit]);
            if($request->CS_num != null){
                $unique = DB::table('Course')->where("CS_num","=",$request->CS_num)->get();
                if(!$unique->isEmpty())
                    return redirect('/admin/Course')->with(["msg"=>"輸入課號已存在，請重新操作"]);
                DB::table('Course')->where("CS_num","=",$origin)->update(['CS_num'=> $request->CS_num]);
            }
            return redirect('/admin/Course')->with(["msg"=>"課程資料更新成功"]);
        }
    }
    public function Course_drop(Request $request){
        $result = DB::table('Course')->where("CS_num","=",$request->CS_num)->get();
        if($result->isEmpty()) return redirect('/admin/Course')->with(["msg"=>"課程不存在，請重新操作"]);
        else{
            DB::table('Record')->where("CS_num","=",$request->CS_num)->delete();
            DB::table('Course')->where("CS_num","=",$request->CS_num)->delete();
            return redirect('/admin/Course')->with(["msg"=>"課程資料刪除成功"]);
        }
    }
    //學籍管理
    public function SchoolRoll(Request $request){
        $user = $request->session()->get('user', 'default')[0];
        if(session()->has('msg'))
            $check = session()->get('msg');
        else $check = null;
        $temp = DB::table('Student')->orderBy('STU_num')->get();
        $list = Array();
        foreach($temp as $t){
            $dp = DB::table('Department')->where("DP_num","=",$t->DP_num)->first();
            $add = array( "Name" => $t->Name, "STU_num" => $t->STU_num, "DP" => $dp->DP);
            $list[] = $add;
        }
        if($list == [])$current = null;
        else $current = $list[0];
        return view("/admin/SchoolRoll")->with(['user'=>$user, 'list'=>$list, 'check'=>$check, 'current'=>$current,'popup'=>null]);
    }
    public function SchoolRoll_search(Request $request){
        $user = $request->session()->get('user', 'default')[0];
        $search = $request->id;
        $result = DB::table('Student')->where("STU_num","=",$search)->get();
        if($result->isEmpty()) return redirect('/admin/SchoolRoll')->with(["msg"=>"學生不存在，請重新操作"]);
        else{
            $list = Array();
            foreach($result as $r){
                $dp = DB::table('Department')->where("DP_num","=",$r->DP_num)->first();
                $add = array( "Name" => $r->Name, "STU_num" => $r->STU_num, "DP" => $dp->DP);
                $list[] = $add;
            }
            if($list == [])$current = null;
            else $current = $list[0];
            return view("/admin/SchoolRoll")->with(['user'=>$user, 'list'=>$list, 'check'=>null, 'current'=>$current,'popup'=>null]);
        }
    }
    public function SchoolRoll_origin(Request $request){
        $user = $request->session()->get('user', 'default')[0];
        $o = $request->origin;
        $temp = DB::table('Student')->orderBy('STU_num')->get();
        $list = Array();
        foreach($temp as $t){
            $dp = DB::table('Department')->where("DP_num","=",$t->DP_num)->first();
            $add = array( "Name" => $t->Name, "STU_num" => $t->STU_num, "DP" => $dp->DP);
            $list[] = $add;
        }
        $origin = DB::table('Student')->where("STU_num","=",$o)->first();
        if($origin != null){
            $dp_origin = DB::table('Department')->where("DP_num","=",$origin->DP_num)->first();
            $current = array("Name" => $origin->Name, "STU_num" => $origin->STU_num, "DP" => $dp_origin->DP);
        }
        else $current = null;
        return view("/admin/SchoolRoll")->with(['user'=>$user, 'list'=>$list, 'check'=>null, 'current'=>$current, 'popup'=>"1"]);
    }
    public function SchoolRoll_update(Request $request){
        $origin = $request->origin;
        if($origin == "null"){
            if($request->Name == null || $request->STU_num == null || $request->DP == null)
                return redirect('/admin/SchoolRoll')->with(["msg"=>"學生信息輸入不完整，請重新操作"]);
            else{
                $dp = DB::table('Department')->where("DP_num","=",$request->DP)->orWhere("DP","=",$request->DP)->first();
                if($dp == null)
                    return redirect('/admin/SchoolRoll')->with(["msg"=>"輸入科系不存在，請重新操作"]);
                else{
                    $unique = DB::table('Student')->where("STU_num","=",$request->STU_num)->get();
                    if($unique->isEmpty()){
                        DB::table('Student')->insert(['Name'=>$request->Name,'STU_num'=>$request->STU_num,'DP_num'=>$dp->DP_num]);
                        return redirect('/admin/SchoolRoll')->with(["msg"=>"學生新增成功"]);
                    }
                    else return redirect('/admin/SchoolRoll')->with(["msg"=>"輸入學號已存在，請重新操作"]);
                }
            }
        }
        else{
            if($request->DP != null){
                $dp = DB::table('Department')->where("DP_num","=",$request->DP)->orWhere("DP","=",$request->DP)->first();
                if($dp == null)
                    return redirect('/admin/SchoolRoll')->with(["msg"=>"輸入科系不存在，請重新操作"]);
                DB::table('Student')->where("STU_num","=",$origin)->update(['DP_num'=> $dp->DP_num]);
            }
            if($request->STU_num != null){
                $unique = DB::table('Student')->where("STU_num","=",$origin)->get();
                if(!$unique->isEmpty())
                    return redirect('/admin/SchoolRoll')->with(["msg"=>"輸入學號已存在，請重新操作"]);
                DB::table('Student')->where("STU_num","=",$origin)->update(['STU_num'=> $request->STU_num]);
            }
            if($request->Name != null)
                DB::table('Student')->where("STU_num","=",$origin)->update(['Name'=> $request->Name]);
            return redirect('/admin/SchoolRoll')->with(["msg"=>"學生資料更新成功"]);
        }
    }
    public function SchoolRoll_drop(Request $request){
        $result = DB::table('Student')->where("STU_num","=",$request->STU_num)->get();
        if($result->isEmpty()) return redirect('/admin/SchoolRoll')->with(["msg"=>"學生不存在，請重新操作"]);
        else{
            DB::table('Record')->where("STU_num","=",$request->STU_num)->delete();
            DB::table('Student')->where("STU_num","=",$request->STU_num)->delete();
            return redirect('/admin/SchoolRoll')->with(["msg"=>"學籍資料刪除成功"]);
        }
    }
    //科系管理
    public function Department(Request $request){
        $user = $request->session()->get('user', 'default')[0];
        if(session()->has('msg'))
            $check = session()->get('msg');
        else $check = null;
        $list = DB::table('Department')->orderBy('DP_num')->get();
        return view("/admin/Department")->with(['user'=>$user, 'list'=>$list, 'check'=>$check, 'current'=>$list[0],'popup'=>null]);
    }
    public function Department_search(Request $request){
        $user = $request->session()->get('user', 'default')[0];
        $search = $request->dp;
        $result = DB::table('Department')->where("DP_num","=",$search)->orWhere("DP","=",$search)->get();
        if($result->isEmpty()) return redirect('/admin/Department')->with(["msg"=>"科系不存在，請重新操作"]);
        else return view("/admin/Department")->with(['user'=>$user, 'list'=>$result, 'check'=>null, 'current'=>$result,'popup'=>null]);
    }
    public function Department_origin(Request $request){
        $user = $request->session()->get('user', 'default')[0];
        $list = DB::table('Department')->orderBy('DP_num')->get();
        $o = $request->origin;
        $origin = DB::table('Department')->where("DP_num","=",$o)->first();
        if($o != "null")$current = $origin;
        else $current = null;
        return view("/admin/Department")->with(['user'=>$user, 'list'=>$list, 'check'=>null, 'current'=>$current, 'popup'=>"1"]);
    }
    public function Department_update(Request $request){
        $user = $request->session()->get('user', 'default')[0];
        $origin = $request->origin;
        if($origin == "null"){
            if($request->DP == null || $request->Dean == null || $request->DP_num == null)
                return redirect('/admin/Department')->with(["msg"=>"科系信息輸入不完整，請重新操作"]);
            else{
                $unique = DB::table('Department')->where("DP_num","=",$request->DP_num)->get();
                if($unique->isEmpty()){
                    DB::table('Department')->insert(['DP'=>$request->DP,'DP_num'=>$request->DP_num,'Dean'=>$request->Dean]);
                    return redirect('/admin/Department')->with(["msg"=>"科系新增成功"]);
                }
                else return redirect('/admin/Department')->with(["msg"=>"輸入系碼已存在，請重新操作"]);
            }
        }
        else{
            if($request->DP != null)
                DB::table('Department')->where("DP_num","=",$origin)->update(['DP'=> $request->DP]);
            if($request->Dean != null)
                DB::table('Department')->where("DP_num","=",$origin)->update(['Dean'=> $request->Dean]);
            if($request->DP_num != null){
                $unique = DB::table('Department')->where("DP_num","=",$request->DP_num)->get();
                if(!$unique->isEmpty())
                    return redirect('/admin/Department')->with(["msg"=>"輸入系碼已存在，請重新操作"]);
                DB::table('Department')->where("DP_num","=",$origin)->update(['DP_num'=> $request->DP_num]);
                //database中Student表的FK(即，DP_num)對於update要採用cascade
            }
            if($origin == $user->DP_num || $request->DP_num == $user->DP_num){
                $num = ($request->DP_num == null)? $origin : $request->DP_num;
                $user = DB::table('Department')->where("DP_num","=",$num)->get();
                session(["user"=>$user]);
            }
            return redirect('/admin/Department')->with(["msg"=>"科系資料更新成功"]);
        }
    }
    public function Department_drop(Request $request){
        $user = $request->session()->get('user', 'default')[0];
        if($request->DP_num == $user->DP_num) return redirect('/admin/Department')->with(["msg"=>"您沒有權限刪除您所屬的科系"]);
        $result = DB::table('Department')->where("DP_num","=",$request->DP_num)->get();
        if($result->isEmpty()) return redirect('/admin/Department')->with(["msg"=>"科系不存在，請重新操作"]);
        else{
            $stu = DB::table('Student')->where("DP_num","=",$request->DP_num)->get();
            foreach($stu as $s)
                DB::table('Record')->where("STU_num","=",$s->STU_num)->delete();
            DB::table('Student')->where("DP_num","=",$request->DP_num)->delete();
            DB::table('Department')->where("DP_num","=",$request->DP_num)->delete();
            return redirect('/admin/Department')->with(["msg"=>"科系資料刪除成功"]);
        }
    }
}
