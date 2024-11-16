<?php 
include_once("includes/connect.php");  
if(isset($_GET["id"])) {
    $id = $_GET["id"];
    $list = QB::table('books')->where('id', '=', $id)->delete();
    if($list){
        header("location:books-listview.php");
        exit();
    }else{
        //echo "Not deleted";
        header("location:books-listview.php");
        exit();
    }
}
?>