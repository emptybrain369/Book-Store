<?php
session_start();   
?>
<?php  $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;?>

<?php include_once "includes/connect.php"; ?><!--DB Connection-->

<?php
class operation{

    function return_pagination($current_page,$start_page,$end_page,$total_pages){
        $code= '<nav>';
        $code .= '<ul class="pagination justify-content-center">';
            // <!-- First Page Button -->
        $code .= '     <li class="page-item ';
            if ($current_page == 1) 
            {$code .=  'disabled';}
            $code .=   '">
                <a class="page-link" href="?page=1">First</a>
            </li>';
    
        /*    <!-- Previous Page Button --> */
        $code .=   '    <li class="page-item ';
            if ($current_page == 1) 
            {  $code .=    'disabled'; 
            }
            $code .=   ' ">
                <a class="page-link" href="?page=';
                $code .=    max(1, $current_page - 1); 
                $code .=   ' ">Previous</a>
            </li>';
    
            // <!-- Page Numbers -->
            for ($i = $start_page; $i <= $end_page; $i++) {
                $code .=   ' <li class="page-item ';
        if ($i == $current_page)
        {  $code .=  'active';}
                $code .=  '  ">';
                $code .=   '  <a class="page-link" href="?page=';
                $code .=  $i; 
                    $code .=   ' ">';
                    $code .=  $i; 
                    $code .=   '</a>
                </li>';
            } 
    
        /*    // <!-- Next Page Button --> */
            $code .=   ' <li class="page-item ';
        if ($current_page == $total_pages){ 
            $code .=  'disabled'; 
        }
            $code .=   '   ">';
            $code .=   '    <a class="page-link" href="?page=';
            $code .=  min($total_pages, $current_page + 1); 
                $code .=   '    ">Next</a>
            </li>';
    
            // <!-- Last Page Button -->
        $code .=   '    <li class="page-item';
            if ($current_page == $total_pages){
                $code .= 'disabled';
                } 
            $code .=   '   ">
                <a class="page-link" href="?page=';
                $code .=  $total_pages; 
            $code .=   '    ">Last</a>
            </li>
        </ul>
    </nav>';
    return  $code ;
    }
    function get_val($per_page_val,$table,$current_page_num){
    $records_per_page = $per_page_val; // Number of records per page
    $total_records = QB::query("SELECT COUNT(*) as count FROM $table")->first()->count; // Get total number of records
    $total_pages = ceil($total_records / $records_per_page); // Calculate total pages

    // Get the current page number
    /* $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1; */
    $current_page = max(1, min($current_page_num, $total_pages)); // Ensure current page is valid

    // Determine the range of pages to display
    $start_page = max(1, $current_page - 2);
    $end_page = min($total_pages, $start_page + 4);

    // Adjust the range if the total pages are less than 5
    if ($end_page - $start_page < 4) {
        $start_page = max(1, $end_page - 4);
    }

    // Fetch records for the current page
    $offset = ($current_page - 1) * $records_per_page;
    return array('offset'=>$offset,'records_per_page'=>$records_per_page,'current_page'=>$current_page,'start_page'=>$start_page,'end_page'=>$end_page,'total_pages'=>$total_pages);
    }
    

