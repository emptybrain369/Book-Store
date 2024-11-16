<?php
include_once("function.php");
include_once("includes/header.php");
include_once("includes/navbar.php");

if (!isset($_SESSION['email'])) {
    header("location:login.php");
    exit();
}

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];
    $book = QB::query("
        SELECT books.*, authors.auth_name, publications.pub_name 
        FROM books
        JOIN authors ON books.auth_id = authors.id
        JOIN publications ON books.pub_id = publications.id
        WHERE books.id = ?", [$book_id]
    )->first();
}
?>
        <div id="layoutSidenav">
          <?php include_once "includes/sidenav.php"; ?><!--Side_Navbar-->
            <div id="layoutSidenav_content">
                <main>
<div class="container mt-5">
    <?php if (!empty($book)) { ?>
        <h3 class="text-center text-success">Book Details</h3>
        <table class="table table-bordered">
            <tr>
                <th>Book Name:</th>
                <td><?php echo htmlspecialchars($book->bname); ?></td>
            </tr>
            <tr>
                <th>Author Name:</th>
                <td><?php echo htmlspecialchars($book->auth_name); ?></td>
            </tr>
            <tr>
                <th>Publication Name:</th>
                <td><?php echo htmlspecialchars($book->pub_name); ?></td>
            </tr>
            <tr>
                <th>Price:</th>
                <td><?php echo htmlspecialchars($book->price); ?> BDT</td>
            </tr>
            <tr>
                <th>Status:</th>
                <td><?php echo $book->status == 1 ? 'Available' : 'Unabailable'; ?></td>
            </tr>
            <tr>
                <th>Image:</th>
                <td>
                    <?php if (!empty($book->img)) { ?>
                        <img src="Images/<?php echo htmlspecialchars($book->img); ?>" 
                             style="width: 150px; height: 150px;" alt="Book Image">
                    <?php } else { ?>
                        No Image
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <th>Added Date:</th>
                <td><?php echo date('d M Y, h:i A', strtotime($book->date)); ?></td>
            </tr>
        </table>
        <a href="books-listview.php" class="btn btn-primary">Back to List</a>
    <?php } else { ?>
        <h4 class="text-danger text-center">Book Not Found!</h4>
    <?php } ?>
</div>
</main>
                <?php include_once "includes/footer-pre.php"; ?><!--Main Footer-->
            </div> 
        </div>
<?php include_once("includes/footer.php"); ?>
