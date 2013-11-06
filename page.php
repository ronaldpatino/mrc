<?php get_header(); ?>

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

            <?php /* The loop */ ?>
            <?php while ( have_posts() ) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
                            <div class="entry-thumbnail">
                                <?php the_post_thumbnail(); ?>
                            </div>
                        <?php endif; ?>

                        <h2><?php the_title(); ?></h2>
                    </header><!-- .entry-header -->

                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div><!-- .entry-content -->


                </article><!-- #post -->


            <?php endwhile; ?>
        </div>
        <div class='span4 sidebar'>

            <?php if ( dynamic_sidebar('detallenoticia') ) : else : endif; ?>

        </div>
    </div>

</div>

<?php wpb_set_post_views(get_the_ID());?>

<?php get_template_part('blocks/pie'); ?>
<?php get_template_part('blocks/twitter'); ?>

<?php get_footer(); ?>
