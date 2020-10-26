<?php if ($this->show_center) { ?>
<!-- Page Content -->
<div class="<?php echo $class = ($this->show_sidebar == true) ? 'container-fluid' : 'container'; ?>">

    <div class="row">
        <?php require_once(dirname(__FILE__).'/sidebar.php')?>

        <div class="<?php echo $class = ($this->show_sidebar == true) ? 'col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2' :
            'col-md-12'; ?> main" style="padding-top: 0;padding-bottom: 0;">
            <?php } ?>
            <?php echo $this->page;?>
            <?php if ($this->show_center) { ?>

        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /.container -->
<?php } ?>
