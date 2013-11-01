<!-- Suplementos -->
<div class='container margen-container'>
    <div id='suplementos' class='row-fluid'>
        <div class="span4">
            <?php get_template_part( 'blocks/publicidadsuplementos' ); ?>
        </div>
        <div class="span8 seccion-right">
            <h2><a href="<?php echo get_home_url()?>/suplementos" >Suplementos</a></h2>
            <!-- Carrusel suplementos -->
            <?php if ( dynamic_sidebar('suplementos') ) : else : endif; ?>
            <!-- Fin Carrusel suplementos -->
        </div>
    </div>

</div>
<!-- Fin Suplementos -->