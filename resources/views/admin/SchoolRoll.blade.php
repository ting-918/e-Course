<!DOCTYPE html>
<html lang="en">
<head>
<title>教學管理系統</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-brown.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif;}
.w3-sidebar {
  z-index: 3;
  width: 250px;
  top: 43px;
  bottom: 0;
  height: inherit;
}
input {
    padding:3px 15px;
    background:white;
    border:1px solid #8FBC8f;
    font-size: 17px;
    cursor:pointer;
    border-radius: 5px;
}
button.submit{
    border: none;
    outline: none;
    background-color: #556B2F;
    color: white;
    padding: 10px 14px;
    border-radius: 5%;
    font-size: 15.5px;
    cursor: pointer;
}
button:hover{
    background-color: #8FBC8f;
    color:#455A64;
}
button.update{
    border: none;
    outline: none;
    background-color: #8fbc8fa3;
    color:#455A64;
    padding: 10px 14px;
    border-radius: 5%;
    font-size: 15.5px;
    cursor: pointer;
}
button:hover{
    background-color: #556b2fd4;
    color: white;
}
table{
    font-family: 標楷體;
    font-size: 15.5px;
    width: 800px;
    border: none;
    text-align: center;
    border-collapse: collapse;
}
th{
    background-color:#8FBC8f;
    padding: 16px;
    border: 0.2px solid #8FBC8f;
    color:#fff;
}
td{
    border: 0.2px solid #8FBC8f;
    padding: 14px;
    color:#455A64;
}
table tbody {
    display: block;
    height: 280px;
    overflow: scroll;
}
table thead {
    width: calc( 100% - 1em)
}
table thead,
tbody tr {
    display: table;
    width: 100%;
    table-layout: fixed;
}
.ml3 {
    font-weight: 900;
    font-size: 2em;
    color: #556B2F;
}
/* The popup window - hidden by default */
*,
*:before,
*:after{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}
.popup{
    background-color:#f0fff0fa;
    border: 1px solid #f1f1f1;
    box-shadow: 10px 10px 7px #556b2fdd;
    width: 420px;
    padding: 50px 50px;
    position: fixed;
    transform: translate(-50%,-50%);
    left: 50%;
    top: 50%;
    border-radius: 8px;
    text-align: center;
}
.popup .cancel{
    border: none;
    outline: none;
    background: #cd5c5cfc;
    color: white;
    border-radius: 100%;
    width: 35px;
    height: 35px;
    font-size: 25px;
    cursor: pointer;
    position: absolute;
    top: 5px;
    right: 5px;
}
.popup .cancel:hover{
    background: #cd5c5cce;
}
.popup .submit {
    border: none;
    outline: none;
    background-color: #4683b4f7;
    color: white;
    padding: 10px 14px;
    border-radius: 5%;
    font-size: 15.5px;
    cursor: pointer;
}
.popup .submit:hover{
    background: #4683b4d4;
    color: #ebf3f3;
}
</style>
</head>
<body>

<!-- Navbar -->
<div class="w3-top">
    <div class="w3-bar w3-theme w3-top w3-left-align w3-large">
      <a class="w3-bar-item w3-button w3-right w3-hide-large w3-hover-white w3-large w3-theme-l1" href="javascript:void(0)" onclick="w3_open()"><i class="fa fa-bars"></i></a>
      <a href="/admin" class="w3-bar-item w3-button w3-theme-l1">教學管理系統</a>
      <a href="/logout" class="w3-bar-item w3-button w3-theme-l1 w3-right">登出</a>
    </div>
  </div>

  <!-- Sidebar -->
  <nav class="w3-sidebar w3-bar-block w3-collapse w3-large w3-theme-l5 w3-animate-left" id="mySidebar">
    <a href="javascript:void(0)" onclick="w3_close()" class="w3-right w3-xlarge w3-padding-large w3-hover-black w3-hide-large" title="Close Menu">
      <i class="fa fa-remove"></i>
    </a>
    <h4 class="w3-bar-item"><b>主頁</b></h4>
    <a class="w3-bar-item w3-button w3-hover-black" href="/admin/Course">課程管理</a>
    <a class="w3-bar-item w3-button w3-hover-black" href="/admin/SchoolRoll">學籍管理</a>
    <a class="w3-bar-item w3-button w3-hover-black" href="/admin/Department">科系管理</a>
  </nav>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
