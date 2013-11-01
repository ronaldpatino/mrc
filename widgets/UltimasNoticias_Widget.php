<?php

class UltimasNoticias extends WP_Widget {

    private $max_noticias;
    public function __construct() {
        parent::__construct(
            'ultimasnoticias_widget', // Base ID
            'M_Noticias: Ultimas Noticias', // Name
            array( 'description' => __( 'Listado de Ultima Noticias', 'text_domain' ), ) // Args
        );

        $this->max_noticias = 10;
    }

    public function widget( $args, $instance ) {

        if (!isset($instance['numberposts'])) {$instance['numberposts']= $this->max_noticias;}
        global $wpdb,  $post;
        $NOTICIA_LO_ULTIMO =    18;


        $sql = "SELECT
					a.ID, a.post_date, a.post_title, a.post_content, a.post_author, a.post_name, a.post_excerpt, a.comment_status

                                FROM wp_04vcw8_posts a, wp_04vcw8_term_relationships b, wp_04vcw8_term_taxonomy c

				WHERE

					a.id = b.object_id

				AND
					b.term_taxonomy_id = c.term_taxonomy_id

				AND
					c.term_id = '{$NOTICIA_LO_ULTIMO}'

				AND
					a.post_type = 'post'

				AND
					a.post_status = 'publish'

				ORDER BY
					a.post_date DESC LIMIT 0,".$instance['numberposts']."";

        $ultimasNoticias = $wpdb->get_results($sql);

        $noticia = '<h2>&Uacute;ltimas Noticias</h2>';
        $noticia .= '<ul class="nav nav-tabs nav-stacked">';

        foreach ($ultimasNoticias as $post) {
            $noticia .= '<li><a href="' . get_permalink() . '" title="' . $post->post_title . '" ><span class="label label-inverse">' . mysql2date('H:i', $post->post_date) . '</span> ' . $post->post_title . '</a> </li> ';
        }
        $noticia .= '</ul>';
        echo $noticia;


    }

    public function form( $instance )
    {
        if (!isset($instance['numberposts'])) {$instance['numberposts']= $this->max_noticias;}

        $form  = '<p>';
        $form .= '<label for="' . $this->get_field_id( 'numberposts' ) . '">'  . _e( 'Numero de noticias:' ) . '</label>';

        $form .= '<select id="' . $this->get_field_id( 'numberposts' ) . '" name="' . $this->get_field_name( 'numberposts' ) . '">';

        for($i=1; $i<=$this->max_noticias; $i++)
        {
            $form .= '<option value="' . $i . '" ' . $this->get_selected($instance['numberposts'],$i) . ' >' . $i . '</option>';
        }

        $form .= '</select>';

        $form .= '</p>';
        echo $form;
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

register_widget('UltimasNoticias');

?>