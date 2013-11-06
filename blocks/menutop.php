<div class="navbar top-navbar">
    <div class='navbar-inner menu-navbar-inner  nopadding-top nav-collapse'>
        <div class="container">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li <?php echo menu_activo('/');?>><a href="<?php echo get_home_url()?>"><i class="icon-home"></i></a></li>
                    <li <?php echo menu_activo('cuenca');?>><a href="<?php echo get_home_url()?>/cuenca" class="cuenca">CUENCA</a></li>
                    <li <?php echo menu_activo('deportes');?>><a href="<?php echo get_home_url()?>/deportes" class="deportes">DEPORTES</a></li>
                    <li <?php echo menu_activo('sucesos');?>><a href="<?php echo get_home_url()?>/sucesos" class="sucesos">SUCESOS</a></li>
                    <li <?php echo menu_activo('nacionales');?>><a href="<?php echo get_home_url()?>/nacionales" class="nacionales">NACIONALES</a></li>
                    <li <?php echo menu_activo('austro');?>><a href="<?php echo get_home_url()?>/austro" class="austro">AUSTRO</a></li>
                    <li <?php echo menu_activo('cultura');?>><a href="<?php echo get_home_url()?>/cultura" class="cultura">CULTURA</a></li>
                    <li <?php echo menu_activo('farandula');?>><a href="<?php echo get_home_url()?>/farandula" class="farandula">FARANDULA</a></li>
                    <li <?php echo menu_activo('mundo');?>><a href="<?php echo get_home_url()?>/mundo" class="mundo">MUNDO</a></li>
                    <li <?php echo menu_activo('opinion');?>><a href="<?php echo get_home_url()?>/opinion" class="opinion">OPINION</a></li>
                    <li <?php echo menu_activo('defunciones');?>><a href="<?php echo get_home_url()?>/defunciones" class="defunciones">DEFUNCIONES</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>