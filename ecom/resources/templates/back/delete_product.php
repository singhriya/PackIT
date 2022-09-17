<?php require_once("../../config.php"); ?>
<?php
if(isset($_GET['id'])){

  $query = query("DELETE from products where product_id = ".escape_string($_GET['id'])." ");
  confirm($query);
  set_message("Product Deleted.");
  redirect("../../../public/admin/index.php?products");
  }
  else{
    redirect("../../../public/admin/index.php?products");
  }

?>
