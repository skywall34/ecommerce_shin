<?php
//getting the categories
$conn = mysqli_connect("localhost","root","skywall34","opentutorials");

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: ".myslqi_connect_error();
}

//get IP address
function getIp(){

  $ip = $_SERVER['REMOTE_ADDR'];

  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
  } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    //looks at proxy addresses
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }

  return $ip;
}



//function for the cart
function cart(){
  if (isset($_GET['add_cart'])) {

    global $conn;
    $ip = getIp();
    $pro_id = $_GET['add_cart'];
    $check_pro = "SELECT * FROM cartudemy WHERE ip_add ='$ip' AND p_id = $pro_id"; //checks whether product was already added
    $run_check = mysqli_query($conn, $check_pro);

    if (mysqli_num_rows($run_check)>0) {
      echo ""; //if there are duplicate products then the page will show nothing
    }
    else {
      //insert product to cart product
      //$p_id and $ip have already been given by the user
      $insert_pro = "INSERT INTO cartudemy(p_id, ip_add, qty) VALUES('$pro_id','$ip','1')";

      $run_pro = mysqli_query($conn, $insert_pro);
      //go pack to index.php
      echo "<script>window.open('index.php','_self')</script>";
    }
  }
}

//getting the total added items
function total_items(){
  if (isset($_GET['add_cart'])) {
    global $conn;

    $ip = getIp();

    $get_items = "SELECT * FROM cartudemy WHERE ip_add = '$ip'";

    $run_items = mysqli_query($conn, $get_items);

    $count_items = mysqli_num_rows($run_items);
    }
  else {
      global $conn;

      $ip = getIp();

      $get_items = "SELECT * FROM cartudemy WHERE ip_add = '$ip'";

      $run_items = mysqli_query($conn, $get_items);

      $count_items = mysqli_num_rows($run_items);

  }
  echo "$count_items";
}

//getting the total price of the items in the cart
function total_price(){
  $total = 0; //initiate local value for result
  global $conn;
  $ip = getIp();

  $sel_price = "SELECT * FROM cartudemy WHERE ip_add = '$ip'";

  $run_price = mysqli_query($conn, $sel_price);

  //fetch data from the table
  while ($p_price = mysqli_fetch_array($run_price)) {
    //getting the id from the table
    $pro_id = $p_price['p_id'];
    //now going to products table and take data using p_id as a reference
    //using two tables
    $pro_price = "SELECT * FROM productsudemy WHERE product_id = '$pro_id'";
    $run_pro_price = mysqli_query($conn, $pro_price);
    //taking data from products table
    // this is because there might be more products
    while ($pp_price = mysqli_fetch_array($run_pro_price)) {
      //getting the price column and taking all prices in one array
      $product_price = array($pp_price['product_price']);
      //get sum of values in the array
      $values = array_sum($product_price);

      $total += $values;
    }
  }
  echo "$".$total; //show result, the . Concants with the $ sign
}

//getting the categories
function getCats(){
  global $conn;

  $get_cats = "SELECT * FROM categoriesudemy";
  $run_cats = mysqli_query($conn, $get_cats);

  while ($row_cats = mysqli_fetch_array($run_cats)) {
    $cat_id = $row_cats['cat_id'];
    $cat_title = $row_cats['cat_title'];

    echo"<li><a href='index.php?cat=$cat_id'>$cat_title</a></li>";
  }
}

//getting the Brands

function getBrands(){
  global $conn;

  $get_brand = "SELECT * FROM brandsudemy";
  $run_brand = mysqli_query($conn, $get_brand);

  while ($row_brand = mysqli_fetch_array($run_brand)) {
    $brand_id = $row_brand['brand_id'];
    $brand_title = $row_brand['brand_title'];

    echo"<li><a href='index.php?brand=$brand_id'>$brand_title</a></li>";
  }
}

