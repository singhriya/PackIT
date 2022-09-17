<?php

$upload_directory = "uploads";

//helper functions
function last_id(){
  global $connection;
  return mysqli_insert_id($connection);
}



function set_message($msg){
  if(!empty($msg)){
    $_SESSION['message'] = $msg;
  }
  else{
    $msg = "";
  }
}

function display_message(){
  if(isset($_SESSION['message'])){
    echo $_SESSION['message'];
    unset($_SESSION['message']);
  }
}

function redirect($location){
  header("Location: $location");
}

function query($sql){
  global $connection;
  return mysqli_query($connection, $sql);
}

function confirm($result){
  global $connection;
  if(!$result){
    die("QUERY FAILED ". mysqli_error($connection));
  }
}

function escape_string($string){
  global $connection;
  return mysqli_real_escape_string($connection, $string);
}

function fetch_array($result){
  return mysqli_fetch_array($result);
}

//*********FRONT END FUNCTIONS***************************

//Get Product

function get_products(){

$query = query("SELECT * FROM products");
confirm($query);
while($row = fetch_array($query)){
  $product_image = display_image($row['product_image']);

$product = <<<DELIMETER

<div class="col-sm-4 col-lg-4 col-md-4">
    <div class="thumbnail">
        <a href="item.php?id={$row['product_id']}"><img style="height:100px" src="../resources/{$product_image}" alt=""></a>
        <div class="caption">
            <h4 class="pull-right">&#36;{$row['product_price']}</h4>
            <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
            </h4>
            <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
            <a class="btn btn-primary" href="../resources/cart.php?add={$row['product_id']}">Add to Cart</a>
        </div>
    </div>
</div>

DELIMETER;

echo $product;
}

}

function get_categories(){

$query = query("SELECT * FROM categories");
confirm($query);

while($row = fetch_array($query)){
$category_links = <<<DELIMETER

<a href='category.php?id={$row['cat_id']}' class='list-group-item'>{$row['cat_title']}</a>

DELIMETER;
echo $category_links;
  }
}

//*********BACK END FUNCTIONS***************************

function get_products_in_cat(){

$query = query("SELECT * FROM products where product_category_id=".escape_string($_GET['id'])."  ");
confirm($query);
while($row = fetch_array($query)){
  $product_image = display_image($row['product_image']);
$product = <<<DELIMETER

<div class="col-sm-4 col-lg-4 col-md-4">
    <div class="thumbnail">
        <a href="item.php?id={$row['product_id']}"><img style="height:100px" src="../resources/{$product_image}" alt=""></a>
        <div class="caption">
            <h4 class="pull-right">&#8377;{$row['product_price']}</h4>
            <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
            </h4>
            <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
            <a class="btn btn-primary" href="../resources/cart.php?add={$row['product_id']}">Add to Cart</a>
        </div>
    </div>
</div>

DELIMETER;
echo $product;
}
}

function get_products_in_shop(){

$query = query("SELECT * FROM products");
confirm($query);
while($row = fetch_array($query)){
  $product_image = display_image($row['product_image']);
$product = <<<DELIMETER

<div class="col-sm-4 col-lg-4 col-md-4">
    <div class="thumbnail">
        <a href="item.php?id={$row['product_id']}"><img style="height:100px" src="../resources/{$product_image}" alt=""></a>
        <div class="caption">
            <h4 class="pull-right">&#36;{$row['product_price']}</h4>
            <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
            </h4>
            <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
            <a class="btn btn-primary" target="_blank" href="../resources/cart.php?add={$row['product_id']}">Add to Cart</a>
        </div>
    </div>
</div>

DELIMETER;
echo $product;
}
}

function login_user(){
  if(isset($_POST['submit'])){
    $username = escape_string($_POST['username']);
    $password = escape_string($_POST['password']);
    $query = query("SELECT * from users where username ='{$username}' AND password = '{$password}'");
    confirm($query);
    if(mysqli_num_rows($query) == 0){
      set_message("Check username or password!");
      redirect("login.php");
    }
    else{
      $_SESSION['username'] = $username;
      set_message("Welcome to Admin, {$username}!");
      redirect("admin");
    }

  }
}

