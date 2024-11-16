<?php 
include_once("includes/connect.php");  
if(isset($_GET["id"])) {
    $id = $_GET["id"];
    $list = QB::table('publications')->where('id', '=', $id)->delete();
    if($list){
        header("location:publications-listview.php");
        exit();
    }else{
        //echo "Not deleted";
        header("location:publications-listview.php");
        exit();
    }
}
?>