<?php include_once "function.php"; ?><!--All Function-->

<?php include_once "includes/header.php"; ?><!--Header-->

<?php include_once "includes/navbar.php"; ?><!--Navbar-->

<?php
 if (!isset($_SESSION['email'])){
    header("location:login.php");
    exit();
  }
?>
<?php
$auth_list = QB::query("SELECT * FROM authors")->get();

if(isset($_GET["id"])) {
    $id = $_GET["id"];
    $list = QB::query("SELECT * FROM publications WHERE id=$id")->first();
}

$obj = new operation;
if(isset($_POST["submit"])){
$obj->update_publications($_POST);
}
?>

        <div id="layoutSidenav">
          <?php include_once "includes/sidenav.php"; ?><!--Side_Navbar-->
            <div id="layoutSidenav_content">
                <main>
                <div class="container-fluid px-4">
                        <div class="row align-items-center d-flex flex-column text-center fw-light mt-5">
                                <div class="col-md-6">
                                <form  method="POST" enctype="multipart/form-data">
                                <div class="mb-2">
                                    <label for="pname" class="form-label">Publications Name</label>
                                    <input type="text" name="pname" id="pname" class="form-control" value="<?php if(!empty($list->pub_name)){echo $list->pub_name; } ?>" required>
                                </div>
                                <div class="mb-2">
                                    <label for="aname" class="form-label">Authors Name</label>
                                    <select name="aname" id="aname" class="form-select fw-light" required>
                                        <option value="" disabled selected class="fw-light">===Select Authors===</option>
                                        <?php foreach($auth_list as $alist){ ?>
                                            <option value="<?php echo $alist->id; ?>" 
                                                class="fw-light" 
                                                <?php if($list->auth_id == $alist->id) echo 'selected'; ?>>
                                                <?php echo $alist->auth_name; ?>
                                            </option>
                                            <?php } ?>
                                    </select>
                                </div>
                                <button name="submit" class="btn btn-primary btn-sm fw-light">Update</button>
                            </form>
                            </div>
                            </div>     
                    </div>
                </main>
                <?php include_once "includes/footer-pre.php"; ?><!--Main Footer-->
            </div> 
        </div>

<?php include_once "includes/footer.php"; ?><!--Footer-->

