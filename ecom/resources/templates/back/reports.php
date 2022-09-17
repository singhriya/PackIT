<h3 class="bg-success"><?php display_message(); ?>
<h1 class="page-header">
   Reports
</h1>
<table class="table table-hover">
    <thead>
      <tr>
           <th>Report Id</th>
           <th>Order Id</th>
           <th>Product Id</th>
           <th>Product title</th>
           <th>Product Price</th>
           <th>Product Quantity</th>
      </tr>
    </thead>
    <tbody>
      <?php get_reports(); ?>
  </tbody>
</table>
