<?php

include('DataBase.php');

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>
    <style>

.container2{
    position: relative;
    left:50%;
    transform: translate(-50%,-50%);
    width:90%;
    height:27rem;
    padding:50px;
    margin-top: 27rem;
    background-color:azure;
    box-shadow: 0 30px 50px #dbdbdb;
    margin-bottom: -10rem
}
#slide2{
    width:max-content;
    margin-top:50px;
}
.item2{
    width:200px;
    height:300px;
    background-position: 50% 50%;
    display: inline-block;
    transition: 0.5s;
    background-size: cover;
    position: absolute;
    
    top:50%;
    transform: translate(0,-50%);
    border-radius: 20px;
    box-shadow:  0 30px 50px #505050;
}
.item2:nth-child(1),
.item2:nth-child(2){
    left:0;
    top:0;
    transform: translate(0,0);
    border-radius: 0;
    width:0%;
    height:0%;
    box-shadow: none;
}
.item2:nth-child(3){
    left:50%;
}
.item2:nth-child(4){
    left:calc(50% + 220px);
}
.item2:nth-child(5){
    left:calc(50% + 440px);
}
.item2:nth-child(n+6){
    left:calc(50% + 660px);
    opacity: 0;
}
.item2 .content{
    position: absolute;
    top:50%;
    left:100px;
    width:300px;
    text-align: left;
    padding:0;
    color:#eee;
    transform: translate(0,-50%);
    display: none;
    font-family: system-ui;
}
.item2:nth-child(2) .content{
    display: block;
    z-index: 11111;
}
.item2 .name{
    font-size: 40px;
    font-weight: bold;
    opacity: 0;
    animation:showcontent 1s ease-in-out 1 forwards
}
.item2 .des{
    margin:20px 0;
    opacity: 0;
    animation:showcontent 1s ease-in-out 0.3s 1 forwards
}
.item2 button{
    padding:10px 20px;
    border:none;
    opacity: 0;
    animation:showcontent 1s ease-in-out 0.6s 1 forwards
}
@keyframes showcontent{
    from{
        opacity: 0;
        transform: translate(0,100px);
        filter:blur(33px);
    }to{
        opacity: 1;
        transform: translate(0,0);
        filter:blur(0);
    }
}
.buttons2{
    position: absolute;
    bottom:30px;
    z-index: 222222;
    text-align: center;
    width:100%;
}
.buttons2 button{
    width:50px;
    height:50px;
    border-radius: 50%;
    border:1px solid #555;
    transition: 0.5s;
}.buttons2 button:hover{
    background-color: #bac383;
}
  
@media (max-width: 600px) {
   .container2 {
      position: relative;
      left: 50%;
      transform: translate(-50%,-50%);
      width: 90%;
      height: 20rem;
      padding: 20px;
      margin-top: 20rem;
      background-color: azure;
      box-shadow: 0 30px 50px #dbdbdb;
      margin-bottom: -10rem;
  }
  #slide2{
    width:max-content;
    margin-top:50px;
}
.item2{
    width:150px;
    height:217px;
    background-position: 50% 50%;
    display: inline-block;
    transition: 0.5s;
    background-size: cover;
    position: absolute;
    top:36%;
    transform: translate(0,-50%);
    border-radius: 20px;
    box-shadow:  0 30px 50px #505050;
}
.item2:nth-child(1),

.item2 .content{
    position: absolute;
    top:50%;
    left:100px;
    width:300px;
    text-align: left;
    padding:0;
    color:#eee;
    transform: translate(0,-50%);
    display: none;
    font-family: system-ui;
}
.item2:nth-child(1),
.item2:nth-child(2){
    left:0;
    top:0;
    transform: translate(0,0);
    border-radius: 0;
    width:0%;
    height:0%;
    box-shadow: none;
}
.item2:nth-child(3){
    left:25%;
}
.item2:nth-child(4){
    left:calc(25% + 160px);
}
.item2:nth-child(5){
    display: none;
}

.item2:nth-child(n+6){
 display: none;
}

.buttons2{
    position: absolute;
    bottom:30px;
    z-index: 222222;
    text-align: center;
    width:100%;
}
.buttons2 button{
    width:50px;
    height:50px;
    border-radius: 50%;
    border:1px solid #555;
    transition: 0.5s;
}.buttons2 button:hover{
    background-color: #bac383;
}
  
 }
    </style>

<?php
//importer les 8 derniers livres dans la base
$row_per_page2 = 8;

$sql202 = 'select * from livres';
$records2 = mysqli_query($conn, $sql202);

$nr_of_rows2 = mysqli_num_rows($records2);

$pages2 = ceil($nr_of_rows2 / $row_per_page2);

$start2 = max(0, $nr_of_rows2 - 8);
$sql2 = "SELECT * FROM livres LIMIT $start2, $row_per_page2";
$result2 = mysqli_query($conn, $sql2);
?>



<div class="container2">

  <div id="slide2">
<?php  if ($result2->num_rows > 0)  {

while ($row = $result2->fetch_assoc()) {
    echo '<div class="item2" style="background-image: url(data:image/jpeg;base64,' . base64_encode($row['Image']) . ');">';
    echo '</div>';
   
}
}
?>

</div>
        <div class="buttons2">
            <button id="prev"><i class="fa-solid fa-angle-left"></i></button>
            <button id="next"><i class="fa-solid fa-angle-right"></i></button>
        </div>
    
</div>

    <script>

    document.getElementById('next').onclick = function(){
    let lists = document.querySelectorAll('.item2');
    document.getElementById('slide2').appendChild(lists[0]);
}
document.getElementById('prev').onclick = function(){
    let lists = document.querySelectorAll('.item2');
    document.getElementById('slide2').prepend(lists[lists.length - 1]);
}
  

    </script>
</body>
</html>
  