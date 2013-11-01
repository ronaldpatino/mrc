<?php get_header(); ?>


<!-- Cabecera, titulares -->
<div class='container'>
    <?php get_template_part( 'blocks/menutop' ); ?>
</div>
<div class='container'>
    <?php get_template_part( 'blocks/logo' ); ?>
    <?php get_template_part( 'blocks/navbartop' ); ?>
</div>

<?php get_template_part( 'blocks/publicidadcabecera' ); ?>

<div class='container'>
    <?php get_template_part( 'blocks/masleido' ); ?>
    <?php get_template_part( 'blocks/titulares' ); ?>
</div>
<!-- Fin cabecera, titulares -->

<?php get_template_part( 'blocks/publicidadtitulares' ); ?>

<?php get_template_part( 'blocks/culturacuencasucesos' ); ?>

<?php get_template_part( 'blocks/sociales' ); ?>

<?php get_template_part( 'blocks/azuaycanarloja' ); ?>



<?php get_template_part( 'blocks/deportes' ); ?>

<?php get_template_part( 'blocks/deportivocuenca' ); ?>

<?php get_template_part( 'blocks/opinion' ); ?>

<?php get_template_part( 'blocks/multimedia' ); ?>

<?php get_template_part( 'blocks/suplementos' ); ?>

<?php get_template_part( 'blocks/pie' ); ?>

<?php get_template_part( 'blocks/twitter' ); ?>

<?php get_footer(); ?>
