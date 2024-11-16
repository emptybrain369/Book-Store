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
$obj=new operation;
if(isset($_POST["submit"])){
$obj->add_authors($_POST);
  }
?>

        <div id="layoutSidenav">
          <?php include_once "includes/sidenav.php"; ?><!--Side_Navbar-->
            <div id="layoutSidenav_content">
                <main>
                            <div class="row align-items-center d-flex flex-column text-center fw-light">
                                <div class="col-md-6 mt-5">
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="mb-3 mt-5">
                                        <label for="aname" class="label-control mb-2 text-uppercase fs-5 text-primary">Add Authors</label>
                                        <input type="text" name="aname" id="aname" class="form-control" required>
                                        </div>
                                        <div class="d-grid gap-2">
                                            <button class="btn btn-primary fw-light" type="submit" name="submit">Add Authors</button>
                                        </div>
                                    </form>
                                </div>
                            </div>  
                </main>
                <?php include_once "includes/footer-pre.php"; ?><!--Main Footer-->
            </div> 
        </div>

<?php include_once "includes/footer.php"; ?><!--Footer-->
