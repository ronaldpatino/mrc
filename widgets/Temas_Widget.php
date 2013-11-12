<?php

class Temas_Widget extends WP_Widget {

    private $max_noticias;
    public function __construct() {
        parent::__construct(
            'temas_widget', // Base ID
            'M_Opinion: Bloque Tema', // Name
            array( 'description' => __( 'Temas', 'text_domain' ), ) // Args
        );

        $this->max_noticias = 4;
    }

    public function widget( $args, $instance ) {

        if (!isset($instance['numberposts'])) {$instance['numberposts']= $this->max_noticias;}

        $NOTICIA_OPINION = get_category_by_slug('temas');

        global $wpdb, $post;

        $sql = "    SELECT
					a.ID, a.post_date, a.post_title, a.post_content, a.post_author, a.post_name, a.post_excerpt, a.comment_status

                FROM wp_04vcw8_posts a, wp_04vcw8_term_relationships b, wp_04vcw8_term_taxonomy c

				WHERE

					a.id = b.object_id

				AND
					b.term_taxonomy_id = c.term_taxonomy_id

				AND
					c.term_id = '{$NOTICIA_OPINION->cat_ID}'
				AND
					a.post_type = 'post'

				AND
					a.post_status = 'publish'

				ORDER BY
					a.post_date
                DESC

                LIMIT 0,$this->max_noticias";

        $noticiasSecundariaLista = $wpdb->get_results($sql);


        $opinion = '<h2><a href="' . get_home_url() . '/temas" >Temas</a></h2>';
        $noticia_secundaria_lista_seccion = '<div class="span4 noticia-tricol">';

        foreach ($noticiasSecundariaLista as $post)
        {
            setup_postdata($post);
            $permalink = get_permalink();

            $opinion .= '<h3>';
            $opinion .= '<a href="' . $permalink .'">';
            $opinion .= strtoupper($post->post_title);
            $opinion .= '</a>';
            $opinion .= '</h3>';
            $opinion .= '<p>';
            $opinion .= '<a href="' . $permalink .'">';
            $opinion .=   get_summary($post->post_content,70);
            $opinion .= '</a>';
            $opinion .= '</p>';
            $opinion .= '<hr/>';
        }

        echo $opinion;
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

register_widget('Temas_Widget');
