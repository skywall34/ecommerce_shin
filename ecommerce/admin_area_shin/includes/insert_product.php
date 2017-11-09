<!DOCTYPE html>
<?php
  include("includes/db_shin.php"); //db initializer
  //add admin_area_udemy for other files outside of the admin path
  if (!isset($_SESSION['user_email'])) {
    echo "<script>window.open('login.php?not_admin=You are not an Admin!', '_self')</script>";
  }
  else {
 ?>
<html>
  <head>
    <meta charset="utf-8">
    <!--Inserting Products UI to the database-->
    <title>Inserting Product</title>
    <!--text editor-->
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
    <!--gives text editor to tags that are created as textarea-->
  </head>
  <body bgcolor="skyblue">
    <form enctype="multipart/form-data" action="insert_product.php" method="post">
      <!--table attributes are for design-->
      <table align="center" width="795" border="2px" bgcolor="orange">
        <tr align="center"><!--table row-->
          <td colspan="7"><h2>Insert New Post Here</h2></td><!--table cell-->
        </tr>
        <!--Enter the product-->
        <tr>
          <td align="right"><b>Product Title: </b></td>
          <td><input type="text" name="product_title" size="60" required></td>
        </tr>
        <tr>
          <td align="right"><b>Product Category: </b></td>
          <td>
            <select name="product_cat" required>
              <!--Chooses the categories dynamically created from the db-->
              <option>Select Category</option>
              <?php
                $get_cats = "SELECT * FROM categoriesudemy";
                $run_cats = mysqli_query($conn, $get_cats);

                while ($row_cats = mysqli_fetch_array($run_cats)) {
                  $cat_id = $row_cats['cat_id'];
                  $cat_title = $row_cats['cat_title'];

                  echo"<option value='$cat_id'>$cat_title</option>";
                  //need the id to specifically select the category
                  //the title alone will not choose the category we need
                }
               ?>
            </select>
          </td>
        </tr>
        <tr>
          <td align="right"><b>Product Brand: </b></td>
          <td>
            <select name="product_brand" required>
              <option>Select a Brand</option>
              <?php
                $get_brand = "SELECT * FROM brandsudemy";
                $run_brand = mysqli_query($conn, $get_brand);

                while ($row_brand = mysqli_fetch_array($run_brand)) {
                  $brand_id = $row_brand['brand_id'];
                  $brand_title = $row_brand['brand_title'];

                  echo"<option value='$brand_id'>$brand_title</option>";
                }
               ?>
            </select>

          </td>
        </tr>
        <tr>
          <!--Enables user to choose file from local files-->
          <!--The required attribute makes sure that the user
          fills in that blank-->
          <td align="right"><b>Product Image: </b></td>
          <td><input type="file" name="product_image" required></td>
        </tr>
        <tr>
          <td align="right"><b>Product Price: </b></td>
          <td><input type="text" name="product_price" required></td>
        </tr>
        <tr>
          <td align="right"><b>Product Description: </b></td>
          <td><textarea name="product_desc" rows="10" cols="20"></textarea></td>
        </tr>
        <tr>
          <td align="right"><b>Product Keywords: </b></td>
          <td><input type="text" name="product_keywords" size="50" required></td>
        </tr>
        <!--sumbit-->
        <tr align="center">
          <td colspan="7"><input type="submit" name="insert_post" value="Insert Product Now"></td>
        </tr>
      </table>
    </form>
  </body>
</html>

<?php
  if (isset($_POST['insert_post'])) { //return true if the value is not null
    //if nothing has happened to fill outs above then this will not run
    //the submit button is what takes the data

    //getting the text data from the fields
    $product_title = $_POST['product_title'];
    $product_cat = $_POST['product_cat'];
    $product_brand = $_POST['product_brand'];
    $product_price = $_POST['product_price'];
    $product_desc = $_POST['product_desc'];
    $product_keywords = $_POST['product_keywords'];

    //getting the image from the fields
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp = $_FILES['product_image']['tmp_name'];
    //move the uploaded file to images folder in admin_area_udemy
    move_uploaded_file($product_image_tmp,"productImages/$product_image");

    //inserting products into the database using mysql (use echo to test)
    $insert_product = "INSERT INTO productsudemy(product_cat, product_brand, product_title, product_price, product_desc, product_image, product_keywords) VALUES('$product_cat','$product_brand','$product_title','$product_price','$product_desc','$product_image','$product_keywords')";

    $insert_pro = mysqli_query($conn, $insert_product);
    if ($insert_pro) {
      echo "<script>alert('Product has been inserted!')</script>";
      echo "<script>window.open('includes/index.php?insert_product', '_self')</script>";
    };
  };
 ?>

 <?php }; ?>
