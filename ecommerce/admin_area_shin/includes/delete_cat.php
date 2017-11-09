<?php
  include("dbUdemy.php");

  if (isset($_GET['delete_cat'])) {

    $delete_id = $_GET['delete_cat'];

    $delete_cat = "DELETE FROM categoriesudemy WHERE cat_id = '$delete_id'";

    $run_delete = mysqli_query($conn, $delete_cat);

    if ($run_delete) {
      echo "<script>alert('The product has been deleted!')</script>";
      echo "<script>window.open('../index.php?view_cats', '_self')</script>";
    }
  }
 ?>
