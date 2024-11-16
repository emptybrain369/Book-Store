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
$obj = new operation;
$status= $obj->return_status();
if(isset($_POST["submit"])){
    $obj->add_books($_POST);
}
?>

        <div id="layoutSidenav">
          <?php include_once "includes/sidenav.php"; ?><!--Side_Navbar-->
            <div id="layoutSidenav_content">
                <main>
                            <div class="row align-items-center d-flex flex-column text-center fw-light m-3">
                                <div class="col-md-6">
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="mb-2">
                                            <label for="bname" class="form-label">Books Name</label>
                                            <input type="text" name="bname" id="bname" class="form-control" required>
                                        </div>
                                        <div class="mb-2">
                                            <label for="aname" class="form-label">Authors Name</label>
                                            <select name="aname" id="aname" class="form-select fw-light" required>
                                                <option value="" disabled selected class="fw-light">===Authors===</option>
                                                <?php foreach($auth_list as $list) { ?>
                                                    <option value="<?php echo $list->id;?>" class="fw-light"><?php echo $list->auth_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label for="pname" class="form-label">Publications Name</label>
                                            <select name="pname" id="pname" class="form-select fw-light" required>
                                                <option value="" disabled selected class="fw-light">===Publications===</option>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label for="price" class="form-label">Price</label>
                                            <input type="text" name="price" id="price" class="form-control" required>
                                        </div>
                                        <div class="mb-2">
                                            <label for="status" class="form-label">Status</label>
                                            <select name="status" id="status" class="form-select fw-light" required>
                                                <option value="" disabled selected class="fw-light">===Select Status===</option>
                                                <?php foreach($status as $key=>$value){?>
                                                <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label for="image" class="form-label">Upload Image</label>
                                            <input type="file" name="image" id="image" class="form-control" required>
                                        </div>
                                        <div class="mb-2">
                                            <label for="datetime" class="form-label">Date and Time</label>
                                            <input type="datetime-local" name="datetime" id="datetime" class="form-control" placeholder="m-d-y || H:S:M" required>
                                        </div>
                                            <button name="submit" class="btn btn-primary btn-sm fw-light">Add Books</button>
                                    </form>
                                </div>
                            </div>  
                </main>
                <?php include_once "includes/footer-pre.php"; ?><!--Main Footer-->
            </div> 
        </div>

<?php include_once "includes/footer.php"; ?><!--Footer-->
<script>
    $(document).ready(function() {
    $('#aname').on('change', function() { 
        var auth_id = $(this).val();
        $.ajax({
            url: "ajaxinfo.php",
            type: "POST",
            data: {
                auth_id: auth_id
            },
            success: function(res) {
                console.log(res);
                $('#pname').html(res);
            }
        });
    });
});
</script>