<?php
if (!isset($_SESSION['user_email'])) {
  echo "<script>window.open('login.php?not_admin=You are not an Admin!', '_self')</script>";
}
else {
 ?>
<table width = "795" align = "center" bgcolor="skyblue">

  <tr align="center">
    <td colspan="6"><h2>View All Brands Here</h2></td>
  </tr>

  <tr align="center" bgcolor = "white">
    <th>Brand ID</th><!--Serial Number?-->
    <th>Brand Title</th>
    <th>Edit</th>
    <th>Delete</th>
  </tr>

  <?php
    include("db_shin.php");
    $get_brand = "SELECT * FROM brandsudemy";
    $run_brand = mysqli_query($conn, $get_brand);

    $i = 0;

    while ($row_brand = mysqli_fetch_array($run_brand)) {
      $brand_id = $row_brand['brand_id'];
      $brand_title = $row_brand['brand_title'];
      $i++; //increment for as many products there are (increments the id)
   ?>

  <tr align="center">
    <td><?php echo $i; ?></td>
    <td><?php echo $brand_title ?></td>
    <td><a href="index.php?edit_brand=<?php echo $brand_id;?>">Edit</a></td>
    <td><a href="includes/delete_brand.php?delete_brand=<?php echo $brand_id;?>">Delete</a></td>
  </tr>

<?php } //continues the loop throughout the html ?>

</table>

<?php } ?>
