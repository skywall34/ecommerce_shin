<?php
include("db_shin.php");

if (isset($_GET['edit_brand'])) {
  $brand_id = $_GET['edit_brand'];

  $get_brand = "SELECT * FROM brandsudemy WHERE brand_id = '$brand_id'";

  $run_brand = mysqli_query($conn, $get_brand);

  $row_brand = mysqli_fetch_array($run_brand);

  $brand_id = $row_brand['brand_id'];
  $brand_title = $row_brand['brand_title'];
}

 ?>



<form class="" action="" method="post" style="padding:40px;">

  <b>Edit Brand:</b>
  <input type="text" name="new_brand" value = "<?php echo $brand_title?>">
  <input type="submit" name="add_brand" value="Update Brand">

</form>

<?php

//adds the new brandegory into the brandegoriesudemy database
if (isset($_POST['add_brand'])) {
  $update_id = $brand_id;

  $new_brand = $_POST['new_brand'];

  $update_brand = "UPDATE brandsudemy SET brand_title = '$new_brand' WHERE brand_id = '$update_id'";

  $run_update = mysqli_query($conn, $update_brand);

  if ($run_update) {
    echo "<script>alert('Brand Updated!')</script>";
    echo "<script>window.open('index.php?view_brands','_self')</script>";
  }
}

 ?>
