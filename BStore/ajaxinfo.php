<?php
include_once "function.php"; // All Function


// Handle AJAX requests for fetching publications and books
if (isset($_POST['auth_id'])) {
    // Fetch publications based on selected author
    $auth_id = $_POST['auth_id'];
    $publications = QB::query("SELECT * FROM publications WHERE auth_id = ?", [$auth_id])->get();

    // Generate HTML for publications dropdown
    $html = "<option value=''>Select Publication</option>";
    foreach ($publications as $pub) {
        $html .= "<option value='{$pub->id}'>{$pub->pub_name}</option>";
    }
    echo $html;
} elseif (isset($_POST['pub_id'])) {
    // Fetch books based on selected publication
    $pub_id = $_POST['pub_id'];
    $books = QB::query("SELECT * FROM books WHERE pub_id = ?", [$pub_id])->get();

    // Generate HTML for books dropdown
    $html = "<option value=''>Select Book</option>";
    foreach ($books as $book) {
        $html .= "<option value='{$book->id}'>{$book->bname}</option>";
    }
    echo $html;
}
?>
<?php

$a_id = $_POST['a_id'];
$pid = $_POST['pid'];
$publications = QB::query("SELECT * FROM publications WHERE auth_id = $a_id")->get();
$output = '<option value="" class="fw-light">All Publications</option>';

foreach ($publications as $plist) {
    if($plist->id==$pid){
        $sec="selected";
    }
    else{
        $sec="";
    }
    $output .= '<option value="'. $plist->id .'" '.$sec.'  class="fw-light">'. $plist->pub_name .'</option>';
}
echo  $output;
?> 



 