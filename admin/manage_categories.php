<?php
require('top.inc.php');
$categories = '';
$msg = '';
//$getData = '';
if (isset($_GET['id']) && $_GET['id']) {
   $id = get_safe_value($con, $_GET['id']);
   $res = mysqli_query($con, "select * from categories where id='$id'");//for edit
   $check = mysqli_num_rows($res);
   if($check > 0){
   $row = mysqli_fetch_assoc($res); // for edit code
   $categories = $row['categories']; // for edit code
   } else {
   header('location: categories.php'); // redirect page code 
   die();
   }
}

// if (isset($_POST['submit'])) {
//    $categories = get_safe_value($con, $_POST['categories']);
//    $res = mysqli_query($con, "select * from categories where categories='$categories'");
//    $check=mysqli_num_rows($res);
//    if ($check > 0) {
//       $msg = "Categories already exist";
//    } else {
//       if (isset($_GET['id']) && $_GET['id'] !='') {
//          mysqli_query($con, "update categories set categories='$categories' where id='$id'");
//       }else {
//          mysqli_query($con, "insert into categories(categories, status) values('$categories', '1')");
//       }
//       header("location: categories.php");
//       die();
//    }
// }


//second code start
if (isset($_POST['submit'])) {
   $categories = get_safe_value($con, $_POST['categories']);
   $res = mysqli_query($con, "select * from categories where categories='$categories'");
   $check=mysqli_num_rows($res);
   if ($check > 0) {
      if (isset($_GET['id']) && $_GET['id'] != '') {
         $getData = mysqli_fetch_assoc($res);
         if ($id==$getData['id']) {
         }else{
         $msg = "Categories already exist";
         }

      }else{
      $msg = "Categories already exist";
      }
   } 
   if ($msg=='') {
      if (isset($_GET['id']) && $_GET['id'] !='') {
         mysqli_query($con, "update categories set categories='$categories' where id='$id'");
      }else {
         mysqli_query($con, "insert into categories(categories, status) values('$categories', '1')");
      }
      header("location: categories.php");
      die();
   }
}
//second code end


//add categories item code start
// if (isset($_POST['submit'])) {
//     //$categories = get_safe_value($con, $_POST['categories']);
//     $categories = get_safe_value($con, $_POST['categories']);
//     mysqli_query($con, "INSERT INTO categories (categories, status) values('$categories', '1')");
//     header('location: categories.php');
//     die();
// }
// //add categories item code end

// //categories item edit code start
// if (isset($_GET['id']) && $_GET['id']) {
//    $id = get_safe_value($con, $_GET['id']);
//    $res =mysqli_query($con, "select * from categories where id='$id'");
//    $row = mysqli_fetch_assoc($res);
//    $categories = $row['categories'];
// }

//categories item edit code end
?>

<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Categories</strong><small> Form</small></div>
                        <form method="post">
                             <div class="card-body card-block">
                           <div class="form-group">
                               <label for="categories" class=" form-control-label">Categories</label>
                               <input type="text" id="categories" name="categories" placeholder="Enter Categories name" class="form-control" required value="<?php echo $categories; ?>">
                            </div>
                           <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block" name="submit">
                           <span id="payment-button-amount">Submit</span>
                           </button>
                           <div class="field_error"><?php echo $msg; ?></div>
                        </div>
                        </form>
                       
                     </div>
                  </div>
               </div>
            </div>
         </div>
<?php
require ('footer.inc.php');
?>