<!DOCTYPE html>
<?php
  include("db_shin.php"); //db initializer
  //add admin_area_udemy for other files outside of the admin path
  if (isset($_GET['edit_product'])) {
    $get_id = $_GET['edit_product'];

    $get_id = "SELECT * FROM productsudemy WHERE product_id = $get_id";
    $run_pro = mysqli_query($conn, $get_id);

    $row_pro = mysqli_fetch_array($run_pro);

    $pro_id = $row_pro['product_id'];
    $pro_title = $row_pro['product_title'];
    $pro_image = $row_pro['product_image'];
    $pro_price = $row_pro['product_price'];
    $pro_desc = $row_pro['product_desc'];
    $pro_keywords = $row_pro['product_keywords'];
    $pro_cat = $row_pro['product_cat'];
    $pro_brand = $row_pro['product_brand'];

    //to get category name
    $get_cat = "SELECT * FROM categoriesudemy WHERE cat_id = '$pro_cat'";
    $run_cat = mysqli_query($conn, $get_cat);
    $row_cat = mysqli_fetch_array($run_cat);
    $category_title = $row_cat['cat_title'];

    //to get brand name
    $get_brand = "SELECT * FROM brandsudemy WHERE brand_id = '$pro_brand'";
    $run_brand = mysqli_query($conn, $get_brand);
    $row_brand = mysqli_fetch_array($run_brand);
    $brand_title = $row_brand['brand_title'];
  }
 ?>
<html>
  <head>
    <meta charset="utf-8">
    <!--Inserting Products UI to the database-->
    <title>Update Product</title>
    <!--text editor-->
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
    <!--gives text editor to tags that are created as textarea-->
  </head>
  <body bgcolor="skyblue">
    <form enctype="multipart/form-data" action="" method="post">
      <!--table attributes are for design-->
      <table align="center" width="795" border="2px" bgcolor="orange">
        <tr align="center"><!--table row-->
          <td colspan="7"><h2>Edit and Update product</h2></td><!--table cell-->
        </tr>
        <!--Enter the product-->
        <tr>
          <td align="right"><b>Product Title: </b></td>
          <td><input type="text" name="product_title" size="60" value="<?php echo $pro_title;?>"></td>
        </tr>
        <tr>
          <td align="right"><b>Product Category: </b></td>
          <td>
            <select name="product_cat" required>
              <!--Chooses the categories dynamically created from the db-->
              <option><?php echo $category_title; ?></option>
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
              <option><?php echo $brand_title;?></option>
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
          <td><input type="file" name="product_image"><img src="productImages/<?php echo $pro_image;?>" width="60" height="60"></td>
        </tr>
        <tr>
          <td align="right"><b>Product Price: </b></td>
          <td><input type="text" name="product_price" value = "<?php echo $pro_price;?>"></td>
        </tr>
        <tr>
          <td align="right"><b>Product Description: </b></td>
          <td><textarea name="product_desc" rows="10" cols="20"><?php echo $pro_desc;?></textarea></td>
        </tr>
        <tr>
          <td align="right"><b>Product Keywords: </b></td>
          <td><input type="text" name="product_keywords" size="50" value="<?php echo $pro_keywords;?>"></td>
        </tr>
        <!--sumbit-->
        <tr align="center">
          <td colspan="7"><input type="submit" name="update_product" value="Update Product"></td>
        </tr>
      </table>
    </form>
  </body>
</html>


 <?php
   if (isset($_POST['update_product'])) {
     //getting the text data from the fields
     $product_id = $pro_id;
     $product_title = $_POST['product_title'];
     $product_cat = $_POST['product_cat'];
     $product_brand = $_POST['product_brand'];
     $product_price = $_POST['product_price'];
     $product_desc = $_POST['product_desc'];
     $product_keywords = $_POST['product_keywords'];

     if ($product_cat == 0) {
       //default clause
       $product_cat = $pro_cat;
     }
     if ($product_brand == 0) {
       //default clause
       $product_brand = $pro_brand;
     }

     //getting the image from the fields

     $product_image = $_FILES['product_image']['name'];
     $product_image_tmp = $_FILES['product_image']['tmp_name'];
     //move the uploaded file to images folder in admin_area_udemy
     move_uploaded_file($product_image_tmp,"productImages/$product_image");

     //updates new info into the database
     //created if else clause to handle image default selection
     if ($product_image == '') {
       $update_product = "UPDATE productsudemy SET product_cat='$product_cat', product_brand='$product_brand', product_title='$product_title', product_price='$product_price',
       product_desc='$product_desc', product_keywords='$product_keywords' WHERE product_id = '$product_id'";
     }
     else {
       $update_product = "UPDATE productsudemy SET product_cat='$product_cat', product_brand='$product_brand', product_title='$product_title', product_price='$product_price',
       product_desc='$product_desc', product_image='$product_image', product_keywords='$product_keywords' WHERE product_id = '$product_id'";
     }

     $run_update = mysqli_query($conn, $update_product);

     if ($run_update) {
       echo "<script>alert('Product has been updated!')</script>";
       echo "<script>window.open('index.php?view_products', '_self')</script>";
     }
   }
  ?>
