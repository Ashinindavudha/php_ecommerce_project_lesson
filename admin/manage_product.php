<?php
require('top.inc.php');
$categories_id = '';
$name = '';
$mrp = '';
$price = '';
$qty = '';
$image = '';
$short_desc = '';
$description = '';
$meta_title = '';
$meta_desc = '';
$meta_keyword = '';
$msg = '';
$image_required = 'required';
//$getData = '';
if (isset($_GET['id']) && $_GET['id']) {
   $image_required = '';
   $id = get_safe_value($con, $_GET['id']);
   $res = mysqli_query($con, "select * from product where id='$id'");//for edit
   $check = mysqli_num_rows($res);
   if($check > 0){
   $row = mysqli_fetch_assoc($res); // for edit code
   $categories_id = $row['categories_id']; // for edit code
   $name = $row['name'];
   $mrp = $row['mrp'];
   $price = $row['price'];
   $qty = $row['qty'];
   $short_desc = $row['short_desc'];
   $description = $row['description'];
   $meta_title = $row['meta_title'];
   $meta_desc = $row['meta_desc'];
   $meta_keyword = $row['meta_keyword'];
   } else {
   header('location: product.php'); // redirect page code 
   die();
   }
}

//second code start
if (isset($_POST['submit'])) {
   $categories_id = get_safe_value($con, $_POST['categories_id']);
   $name = get_safe_value($con, $_POST['name']);
   $mrp = get_safe_value($con, $_POST['mrp']);
   $price = get_safe_value($con, $_POST['price']);
   $qty = get_safe_value($con, $_POST['qty']);
   $short_desc = get_safe_value($con, $_POST['short_desc']);
   $description = get_safe_value($con, $_POST['description']);
   $meta_title = get_safe_value($con, $_POST['meta_title']);
   $meta_desc = get_safe_value($con, $_POST['meta_desc']);
   $meta_keyword = get_safe_value($con, $_POST['meta_keyword']);

   $res = mysqli_query($con, "select * from product where name='$name'");
   $check=mysqli_num_rows($res);
   if ($check > 0) {
      if (isset($_GET['id']) && $_GET['id'] != '') {
         $getData = mysqli_fetch_assoc($res);
         if ($id==$getData['id']) {
         }else{
         $msg = "Product already exist";
         }

      }else{
      $msg = "Product already exist";
      }
   } 
   //image upload validation start
   if ($_FILES['image']['type'] !='' && ($_FILES['image']['type'] !='image/png' || $_FILES['image']['type'] !='image/jpg' || $_FILES['image']['type'] !='image/jpeg')) {
      $msg= "please select only png, jpg and jpeg image format";
   }
   // image upload validation end 
   
   if ($msg=='') {
      if (isset($_GET['id']) && $_GET['id'] !='') {
         if ($_FILES['image']['name'] !=='') {
         $image = rand(111111111, 999999999).'_'. $_FILES['image']['name'];
         //move_uploaded_file($_FILES['image']['tmp_name'], 'media/product/' . $image);
         move_uploaded_file($_FILES['image']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH . $image);
         $update_sql = "update product set categories_id='$categories_id', name='$name', mrp='$mrp', price='$price', qty='$qty', short_desc='$short_desc', description='$description', meta_title='$meta_title', meta_desc='$meta_desc', meta_keyword='$meta_keyword', image='$image' where id='$id'";
         }else{
            $update_sql = "update product set categories_id='$categories_id', name='$name', mrp='$mrp', price='$price', qty='$qty', short_desc='$short_desc', description='$description', meta_title='$meta_title', meta_desc='$meta_desc', meta_keyword='$meta_keyword' where id='$id'";
         }
         mysqli_query($con, $update_sql);
      }else {
         $image = rand(111111111, 999999999).'_'. $_FILES['image']['name'];
         //move_uploaded_file($_FILES['image']['tmp_name'], 'media/product/' . $image);
         move_uploaded_file($_FILES['image']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH . $image);

         mysqli_query($con, "insert into product(categories_id, name, mrp, price, qty, short_desc, description, meta_title, meta_desc, meta_keyword, status, image) values('$categories_id', '$name', '$mrp', '$price', '$qty', '$short_desc', '$description', '$meta_title', '$meta_desc', '$meta_keyword', '1', '$image')");
      }
      header("location: product.php");
      die();
   }
}
//second code end
?>

