<?php include_once "function.php"; ?><!--All Function-->

<?php 
if (!isset($_SESSION['email'])){
  header("location:login.php");
} 
if(isset($_GET["id"])) {
    $id = $_GET["id"];
    $list = QB::table('authors')->where('id', '=', $id)->delete();
    if($list){
        header("location:authors-listview.php");
        exit();
    }else{
        //echo "Not deleted";
        header("location:authors-listview.php");
        exit();
    }
}
?>