function send_message(){
  if(isset($_POST['submit'])){
    $to = "riya26March@gmail.com";
    $from_name = $_POST['name'];
    $subject = $_POST['subject'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $headers = "From: {$from_name}";
    $result = mail($to, $subject, $message, $headers);
    if(!$result)
      echo "ERROR!!!!";
    else
      echo "SENT";
  }
}
function display_orders(){
  $query = query("Select * from orders");
  confirm($query);
  while($row = fetch_array($query)){

$orders = <<<DELIMETER

<tr>
    <td>{$row['order_id']}</td>
    <td>{$row['order_transaction']}</td>
    <td>{$row['order_currency']}</td>
    <td>{$row['order_status']}</td>
   <td>{$row['order_amount']}</td>
   <td><a class = "btn btn-danger" href ="../../resources/templates/back/delete_order.php?id={$row['order_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
</tr>


DELIMETER;
echo $orders;

  }
}

/*************************** ADMIN PRODUCTS PAGE***************/
function display_image($picture){
  global $upload_directory;
  return $upload_directory . DS. $picture ;
}



function get_products_in_admin(){

$query = query("SELECT * FROM products");
confirm($query);
while($row = fetch_array($query)){
$product_image = display_image($row['product_image']);
$category_title = product_category_title($row['product_category_id']);
$product = <<<DELIMETER

      <tr>
      <td>{$row['product_id']}</td>
      <td>{$row['product_title']}<br>
        <a href="index.php?edit_product&id={$row['product_id']}" ><img width='100' src="../../resources/{$product_image}" alt=""></a>
      </td>
      <td>{$category_title}</td>
      <td>{$row['product_price']}</td>
      <td>{$row['product_quantity']}</td>
      <td><a class = "btn btn-danger" href ="../../resources/templates/back/delete_product.php?id={$row['product_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
  </tr>

DELIMETER;

echo $product;
}

}

function product_category_title($product_category_id){
  $category_query = query("SELECT * from categories where cat_id={$product_category_id}  ");
  confirm($category_query);
  while($category_row = fetch_array($category_query)){
    return $category_row['cat_title'];
  }
}



/*************************** ADDING ADMIN PRODUCTS ***************/
function add_products(){

  if(isset($_POST['publish'])){

    $product_title        = escape_string($_POST['product_title']);
    $product_category_id  = escape_string($_POST['product_category_id']);
    $product_price        = escape_string($_POST['product_price']);
    $product_quantity     = escape_string($_POST['product_quantity']);
    $product_description  = escape_string($_POST['product_description']) ;
    $product_short_desc   = escape_string($_POST['product_short_desc']);
    $product_image   = escape_string($_FILES['file']['name']);
    $image_tmp_location   = escape_string($_FILES['file']['tmp_name']);

    $error = $_FILES['file']['error'];
    echo $image_tmp_location;
    $a = move_uploaded_file($image_tmp_location, UPLOAD_DIRECTORY.DS.$product_image);
    $uploadfile = UPLOAD_DIRECTORY.DS.basename($_FILES['file']['name']);


    if(move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)){

      $query = query("INSERT INTO products(product_title, product_category_id, product_price, product_quantity, product_description, short_desc, product_image)
      values('{$product_title}', '{$product_category_id}', '{$product_price}', '{$product_quantity}', '{$product_description}', '{$product_short_desc}', '{$product_image}')  ");
      confirm($query);
      $last_id = last_id();
      set_message("Product added with id=".$last_id);
      redirect("index.php?products");
    }
    else{
      echo "Error" . file_upload_error($error);
      set_message("SOME ERROR IN UPLOADING FILE" . file_upload_error($error));
    }

  }
}

function get_categories_add_product(){

$query = query("SELECT * FROM categories");
confirm($query);

while($row = fetch_array($query)){
$category_options= <<<DELIMETER

<option value="{$row['cat_id']}">{$row['cat_title']}</option>

DELIMETER;
echo $category_options;
  }
}

/*************************** editing ADMIN PRODUCTS ***************/
function edit_products(){

  if(isset($_POST['update'])){

    $product_title        = escape_string($_POST['product_title']);
    $product_category_id  = escape_string($_POST['product_category_id']);
    $product_price        = escape_string($_POST['product_price']);
    $product_quantity     = escape_string($_POST['product_quantity']);
    $product_description  = escape_string($_POST['product_description']) ;
    $product_short_desc   = escape_string($_POST['product_short_desc']);
    $product_image        = escape_string($_FILES['file']['name']);
    $image_tmp_location   = escape_string($_FILES['file']['tmp_name']);

    if(empty($product_image)){
      $get_pic = query("SELECT product_image from products where product_id=".escape_string($_GET['id']) ." ");
      confirm($get_pic);
      $pic = fetch_array($get_pic);
      $product_image = $pic['product_image'];
    }
    $uploadfile = UPLOAD_DIRECTORY. DS . basename($product_image);
    move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);

      $query = "UPDATE products SET ";
      $query .= "product_title        = '{$product_title}'        , ";
      $query .= "product_category_id  = '{$product_category_id}'  , ";
      $query .= "product_price        = '{$product_price}'        , ";
      $query .= "product_quantity     = '{$product_quantity}'        , ";
      $query .= "product_description = '{$product_description}'   , ";
      $query .= "short_desc = '{$product_short_desc}'             , ";
      $query .= "product_image = '{$product_image}'                 ";
      $query .= "WHERE product_id = ".escape_string($_GET['id']). " ";

      $query =  query($query);
      confirm($query);
      set_message("Product has been updated");
      redirect("index.php?products");
    }
}
/************ Getting and adding ADMIN CATEGORIES ***********/

function show_categories_in_admin(){
  $category_query = query("SELECT * from categories");
  confirm($category_query);
  while($row = fetch_array($category_query)){

$category = <<<DELIMETER
<tr>
    <td>{$row['cat_id']}</td>
    <td>{$row['cat_title']}</td>
    <td><a class = "btn btn-danger" href ="../../resources/templates/back/delete_category.php?id={$row['cat_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
</tr>
</tr>
DELIMETER;
echo $category;

  }
}

