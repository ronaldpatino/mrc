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


<?php if (have_posts())



while (have_posts()) :


the_post(); ?>



<!-- detalle de la noticia -->


<article role="main" class="primary-content" id="post-<?php the_ID(); ?>">


<header>


    <h2><?php the_title(); ?></h2>


    <p>Publicado el <?php the_time('Y/m/d') ?> por  <?php echo get_the_author(); ?>





        <?php get_template_part('blocks/socialtags'); ?>



        <br>


</header>



<?php

$cadena = '';

$primero = true;

$count =0;

if (has_post_thumbnail()) {


    $imagen = get_featured_image(get_the_ID());

    $src = '/thumbs/685x340xS/' . $imagen;


    $cadena .= '<div class="active item itembg">';

    $cadena .= "<img  src='{$src}' alt='" . get_the_title() . "  - El Mercurio de Cuenca Noticias Tiempo  Ecuador Azuay' title='" . get_the_title() . "  - El Mercurio de Cuenca Noticias Tiempo  Ecuador Azuay'/>";


    $caption = the_post_thumbnail_caption();

    if (strlen($caption)) {

        $cadena .= "<div class='carousel-caption carousel-caption_imagenes_noticia'>";

        $cadena .= "<p>{$caption}</p>";

        $cadena .= '</div>';

    }

    $cadena .= '</div>';

    $primero = false;

    $count++;

}


$has_attachment = false;

$attachments = mrc_get_image_attachments(get_the_ID());


if ($attachments) {

    $has_attachment = true;

    foreach ($attachments as $attachment) {


        if ($primero) {

            $imagen = strip_url_image($attachment->guid);

            $src = '/thumbs/685x340xS/' . $imagen;


            $cadena .= '<div class="active item itembg">';

            $cadena .= "<img  src='{$src}' alt='{$attachment->post_excerpt}  - El Mercurio de Cuenca Noticias Tiempo  Ecuador Azuay' title='{$attachment->post_excerpt}  - El Mercurio de Cuenca Noticias Tiempo  Ecuador Azuay'/>";

            if (strlen($attachment->post_excerpt)) {

                $cadena .= "<div class='carousel-caption carousel-caption_imagenes_noticia'>";

                $cadena .= "<p>{$attachment->post_excerpt}</p>";

                $cadena .= '</div>';

            }

            $cadena .= '</div>';

            $primero = false;


        } else {


            $imagen = strip_url_image($attachment->guid);

            $src = '/thumbs/685x340xS/' . $imagen;


            $cadena .= '<div class="item itembg">';

            $cadena .= "<img  src='{$src}' alt='{$attachment->post_excerpt}   - El Mercurio de Cuenca Noticias Tiempo  Ecuador Azuay' title='{$attachment->post_excerpt}  - El Mercurio de Cuenca Noticias Tiempo  Ecuador Azuay'/>";

            if (strlen($attachment->post_excerpt)) {

                $cadena .= "<div class='carousel-caption carousel-caption_imagenes_noticia'>";

                $cadena .= "<p>{$attachment->post_excerpt}</p>";

                $cadena .= '</div>';

            }

            $cadena .= '</div>';


        }

        $count++;
    }

}



?>




<br/>

<?php if (strlen($cadena)): ?>

    <div id="imagenes_noticia" class="carousel slide">

        <!-- Carousel items -->

        <div class="carousel-inner">

            <?php echo $cadena; ?>

        </div>

        <!-- Carousel nav -->
        <?php if($count > 1):?>

        <a class="carousel-control left" href="#imagenes_noticia" data-slide="prev">&lsaquo;</a>

        <a class="carousel-control right" href="#imagenes_noticia" data-slide="next">&rsaquo;</a>
        <?php endif;?>

    </div>
<?php endif; ?>







<?php the_content(); ?>

<hr/>



<?php //comments_template('', true); ?>





<!-- fin detalle de la noticia -->



<?php endwhile; ?>





<?php get_template_part('blocks/socialtags'); ?>


</article>


</div>


<div class='span4 sidebar'>


    <?php if (dynamic_sidebar('detallenoticia')) : else : endif; ?>


</div>


</div>


</div>







<?php wpb_set_post_views(get_the_ID()); ?>



<?php get_template_part('blocks/pie'); ?>



<?php get_template_part('blocks/twitter'); ?>



<?php get_footer(); ?>



