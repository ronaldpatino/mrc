<?php

class Multimedia_Widget extends WP_Widget
{

    public function __construct()
    {
        parent::__construct(
            'multimedia_widget', // Base ID
            'M_Carrusel: Multimdia', // Name
            array('description' => __('Carrusel de Multimedia con un texto en la parte inferior link a una pagina no zoom', 'text_domain'),)
        );
    }

    public function widget($args, $instance)
    {
        if ($instance['categoria'] == -1) {return;}

        $NOTICIA_MULTIMEDIA = $instance['categoria'];

        global $wpdb, $post;

        $sql = "    SELECT
					a.ID, a.post_date, a.post_title, a.post_content, a.post_author, a.post_name, a.post_excerpt, a.comment_status

                FROM wp_04vcw8_posts a, wp_04vcw8_term_relationships b, wp_04vcw8_term_taxonomy c

				WHERE

					a.id = b.object_id

				AND
					b.term_taxonomy_id = c.term_taxonomy_id

				AND
					c.term_id = '{$NOTICIA_MULTIMEDIA}'

				AND
					a.post_type = 'post'

				AND
					a.post_status = 'publish'

				ORDER BY
					a.post_date
                DESC

                LIMIT 0,12";

        $noticiaMultimedia = $wpdb->get_results($sql);

        $category = str_replace(" ", "_", get_the_category_by_ID($NOTICIA_MULTIMEDIA));
        $carussel_id = 'carrusel' . $category;
        $carrusel_modal = 'modal' . $category;
        $imagen_modal = 'imagen' . $category;

        $counter = 1;
        $activo = 1;

        $carrusel  = '<div class="carousel slide" id="'. $carussel_id .'">';
        $carrusel .= '<div class="carousel-inner">';

        $pintado = false;

        foreach ($noticiaMultimedia as $post)
        {
            setup_postdata($post);
            $permalink = get_permalink();

            if ($counter == 1) {
                if ($activo) {
                    $carrusel .= '<div class="item active">';
                    $activo = 0;
                } else {
                    $carrusel .= '<div class="item">';
                }

                $carrusel .= '<ul class="thumbnails sociales-thumbnails">';
            }
            //Loop 3
            $carrusel .= '<li class="span4">';
            $carrusel .= '<div class="thumbnail sociales-thumbnails-item">';

            $imagen = get_featured_image($post->ID);
            if ($NOTICIA_MULTIMEDIA == 4252){
                $src= thumb_multimedia($imagen, 'w=180&h=180&zc=1');
            }
            else{
                $src= thumb_multimedia($imagen, 'w=230&h=164&zc=1');
            }


            $carrusel .= '<a href="' . $permalink . '">' ;
            $carrusel .= '<img src="' . $src . '" alt="' .$post->post_title . '" title="' .$post->post_title . '">';
            $carrusel .= '</a>';
            $carrusel .= '<p>'.$post->post_title .'</p>';
            $carrusel .= '</div>';
            $carrusel .= '</li>';
            //Fin Loop 3


            if ($counter == 3) {
                $carrusel .= '</ul>';
                $carrusel .= '</div>';
                $counter = 1;
                $pintado = true;
            } else {
                $counter++;
                $pintado = false;
            }

        }

        if (!$pintado) {
            $carrusel .= '</ul>';
            $carrusel .= '</div>';
        }

        $carrusel .= '</div>';

        $carrusel .= '<a data-slide="prev" href="#' . $carussel_id . '" class="left sociales-carousel-control">&nbsp;</a>';
        $carrusel .= '<a data-slide="next" href="#' . $carussel_id . '" class="right sociales-carousel-control">&nbsp;</a>';
        $carrusel .= '</div>';

        echo $carrusel;

    }

    public function form($instance)
    {
        $selected = (isset($instance['categoria']) && $instance['categoria'] != -1) ? $instance['categoria'] : -1;

        $form = '<p>';
        $form .= '<label for="' . $this->get_field_id('categoria') . '">' . _e('Seccion:') . '</label>';
        $form .= wp_dropdown_categories(array('selected' => $selected, 'show_option_none' => __('Ninguna'), 'hide_empty' => 0, 'id' => $this->get_field_id('categoria'), 'name' => $this->get_field_name('categoria'), 'orderby' => 'name', 'hierarchical' => true, 'echo' => 0));
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

register_widget('Multimedia_Widget');

?>