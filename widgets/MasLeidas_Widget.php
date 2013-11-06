<?php
/**
 * Class Masleidas
 */
class MasLeidas_Widget extends WP_Widget {

    private $max_noticias;
    public function __construct() {
        parent::__construct(
            'masleidas_widget', // Base ID
            'M_Noticias: Noticias Mas Leidas', // Name
            array( 'description' => __( 'Listado de Noticias mas leidas', 'text_domain' ), ) // Args
        );

        $this->max_noticias = 7;
    }

    public function widget( $args, $instance ) {

        if (!isset($instance['numberposts'])) {$instance['numberposts']= $this->max_noticias;}
        global $wpdb, $post;
        $date = date('Y-m-d');
        $date_semana = date ( 'Y-m-d', strtotime ( '-7 day' . $date ) );

        $sql = "SELECT
                   *
                FROM
                    wp_04vcw8_posts, wp_04vcw8_postmeta
                WHERE
                    wp_04vcw8_posts.ID = wp_04vcw8_postmeta.post_id
                AND
                    wp_04vcw8_postmeta.meta_key='wpb_post_views_count'
                AND
                    wp_04vcw8_posts.post_status='publish'
                AND
                    wp_04vcw8_posts.post_type='post'
                AND
                    wp_04vcw8_posts.post_date <= '{$date}'
				AND
                    wp_04vcw8_posts.post_date >= '{$date_semana}'
                AND
                    wp_04vcw8_postmeta.meta_value+0 > 0
                ORDER BY
                    wp_04vcw8_postmeta.meta_value+0
                DESC
				  LIMIT 0,{$instance['numberposts']}";

        $noticiasMasLeidas = $wpdb->get_results($sql);

        $mas_leidas = '<h2>M&aacute;s Le&iacute;das</h2>';
        $mas_leidas .= '<ul class="nav nav-tabs nav-stacked">';

        foreach ($noticiasMasLeidas as $post) {

            $mas_leidas .= '<li><a href="' . get_permalink() . '" title="' .$post->post_title . '" >' . $post->post_title . ' <span class="label label-warning">' . wpb_get_post_views($post->ID) . '</span></a> </li> ';
        }
        $mas_leidas .= '</ul>';

        echo $mas_leidas;
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

register_widget('MasLeidas_Widget');
