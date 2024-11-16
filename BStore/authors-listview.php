<?php include_once "function.php"; ?><!--All Function-->

<?php include_once "includes/header.php"; ?><!--Header-->

<?php include_once "includes/navbar.php"; ?><!--Navbar-->

<?php
 if (!isset($_SESSION['email'])){
    header("location:login.php");
    exit();
  }
  $list = QB::query("SELECT * FROM authors")->get();
  
?>

        <div id="layoutSidenav">
          <?php include_once "includes/sidenav.php"; ?><!--Side_Navbar-->
            <div id="layoutSidenav_content">
                <main>
                <div class="container-fluid px-4">
                        <h1 class="mt-4">Authors</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item active">Authors</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <div><i class="fas fa-table me-1"></i>
                                  Authors Name
                                </div>
                                <div><a href="authors-add.php" class="btn btn-sm btn-primary">New Authors</a></div>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Authors Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                          <th>ID</th>
                                          <th>Authors Name</th>
                                          <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php $i = 1; foreach($list as $row){?>
                                     <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $row->auth_name; ?></td>
                                        <td>
                                        <a class="btn btn-warning btn-sm" href=authors-update.php?id=<?php echo $row->id; ?>"><i class="fas fa-edit"></i></a>
                                        <a class="btn btn-danger btn-sm" href="authors-delete.php?id=<?php echo $row->id; ?>"><i class="fas fa-trash"></i></a>
                                        </td>
                                     </tr>
                                       <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <?php include_once "includes/footer-pre.php"; ?><!--Main Footer-->
            </div> 
        </div>

<?php include_once "includes/footer.php"; ?><!--Footer-->
