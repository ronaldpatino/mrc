<!-- Sociales -->
<div class='container margen-container'>
    <div id='sociales' class='row-fluid'>
        <div class="span8 seccion-left">
            <h2><a href="<?php echo get_home_url()?>/sociales" >Sociales</a></h2>
            <?php if ( dynamic_sidebar('sociales') ) : else : endif; ?>
        </div>
        <div class="span4">
            <?php get_template_part( 'blocks/publicidadsociales' ); ?>
        </div>
    </div>
</div>

<!-- Fin Sociales -->