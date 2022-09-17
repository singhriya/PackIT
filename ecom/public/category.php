<?php require_once("../resources/config.php") ?>

<?php include(TEMPLATE_FRONT. DS ."header.php") ?>

    <!-- Page Content -->
    <div class="container">
        <!-- Page Features -->
        <div class="row text-center">

          <?php get_products_in_cat(); ?>

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->
    <?php include(TEMPLATE_FRONT. DS ."footer.php") ?>
