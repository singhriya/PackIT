<?php require_once("../../config.php"); ?>
<?php
if(isset($_GET['id'])){

  $query = query("DELETE from reports where report_id = ".escape_string($_GET['id'])." ");
  confirm($query);
  set_message("Report Deleted.");
  redirect("../../../public/admin/index.php?reports");
  }
  else{
    redirect("../../../public/admin/index.php?reports");
  }

?>
