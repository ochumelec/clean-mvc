<?php if ($this->show_menu) { ?>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav pull-left">
                    <li>
                        <a href="/" aria-hidden="true"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                    </li>
                    <li>
                        <a href="/domains" aria-hidden="true"><i class="fa fa-table"></i> Domains</a>
                    </li>
                    <li>
                        <a href="/results" aria-hidden="true"><i class="fa fa-th"></i> Results</a>
                    </li>
                </ul>
                <ul class="pull-right nav navbar-nav">
                    <li>
                        <a href="/auth/logout"><i class="fa fa-sign-out"></i>Выйти</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <?php
}
?>

<div class="row" style="">
    <div class="container main" style="padding: 0;">
        <div class="col-md-12" id="alerts">

        </div>
    </div>
</div>

