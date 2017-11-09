<?php
if (!isset($_SESSION['user_email'])) {
  echo "<script>window.open('login.php?not_admin=You are not an Admin!', '_self')</script>";
}
else {

 ?>
<table width = "795" align = "center" bgcolor="skyblue">

  <tr align="center">
    <td colspan="6"><h2>View All Categories Here</h2></td>
  </tr>

  <tr align="center" bgcolor = "white">
    <th>Category ID</th><!--Serial Number?-->
    <th>Category Title</th>
    <th>Edit</th>
    <th>Delete</th>
  </tr>

  <?php
    include("dbUdemy.php");
    $get_cat = "SELECT * FROM categoriesudemy";
    $run_cat = mysqli_query($conn, $get_cat);

    $i = 0;

    while ($row_cat = mysqli_fetch_array($run_cat)) {
      $cat_id = $row_cat['cat_id'];
      $cat_title = $row_cat['cat_title'];
      $i++; //increment for as many products there are (increments the id)
   ?>

  <tr align="center">
    <td><?php echo $i; ?></td>
    <td><?php echo $cat_title ?></td>
    <td><a href="index.php?edit_cat=<?php echo $cat_id;?>">Edit</a></td>
    <td><a href="includes/delete_cat.php?delete_cat=<?php echo $cat_id;?>">Delete</a></td>
  </tr>

<?php } //continues the loop throughout the html ?>

</table>

<?php } ?>