    public function set_register($post){
        $fname = $post["fname"];
        $lname = $post["lname"];
        $name = $fname . ' ' . $lname;
        $password = $post["password"];
        $cpassword = $post["cpassword"];
        if($password===$cpassword){
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        }else{
           // echo "Passwords do not match!";
            header("location: register.php"); 
            exit();
    
        }
        $data = array(
            "aname" => $name,
            "email" => $post["email"],
            "password" => $hashedPassword,
            "status" => 2
        );
        $list = QB::table('admin')->insert($data); 
        if($list){
             // Data Successfully Inserted."; 
            header("location:login.php");
            exit();
        }else{
           // echo "Insertion failed, please try again."; 
            header("location: register.php"); 
            exit();
        }
    }
    public function admin_login($data){
        $email = $data["email"];
        $password = $data["password"];
        //var_dump($data);
        $query= QB::table('admin')->where('email','=',$email);
        $result=$query->first();
        //var_dump($result->password);
        if(!empty($result->password)){
            if(password_verify($password,$result->password)){
                $_SESSION['username']=$result->aname;
                $_SESSION['email']=$result->email;
                //var_dump($_SESSION['username']);
                echo "<script>window.location.href = 'dashboard.php';</script>";
                //echo "Varification Done";
                exit();
            }else{
                //echo "Please Enter Valid Email Or password";
                header("location:login.php");
                exit();
            }
        }else{
            //echo "Please Enter Valid Email Or password";
            header("location:login.php");
            exit();
        }
    }
    public function add_authors($data){
        $aname=!empty($data["aname"]) ? $data["aname"] : NULL;
        if(!empty($aname)){
        $data = array(
            'auth_name' => $aname
        );
        $list = QB::table('authors')->insert($data);
        if($list){
            header("location:authors-listview.php");
            exit();
        }else{
           // echo "Not inserted";
           header("location:authors-add.php");
            exit();
        }
    }
    }
    public function update_authors($data){
        $aname = !empty($data["aname"]) ? $data["aname"] : NULL;
        $id = $_GET["id"];
        $data = array(
            'auth_name' => $aname
        );
        $list = QB::table('authors')->where("id","=",$id)->update($data);
        if($list){
            header("location:authors-listview.php");
            exit();
        }else{
            //echo "Not updated";
            header("location:authors-update.php");
            exit();
        }
    }
    public function add_publications($data){
        $pname = $data["pname"];
        $aname = $data["aname"];
        $data = array(
            "pub_name"=>$pname,
            "auth_id"=>$aname
        );
        $list = QB::table('publications')->insert($data);
        if($list){
            header("location:publications-listview.php");
            exit();
        }else{
           // echo "Not inserted";
           header("location:publications-add.php");
            exit();
        }
    }
    public function update_publications($data){
        $pname  = $data["pname"];
        $aname  = $data["aname"];
        $id = $_GET["id"];
        $data = array(
            "pub_name"=>$pname,
            "auth_id"=>$aname
        );
        $list = QB::table('publications')->where("id","=",$id)->update($data);
        if($list){
            header("location:publications-listview.php");
            exit();
        }else{
           // echo "Not updated";
            header("location:publications-update.php");
            exit();
        }
    }
    public function return_status(){
        return  array(
          '1'=>"Available",
          '2'=>"Unavailable"
        );
    }
    public function check_status($id){
        if($id==2){
            return "Unavailable";
        }else{
            return "Available";
        }
    }
    public function formatDateTime($data) {
        $date = new DateTime($data);
        return $date->format('d-m-Y H:i:s A');
    }
    public function add_books($data){
        $bname = $data["bname"];
        $aname = $data["aname"];
        $pname = $data["pname"];
        $price = $data["price"];
        $status = $data["status"];
        $photo=$_FILES['image']['name'];
        $photocopy =$_FILES['image']['tmp_name'];
        move_uploaded_file($photocopy,"Images/$photo");
        $datetime = $data["datetime"];
        $data = array(
            "bname"=> $bname,
            "auth_id"=> $aname,
            "pub_id"=> $pname,
            "price"=> $price,
            "status"=> $status,
            "img"=>  $photo,
            "date"=>  $datetime
        );
        $list = QB::table('books')->insert($data);
        if($list){
            header("location:books-listview.php");
            exit();
        }else{
           // echo "Not inserted";
           header("location:books-add.php");
            exit();
        }
    }
    public function update_books($data){
        var_dump($data);
        $id = $_GET["id"];
        $bname = $data["bname"];
        $aname = $data["aname"];
        $pname = $data["pname"];
        $price = $data["price"];
        $status = $data["status"];
        $list = QB::query("SELECT * FROM books WHERE id=$id")->first(); // Fetch the book details
        if(!empty($list->img)){
            $photo=$data["oldimg"] ;
            }
            else{
                $photo=$_FILES['image']['name'];
                $photocopy =$_FILES['image']['tmp_name'];
                move_uploaded_file($photocopy,"Images/$photo");
            }
            if(!empty($list->date)){
                $datetime=$data["datetime"] ;
                }
                else{
                    $datetime=$data["datetime_display"] ;  
                }
        $data = array(
            "bname"=> $bname,
            "auth_id"=> $aname,
            "pub_id"=> $pname,
            "price"=> $price,
            "status"=> $status,
            "img"=>  $photo,
            "date"=>  $datetime
        );
        $list = QB::table('books')->where("id","=",$id)->update($data);
        if($list){
            header("location:books-listview.php");
            exit();
        }else{
           // echo "Not inserted";
           header("location:books-listview.php");
            exit();
        }
    } 
}
?>