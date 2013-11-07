<?php

class NoticiasPortada extends WP_Widget
{

    private $max_noticias;

    public function __construct()
    {
        parent::__construct(
            'noticiasportada_widget', // Base ID
            'M_Noticias: Noticias de Portada', // Name
            array('description' => __('Listado de dos coluna de Noticias de Portada con foto tamaño mediano, las noticias de este listado son pares ya que se muestran en dos columnas', 'text_domain'),) // Args
        );

        $this->max_noticias = 12;
    }

    public function widget($args, $instance)
    {

        if (!isset($instance['numberposts'])) { $instance['numberposts'] = $this->max_noticias;}
        $NOTICIA_PORTADA = 54;
        global $wpdb, $post;

        $sql = "    SELECT
					a.ID, a.post_date, a.post_title, a.post_content, a.post_author, a.post_name, a.post_excerpt, a.comment_status

                FROM wp_04vcw8_posts a, wp_04vcw8_term_relationships b, wp_04vcw8_term_taxonomy c

				WHERE

					a.id = b.object_id

				AND
					b.term_taxonomy_id = c.term_taxonomy_id

				AND
					c.term_id = '{$NOTICIA_PORTADA}'
				AND
					a.post_type = 'post'

				AND
					a.post_status = 'publish'

				ORDER BY
					a.post_date
                DESC

                LIMIT 0,12";

        $noticiasPortada = $wpdb->get_results($sql);

        $noticia = '';
        $noticia_col_izq = '<div class="span6 noticia-secundaria"><ul class="thumbnails">';
        $noticia_col_der = '<div class="span6 noticia-secundaria"><ul class="thumbnails">';

        $izquierda = 0;
        $derecha = 0;

        foreach ($noticiasPortada as $post)
        {
            setup_postdata($post);
            $permalink = get_permalink();

            if ($izquierda <= 5) {
                $imagen = get_featured_image($post->ID);
                $src= 'thumbs/295x154/' . $imagen;

                $noticia_col_izq .= '<li class="span12 nomargen-abajo"><div class="thumbnail thumbnail-custom">';
                $noticia_col_izq .= '<a href="' . $permalink . '"><img class="img-cultura" src="' . $src . '" alt="' . $post->post_title . '  - El Mercurio de Cuenca Noticias Tiempo  Ecuador Azuay" title="' . $post->post_title . ' - ' . '  - El Mercurio de Cuenca Noticias Tiempo  Ecuador Azuay"></a>';
                $noticia_col_izq .= '<h3 style="height:65px;"><a href="' .$permalink . '">' . $post->post_title . '</a></h3>';
                $noticia_col_izq .= '</div></li>';
                $izquierda++;

            } else if ($derecha <= 5 && $izquierda == 6) {

                $imagen = get_featured_image($post->ID);
                $src= 'thumbs/295x154/' . $imagen;

                $noticia_col_der .= '<li class="span12 nomargen-abajo"><div class="thumbnail thumbnail-custom">';
                $noticia_col_der .= '<a href="' . $permalink . '"><img  class="img-cultura" src="' . $src . '" alt="' . $post->post_title . '  - El Mercurio de Cuenca Noticias Tiempo  Ecuador Azuay" title="' . $post->post_title . ' - ' . '  - El Mercurio de Cuenca Noticias Tiempo  Ecuador Azuay"></a>';
                $noticia_col_der .= '<h3 style="height:65px;"><a href="' .$permalink . '">' . $post->post_title . '</a></h3>';
                $noticia_col_der .= '</div></li>';
                $derecha++;
            }
        }
            $noticia_col_izq .= '</ul></div>';
            $noticia_col_der .= '</ul></div>';

            echo '<div class="row-fluid">' . $noticia_col_izq . $noticia_col_der . '</div>';






    }

    public function form($instance)
    {
        if (!isset($instance['numberposts'])) {
            $instance['numberposts'] = $this->max_noticias;
        }

        $form = '<p>';
        $form .= '<label for="' . $this->get_field_id('numberposts') . '">' . _e('Numero de noticias:') . '</label>';

        $form .= '<select id="' . $this->get_field_id('numberposts') . '" name="' . $this->get_field_name('numberposts') . '">';

        for ($i = 2; $i <= $this->max_noticias; $i += 2) {
            $form .= '<option value="' . $i . '" ' . $this->get_selected($instance['numberposts'], $i) . ' >' . $i . '</option>';
        }

        $form .= '</select>';

        $form .= '</p>';
        echo $form;
    }

    private function get_selected($numberposts, $post)
    {
        if ($numberposts == $post) {
            return 'selected="selected"';
        }

        return '';

    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['numberposts'] = strip_tags($new_instance['numberposts']);
        return $instance;
    }
}

register_widget('NoticiasPortada');

?>