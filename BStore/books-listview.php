<?php
include_once "function.php"; // All Function
include_once "includes/header.php"; // Header
include_once "includes/navbar.php"; // Navbar

if (!isset($_SESSION['email'])) {
    header("location:login.php");
    exit();
}

$obj = new operation;

// Fetch authors and publications
$auth_list = QB::query("SELECT * FROM authors")->get();

// Prepare the query for publications based on selected author
$pub_list = [];
if (isset($_GET['athr']) && $_GET['athr'] != "") {
    // Fetch publications filtered by the selected author
    $pub_list = QB::query("SELECT * FROM publications WHERE auth_id = ?", [$_GET['athr']])->get();
} else {
    // Fetch all publications if no author is selected
    $pub_list = QB::query("SELECT * FROM publications")->get();
}

$athrStr = ""; 

if (isset($_GET["search"])) {
    $aname = $_GET["athr"];
    $pname = $_GET["pname"] ?? ""; 
    $book_id = $_GET["book_id"] ?? "";
    $price = $_GET["price"];
    $status = $_GET["status"];
    $athrArr = array();

    if ($aname != "") {
        $athrArr[] = "t1.auth_id = '{$aname}'";
    }
    if ($pname != "") {
        $athrArr[] = "t1.pub_id = '{$pname}'";
    }
    if ($book_id != "") {
        $athrArr[] = "t1.id = '{$book_id}'";
    }
    if ($price != "") {
        $athrArr[] = "t1.price = '{$price}'";
    }

    // Check if status is set and valid
    if ($status !== "" && ($status === "2" || $status === "1")) {
        $athrArr[] = "t1.status = '{$status}'";
    }

    if (!empty($athrArr)) {
        $athrStr = " AND " . implode(" AND ", $athrArr);
    }
}