<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Product</strong><small> Form</small></div>
                        <form method="post" enctype="multipart/form-data">
                             <div class="card-body card-block">
                             <div class="form-group">
                               <label for="categories" class=" form-control-label">Categories</label>
                               <select name="categories_id" id="" class="form-control">
                               <option value="">Select Categories</option>
                               <?php
                               $res = mysqli_query($con, "select id, categories from categories order by categories asc");
                                while($row= mysqli_fetch_assoc($res)) {
                                   if ($row['id'] == $categories_id) {
                                      echo "<option selected value=".$row['id'].">".$row['categories']."</option>";
                                   }else{
                                    echo "<option value=".$row['id'].">".$row['categories']."</option>";
                                   }
                                }
                               ?>
                               </select>
                            </div>

                           <div class="form-group">
                               <label for="categories" class=" form-control-label">Product Name</label>
                               <input type="text" id="name" name="name" placeholder="Enter Product name" class="form-control" required value="<?php echo $name; ?>">
                            </div>

                            <div class="form-group">
                               <label for="categories" class=" form-control-label">MRP</label>
                               <input type="text" id="mrp" name="mrp" placeholder="Enter Product mrp" class="form-control" required value="<?php echo $mrp; ?>">
                            </div>

                            <div class="form-group">
                               <label for="categories" class=" form-control-label">Product Price</label>
                               <input type="text" id="price" name="price" placeholder="Enter Product price" class="form-control" required value="<?php echo $price; ?>">
                            </div>

                            <div class="form-group">
                               <label for="categories" class=" form-control-label">Product QTY</label>
                               <input type="text" id="qty" name="qty" placeholder="Enter Product QTY" class="form-control" required value="<?php echo $qty; ?>">
                            </div>

                            <div class="form-group">
                               <label for="categories" class=" form-control-label">Product Image</label>
                               <input type="file" id="image" name="image"  class="form-control" value="<?php echo $image_required; ?>">
                            </div>

                            <div class="form-group">
                               <label for="short_desc" class=" form-control-label">Product Short Description</label>
                               <textarea name="short_desc" id="short_desc" cols="30" rows="10" class="form-control" placeholder="Enter Your Product Short Description" required><?php echo $short_desc ?></textarea>
                            </div>
                            <div class="form-group">
                               <label for="description" class=" form-control-label">Product Description</label>
                               <textarea name="description" id="description" cols="30" rows="10" class="form-control" placeholder="Enter Your Product Description" required><?php echo $description ?></textarea>
                            </div>
                            <div class="form-group">
                               <label for="meta_title" class=" form-control-label">Product Meta Title</label>
                               <textarea name="meta_title" id="meta_title" cols="30" rows="10" class="form-control" placeholder="Enter Your Product  Description"><?php echo $meta_title ?></textarea>
                            </div>
                            <div class="form-group">
                               <label for="meta_description" class=" form-control-label">Product Meta Description</label>
                               <textarea name="meta_desc" id="meta_description" cols="30" rows="10" class="form-control" placeholder="Enter Your Product Meta Description"><?php echo $meta_desc ?></textarea>
                            </div>
                            <div class="form-group">
                               <label for="meta_title" class=" form-control-label">Product Meta keyword</label>
                               <textarea name="meta_keyword" id="meta_keyword" cols="30" rows="10" class="form-control" placeholder="Enter Your Product Mete Keyword"><?php echo $meta_keyword ?></textarea>
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