<div class="w3-main" style="margin-left:250px">

  <div class="w3-row w3-padding-64">
    <div class="w3-thirdfour w3-container">
        <p class="ml3" style="margin-left:20px">學籍管理
        @php
            if($list != [])
                echo "<button style='float:right;' class='update' onclick='open_window();'>刪除學生</button>
                      </p><br>";
        @endphp
        <form action="/admin/SchoolRoll" method="POST">
        @csrf
        @php
        if($list != []){
            echo "<div style='background-color:MintCream;'>
                <br>
                <center><h5 style='color:#556B2F;'>學生
                <input style='margin-left:10px' type='text' placeholder=' 學號' name='id'>
                <button style='margin-left:10px' class='submit'>查詢</button></center></h5>
                <br>
                </div>";
        }
        @endphp
      </form>
        <div style="background-color:MintCream;">
          <form action="/admin/SchoolRoll_origin" method="POST">
            @csrf
            @php
            if($list == []){
                echo "<br><br><center><h4 style='color:#455A64'>暫無學生</h4></center><br>";
            }
            else{
                echo "<center><table>
                      <thead><tr>
                      <th>姓名</th>
                      <th>學號</th>
                      <th>科系</th>
                      <th>修改</th>
                      </tr></thead><tbody>";
                foreach($list as $l){
                    echo "<tr>
                          <td>$l[Name]</td>
                          <td>$l[STU_num]</td>
                          <td>$l[DP]</td>
                          <td><button class='update' name='origin' value=$l[STU_num]>修改</button></td>";
                }
                echo "</tr></tbody></table></center>";
                }
                echo "<br><center>
                      <button name='origin' value='null' class='submit'>新增</button>
                      </center><br>";
            @endphp
          </form>
        </div>
        <div class='popup' style='display: none;' id='popWindow_2'>
            <button id='close'class='cancel' onclick='close_window_2();'>&times;</button>
            <center>
            <br>
            <form action="/admin/SchoolRoll_drop" method="POST">
            @csrf
                <h5 style='color:#556B2F;'>學生
                <input style='margin-left:10px' type='text' placeholder='輸入待刪除的學生學號' name='STU_num'></h5>
                </center>
                <br>
                <button class='submit'>確認</button>
                <br>
            </form>
        </div>
          @php
            if($popup == "1" ){
                echo"<div class='popup' style='display: block;' id='popWindow_1'>
                     <button id='close'class='cancel' onclick='close_window();'>&times;</button>
                     <center><br>";
            }
          @endphp
          <form action="/admin/SchoolRoll_update"  method="POST" class="form-container">
          @csrf
          @php
            if($popup == "1" ){
                if($current != null)
                    echo" <input type='hidden' name='origin' value=$current[STU_num]>
                          <h5 style='color:#556B2F;'>姓名
                          <input style='margin-left:10px' type='text' placeholder=$current[Name] name='Name'></h5>
                          <h5 style='color:#556B2F;'>學號
                          <input style='margin-left:10px' type='text' placeholder=$current[STU_num] name='STU_num'></h5>
                          <h5 style='color:#556B2F;'>科系
                          <input style='margin-left:10px' type='text' placeholder=$current[DP] name='DP'></h5>";
                else
                    echo" <input type='hidden' name='origin' value='null'>
                          <h5 style='color:#556B2F;'>姓名
                          <input style='margin-left:10px' type='text' placeholder='學生姓名' name='Name'></h5>
                          <h5 style='color:#556B2F;'>學號
                          <input style='margin-left:10px' type='text' placeholder='學號' name='STU_num'></h5>
                          <h5 style='color:#556B2F;'>科系
                          <input style='margin-left:10px' type='text' placeholder='所屬科系(系名/系碼)' name='DP'></h5>";
                echo"</center><br>
                     <button class='submit'>確認</button>
                     <br></div>";
            }
          @endphp
          </form>
        <script>
            function close_window(){
                document.getElementById("popWindow_1").style.display = "none";
            }
            function open_window(){
                document.getElementById("popWindow_2").style.display = "block";
            }
            function close_window_2(){
                document.getElementById("popWindow_2").style.display = "none";
            }
        </script>
    </div>
  </div>


<!-- END MAIN -->
</div>

<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
    overlayBg.style.display = "none";
  } else {
    mySidebar.style.display = 'block';
    overlayBg.style.display = "block";
  }
}

// Close the sidebar with the close button
function w3_close() {
  mySidebar.style.display = "none";
  overlayBg.style.display = "none";
}
window.onload = function() {
    if({{ !is_null($check) }}){
        alert("{{ $check }}");
    }
    {{ session()->forget('msg'); }}
}
</script>

</body>
</html>
