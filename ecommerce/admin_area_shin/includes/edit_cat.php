<?php
include("db_shin.php");

if (isset($_GET['edit_cat'])) {
  $cat_id = $_GET['edit_cat'];

  $get_cat = "SELECT * FROM categoriesudemy WHERE cat_id = '$cat_id'";

  $run_cat = mysqli_query($conn, $get_cat);

  $row_cat = mysqli_fetch_array($run_cat);

  $cat_id = $row_cat['cat_id'];
  $cat_title = $row_cat['cat_title'];
}

 ?>



<form class="" action="" method="post" style="padding:40px;">

  <b>Edit Category:</b>
  <input type="text" name="new_cat" value = "<?php echo $cat_title?>">
  <input type="submit" name="add_cat" value="Update Category">

</form>

<?php

//adds the new category into the categoriesudemy database
if (isset($_POST['add_cat'])) {
  $update_id = $cat_id;

  $new_cat = $_POST['new_cat'];

  $update_cat = "UPDATE categoriesudemy SET cat_title = '$new_cat' WHERE cat_id = '$update_id'";

  $run_update = mysqli_query($conn, $update_cat);

  if ($run_update) {
    echo "<script>alert('Category Updated!')</script>";
    echo "<script>window.open('index.php?view_cats','_self')</script>";
  }
}

 ?>
