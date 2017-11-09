<?php
if (!isset($_SESSION['user_email'])) {
  echo "<script>window.open('login.php?not_admin=You are not an Admin!', '_self')</script>";
}
else {
 ?>

<form class="" action="" method="post" style="padding:40px;">

  <b>Insert New Category:</b>
  <input type="text" name="new_cat" required>
  <input type="submit" name="add_cat" value="Add Category">

</form>

<?php
include("db_shin.php");
//adds the new category into the categoriesudemy database
if (isset($_POST['add_cat'])) {
  $new_cat = $_POST['new_cat'];

  $insert_cat = "INSERT INTO categoriesudemy (cat_title) VALUES('$new_cat')";

  $run_insert = mysqli_query($conn, $insert_cat);

  if ($run_insert) {
    echo "<script>alert('Category Inserted!')</script>";
    echo "<script>window.open('index.php?view_cats','_self')</script>";
  }
}

 ?>

 <?php } ?>
