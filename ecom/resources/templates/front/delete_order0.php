<?php require_once("../../config.php"); ?>
<?php
if(isset($_GET['id'])){

  $query = query("DELETE from orders where order_id = ".escape_string($_GET['id'])." ");
  confirm($query);
  set_message("Record Deleted.");
  redirect("../../../public/admin/index.php?orders");
  }
  else{
    redirect("../../../public/admin/index.php?orders");
  }

?>
