<?php require_once("../../resources/config.php"); ?>
<?php
if(isset($_GET['delete_slide_id'])){

  $get_name = query("SELECT slide_image from slides where slide_id= ".escape_string($_GET['delete_slide_id'])."   ");
  confirm($get_name);
  $row = fetch_array($get_name);
  
  $query = query("DELETE from slides where slide_id = ".escape_string($_GET['delete_slide_id'])." ");
  confirm($query);

  $target = UPLOAD_DIRECTORY.DS.$row['slide_image'];
  unlink($target);

  set_message("Slide Deleted.");
  redirect("index.php?slides");
  }
  else{
    redirect("index.php?slides");
  }

?>
