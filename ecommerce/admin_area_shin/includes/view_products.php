<?php
if (!isset($_SESSION['user_email'])) {
  echo "<script>window.open('login.php?not_admin=You are not an Admin!', '_self')</script>";
}
else {

 ?>
<table width = "795" align = "center" bgcolor="skyblue">

  <tr align="center">
    <td colspan="6"><h2>View All Products Here</h2></td>
  </tr>

  <tr align="center" bgcolor = "white">
    <th>S.N</th><!--Serial Number?-->
    <th>Title</th>
    <th>Image</th>
    <th>Price</th>
    <th>Edit</th>
    <th>Delete</th>
  </tr>

  <?php
    include("dbUdemy.php");
    $get_pro = "SELECT * FROM productsudemy";
    $run_pro = mysqli_query($conn, $get_pro);

    $i = 0;

    while ($row_pro = mysqli_fetch_array($run_pro)) {
      $pro_id = $row_pro['product_id'];
      $pro_title = $row_pro['product_title'];
      $pro_image = $row_pro['product_image'];
      $pro_price = $row_pro['product_price'];
      $i++; //increment for as many products there are (increments the id)

   ?>

  <tr align="center">
    <td><?php echo $i; ?></td>
    <td><?php echo $pro_title ?></td>
    <td><img src="productImages/<?php echo $pro_image ?>" width="60" height="60"></td>
    <td><?php echo $pro_price ?></td>
    <td><a href="index.php?edit_product=<?php echo $pro_id;?>">Edit</a></td>
    <td><a href="includes/delete_product.php?delete_product=<?php echo $pro_id;?>">Delete</a></td>
  </tr>

<?php } //continues the loop throughout the html ?>

</table>

<?php } ?>
