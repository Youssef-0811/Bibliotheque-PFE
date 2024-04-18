<?php

include('DataBase.php');

$row_per_page = 16;

$sql0 = 'select * from livres';

$records = mysqli_query($conn,$sql0);

$nr_of_rows = mysqli_num_rows($records); 

$pages = ceil($nr_of_rows / $row_per_page);

$start = 0;

if(isset($_GET['page-nr'])){

$page = $_GET['page-nr'] - 1;

$start = $page * $row_per_page;


}

?>
