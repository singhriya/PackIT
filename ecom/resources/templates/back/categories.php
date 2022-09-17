<?php add_categories_in_admin(); ?>
<h1 class="page-header">
  Product Categories
</h1>


<div class="col-md-4">
  <h4 class="bg-success"><?php display_message(); ?></h4>

    <form action="" method="post">
        <div class="form-group">
            <label for="category-title">Title</label>
            <input type="text" class="form-control" name="cat_title">
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="add_category" value="Add Category">
        </div>

    </form>
</div>


<div class="col-md-8">
    <table class="table">
      <thead>
        <tr>
          <th>id</th>
          <th>Title</th>
        </tr>
      </thead>
      <tbody>
        <?php show_categories_in_admin(); ?>
      </tbody>
    </table>
</div>
