<?php

class Farandula_Widget extends WP_Widget
{

    public function __construct()
    {
        parent::__construct(
            'Farandula_Widget', // Base ID
            'M_Farandula: Farandula', // Name
            array('description' => __('Farandula', 'text_domain'),)
        );

        $this->max_noticias = 7;
    }

    public function widget($args, $instance)
    {

        if ($instance['categoria'] == -1) {return;}

        $NOTICIA_FARANDULA = 48;

        global $wpdb, $post;

        $sql = "    SELECT
					a.ID, a.post_date, a.post_title, a.post_content, a.post_author, a.post_name, a.post_excerpt, a.comment_status

                FROM wp_04vcw8_posts a, wp_04vcw8_term_relationships b, wp_04vcw8_term_taxonomy c

				WHERE

					a.id = b.object_id

				AND
					b.term_taxonomy_id = c.term_taxonomy_id

				AND
					c.term_id = '{$NOTICIA_FARANDULA}'

				AND
					a.post_type = 'post'

				AND
					a.post_status = 'publish'

				ORDER BY
					a.post_date
                DESC

                LIMIT 0,{$this->max_noticias}";

        $noticiaFarandula = $wpdb->get_results($sql);
        $activo = 1;
        $farandula  = "<div id='farandulamain' class='carousel slide'>";
        $farandula .= '<div class="carousel-inner">';

        foreach ($noticiaFarandula as $post)
        {
            setup_postdata($post);
            $permalink = get_permalink();

            if ($activo) {
                $farandula .= '<div class="item active">';
                $activo = 0;
            } else {
                $farandula .= '<div class="item">';
            }

            $farandula .= '<ul class="thumbnails sociales-thumbnails">';

            $imagen = get_featured_image($post->ID);
            $src = getphpthumburl($imagen, 'w=390&h=355&iar=1');
            $farandula .= "<li class='span12'>";

            $farandula .= '<a href="' . $permalink . '">';
            $farandula .= '<img class="img_farandula" widht="390" height="355" src="' . $src . '" alt="' . $post->post_title . '  - El Mercurio de Cuenca Noticias Tiempo  Ecuador Azuay" title="' . $post->post_title . '  - El Mercurio de Cuenca Noticias Tiempo  Ecuador Azuay">';
            $farandula .= "<div class='carousel-caption carousel-caption_imagenes_noticia'>";
            $farandula .= '<p>' . $post->post_title . '</p>';
            $farandula .= '</div>';
            $farandula .= '</a>';
            $farandula .= "</li>";
            //Fin Loop 3
            $farandula .= '</ul>';
            $farandula .= '</div>';
        }

        $farandula .= '</div>';
        $farandula .= '<a data-slide="prev" href="#farandulamain"  class="left farandula-carousel-control">&nbsp;</a>';
        $farandula .= '<a data-slide="next" href="#farandulamain"  class="right farandula-carousel-control">&nbsp;</a>';
        $farandula .= '</div>';

        echo $farandula;
    }

    public function form($instance)
    {
        $selected = (isset($instance['categoria']) && $instance['categoria'] != -1) ? $instance['categoria'] : -1;

        $form = '<p>';
        $form .= "farandula";
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

register_widget('Farandula_Widget');
