<?php
  include("dbUdemy.php");

  if (isset($_GET['delete_brand'])) {

    $delete_id = $_GET['delete_brand'];

    $delete_brand = "DELETE FROM brandsudemy WHERE brand_id = '$delete_id'";

    $run_delete = mysqli_query($conn, $delete_brand);

    if ($run_delete) {
      echo "<script>alert('The brand has been deleted!')</script>";
      echo "<script>window.open('../index.php?view_brands', '_self')</script>";
    }
  }
 ?>
