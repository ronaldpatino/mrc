<?php

class Seccion_Widget extends WP_Widget
{

    public function __construct()
    {
        parent::__construct(
            'seccion_widget', // Base ID
            'M_Noticias: Seccion Noticias', // Name
            array('description' => __('Una noticia con una imagen grande y tres noticias alineadas a la derecha con una imagen pequeña cada una alineada a la izquierda, en sentido vertical', 'text_domain'),) // Args
        );
    }

    public function widget($args, $instance)
    {

        if ($instance['categoria'] == -1) {
            return;
        }


        $NOTICIA_SECCION = get_id_real($instance['categoria']);

        global $wpdb, $post;



        $sql = "SELECT
                  *
                FROM
                    wp_04vcw8_posts
                INNER JOIN
                    wp_04vcw8_term_relationships ON (wp_04vcw8_posts.ID = wp_04vcw8_term_relationships.object_id)
                WHERE
                    ( wp_04vcw8_term_relationships.term_taxonomy_id IN ({$NOTICIA_SECCION}) )
                AND
                    wp_04vcw8_posts.post_type = 'post'
                AND (wp_04vcw8_posts.post_status = 'publish')
                GROUP BY
                    wp_04vcw8_posts.ID
                ORDER BY
                    wp_04vcw8_posts.post_date
                DESC LIMIT 0, 4";


        $noticiaSeccion = $wpdb->get_results($sql);
        $category = get_category($instance['categoria']);

        $post_imprimir  = '<div class="span4 noticia-tricol">';
        $post_imprimir .= '<h2 class="cultura"><a href="' . get_home_url() . '/'. strtolower($category->slug) . '">' . $category->name . '</a></h2>';
        $primera_noticia = true;
        foreach ($noticiaSeccion as $post) {
            setup_postdata($post);
            $permalink = get_permalink();

            if ($primera_noticia) {
                $post_imprimir .= '<ul class="thumbnails">';
                $post_imprimir .= '<li class="span12"><div class="thumbnail thumbnail-custom"><h3>';
                $post_imprimir .= '<a href="' . $permalink . '">' . $post->post_title . '</a></h3>';

                $imagen = get_featured_image($post->ID);
                $src= 'thumbs/332x260/' . $imagen;


                $post_imprimir .= '<a href="' . $permalink . '">' . '<img src="' . $src . '" alt="' . $post->post_title . '  - El Mercurio de Cuenca Noticias Tiempo  Ecuador Azuay" title="' . $post->post_title . '  - El Mercurio de Cuenca Noticias Tiempo  Ecuador Azuay">' . '</a>';
                $post_imprimir .= '<p>' . '<a href="' . $permalink . '">' . get_summary(limpia_contenido($post->post_content), 90) . '</a>' . '</p>';
                $post_imprimir .= '</div></li></ul>';
                $primera_noticia = false;
            } else {
                $post_imprimir .= '<div class="media ml2p">';
                $post_imprimir .= '<a class="pull-left" href="' . $permalink . '">';

                $imagen = get_featured_image($post->ID);
                $src= 'thumbs/120x74/' . $imagen;
                $post_imprimir .= '<img src="' . $src . '" alt="' . $post->post_title . '  - El Mercurio de Cuenca Noticias Tiempo  Ecuador Azuay"' . '" title="' . $post->post_title . '  - El Mercurio de Cuenca Noticias Tiempo  Ecuador Azuay">';
                $post_imprimir .= '</a>';
                $post_imprimir .= '<div class="media-body media-body-tricol">' . '<a class="pull-left" href="' . $permalink . '">' . $post->post_title . '</a></div>';
                $post_imprimir .= '</div>';
            }

        }
        $post_imprimir .= '<br/></div>';
        echo $post_imprimir;


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

register_widget('Seccion_Widget');

?>
