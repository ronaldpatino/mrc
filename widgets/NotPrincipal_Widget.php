<?php

/**
 * Class NotPrincipal_Widget
 * Todas las notas marcadas como 16 (destacadas) serán motradas en este contexto
 */

class NotPrincipal_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'notprincipal_widget', // Base ID
            'M_Noticia: Principal de Seccion', // Name
            array( 'description' => __( 'Contiene una cabecera, una imagen grande y un extracto de la noticia', 'text_domain' ), ) // Args
        );
    }

    public function widget( $args, $instance ) {

        if ($instance['categoria'] == -1) {return;}



        $NOTICIA_NOTPRINCIPAL_SECCION = get_id_real($instance['categoria']);
        $NOTICIA_DESTACADA_SECCION = get_id_real(53);

        global $wpdb, $post;

        $sql = "SELECT
                    *
                FROM wp_04vcw8_posts
                WHERE  ( (
                                    SELECT COUNT(1)
                                    FROM wp_04vcw8_term_relationships
                                    WHERE term_taxonomy_id IN ($NOTICIA_NOTPRINCIPAL_SECCION, $NOTICIA_DESTACADA_SECCION)
                                    AND object_id = wp_04vcw8_posts.ID
                                ) = 2 )
                AND
                    wp_04vcw8_posts.post_type = 'post'
                AND (wp_04vcw8_posts.post_status = 'publish')
                GROUP BY
                    wp_04vcw8_posts.ID
                ORDER BY
                    wp_04vcw8_posts.post_date
                DESC
                LIMIT 0, 1";



        $noticiasNotPrincipal = $wpdb->get_results($sql);

        $noticia_principal_seccion = '';

        foreach ($noticiasNotPrincipal as $post)
        {
            setup_postdata($post);
            $permalink = get_permalink();
            $noticia_principal_seccion = '';

            $noticia_principal_seccion  .= '<div class="span4 noticia-tricol">';
            $noticia_principal_seccion .= '<ul class="thumbnails">';
            $noticia_principal_seccion .= '<li class="span12">';
            $noticia_principal_seccion .= '<div class="thumbnail thumbnail-custom">';
            $noticia_principal_seccion .= '<h3><a href="' . $permalink . '">' . $post->post_title . '</a></h3>';
            $imagen = get_featured_image($post->ID);
            $src= 'thumbs/345x260/' . $imagen;
            $noticia_principal_seccion .= '<a href="' . $permalink . '">' . '<img src="' . $src . '" alt="' . $post->post_title . 'alt="' . $post->post_title . '  - El Mercurio de Cuenca Noticias Tiempo  Ecuador Azuay" title="' . $post->post_title . '  - El Mercurio de Cuenca Noticias Tiempo  Ecuador Azuay">' . '</a>';
            /*330 * 154*/
            $noticia_principal_seccion .= '<p>' . '<a href="' . $permalink . '">' . get_summary(limpia_contenido($post->post_content), 100) . '' . '</p>';
            $noticia_principal_seccion .= '</div></li></ul></div>';
        }

        echo $noticia_principal_seccion;

    }

    public function form( $instance )
    {
        $selected =  (isset($instance['categoria']) && $instance['categoria'] != -1)?$instance['categoria']:-1;

        $form  = '<p>';
        $form .= '<label for="' . $this->get_field_id( 'categoria' ) . '">'  . _e( 'Seccion:' ) . '</label>';
        $form .= wp_dropdown_categories(array('selected'=> $selected, 'show_option_none' => __('Ninguna'), 'hide_empty' => 0, 'id' => $this->get_field_id( 'categoria' ) ,'name' => $this->get_field_name( 'categoria' ), 'orderby' => 'name', 'hierarchical' => true, 'echo'=>0));
        $form .= '</p>';
        echo $form;
    }

    public function update( $new_instance, $old_instance )
    {
        $instance = array();
        $instance['categoria'] = strip_tags( $new_instance['categoria'] );
        return $instance;
    }
}

register_widget('NotPrincipal_Widget');

?>
