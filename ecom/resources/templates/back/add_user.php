<div class="col-md-12">

<div class="row">
<h1 class="page-header">
   Add User
</h1>
</div>

<form action="<?php add_user() ;?>" method="post" enctype="multipart/form-data">
<h4><?php display_message() ;?></h4>
<div class="col-md-4">

  <div class="form-group">
    <label for="username">Username</label>
        <input type="text" name="username" class="form-control">
  </div>

  <div class="form-group">
    <label for="email">Email</label>
      <input type="email" name="email" class="form-control">
  </div>

  <div class="form-group">
    <label for="password">Password</label>
      <input type="password" name="password" class="form-control">
  </div>

  <div class="form-group">
      <label for="user-image">User photo</label>
      <input type="file" name="file">
  </div>

  <div class="form-group">
    <input type="submit" name="add_user" class="btn btn-primary btn-lg" value="Add User">
  </div>

</div><!--Main Content-->

</form>
