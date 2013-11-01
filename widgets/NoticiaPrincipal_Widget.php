<?php

class NoticiaPrincipal extends WP_Widget {

    private $max_noticias;
    public function __construct() {
        parent::__construct(
            'noticiaprincipal_widget', // Base ID
            'M_Noticias: Noticia Principal', // Name
            array( 'description' => __( 'Noticia principal, contiene cabecera, imagen grande y extracto', 'text_domain' ), ) // Args
        );

        $this->max_noticias = 1;
    }

    public function widget( $args, $instance ) {

        if (!isset($instance['numberposts'])) {$instance['numberposts']= $this->max_noticias;}

        $NOTICIA_PRINCIPAL = 8036;

        global $wpdb, $post;

        $sql = "    SELECT
					a.ID, a.post_date, a.post_title, a.post_content, a.post_author, a.post_name, a.post_excerpt, a.comment_status

                FROM wp_04vcw8_posts a, wp_04vcw8_term_relationships b, wp_04vcw8_term_taxonomy c

				WHERE

					a.id = b.object_id

				AND
					b.term_taxonomy_id = c.term_taxonomy_id

				AND
					c.term_id = '{$NOTICIA_PRINCIPAL}'

				AND
					a.post_type = 'post'

				AND
					a.post_status = 'publish'

				ORDER BY
					a.post_date
                DESC

                LIMIT 0,1";

        $noticiaPrincipal = $wpdb->get_results($sql);
        $noticia = '';
        foreach ($noticiaPrincipal as $post)
        {
            setup_postdata($post);
            $permalink = get_permalink();
            $noticia .= '<h2><a href="' . $permalink . '">' . $post->post_title . '</a></h2>';

            $imagen = get_featured_image($post->ID);
            $src= getphpthumburl($imagen, 'w=696&h=344&zc=1&q=90');
            $noticia .= '<a href="' . $permalink . '"><img src="' . $src . '" alt="' . $post->post_title . '  - El Mercurio de Cuenca Noticias Tiempo  Ecuador Azuay" title="' . $post->post_title . ' - ' . '  - El Mercurio de Cuenca Noticias Tiempo  Ecuador Azuay"></a>';
            $noticia .= '<p><a href="' .$permalink . '">'. get_summary(limpia_contenido($post->post_content)) . '</a> </p>';
        }

        echo $noticia;
    }

    public function form( $instance )
    {
    }

    public function update( $new_instance, $old_instance )
    {
        $instance = array();
        $instance['numberposts'] = strip_tags( $new_instance['numberposts'] );
        return $instance;
    }

    private function get_selected($numberposts, $post)
    {
        if ( $numberposts == $post )
        {
            return 'selected="selected"';
        }

        return '';

    }
}

register_widget('NoticiaPrincipal');
