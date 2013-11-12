<?php
/*
Template Name: Pagina Impreso
*/
get_header(); ?>


<!-- Cabecera, titulares -->
<div class='container'>

    <?php get_template_part('blocks/menutop'); ?>
    <?php get_template_part('blocks/logo'); ?>
    <?php get_template_part('blocks/navbartop'); ?>
</div>

<?php get_template_part('blocks/publicidadcabecera'); ?>

<!-- Fin cabecera, titulares -->

<div class='container'>
    <?php get_template_part('blocks/masleido'); ?>

    <div id='content' class='row-fluid'>
        <div class='span8 main'>


            <?php

                if (isset($_GET['io6971'])){
                    $fecha = is_numeric($_GET['io6971']) ?  date('Y-m-d', $_GET['io6971']):date('Y-m-d');
                }
                else {
                    $fecha =  date('Y-m-d');
                }

                $portada_date = get_portada_by_date($fecha);
            ?>

            <?php if ($portada_date):?>
                <h2>Versi&oacute;n Impresa del <?php echo $fecha?></h2>
                <?php echo  $portada_date;?>
            <?php endif;?>
            <?php echo get_portadas_anteriores(); ?>

        </div>
        <div class='span4 sidebar'>

            <?php if ( dynamic_sidebar('detallenoticia') ) : else : endif; ?>

        </div>
    </div>

</div>

<?php get_template_part('blocks/pie'); ?>
<?php get_template_part('blocks/twitter'); ?>

<?php get_footer(); ?>
