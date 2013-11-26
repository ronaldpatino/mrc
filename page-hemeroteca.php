<?php
/*
Template Name: Pagina Hemeroteca
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
        <div class='span12 main'>

            <div class="row-fluid">
                <div class="span8">
                    ISSUU
                </div>
                <div class="span4">
                    <div  id="sandbox-container">
                        <div></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row-fluid">
            <div class="span12 main">
                <div class="row-fluid">
                    <div class="span4">
                        ...
                    </div>
                    <div class="span4">
                        ...
                    </div>
                    <div class="span4">
                        ...
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<?php get_template_part('blocks/pie'); ?>
<?php get_template_part('blocks/twitter'); ?>

<?php get_footer(); ?>
