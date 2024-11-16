<?php 
include_once("function.php"); // All Function
include_once("includes/header.php"); // Header
include_once("includes/navbar.php"); // Navbar

if (!isset($_SESSION['email'])) {
    header("location:login.php");
    exit();
}

$auth_list = QB::query("SELECT * FROM authors")->get(); // Fetch all authors

$obj = new operation;
if(isset($_POST["update"])){
    $obj->update_books($_POST);
    }
$status= $obj->return_status();

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];
    $list = QB::query("SELECT * FROM books WHERE id=$book_id")->first(); // Fetch the book details
}
?>
<div id="layoutSidenav">
          <?php include_once "includes/sidenav.php"; ?><!--Side_Navbar-->
            <div id="layoutSidenav_content">
                <main>
                <div class="container-fluid px-4">
                <div class="row align-items-center d-flex flex-column fw-light">
                <div class="col-md-6 mt-1">
                    <h5 class="mb-2 text-uppercase fs-5 text-success text-center fw-light">Update Book</h5>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-2">
                            <label for="bname" class="form-label m-3">Books Name</label>
                            <input type="text" name="bname" id="bname" class="form-control fw-light"  value="<?php if(!empty($list->bname)){echo $list->bname; } ?>" required>
                        </div>
                        <!-- Authors Dropdown -->
                        <div class="mb-2">
                            <label for="aname" class="form-label">Authors Name</label>
                            <select name="aname" id="aname" class="form-select fw-light" required>
                                <option value="" disabled selected>===Select Authors===</option>
                                <?php foreach($auth_list as $alist): ?>
                                    <option value="<?php echo $alist->id; ?>" 
                                        class="fw-light" 
                                        <?php if($list->auth_id == $alist->id) echo 'selected'; ?>>
                                        <?php echo $alist->auth_name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- Publications Dropdown -->
                        <div class="mb-2">
                            <label for="pname" class="form-label">Publications Name</label>
                            <select name="pname" id="pname" class="form-select fw-light" required>
                                <option value="" disabled selected>=== Publications ===</option>
                            </select>
                        </div>
                        <!-- Price -->
                        <div class="mb-2">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" name="price" id="price" class="form-control fw-light" value="<?php echo $list->price; ?>" required>
                        </div>
                        <!-- Status -->
                        <div class="mb-2">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select fw-light" required>
                                <option value="" disabled selected>=== Select Status ===</option>
                                <?php foreach($status as $key=>$value){?>
                                    <option value="<?php echo $key; ?>" 
                                        class="fw-light" 
                                        <?php if($list->status == $key) echo 'selected'; ?>>
                                        <?php echo $value; ?>
                                    </option> 
                                <?php }?>
                            </select>
                        </div>
                        <!-- Image -->
                        <div class="mb-2">
                        <label for="image" class="form-label">Upload Image</label>
                        <div class="d-flex align-items-center">
                        <input type="file" name="image" id="image" class="form-control fw-light m-2" value="" >
                        <input type="hidden" name ="oldimg" value="<?php if(!empty($list->img)){echo $list->img; } ?>">
                        <p class="pt-2"><?php  echo '<img src="Images/'.$list->img.'." style="width: 50px;height: 50px;">';?></p>
                        </div>
                        </div>
                        <!-- Date and Time -->
                        <div class="mb-2">
                            <label for="datetime" class="form-label">Date and Time</label>
                            <div class="d-flex align-items-center">
                                <!-- Hidden input for datetime -->
                                <input type="hidden" name="datetime" id="datetime" value="<?php echo !empty($list->date) ? date('Y-m-d\TH:i', strtotime($list->date)) : ''; ?>">
                                
                                <!-- Visible input for user display or update -->
                                <input type="datetime-local" name="datetime_display" id="datetime_display" class="form-control fw-light" value="<?php echo !empty($list->date) ? date('Y-m-d\TH:i', strtotime($list->date)) : ''; ?>" required>
                                

                            </div>
                        </div>


                        <button name="update" class="btn btn-primary btn-sm fw-light">Update Book</button>
                    </form>
                </div>
            </div>
                            </div>
                        </main>
                        <?php include_once "includes/footer-pre.php"; ?><!--Main Footer-->
                    </div> 
                </div>

<?php include_once "includes/footer.php"; ?><!--Footer-->


<script>
 $(document).ready(function() {
        setTimeout(function() {
        $('#aname').change();
    }, 100); 
       // $('#dname').change();
    //
    $('#aname').on('change', function() {
        var a_id = $(this).val();
        let pid = '<?php echo $list->pub_id; ?>';
        $.ajax({
            url: "ajaxinfo.php",
            type: "POST",
            data: {
                a_id: a_id,
                pid: pid
            },
            success: function(res) {
                console.log(res);
                $('#pname').html(res);
            }
        });
    });
});
</script>