$list = QB::query("SELECT 
        t1.*, 
        t2.auth_name as aname, 
        t3.pub_name as pname 
    FROM books t1 
    LEFT JOIN authors t2 ON t1.auth_id = t2.id 
    LEFT JOIN publications t3 ON t1.pub_id = t3.id
    WHERE t1.id <> 0{$athrStr}")->get();

// Fetch return statuses for dropdown
$status = $obj->return_status();
?>

<!-- HTML Content Here -->

<div id="layoutSidenav">
    <?php include_once "includes/sidenav.php"; ?><!-- Side Navbar -->
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <div class="card mb-4">
                <form action="" method="get" class="needs-validation">
                    <div class="row g-3 justify-content-end m-2">
                        
                        <!-- Authors Dropdown -->
                        <div class="col-md-3">
                            <div class="form-group">
                               <!--<label for="aname" class="form-label">Authors</label>-->
                                <select name="athr" id="aname" class="form-select">
                                    <option value="">Authors</option>
                                    <?php foreach ($auth_list as $alist) { ?>
                                        <option value="<?php echo $alist->id; ?>" <?php if (isset($_GET['athr']) && $_GET['athr'] == $alist->id) { echo "selected"; } ?>>
                                            <?php echo $alist->auth_name; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <!-- Publications Dropdown -->
                        <div class="col-md-3">
                            <div class="form-group">
                               <!--<label for="pname" class="form-label">Publications</label>-->
                                <select name="pname" id="pname" class="form-select">
                                    <option value="">Publications</option>
                                    <?php foreach ($pub_list as $plist) { ?>
                                        <option value="<?php echo $plist->id; ?>" <?php if (isset($_GET['pname']) && $_GET['pname'] == $plist->id) { echo "selected"; } ?>>
                                            <?php echo $plist->pub_name; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <!-- Books Dropdown -->
                        <div class="col-md-2">
                            <div class="form-group">
                               <!-- <label for="book_id" class="form-label">Books</label>-->
                                <select name="book_id" id="book_id" class="form-select">
                                    <option value="">Book</option>
                                    <?php
                                    if (isset($pname) && $pname != "") {
                                        // Fetch books for selected publication
                                        $books = QB::query("SELECT * FROM books WHERE pub_id = ?", [$pname])->get();
                                        foreach ($books as $book) {
                                            ?>
                                            <option value="<?php echo $book->id; ?>" <?php if (isset($_GET['book_id']) && $_GET['book_id'] == $book->id) { echo "selected"; } ?>>
                                                <?php echo $book->bname; ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- Advanced Search Toggle Button -->
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" id="toggleAdvancedSearch" class="btn btn-success w-100">Advanced Search</button>
                        </div>

                        <!-- Search Button -->
                        <div class="col-md-2 d-flex align-items-end">
                            <input type="submit" class="btn btn-primary w-100" name="search" value="Search">
                        </div>

                        <!-- Advanced Search Fields -->
                        <div id="advancedSearchFields" class="row g-3 mt-3" style="display: none;">
                            <!-- Price Field -->
                            <div class="col-md-3">
                                <div class="form-group">
                                   <!-- <label for="price" class="form-label">Price</label>-->
                                    <input type="text" name="price" placeholder="Enter price" id="price" class="form-control" 
                                        value="<?php echo isset($_GET['price']) ? $_GET['price'] : ''; ?>">
                                </div>
                            </div>

                            <!-- Status Dropdown -->
                            <div class="col-md-3">
                                <div class="form-group">
                                   <!-- <label for="status" class="form-label">Status</label>-->
                                    <select name="status" id="status" class="form-select">
                                        <option value="">Select Status</option>
                                        <?php foreach ($status as $key => $value) { ?>
                                            <option value="<?php echo $key; ?>" 
                                                <?php if (isset($_GET['status']) && $_GET['status'] == $key) { echo "selected"; } ?>>
                                                <?php echo $value; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div><i class="fas fa-table me-1"></i> Books Name</div>
                        <div><a href="books-add.php" class="btn btn-sm btn-primary">New Books</a></div>
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Books Name</th>
                                    <th>Authors Name</th>
                                    <th>Publications Name</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Date & Time</th>
                                    <th>Action</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Books Name</th>
                                    <th>Authors Name</th>
                                    <th>Publications Name</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Date & Time</th>
                                    <th>Action</th>
                                    <th>Details</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php $i = 1;
                                foreach ($list as $row) { ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $row->bname; ?></td>
                                        <td><?php echo $row->aname; ?></td>
                                        <td><?php echo $row->pname; ?></td>
                                        <td><?php echo $row->price; ?></td>
                                        <td><?php echo $obj->check_status($row->status); ?></td>
                                        <td><?php echo '<img src="Images/' . $row->img . '" style="width: 50px; height: 50px;">'; ?></td>
                                        <td><?php echo $obj->formatDateTime($row->date); ?></td>
                                        <td>
                                            <a class="btn btn-warning btn-sm" href="books-update.php?id=<?php echo $row->id; ?>"><i class="fas fa-edit"></i></a>
                                            <a class="btn btn-danger btn-sm" href="books-delete.php?id=<?php echo $row->id; ?>"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                        <td><a href="books_details.php?id=<?php echo $row->id; ?>" class="btn btn-primary btn-sm">Details</a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <?php include_once "includes/footer.php"; ?>
    </div>
</div>

<script>
$(document).ready(function () {
    // On Author Change - Fetch Publications
    $('#aname').on('change', function () {
        var auth_id = $(this).val();
        $.ajax({
            url: "ajaxinfo.php",
            type: "POST",
            data: { auth_id: auth_id },
            success: function (res) {
                // Populate publications based on selected author
                $('#pname').html(res);
                // Reset books dropdown
                $('#book_id').html("<option value=''>Select Book</option>");
            }
        });
    });

    // On Publication Change - Fetch Books
    $('#pname').on('change', function () {
        var pub_id = $(this).val();
        $.ajax({
            url: "ajaxinfo.php",
            type: "POST",
            data: { pub_id: pub_id },
            success: function (res) {
                $('#book_id').html(res);
            }
        });
    });

    // Toggle advanced search
    document.getElementById('toggleAdvancedSearch').addEventListener('click', function() {
    var advancedSearchFields = document.getElementById('advancedSearchFields');
    
    if (advancedSearchFields.style.display === 'none' || advancedSearchFields.style.display === '') {
        advancedSearchFields.style.display = 'flex'; 
    } else {
        
        var inputs = advancedSearchFields.querySelectorAll('input, select');
        var allEmpty = Array.from(inputs).every(input => input.value === '');
        
        if (allEmpty) {
            advancedSearchFields.style.display = 'none';
        }
    }
});


function checkAdvancedSearchFields() {
    var advancedSearchFields = document.getElementById('advancedSearchFields');
    var inputs = advancedSearchFields.querySelectorAll('input, select');
    var anyFilled = Array.from(inputs).some(input => input.value !== '');

    if (anyFilled) {
        advancedSearchFields.style.display = 'flex';
    } else {
        advancedSearchFields.style.display = 'none'; 
    }
}


window.onload = function() {
    checkAdvancedSearchFields();
};
});

</script>

</body>
</html>
