<?php
if (!isset($_SESSION['user_email'])) {
  echo "<script>window.open('login.php?not_admin=You are not an Admin!', '_self')</script>";
}
else {
 ?>

<form class="" action="" method="post" style="padding:40px;">

  <b>Insert New Brand:</b>
  <input type="text" name="new_brand" required>
  <input type="submit" name="add_brand" value="Add Brand">

</form>

<?php
include("dbUdemy.php");
//adds the new category into the categoriesudemy database
if (isset($_POST['add_brand'])) {
  $new_brand = $_POST['new_brand'];

  $insert_brand = "INSERT INTO brandsudemy (brand_title) VALUES('$new_brand')";

  $run_insert = mysqli_query($conn, $insert_brand);

  if ($run_insert) {
    echo "<script>alert('Brand Inserted!')</script>";
    echo "<script>window.open('index.php?view_brands','_self')</script>";
  }
}

 ?>

 <?php } ?>
