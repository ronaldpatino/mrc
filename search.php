<?php
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

            <?php if ( have_posts() ) : ?>
            <article role="main" class="page-content search-content">
                <h2><?php printf( __( 'Resultados para la búsqueda: %s' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
                <?php while ( have_posts() ) : the_post(); ?>
                    <strong><a href="<?php echo get_permalink( get_the_ID()); ?>"><?php the_title(); ?></a></strong>
                    <p> <?php echo substr(limpia_contenido(get_the_content('', false)), 0, 300);?>... </p>
                    <p>Publicado el <?php the_time('Y/m/d') ?> por  <?php echo get_the_author(); ?>
                    <hr>
                <?php endwhile; ?>
                <?php mrc_paging_nav(); ?>

                <?php else : ?>
                    <h1><?php printf( __( 'No se encontraron resultados para: %s' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
                    <article class="entry-content">
                        <p><?php _e( 'Lo sentimos no se encontraron entradas para su búsqueda. Por favor intente con otras palabras.' ); ?></p>
                        <?php ?>
                    </article><!-- .entry-content -->
                <?php endif; ?>
            </article>



        </div>
        <div class='span4 sidebar'>

            <?php if ( dynamic_sidebar('detallenoticia') ) : else : endif; ?>

        </div>
    </div>

</div>

<?php get_template_part('blocks/pie'); ?>
<?php get_template_part('blocks/twitter'); ?>

<?php get_footer(); ?>
