<?php

class OtrasNotListado_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'otrasnotlistado_widget', // Base ID
            'M_Noticias: Secundarias Listado', // Name
            array( 'description' => __( 'Listado vertical de noticias sin imagenes', 'text_domain' ), ) // Args
        );
    }

    public function widget( $args, $instance ) {

        if ($instance['categoria'] == -1) {return;}
        $NOTICIA_SECUNDARIA_LISTA = $instance['categoria'];

        global $wpdb, $post;

        $sql = "SELECT
                    ID, post_title, post_date, post_name, guid
                FROM
                    wp_04vcw8_posts
                INNER JOIN wp_04vcw8_term_relationships ON (ID = wp_04vcw8_term_relationships.object_id)
                INNER JOIN wp_04vcw8_term_taxonomy ON (wp_04vcw8_term_relationships.term_taxonomy_id = wp_04vcw8_term_taxonomy.term_taxonomy_id)
                WHERE
                    wp_04vcw8_term_taxonomy.taxonomy = 'category'
                AND
                    wp_04vcw8_term_taxonomy.term_id = $NOTICIA_SECUNDARIA_LISTA
                AND
                    wp_04vcw8_term_taxonomy.term_id NOT IN(56)
                ORDER BY
                  post_date
                DESC
                LIMIT 0, 8";

        $noticiasSecundariaLista = $wpdb->get_results($sql);

        $otras_noticia_listado = '<div class="span4 noticia-tricol sidebar"><ul class="nav nav-tabs nav-stacked">';

        foreach ($noticiasSecundariaLista as $post)
        {
            setup_postdata($post);
            $permalink = get_permalink();
            $otras_noticia_listado .= '<li><a href="' . $permalink . '">' . $post->post_title . '</a></li>';
        }
        $otras_noticia_listado .= '</ul></div>';
        echo $otras_noticia_listado;
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

register_widget('OtrasNotListado_Widget');

?>