function add_categories_in_admin(){
  if(isset($_POST['add_category'])){
    $cat_title = escape_string($_POST['cat_title']);

    if(empty($cat_title) || $cat_title == " "){

      echo "<h4 class = 'bg-danger'>This field can not be empty!</h4>";

    }
    else{

      $query = query("INSERT INTO categories(cat_title) values('{$cat_title}') ");
      confirm($query);
      set_message("Category Inserted!");

    }
  }
}

/****************           ADMIN USERS PAGE  ******************/
function display_users(){
  $user_query = query("SELECT * from users");
  confirm($user_query);
  while($row = fetch_array($user_query)){

$user = <<<DELIMETER
<tr>
    <td>{$row['user_id']}</td>
    <td>{$row['username']}</td>
    <td>{$row['email']}</td>
    <td><a class = "btn btn-danger" href ="../../resources/templates/back/delete_user.php?id={$row['user_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
</tr>
</tr>
DELIMETER;
echo $user;

}
}

function add_user(){

  if(isset($_POST['add_user'])){

    $username             = escape_string($_POST['username']);
    $email                = escape_string($_POST['email']);
    $password             = escape_string($_POST['password']);
    // $user_photo           = escape_string($_FILES['file']['name']);
    // $image_tmp_location   = escape_string($_FILES['file']['tmp_name']);
    //
    // $uploadfile = UPLOAD_DIRECTORY.DS.basename($_FILES['file']['name']);
      $query = query("INSERT INTO users(username, email, password) values('{$username}', '{$email}', '{$password}')  ");
      confirm($query);
      set_message("User added");
      redirect("index.php?users");

}
}

/************** get reports ***********/


function get_reports(){

$query = query("SELECT * FROM reports");
confirm($query);
while($row = fetch_array($query)){

$report = <<<DELIMETER

      <tr>
      <td>{$row['report_id']}</td>
      <td>{$row['order_id']}</td>
      <td>{$row['product_id']}</td>
      <td>{$row['product_title']}<br></td>
      <td>{$row['product_price']}</td>
      <td>{$row['product_quantity']}</td>
      <td><a class = "btn btn-danger" href ="../../resources/templates/back/delete_report.php?id={$row['report_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
  </tr>

DELIMETER;

echo $report;
}

}

/***************** SLIDES *********************/

function get_active_slide(){

  $query = query("SELECT * from slides ORDER BY slide_id DESC LIMIT 1");
  confirm($query);
  while($row = fetch_array($query)){
    $slide_image = display_image($row['slide_image']);
$slide_active = <<<DELIMETER
<div class="item active">
  <img class="slide-image" src="../resources/{$slide_image}" alt="">
</div>
DELIMETER;
  echo $slide_active;
  }

}

function get_slides(){
  $query = query("SELECT * from slides");
  confirm($query);
  while($row = fetch_array($query)){
    $slide_image = display_image($row['slide_image']);
$slide = <<<DELIMETER
<div class="item">
    <img class="slide-image" src="../resources/{$slide_image}" alt="">
</div>
DELIMETER;
echo $slide;
  }
}


function add_slides(){

  if(isset($_POST['add_slide'])){
    $slide_title      = escape_string($_POST['slide_title']);
    $slide_image      = escape_string($_FILES['file']['name']);
    $slide_image_loc  = escape_string($_FILES['file']['tmp_name']);

    if(empty($slide_image) || empty($slide_title)){
      set_message("Fields cant be empty");
      redirect("index.php?slides");
    }
    else {
      move_uploaded_file($_FILES['file']['tmp_name'], UPLOAD_DIRECTORY. DS. basename($_FILES['file']['name']));
      $query = query("INSERT INTO slides(slide_title, slide_image) values ('{$slide_title}', '{$slide_image}')   ");
      confirm($query);
      set_message("Slide added");
      redirect("index.php?slides");
    }
  }

}

function get_slide_thumbnails(){

  $query = query("SELECT * from slides ORDER BY slide_id ");
  confirm($query);

  while($row = fetch_array($query)){

    $slide_image = display_image($row['slide_image']);
$slide_thumb_admin = <<<DELIMETER
<div class="col-xs-6 col-xs-3 image-container">
  <a href="index.php?delete_slide_id={$row['slide_id']}">
    <img class="img-responsive slide-image" src="../../resources/{$slide_image}" alt="">
  </a>
  <p>{$row['slide_title']}</p>
</div>
DELIMETER;
  echo $slide_thumb_admin;

}

}

function get_current_slide_in_admin(){

  $query = query("SELECT * from slides ORDER BY slide_id DESC LIMIT 1");
  confirm($query);
  while($row = fetch_array($query)){
    $slide_image = display_image($row['slide_image']);
$slide_active_admin = <<<DELIMETER
<img class="img-responsive" src="../../resources/{$slide_image}" alt="">
DELIMETER;
  echo $slide_active_admin;
  }

}

?>
