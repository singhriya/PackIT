
<div class="col-md-12">
<h4> <?php display_message(); ?>
<div class="row">
  <h1 class="page-header">All Orders</h1>
</div>

<div class="row">
<table class="table table-hover">
    <thead>

      <tr>
           <th>Id</th>
           <th>Transaction</th>
           <th>Currency</th>
           <th>Status</th>
           <th>Amount</th>
      </tr>
    </thead>
    <tbody>
      <?php display_orders(); ?>
    </tbody>
</table>
</div>
</div>
