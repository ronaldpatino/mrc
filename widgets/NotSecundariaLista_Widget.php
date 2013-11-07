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

        $MAX_ITEMS_LISTA = 5;

        $NOTICIA_SECUNDARIA_LISTA = get_id_real($instance['categoria']);
        $NOTICIA_PORTADA = get_id_real(54);
        $NOTICIA_DESTACADA_SECCION_CAT_ID = 53;
        $NOTICIA_DEPORTIVO_CUENCA_CAT_ID = 26;


        if ($NOTICIA_SECUNDARIA_LISTA == 5 && $NOTICIA_SECUNDARIA_LISTA != 26){
            $CATEGORIAS_EXCLUIR[0]=$NOTICIA_DESTACADA_SECCION_CAT_ID;
            $CATEGORIAS_EXCLUIR[1]=$NOTICIA_DEPORTIVO_CUENCA_CAT_ID;
        }
        else
        {
            $CATEGORIAS_EXCLUIR[]=$NOTICIA_DESTACADA_SECCION_CAT_ID;
        }


        global $wpdb, $post;

        $sql = "SELECT
                    *
                FROM wp_04vcw8_posts
                WHERE  ( (
                                    SELECT COUNT(1)
                                    FROM wp_04vcw8_term_relationships
                                    WHERE term_taxonomy_id IN ($NOTICIA_SECUNDARIA_LISTA, $NOTICIA_PORTADA)
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
                LIMIT 0, 20";


        $noticiasSecundariaLista = $wpdb->get_results($sql);

        $noticia_secundaria_lista_seccion = '<div class="span4 noticia-tricol">';

        $count = 0;
        foreach ($noticiasSecundariaLista as $post)
        {
            $category = get_the_category($post->ID);

            $mostrar = true;

            foreach($category as $c)
            {
                if (in_array($c->cat_ID, $CATEGORIAS_EXCLUIR)){
                    $mostrar = false;
                    break;
                }
            }

            if ($mostrar)
            {
                setup_postdata($post);
                $permalink = get_permalink();

                $noticia_secundaria_lista_seccion .= '<div class="media ml2p">';
                $noticia_secundaria_lista_seccion .= '<a class="pull-left" href="' . get_permalink() .'">';

                $imagen = get_featured_image($post->ID);
                $src= 'thumbs/120x74/' . $imagen;

                $noticia_secundaria_lista_seccion .= '<img src="' . $src . '" alt="' . $post->post_title . '  - El Mercurio de Cuenca Noticias Tiempo  Ecuador Azuay" title="' . $post->post_title . '  - El Mercurio de Cuenca Noticias Tiempo  Ecuador Azuay">';
                $noticia_secundaria_lista_seccion .= '</a>';
                $noticia_secundaria_lista_seccion .= '<div class="media-body media-body-tricol">' .'<a href="' . $permalink .'">' . $post->post_title . '</a></div>';
                $noticia_secundaria_lista_seccion .= '</div>';

                $count++;
            }

            if ($count == $MAX_ITEMS_LISTA){
                break;
            }
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
