<?php

class Caricatura_Widget extends WP_Widget
{

    public function __construct()
    {
        parent::__construct(
            'caricatura_widget', // Base ID
            'M_Caricatura: Caricatura', // Name
            array('description' => __('Caricaturas', 'text_domain'),)
        );

        $this->max_noticias = 7;
    }

    public function widget($args, $instance)
    {

        if ($instance['categoria'] == -1) { return;}

        $NOTICIA_CARICATURA = 13;

        global $wpdb, $post;

        $sql = "    SELECT
					a.ID, a.post_date, a.post_title, a.post_content, a.post_author, a.post_name, a.post_excerpt, a.comment_status

                FROM wp_04vcw8_posts a, wp_04vcw8_term_relationships b, wp_04vcw8_term_taxonomy c

				WHERE

					a.id = b.object_id

				AND
					b.term_taxonomy_id = c.term_taxonomy_id

				AND
					c.term_id = '{$NOTICIA_CARICATURA}'

				AND
					a.post_type = 'post'

				AND
					a.post_status = 'publish'

				ORDER BY
					a.post_date
                DESC

                LIMIT 0,7";

        $noticiaCaricatura = $wpdb->get_results($sql);
        $activo = 1;
        $caricatura  = "<div id='caricaturamain' class='carousel slide'>";
        $caricatura .= '<div class="carousel-inner">';

        foreach ($noticiaCaricatura as $post)
        {
            setup_postdata($post);
            $permalink = get_permalink();

            if ($activo) {
                $caricatura .= '<div class="item active">';
                $activo = 0;
            } else {
                $caricatura .= '<div class="item">';
            }

            $caricatura .= '<ul class="thumbnails caricatura-thumbnails">';

            $imagen = get_featured_image($post->ID);
            $src= 'thumbs/346x346xE/' . $imagen;
            $src_big= 'thumbs/400x400xS/' . $imagen;

            $caricatura .= "<li class='span12'>";
            $caricatura .= '<a href="#carruselCaricatura" data-caption=" ' . $post->post_title . '"  data-img="' . $src_big . '" data-toggle="modal">';
            $caricatura .= '<img class="img_caricatura" src="' . $src . '" alt="' . $post->post_title . '  - El Mercurio de Cuenca Noticias Tiempo  Ecuador Azuay" title="' . $post->post_title . '  - El Mercurio de Cuenca Noticias Tiempo  Ecuador Azuay">';
            $caricatura .= "<div class='carousel-caption carousel-caption_imagenes_noticia' data-interval='10000'>";
            $caricatura .= '<p>' . $post->post_title . ' - ' . get_the_time('Y/m/d') .  '</p>';
            $caricatura .= '</div>';
            $caricatura .= '</a>';
            $caricatura .= "</li>";
            //Fin Loop 3
            $caricatura .= '</ul>';
            $caricatura .= '</div>';
        }

        $caricatura .= '</div>';
        $caricatura .= '<a data-slide="prev" href="#caricaturamain"  class="left caricatura-carousel-control">&nbsp;</a>';
        $caricatura .= '<a data-slide="next" href="#caricaturamain"  class="right caricatura-carousel-control">&nbsp;</a>';
        $caricatura .= '</div>';


        $caricatura .= '<script type="text/javascript">jQuery(document).ready(function($) {';
        $caricatura .= "$('#caricaturamain').carousel({pause: true,interval: false});";
        $caricatura .= "$('[data-toggle=\"modal\"]').click(function(e) {e.preventDefault();var imagen_sociales = $(this).data('img');var caption_sociales = $(this).data('caption');$('.modal-body #imagen_caricatura_modal').attr('src', imagen_sociales);$('.modal-footer').html('<p>'+ caption_sociales +'</p>');});";
        $caricatura .= '});</script>';
        $caricatura .= '<div id="carruselCaricatura" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
        $caricatura .= '<div class="modal-header">';
        $caricatura .= '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        $caricatura .= '<h3><i class="icon-eye-open icon-white"></i> </h3>';
        $caricatura .= '</div>';
        $caricatura .= '<div class="modal-body">';
        $caricatura .= '<img id="imagen_caricatura_modal"  src=""/>';
        $caricatura .= '</div>';
        $caricatura .= '<div class="modal-footer"></div>';
        $caricatura .= '</div>';

        echo $caricatura;
    }

    public function form($instance)
    {
        $selected = (isset($instance['categoria']) && $instance['categoria'] != -1) ? $instance['categoria'] : -1;

        $form = '<p>';
        $form .= "Caricatura";
        $form .= '</p>';
        echo $form;
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['categoria'] = strip_tags($new_instance['categoria']);
        return $instance;
    }
}

register_widget('Caricatura_Widget');
