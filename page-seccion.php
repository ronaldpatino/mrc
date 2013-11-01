<?php
/*
Template Name: Pagina Interior Seccion
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
            

            $args = array(

                'cat' => get_seccion(),
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'DESC',
                'posts_per_page' => 10,
                'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1 ),

            );

            query_posts($args);

            ?>

            <ul class="media-list">
            <?php

            if ( have_posts() ) :
                while ( have_posts() ) :
                    the_post();
                    $imagen = get_featured_image(get_the_ID());
                    ;?>


                        <li class="media mlseccion">
                            <a class="pull-left" href="<?php the_permalink();?>">

                                <?php $src = getphpthumburl($imagen, 'w=170&h=124&zc=1');?>
                                <img class="media-object" src="<?php echo $src;?>" alt="<?php echo  get_the_title(); ?>" title="<?php echo  get_the_title(); ?>">
                            </a>
                            <div class="media-body">
                                <h3><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h3>
                                <p> <?php echo get_summary(limpia_contenido(get_the_content('', false)));?></p>
                                <p>Publicado el <?php the_time('Y/m/d') ?></p>
                            </div>
                        </li>
                        <li>
                            <hr/>
                        </li>


                <?php endwhile;?>
            </ul>
        <?php mrc_paging_nav(); ?>
            <?php endif;?>

        </div>
        <div class='span4 sidebar'>

            <?php if ( dynamic_sidebar('detallenoticia') ) : else : endif; ?>

        </div>
    </div>

</div>

<?php get_template_part('blocks/pie'); ?>
<?php get_template_part('blocks/twitter'); ?>

<?php get_footer(); ?>
