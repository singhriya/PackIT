<?php require_once("../../config.php"); ?>
<?php
if(isset($_GET['id'])){

  $query = query("DELETE from users where user_id = ".escape_string($_GET['id'])." ");
  confirm($query);
  set_message("User Deleted.");
  redirect("../../../public/admin/index.php?users");
  }
  else{
    redirect("../../../public/admin/index.php?users");
  }

?>