//getting the products from the database table
//the values will be displayed using the function
function getPro(){
  //if the category or brand is not set run entire function
  if (!isset($_GET['cat'])) {
    if (!isset($_GET['brand'])) {


      global $conn;

      $get_pro = "SELECT * FROM productsudemy ORDER BY RAND() LIMIT 0, 6";

      //run the get_pro mysql query command through connect conn value
      $run_pro = mysqli_query($conn, $get_pro);

      while ($row_pro = mysqli_fetch_array($run_pro)) {
        //row_pro is the array format of run_pro
        $pro_id = $row_pro['product_id'];
        $pro_cat = $row_pro['product_cat'];
        $pro_brand = $row_pro['product_brand'];
        $pro_title = $row_pro['product_title'];
        $pro_price = $row_pro['product_price'];
        $pro_image = $row_pro['product_image'];

        //careful only use single quotations inside the double quotations
        echo "
          <div id= 'single_product'>
            <h3>$pro_title</h3>
            <img src='admin_area_udemy/productImages/$pro_image' width = '180' height = '180' />
            <p><b> Price: $ $pro_price</b></p>
            <a href='details.php?pro_id=$pro_id' style='float:left;'>Details</a>
            <a href = 'index.php?add_cart=$pro_id'><button style='float:right;'>Add to Cart</button></a>
          </div>
          ";
      }
    }
  }
}


function getCatPro(){
  //if the category or brand is not set run entire function
  if (isset($_GET['cat'])) {
    $cat_id = $_GET['cat'];

    global $conn;
    //catches the category id and passes to product_cat where the
    //sql query calls the data from the database
    $get_cat_pro = "SELECT * FROM productsudemy WHERE product_cat = '$cat_id'";

    //run the get_pro mysql query command through connect conn value
    $run_cat_pro = mysqli_query($conn, $get_cat_pro);

    //counts number of rows in a category
    $count_cats = mysqli_num_rows($run_cat_pro);

    if ($count_cats==0) {
      echo "<h2 style = 'padding: 20px;'>No products were found in this category!</h2>";
    }

    while ($row_cat_pro = mysqli_fetch_array($run_cat_pro)) {
      //row_pro is the array format of run_pro
      $pro_id = $row_cat_pro['product_id'];
      $pro_cat = $row_cat_pro['product_cat'];
      $pro_brand = $row_cat_pro['product_brand'];
      $pro_title = $row_cat_pro['product_title'];
      $pro_price = $row_cat_pro['product_price'];
      $pro_image = $row_cat_pro['product_image'];

      //careful only use single quotations inside the double quotations
      echo "
        <div id= 'single_product'>
          <h3>$pro_title</h3>
          <img src='admin_area_udemy/productImages/$pro_image' width = '180' height = '180' />
          <p><b> $ $pro_price</b></p>
          <a href='details.php?pro_id=$pro_id' style='float:left;'>Details</a>
          <a href = 'index.php?pro_id=$pro_id'><button style='float:right;'>Add to Cart</button></a>
        </div>
        ";
    }
  }
}

//getting the product by brands
function getBrandPro(){
  //if the category or brand is not set run entire function
  if (isset($_GET['brand'])) {
    $brand_id = $_GET['brand'];

    global $conn;
    //catches the brand id and passes to product_brand where the
    //sql query calls the data from the database
    $get_brand_pro = "SELECT * FROM productsudemy WHERE product_brand = '$brand_id'";

    //run the get_pro mysql query command through connect conn value
    $run_brand_pro = mysqli_query($conn, $get_brand_pro);

    //counts number of rows in a category
    $count_brands = mysqli_num_rows($run_brand_pro);

    if ($count_brands==0) {
      echo "<h2 style = 'padding: 20px;'>No products were found that matches this brand!</h2>";
    }

    while ($row_brand_pro = mysqli_fetch_array($run_brand_pro)) {
      //row_pro is the array format of run_pro
      $pro_id = $row_brand_pro['product_id'];
      $pro_cat = $row_brand_pro['product_cat'];
      $pro_brand = $row_brand_pro['product_brand'];
      $pro_title = $row_brand_pro['product_title'];
      $pro_price = $row_brand_pro['product_price'];
      $pro_image = $row_brand_pro['product_image'];

      //careful only use single quotations inside the double quotations
      echo "
        <div id= 'single_product'>
          <h3>$pro_title</h3>
          <img src='admin_area_udemy/productImages/$pro_image' width = '180' height = '180' />
          <p><b> $ $pro_price</b></p>
          <a href='details.php?pro_id=$pro_id' style='float:left;'>Details</a>
          <a href = 'index.php?pro_id=$pro_id'><button style='float:right;'>Add to Cart</button></a>
        </div>
        ";
    }
  }
}

 ?>
