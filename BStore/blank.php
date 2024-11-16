<?php
session_start();   
?>

<?php include_once "includes/header.php"; ?><!--Header-->

<?php include_once "includes/navbar.php"; ?><!--Navbar-->

<?php
 if (!isset($_SESSION['email'])){
    header("location:login.php");
    exit();
  }
?>

        <div id="layoutSidenav">
          <?php include_once "includes/sidenav.php"; ?><!--Side_Navbar-->
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                                             
                       
                    </div>
                </main>
                <?php include_once "includes/footer-pre.php"; ?><!--Main Footer-->
            </div> 
        </div>

<?php include_once "includes/footer.php"; ?><!--Footer-->
