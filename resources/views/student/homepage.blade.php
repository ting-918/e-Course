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
        .filterDiv {
        float: left;
        background-color: mintcream;
        color: #455A64;
        width: 800px;
        line-height: 50px;
        text-align: center;
        margin: 2px;
        display: none;
        }
        .show {
        display: block;
        }
        .container {
        margin-top: 20px;
        overflow: hidden;
        }
        .btn{
            border: none;
            outline: none;
            padding: 12px 16px;
            background-color: #8FBC8f;
            color:#455A64;
            cursor: pointer;
        }
        .btn:hover{
            background-color: #8FBC8f;
            color:white;
        }
        .btn.active{
            background-color:#556B2F;
            color: white;
        }
        .ml3 {
        font-weight: 900;
        font-size: 1.9em;
        color: #556B2F;
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
            padding: 4px;
            border: 0.2px solid #8FBC8f;
            color:#fff;
        }
        td{
            border: 0.2px solid #8FBC8f;
            padding: 3px;
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
    <div class="w3-30% w3-container">
      <h5 class="ml3" style="margin-left:20px">{{ $user->Name }} 歡迎登入選課系統</h5>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
      <div style="background-color:MintCream;">
       <br>
       <div id="myBtnContainer">
        <button style="margin-left:50px;" class="btn active" onclick="filterSelection('所有課程')"> 所有課程</button>
        <button style="margin-left:10px;" class="btn" onclick="filterSelection('已選修')"> 已選修</button>
        <button style="margin-left:10px;" class="btn" onclick="filterSelection('未選修')"> 未選修</button>
       </div>
        <div class="container">
        <div style="margin-left:220px" class="filterDiv 所有課程">@php
        {
            if($all != []){
                echo "<table>
                    <thead>
                    <tr>
                    <th>課程</th>
                    <th>課程號</th>
                    <th>學分數</th>
                    <th>狀態</th>
                    <th>成績</th>
                    </tr></thead><tbody>";
                foreach($all as $a)
                    echo "<tr>
                        <td>$a[CS]</td>
                        <td>$a[CS_num]</td>
                        <td>$a[Credit]</td>
                        <td>$a[status]</td>
                        <td>$a[Grade]</td>
                        </tr>";
                echo "</tbody></table>";
            }
            else echo "<br>
                       <center><h4 style='color:#455A64'>尚未開放選課</h4></center>
                       <br>";
        }
        @endphp </div>
        <div style="margin-left:220px" class="filterDiv 已選修">@php
        {
            if(!$selected->isEmpty()){
                echo "<table>
                    <thead>
                    <tr>
                    <th>課程</th>
                    <th>課程號</th>
                    <th>學分數</th>
                    <th>狀態</th>
                    <th>成績</th>
                    </tr></thead><tbody>";
                foreach($all as $a)
                    if($a['status']=="已選修")
                        echo "<tr>
                            <td>$a[CS]</td>
                            <td>$a[CS_num]</td>
                            <td>$a[Credit]</td>
                            <td>$a[status]</td>
                            <td>$a[Grade]</td>
                            </tr>";
                echo "</tbody></table>";
            }
            else if($all != []){
                echo "<br>
                      <center><h4 style='color:#455A64'>尚未選修任何課程</h4></center>
                      <br>";
            }
            else{
                echo "<br>
                      <center><h4 style='color:#455A64'>尚未開放選課</h4></center>
                      <br>";
            }
        }
        @endphp </div>
        <div style="margin-left:220px" class="filterDiv 未選修">@php
        {
            if(!$unselected->isEmpty()){
                echo "<table>
                    <thead>
                    <tr>
                    <th>課程</th>
                    <th>課程號</th>
                    <th>學分數</th>
                    <th>狀態</th>
                    <th>成績</th>
                    </tr></thead><tbody>";
                foreach($all as $a)
                    if($a['status']=="未選修")
                        echo "<tr>
                            <td>$a[CS]</td>
                            <td>$a[CS_num]</td>
                            <td>$a[Credit]</td>
                            <td>$a[status]</td>
                            <td>$a[Grade]</td>
                            </tr>";
                echo "</tbody></table>";
            }
            else if($all != []){
                echo "<br>
                      <center><h4 style='color:#455A64'>您已選修所有課程</h4></center>
                      <br>";
            }
            else {
                echo "<br>
                      <center><h4 style='color:#455A64'>尚未開放選課</h4></center>
                      <br>";
            }
        }
        @endphp </div>
       </div>
       <br>
      </div>
    </div>
  </div>
<!-- END MAIN -->
</div>

<script>
filterSelection("所有課程")
function filterSelection(c) {
    var x, i;
    x = document.getElementsByClassName("filterDiv");
    if (c == "all") c = "";
    for (i = 0; i < x.length; i++) {
        w3RemoveClass(x[i], "show");
        if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "show");
    }
}
// Add active class to the current button (highlight it)
var btnContainer = document.getElementById("myBtnContainer");
var btns = btnContainer.getElementsByClassName("btn");
for (var i = 0; i < btns.length; i++) {
    btns[i].addEventListener("click", function(){
    var current = document.getElementsByClassName("active");
    current[0].className = current[0].className.replace(" active", "");
    this.className += " active";
    });
}
function w3AddClass(element, name) {
    var i, arr1, arr2;
    arr1 = element.className.split(" ");
    arr2 = name.split(" ");
    for (i = 0; i < arr2.length; i++) {
    if (arr1.indexOf(arr2[i]) == -1) {element.className += " " + arr2[i];}
    }
}
function w3RemoveClass(element, name) {
    var i, arr1, arr2;
    arr1 = element.className.split(" ");
    arr2 = name.split(" ");
    for (i = 0; i < arr2.length; i++) {
        while (arr1.indexOf(arr2[i]) > -1) {
            arr1.splice(arr1.indexOf(arr2[i]), 1);
        }
    }
    element.className = arr1.join(" ");
}
// Wrap every letter in a span
var textWrapper = document.querySelector('.ml3');
textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

anime.timeline({loop: true})
  .add({
    targets: '.ml3 .letter',
    opacity: [0,1],
    easing: "easeInOutQuad",
    duration: 2250,
    delay: (el, i) => 150 * (i+1)
  }).add({
    targets: '.ml3',
    opacity: 0,
    duration: 1000,
    easing: "easeOutExpo",
    delay: 1000
  });
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
</script>

</body>
</html>
