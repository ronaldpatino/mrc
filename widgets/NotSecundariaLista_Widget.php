<?php
/**
 * Class NotSecundariaLista
 * Las noticias marcadas como destacadas (16) no seran mostradas
 */
class NotSecundariaLista extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'notsecundarialista_widget', // Base ID
            'M_Noticia: Secundaria Lista Imagenes', // Name
            array( 'description' => __( 'Listado Vertical de noticias con una imagenes pequeña a la izquierda y texto a la derecha', 'text_domain' ), ) // Args
        );
    }

    public function widget( $args, $instance ) {

        if ($instance['categoria'] == -1) {return;}

        $NOTICIA_SECUNDARIA_LISTA = $instance['categoria'];

        global $wpdb, $post;

        $sql = "SELECT
                    *
                FROM wp_04vcw8_posts
                WHERE  ( (
                                    SELECT COUNT(1)
                                    FROM wp_04vcw8_term_relationships
                                    WHERE term_taxonomy_id IN ($NOTICIA_SECUNDARIA_LISTA, 4249)
                                    AND object_id = wp_04vcw8_posts.ID
                                ) = 1 )
                AND
                    wp_04vcw8_posts.post_type = 'post'
                AND (wp_04vcw8_posts.post_status = 'publish')
                GROUP BY
                    wp_04vcw8_posts.ID
                ORDER BY
                    wp_04vcw8_posts.post_date
                DESC
                LIMIT 0, 5";


        $noticiasSecundariaLista = $wpdb->get_results($sql);

        $noticia_secundaria_lista_seccion = '<div class="span4 noticia-tricol">';

        foreach ($noticiasSecundariaLista as $post)
        {
            setup_postdata($post);
            $permalink = get_permalink();

            $noticia_secundaria_lista_seccion .= '<div class="media ml2p">';
            $noticia_secundaria_lista_seccion .= '<a class="pull-left" href="' . get_permalink() .'">';

            $imagen = get_featured_image($post->ID);
            $src= getphpthumburl($imagen, 'w=120&h=74&zc=1&q=90');


            $noticia_secundaria_lista_seccion .= '<img src="' . $src . '" alt="' . $post->post_title . '  - El Mercurio de Cuenca Noticias Tiempo  Ecuador Azuay" title="' . $post->post_title . '  - El Mercurio de Cuenca Noticias Tiempo  Ecuador Azuay">';
            $noticia_secundaria_lista_seccion .= '</a>';
            $noticia_secundaria_lista_seccion .= '<div class="media-body media-body-tricol">' .'<a href="' . $permalink .'">' . $post->post_title . '</a></div>';
            $noticia_secundaria_lista_seccion .= '</div>';

        }

        $noticia_secundaria_lista_seccion .= '</div>';
        echo $noticia_secundaria_lista_seccion;
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

register_widget('NotSecundariaLista');

?>