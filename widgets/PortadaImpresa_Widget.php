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

        
        $fecha =  date('Y-m-d');
        
        $src = get_portada_by_date($fecha, true);
        
        if (!$src){
        	$fecha =  date('Y-m-d', strtotime('-1 day', strtotime($date_raw)));
   	        $src = get_portada_by_date($fecha);        	
        }
        
	        $impreso = '<ul class="thumbnails" style="margin-top: 20px;">';
	        $impreso .= '<li class="span12 thumbnail portada" style="text-align: center;"><h3>Portada</h3>';
	
	        $impreso .= '<a href="' .get_home_url(). '/impresa">' . $src . '</a>';
	        $impreso .= '</li></ul>';
	        
        
        
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
