<!DOCTYPE html>
<html lang="en">
<head>
<title>學生選課系統</title>
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
    overflow-y: scroll;
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
</style>
</head>
<body>

<!-- Navbar -->
<div class="w3-top">
    <div class="w3-bar w3-theme w3-top w3-left-align w3-large">
      <a class="w3-bar-item w3-button w3-right w3-hide-large w3-hover-white w3-large w3-theme-l1" href="javascript:void(0)" onclick="w3_open()"><i class="fa fa-bars"></i></a>
      <a href="/student" class="w3-bar-item w3-button w3-theme-l1">學生選課系統</a>
      <a href="/logout" class="w3-bar-item w3-button w3-theme-l1 w3-right">登出</a>
    </div>
  </div>

  <!-- Sidebar -->
  <nav class="w3-sidebar w3-bar-block w3-collapse w3-large w3-theme-l5 w3-animate-left" id="mySidebar">
    <a href="javascript:void(0)" onclick="w3_close()" class="w3-right w3-xlarge w3-padding-large w3-hover-black w3-hide-large" title="Close Menu">
      <i class="fa fa-remove"></i>
    </a>
    <h4 class="w3-bar-item"><b>主頁</b></h4>
    <a class="w3-bar-item w3-button w3-hover-black" href="/student/add_CS">加選課程</a>
    <a class="w3-bar-item w3-button w3-hover-black" href="/student/drop_CS">退選課程</a>
  </nav>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
<div class="w3-main" style="margin-left:250px">

  <div class="w3-row w3-padding-64">
    <div class="w3-thirdfour w3-container">
      <form action="/student/drop_CS" method="post">
      @csrf
        <h5 class="ml3" style="margin-left:20px">退選課程</h5>
        <div style="background-color:MintCream;">
          <br>@php
            if($list->isEmpty()){
                echo "<br><br><center><h4 style='color:#455A64'>尚未選修任何課程</h4></center><br>";
            }
            else{
                echo "<center><table class='multi-table' cellspacing='0' border>
                      <thead><tr>
                      <th>選擇</th>
                      <th>課程</th>
                      <th>課程號</th>
                      <th>學分數</th>
                      </tr></thead><tbody>";
                foreach($list as $l){
                    echo "<tr><td><input type='checkbox' name='select[]' value='$l->CS_num' oninput='clickCheckbox()'></td>
                          <td>$l->CS</td>
                          <td>$l->CS_num</td>
                          <td>$l->Credit</td>
                          </tr>";
                }
                echo "</tbody></table></center><br>
                      <center><h5><button name='operation' value='add' class='submit'>退選</button></h5</center>";
            }
            @endphp
          <br>
          <br>
        </div>
      </form>
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
