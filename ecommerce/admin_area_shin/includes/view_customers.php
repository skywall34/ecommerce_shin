<?php
if (!isset($_SESSION['user_email'])) {
  echo "<script>window.open('login.php?not_admin=You are not an Admin!', '_self')</script>";
}
else {
 ?>
<table width = "795" align = "center" bgcolor="skyblue">

  <tr align="center">
    <td colspan="6"><h2>View All Customers Here</h2></td>
  </tr>

  <tr align="center" bgcolor = "white">
    <th>Serial Number</th>
    <th>Name</th><!--Serial Number?-->
    <th>Email</th>
    <th>Contact</th>
    <th>Image</th>
    <th>Country</th>
    <th>Delete</th>
  </tr>

  <?php
    include("dbUdemy.php");
    $get_customer = "SELECT * FROM customersudemy";
    $run_customer = mysqli_query($conn, $get_customer);

    $i = 0;

    while ($row_customer = mysqli_fetch_array($run_customer)) {
      $customer_id = $row_customer['customer_id'];
      $customer_name = $row_customer['customer_name'];
      $customer_email = $row_customer['customer_email'];
      $customer_image = $row_customer['customer_image'];
      $customer_contact = $row_customer['customer_contact'];
      $customer_country = $row_customer['customer_country'];
      $i++; //increment for as many products there are (increments the id)

   ?>

  <tr align="center">
    <td><?php echo $i; ?></td>
    <td><?php echo $customer_name; ?></td>
    <td><?php echo $customer_email;?></td>
    <td><?php echo $customer_contact; ?></td>
    <td><img src="../customerUdemy/customer_images/<?php echo $customer_image; ?>" width="60" height="60"></td>
    <td><?php echo $customer_country; ?></td>
    <td><a href="includes/delete_customer.php?delete_customer=<?php echo $customer_id;?>">Delete</a></td>
  </tr>

<?php } //continues the loop throughout the html ?>

</table>

<?php } ?>
