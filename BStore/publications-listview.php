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
$obj = new operation;
$per_page_val = 5;
$table = "publications";

$p = $obj->get_val($per_page_val, $table, $current_page);
$offset = $p["offset"];
$records_per_page = $p["records_per_page"];

$auth_list = QB::query("SELECT * FROM authors")->get();

$athrStr = ""; 

if (isset($_GET["search"])) {
    $aname = $_GET["athr"];
    $athrArr = array();
    if ($aname != "") {
        $athrArr[] = "t1.auth_id = '{$aname}'";
    }
    if (!empty($athrArr)) {
        $athrStr = " AND " . implode(" AND ", $athrArr);
    }
}

$list = QB::query("SELECT 
        t1.id, t1.pub_name, t1.auth_id, 
        t2.auth_name AS name
    FROM publications t1 
    LEFT JOIN authors t2 ON t1.auth_id = t2.id 
    WHERE t1.id <> 0{$athrStr}
    LIMIT ?, ?", [$offset, $records_per_page])->get();
?>

        <div id="layoutSidenav">
          <?php include_once "includes/sidenav.php"; ?><!--Side_Navbar-->
            <div id="layoutSidenav_content">
                <main>
                        <div class="card-header d-flex align-items-center justify-content-between p-2">
                            <div><i class="fas fa-table me-1"></i>
                                Publications Name
                            </div>
                            <div><a href="publications-add.php" class="btn btn-sm btn-success">New Publications</a></div>
                        </div>  


                        <div class="container-fluid px-4">
                        <div class="row align-items-center d-flex flex-column text-center fw-light">
                            <div class="col-md-12">

                            <form action="" method="get">
                                <div class="d-flex flex-row mb-3 justify-content-end">
                                <div class="col-md-4">
                                    <select name="athr" class="form-select">
                                        <option value="">Select Authors</option>
                                        <?php foreach($auth_list as $alist){?>
                                          <option value="<?php echo $alist->id; ?>"
																          <?php if (isset($_GET['athr']) && $_GET['athr'] == $alist->id) {
																	          echo "selected";
																            } ?>>
																          <?php echo $alist->auth_name; ?>
															            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="submit" class="btn btn-primary" name="search" value="Search">
                                </div>
                                </div>
                                </form> 


                               <table class="table table-success table-striped-columns table-hover table-bordered border-primary">
                                <thead>
                                    <tr>
                                        <th class="fw-bold">ID</th>
                                        <th class="fw-bold">Publications</th>
                                        <th class="fw-bold">Authors</th>
                                        <th class="fw-bold">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = $offset + 1; // Start numbering
                                    foreach ($list as $row) { ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $row->pub_name; ?></td>
                                            <td><?php echo $row->name; ?></td>
                                            <td>
                                                <a class="btn btn-warning btn-sm" href="publications-update.php?id=<?php echo $row->id; ?>"><i class="fas fa-edit"></i></a>
                                                <a class="btn btn-danger btn-sm" href="publications-delete.php?id=<?php echo $row->id; ?>"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <?php
                            echo $obj->return_pagination($p["current_page"],$p["start_page"],$p["end_page"],$p["total_pages"]);          
                            ?>
                        </div>
                        </div>     
                    </div>
                </main>
                <?php include_once "includes/footer-pre.php"; ?><!--Main Footer-->
            </div> 
        </div>

<?php include_once "includes/footer.php"; ?><!--Footer-->
