<?php

class PortadaImpresa extends WP_Widget {

    private $max_noticias;
    public function __construct() {
        parent::__construct(
            'portadaimpresa_widget', // Base ID
            'M_Noticias: Portada Impresa', // Name
            array( 'description' => __( 'Imagen de la portada del día', 'text_domain' ), ) // Args
        );

        $this->max_noticias = 1;
    }

    public function widget( $args, $instance ) {


        $NOTICIA_PORTADA_IMPRESA = 8043;

        global $wpdb, $post;

        $sql = "    SELECT
					a.ID, a.post_date, a.post_title, a.post_content, a.post_author, a.post_name, a.post_excerpt, a.comment_status

                FROM wp_04vcw8_posts a, wp_04vcw8_term_relationships b, wp_04vcw8_term_taxonomy c

				WHERE

					a.id = b.object_id

				AND
					b.term_taxonomy_id = c.term_taxonomy_id

				AND
					c.term_id = '{$NOTICIA_PORTADA_IMPRESA}'

				AND
					a.post_type = 'post'

				AND
					a.post_status = 'publish'

				ORDER BY
					a.post_date
                DESC

                LIMIT 0,1";

        $portadaImpresa = $wpdb->get_results($sql);

        $impreso = '';
        foreach ($portadaImpresa as $post)
        {
            setup_postdata($post);
            $permalink = get_permalink();

            $impreso = '<ul class="thumbnails" style="margin-top: 20px;">';
            $impreso .= '<li class="span12 thumbnail portada" style="text-align: center;"><h3>Portada</h3>';

            $imagen = get_featured_image($post->ID);
            $src= 'thumbs/276x95/' . $imagen;

            $impreso .= '<img src="' . $src . '" alt="' . $post->post_title . '  - El Mercurio de Cuenca Noticias Tiempo  Ecuador Azuay" title="' . $post->post_title . '  - El Mercurio de Cuenca Noticias Tiempo  Ecuador Azuay">';
            $impreso .= '</li></ul>';

        }

        echo $impreso;

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


}

register_widget('PortadaImpresa');
