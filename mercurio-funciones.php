<?php
/***
 * RPG TODO SACAR PATH AUTO ACA
 */



//require_once('/Applications/MAMP/htdocs/elmercurio/wp-load.php');	
require_once('D:/wamp/apache2/htdocs/mr/wp-load.php');



Class MercurioFunciones{

	function SetCategoriaMenu( $menuStr, $slug )
	{

            /*
             * Esta funcion nos ayuda a resaltar la seleccion de pagina que tenemos.
             * Parametros de la funcion.
             * $menuStr = va hacer la pagina senialada
             * $slug    = va hacer la cateregoria que puede ser seleccionada y resaltada.
             *
             */

		
		if (is_home() && strlen($menuStr) == 0)
		{
			echo "class=\"inicio-selected\"";
			return;
		}
		
		if (strlen($menuStr) != 0 && strlen($slug) !=0 )
		{
			if (strcmp($menuStr,$slug) == 0)
			{
				if (strlen($menuStr) == 0)
				{
					echo "class=\"inicio-selected\"";	
				}
				else{
					echo "class=\"".$slug."-selected\"";
					return;
				}			
			}
		}	
		else {
			echo "";
			return;
		}

	}
	
   function string_limit_words($string, $word_limit) {

       /*Funcion que va a limitar el tamanio de la cadena escrita.
        * Parametros de la funcion:
        * $string    = es la cadena de texto que estariamos pasando a la funcion.
        * $word_limit= es el tamanio que le queremos dar a la cadena de texto, para su presentacion.
        *
        * retorna una cadena ya cortada con la size que le hemos dado.
        *
        */

     $words = explode(' ', $string);
     return implode(' ', array_slice($words, 0, $word_limit));
   }
	
   function date_hemeroteca()
   {
	setlocale(LC_TIME, "es_ES");      

   	$dia_texto = htmlentities(ucfirst(strftime("%A")));
   	$dia = strftime("%e");
   	$mes = strftime("%B");
   	$anio = strftime("%Y");

        $fecha['dia'] = $dia;
        $fecha['nombre_dia'] = $dia_texto;
        
        return $fecha;

   }	

	function date_localizado($cuenca=true)	
	{
            /*
             * funcion nos permite retornar
             * la variable fecha que contiene, LUGAR,DIA,MES,ANIO validado cuando sea cuenca pase CUENCA,DIA, MES ANIO.
             *
             * parametros de funcion.
             * $cuenca: el lugar para devolverlo con factores antes mencionados.
             * 
             *
             */
   		setlocale(LC_TIME, "es_ES");
   		$dia_texto = ucfirst(strftime("%A"));
   		$dia = strftime("%e");
   		$mes = strftime("%B");
   		$anio = strftime("%Y");
   		
		if ($cuenca){
			$fecha = "Cuenca ".htmlentities($dia_texto).", ".$dia." ".$mes." ".$anio;
		}	
		else{
			$fecha = htmlentities($dia_texto)." ".$dia." ".$mes." de ".$anio;
		}	
   		
		return $fecha;
	}
	
	
	function getLoUltimo($fecha)
	{
             /*
             * Esta funcion extrae de la base la informacion del dia actual.
             * Parametros de la funcion.
             * $fecha = es el dia actual o el dia impuesto por el usuario
             *
             * Esta funcion se utiliza en home,
             */
	
		global $wpdb, $theme_options;
		
		$theme_options = get_option('elmercurio_options');
	
		
		$sql ="	SELECT 
					a.ID, a.post_date, a.post_title, a.post_name, a.post_excerpt 
				FROM 
					wp_04vcw8_posts a, wp_04vcw8_term_relationships b, wp_04vcw8_term_taxonomy c
	
				WHERE 
					a.post_date >= '".$fecha." 00:00:00' 
				AND 
					a.post_date <= '".$fecha." 23:59:59'
	
				AND 
					a.id = b.object_id
	
				AND 
					b.term_taxonomy_id = c.term_taxonomy_id
	
				AND 
					c.term_id = ".$theme_options["featuredCatID"]."
	
				AND 
					a.post_type = 'post' 
	
				AND 
					a.post_status = 'publish' 
	
				ORDER BY 
					a.post_date 
				DESC 
				LIMIT 
					0,10";
						

			$loUltimo = $wpdb->get_results($sql);		
			return 	$loUltimo;			

	} 
	
	
	
	function getMultimedia()
	{
            /*
             * Esta funcion va a extraer de la base los videos guardados para publicarlos.
             * no se  pasan parametros en la funcion
             * .
             * para agregar otro item por ejemplo fotos
             * c.term_id = ID_DE_LA_TAXONOMIA
             */

            

                global $wpdb, $theme_options;
		$theme_options = get_option('elmercurio_options');
                        $sql = "SELECT
                                                a.ID, a.post_title, 
                                                a.post_name, 
                                                a.post_content, 
                                                c.term_id 
                                        FROM
                                                wp_04vcw8_posts a, wp_04vcw8_term_relationships b, wp_04vcw8_term_taxonomy c
                                        WHERE
                                                a.id = b.object_id

                                        AND
                                                b.term_taxonomy_id = c.term_taxonomy_id

                                        AND
                                                ( c.term_id = ".$this->getSlug("videos")."

                                                OR

                                                c.term_id = 52
                                                )

                                        AND
                                                a.post_type = 'post'

                                        AND
                                                a.post_status = 'publish'

                                        ORDER BY
                                                a.post_date DESC LIMIT 0,".$theme_options["videoPostCount"]."";
						
			$multimedia = $wpdb->get_results($sql);	
			return $multimedia;
	}
	
	
	function getYoutubeImage($youtube_url, $titulo, $estilo, $enlace)
	{

		$match = substr($youtube_url, 25);
		
		$codigo = strstr($match, "=");
		
		
		if (strlen($codigo) > 0)
		{
			$item = substr($match, 0, -6);
		}
		
		$match = $item;
		
		if ($estilo)
		{
			$imgTag = '<div id="item_multimedia" ><h3>VIDEO</h3><a href="'.$enlace.'"><img src="http://img.youtube.com/vi/'.  $match . '/default.jpg"></a><p>'.$titulo.'</p></div>';
		}
		else
		{
			$imgTag = '<div id="item_multimedia" ><h3>VIDEO</h3><a href="'.$enlace.'"><img src="http://img.youtube.com/vi/'.  $match . '/default.jpg"></a><p>'.$titulo.'</p></div>';
		}	
		return $imgTag;	
	}	
	

	function getAudio($titulo , $estilo, $enlace, $imagen=null)
	{
	
		if ($imagen)
		{	
	      	$audioTag = '<div id="item_multimedia" ><h3>AUDIO</h3><a href="'.$enlace.'"><img src="'.$imagen.'"/></a><p>'.$titulo.'</p></div>';
			
//	      	$audioTag = '<div id="item_multimedia" ><h3>AUDIO</h3><a href="'.$enlace.'"><img src="'.get_bloginfo( 'template_url' ).'/images/default-audio.gif"></a><p>'.$titulo.'</p></div>';
		}
		else
		{
			$audioTag =	'<div id="item_multimedia"><h3>AUDIO</h3><a href="'.$enlace.'"><img src="'.get_bloginfo( 'template_url' ).'/images/default-audio.gif"></a><p>'.$titulo.'</p></div>';
		}	
		return $audioTag;	
		

	}	
	
	
	
	function getSeccionTitular($seccionId, $fecha, $verHora = false, $verImagen = false)
	{


             /*
             * Esta funcion es la que se encarga de presentar contenido en algunas secciones de la page home.
             * Los parametros que se le pasan a la funcion son:
             * $seccionId = este va hacer el slug utilizado para cada seccion el resultado va a depender de la variacion de slugs.
             * $fecha   = va hacer la fecha del dia en curso o la que asigne el usuario.
             * $verHora = variable para publicar la hora en la entrega de datos
             * $verImagen = esta es la imagen que se encuentra en la base y se expone con el post de la base.
             *
             */
		
		global $wpdb, $theme_options, $post;
		$theme_options = get_option('elmercurio_options');

		$sql = "    SELECT
					a.ID, a.post_date, a.post_title, a.post_content, a.post_name, a.post_excerpt, a.comment_status

                                FROM wp_04vcw8_posts a, wp_04vcw8_term_relationships b, wp_04vcw8_term_taxonomy c

				WHERE 
					a.post_date <= '".$fecha." 23:59:59'

				AND 
					a.id = b.object_id

				AND 
					b.term_taxonomy_id = c.term_taxonomy_id

				AND 
					c.term_id = ".$seccionId." 

				AND 
					a.post_type = 'post' 

				AND 
					a.post_status = 'publish' 

				ORDER BY 
					a.post_date 
                                DESC

                                LIMIT 0,".$theme_options["secondaryMidPostCount"]."";
										
			$seccionTitulares = $wpdb->get_results($sql);
			$seccionTitularesString = "<ul>";
			foreach ($seccionTitulares as $post)
			{				
				setup_postdata($post);
				
				$excerpt = substr(get_the_excerpt(),0,100);

				$hora = ($verHora)?"<span class='hora'>".get_the_time('H:i')."</span>&nbsp;":"";
				
				$imagen = viva_custom('NpAdvSideFea','4');				
				if (strstr($imagen,"cat4_NpAdvSideFea.jpg"))
				{
					$imagenHtml = "";
					$heigh70 =  "";
				}
				else
				{
					$imagenHtml = ($verImagen)?"<img src='".$imagen."'  title='".get_the_title()."' class='alignleft'/>":"";	
					$heigh70= ' style="min-height:70px;" ';					
				}


				$seccionTitularesString .= "<li><a href='".get_permalink( $post->ID )."'>".$post->post_title."</a>".$imagenHtml."<p ".$heigh70." >".$hora.$excerpt."...</p></li>";						
			}
			$seccionTitularesString .= "</ul>";			
			return $seccionTitularesString;	
	}


	function getUltimasNoticias( $fecha)
	{
            /*
             * Esta funcion extrae de la base la informacion de ultimas noticias del dia actual.
             *
             * Parametros de la funcion.
             * $fecha = es el dia actual o el dia impuesto por el usuario
             *
             * esta funcion se utiliza en home page
             *
             */
		
		global $wpdb, $theme_options, $post;
		$theme_options = get_option('elmercurio_options');
		

		$sql = "SELECT 
					a.ID, a.post_date, a.post_title, a.post_content, a.post_name, a.post_excerpt, a.comment_status

                                FROM wp_04vcw8_posts a, wp_04vcw8_term_relationships b, wp_04vcw8_term_taxonomy c

				WHERE 
					a.post_date <= '".$fecha." 23:59:59'

				AND 
					a.id = b.object_id

				AND 
					b.term_taxonomy_id = c.term_taxonomy_id

				AND 
					c.term_id = ".$theme_options["secondaryMidCatID"]." 

				AND 
					a.post_type = 'post' 

				AND 
					a.post_status = 'publish' 

				ORDER BY 
					a.post_date DESC LIMIT 0,".$theme_options["secondaryMidPostCount"]."";
										
			$seccionTitulares = $wpdb->get_results($sql);
			$ultimasNoticiasStr = "<ul>";
			foreach ($seccionTitulares as $post)
			{				
				setup_postdata($post);
				
				$excerpt = substr(get_the_excerpt(),0,150);

				$hora = "<span class='hora'>".get_the_time('H:i')."</span>&nbsp;";
				
				$imagen = viva_custom('NpAdvSideFea','4');
								
				if (strstr($imagen,"cat4_NpAdvSideFea.jpg"))
				{
					$imagenHtml = "";
					$heigh70 =  "";
				}
				else
				{
					$imagenHtml = "<img src='".$imagen."'  title='".get_the_title()."' />";	
					$heigh70= ' style="min-height:70px;" ';
				}
															
				$ultimasNoticiasStr .= "<li><a href='".get_permalink( $post->ID )."'>".$post->post_title."</a>".$imagenHtml."<p ".$heigh70.">".$hora.$excerpt."...</p></li>";						
			}
			$ultimasNoticiasStr .= "</ul>";			
			return $ultimasNoticiasStr;	
	}


	function getEditorial($fecha)
	{
             /*
             * Esta funcion extrae de la base la informacion de editoriales.
             *
             * Parametros de la funcion.
             * $fecha = es el dia actual o el dia impuesto por el usuario
             *
             * esta funcion se utiliza en home page, en la parte de los box dinamicos
             *
             */
		
		global $wpdb, $theme_options, $post;
		$theme_options = get_option('elmercurio_options');

		$sql = "SELECT 
					a.ID, a.post_date, a.post_title, a.post_content, a.post_name, a.post_excerpt, a.comment_status

                                FROM wp_04vcw8_posts a, wp_04vcw8_term_relationships b, wp_04vcw8_term_taxonomy c

				WHERE 
					a.post_date <= '".$fecha." 23:59:59'

				AND 
					a.id = b.object_id

				AND 
					b.term_taxonomy_id = c.term_taxonomy_id

				AND 
					c.term_id = ".$this->getSlug("editorial")."

				AND 
					a.post_type = 'post' 

				AND 
					a.post_status = 'publish' 

				ORDER BY 
					a.post_date DESC LIMIT 0,1";
										
			$seccionTitulares = $wpdb->get_results($sql);
			$seccionTitularesString = "<ul>";
			foreach ($seccionTitulares as $post)
			{				
				setup_postdata($post);
				
				$excerpt = substr(get_the_excerpt(),0,800);

															
				$seccionTitularesString .= "<li><a href='".get_permalink( $post->ID )."'>".$post->post_title."</a><p>".$excerpt."</p></li>";						
			}
			$seccionTitularesString .= "</ul>";			
			return $seccionTitularesString;	
	}	

	function getDestacadas($seccionId, $fecha)
	{

             /*
             * Esta funcion extrae de la base la informacion de Destacadas.
             *
             * Parametros de la funcion.
             * $seccionId = se le pasa el slug para obtener informacion.
             * $fecha = es el dia actual o el dia impuesto por el usuario
             *
             * esta funcion se utiliza en home page, en la parte de los box dinamicos
             *
             */
		
		global $wpdb, $theme_options, $post;
		$theme_options = get_option('elmercurio_options');

		$sql = "        SELECT
					a.ID, a.post_date, a.post_title, a.post_content, a.post_name, a.post_excerpt, a.comment_status

                                FROM
                                        wp_04vcw8_posts a, wp_04vcw8_term_relationships b, wp_04vcw8_term_taxonomy c

				WHERE 
					a.post_date <= '".$fecha." 23:59:59'

				AND 
					a.id = b.object_id

				AND 
					b.term_taxonomy_id = c.term_taxonomy_id

				AND 
					c.term_id = ".$seccionId." 

				AND 
					a.post_type = 'post' 

				AND 
					a.post_status = 'publish' 

				ORDER BY 
					a.post_date DESC LIMIT 0,".$theme_options["secondaryMidPostCount"]."";
										
			$seccionTitulares = $wpdb->get_results($sql);
			$seccionTitularesString = "<ul>";
			foreach ($seccionTitulares as $post)
			{				
				setup_postdata($post);
				
				$excerpt = substr(get_the_excerpt(),0,100);
				$imagen =  viva_custom('NpAdvSideFea','4');
				if (strstr($imagen,"cat4_NpAdvSideFea.jpg"))
				{
					$seccionTitularesString .= "<li><a href='".get_permalink( $post->ID )."'>".$post->post_title."</a><p>".$excerpt."...</p></li>";
				}
				else 
				{
					$seccionTitularesString .= "<li><a href='".get_permalink( $post->ID )."'>".$post->post_title."</a><p>"."<img src='".$imagen."'  title='".get_the_title()."' class='alignleft'/>" .$excerpt."...</p></li>";
				}
			}
			$seccionTitularesString .= "</ul>";			
			return $seccionTitularesString;	
	}
      



	function getSeccionSubTitular($seccionId, $fecha)
	{
             /*
             * Esta funcion se la utiliza en secciones para poder obtener infomacion dependiendo del slug utilizado.
             *
             * Parametros de la funcion.
             *  $seccionId = es el tipo de slug o categoria que se pasa para el parametro necesitado.
             * $fecha = es el dia actual o el dia impuesto por el usuario
             *
             */

		global $wpdb, $theme_options;
		$theme_options = get_option('elmercurio_options');

		$sql = "SELECT
                                a.ID, a.post_date, a.post_title, a.post_content, a.post_name, a.post_excerpt, a.comment_status

                        FROM 
                                wp_04vcw8_posts a, wp_04vcw8_term_relationships b, wp_04vcw8_term_taxonomy c

                        WHERE 
                                a.post_date <= '".$fecha." 23:59:59'

                        AND 
                                a.id = b.object_id

                        AND     
                                b.term_taxonomy_id = c.term_taxonomy_id

                        AND     
                                c.term_id =".$seccionId."

                        AND 
                                a.post_type = 'post'

                        AND 
                                a.post_status = 'publish'

                        ORDER BY 
                                a.post_date DESC
                                
                        LIMIT 0 ,  7";


			$seccionTitulares = $wpdb->get_results($sql);
                      
			$seccionTitularesString = "<ul>";
			foreach ($seccionTitulares as $seccionTitular)
			{
				if (strlen($seccionTitular->post_title) > 45)
				{
					$titular = substr($seccionTitular->post_title,0,45)."...";
				}
				else
				{
					$titular = $seccionTitular->post_title;
				}

				$seccionTitularesString .= "<li><a href='".get_permalink( $seccionTitular->ID )."'>".$titular."</a></li>";
			}
			$seccionTitularesString .= "</ul>";
			return $seccionTitularesString;
	}



	function getPortada($fecha, $ancho, $alto){

            /*
             * Funcion utilizada para sacar la portada del dia en curso.
             * se tiene de referencia que la imagen no saldra si es que no se a guardado respectivamente
             *
             * Parametros de la funcion.
             * $fecha = dia en curso.
             * $ancho = ancho de la imagen para publicarla en la page.
             * $alto = alto de la imagen para publicarla en la page.
             * estos dos ultimas variables tiene que ser definidas por el administardor, dependiendo donde se ubique la llamada.
             * Utilizada en la page home
             *
             */


	    global $wpdb;
	    $sql="  SELECT *

                        FROM
                            notas_portadas
                        WHERE
	                fecha = '".$fecha."'
	            LIMIT 0,1";

       	$queryportada = $wpdb->get_results($sql);
 
       	$seccionPortadaString = "";
		foreach ($queryportada as $portada)
		{

        	$seccionPortadaString .= '<a href="/impreso/?fecha='.$fecha.'">'.'<img src="/thumb.php?src=/wp-content/uploads/'.$portada->img1.'&amp;h='.$alto.'&amp;w='.$ancho.'&amp;zc=0&amp;q=80" border="0" />'.'</a>';
		}
		return $seccionPortadaString;
    }





    function getSeccionMensajes()
	{
                /*
                 * Utilizamos la funcion para poder sacar de la base los mensajes publicados
                 * los usuarios los pueden ver de manera ordenada en el home page
                 *
                 */

		global $wpdb, $theme_options;
		$theme_options = get_option('elmercurio_options');

		$sql = "SELECT *

                        FROM
                                mensajes

                        WHERE
                                mostrar = 'S'

                        ORDER BY
                                fecha DESC limit 0,1";


			$mensaje = $wpdb->get_results($sql);
            
			$seccionTitularesString = "<ul>";
			foreach ($mensaje as $seccionTitular)
			{
			    $seccionTitularesString .=  '<li><a href="/mensajes/_'.$seccionTitular->codigo.'">'.$seccionTitular->asunto.'</a><br /> <strong>Nombre:</strong> '.$seccionTitular->nombre.'<br /> <strong>Ciudad/Pais:</strong> '.$seccionTitular->pais.'<br />'.$seccionTitular->texto.'<br />';
			}
			$seccionTitularesString .= "</ul>";
			return $seccionTitularesString;
	}


	function getSociales($fecha)		
	{

            /*
             * Esta funcion saca fotos de tema social para ubicarlas en la seccion Sociales
             *
             * Parametros de la funcion.
             * $fecha =  fecha impuesta por el administrador.
             *
             * se sacara una cantidad limitada de fotos de la fecha indicada hasta unos cuantos dias atras con su respectiva presentacion.
             *
             *
             */
	
		global $wpdb, $theme_options, $post;

		$theme_options = get_option('elmercurio_options');

		$sql = 
			"SELECT 
				a.ID, a.post_date, a.post_title, a.post_content, a.post_name, a.post_excerpt, a.comment_status FROM wp_04vcw8_posts a, wp_04vcw8_term_relationships b, wp_04vcw8_term_taxonomy c

			WHERE a.post_date <= '".$fecha." 23:59:59'

			and a.id = b.object_id

			AND b.term_taxonomy_id = c.term_taxonomy_id

			AND c.term_id = ".$this->getSlug("sociales")."

			AND a.post_type = 'post' 

			AND a.post_status = 'publish' 

			ORDER BY a.post_date DESC LIMIT 0,".$theme_options["postCountPhotoBar"]."";

	
		$socialesFotos = $wpdb->get_results($sql);			

		$socialesHtml = '';

		$divCount = 1;
	
		foreach ($socialesFotos as $post) 
		{				
			setup_postdata($post);
			
			if ($divCount == 1) { $socialesHtml .= "<div>";}
											
			$socialesHtml .= '<div id="item_sociales" ><a class="grouped_elements" title="'. get_the_title().'" href="'.viva_custom('NpAdvHover','7').'"><img src="'.viva_custom('NpAdvMainPGThumb','8') . '"></a><p><a href="'. get_permalink() .'" rel="bookmark">'.get_the_title().'</a></p></div>';	

			if ($divCount == 5) {$socialesHtml .=  "</div>";}								

			$divCount++;

			if ($divCount == 6) $divCount = 1;
									
		}								

		return 	$socialesHtml;
	}
	
	
	function getCaricatura($fecha)
	{

            /*
             * Esta funcion nos devuelve las imagens de caricaturas ingresadas en la base.
             * saca una cantidad limitada de imagenes impuestas por el administrador.
             *
             * Parametros de la funcion.
             * $fecha = dia utilizado por el adminsitrador.
             *
             */
		global $wpdb, $theme_options, $post;

		$theme_options = get_option('elmercurio_options');

		$sql = 
			"SELECT 
				a.ID, a.post_date, a.post_title, a.post_name FROM wp_04vcw8_posts a, wp_04vcw8_term_relationships b, wp_04vcw8_term_taxonomy c

			WHERE 
				a.id = b.object_id

			AND 
				b.term_taxonomy_id = c.term_taxonomy_id

			AND 
				c.term_id = 13 

			AND 
				a.post_type = 'post' 

			AND 
				a.post_status = 'publish' 
			AND 

				a.post_date <= '".$fecha." 23:59:59'				

			ORDER BY 
				a.post_date DESC 
			LIMIT 0,7";		


		$caricatura = $wpdb->get_results($sql);
		$caricaturaStr = "";
		$caricaturaActual = 1;
			
        foreach ($caricatura as $post) 
        {
        	
			setup_postdata($post);
			if ($caricaturaActual)
			{
				$caricaturaStr .= '<span><a class="caricaturaLnk" title="'.strtoupper(get_the_title()).' - '.get_the_date().'" rel="caricatura_group" href="'.viva_custom('NpAdvSinglePhoto','1').'" > <img border="0" src="'.viva_custom('NpAdvSinglePhoto','').'"/></a></span>';
        		$caricaturaActual = 0;
			}
			else
        	{

        		$caricaturaStr .= '<span style="display:none;"><a class="caricaturaLnk" title="'.strtoupper(get_the_title()).' - '.get_the_date().'" rel="caricatura_group" href="'.viva_custom('NpAdvSinglePhoto','').'" > <img border="0" src="'.viva_custom('NpAdvSinglePhoto','1').'"/></a></span>';
        	}
			
		}
		
		return $caricaturaStr;
	}




	function getMasComentados($no_posts = 7, $before = '<li>', $after = '</li>', $show_pass_post = false, $duration='') 
	{

            /*
             * Funcion devuelve el post y cuantos comentarias a tenido.
             * publicandolos si tienen mas de X cantidad de comentarios
             *
             * $no_post = limitante de post publicados.
             * $before = declaracion de entrada html para publicacion en la pagina.
             * after = declaracion de salida html para publicacion en la pagina.
             * $show_pass_post = variable booleana utilizada en una validacion if
             * $duracion= variable en comparacion y en el sql de la base.
             *
             */


		global $wpdb;
		
		$request = "SELECT ID, post_title, COUNT($wpdb->comments.comment_post_ID) AS 'comment_count' FROM $wpdb->posts, $wpdb->comments";
		$request .= " WHERE comment_approved = '1' AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status = 'publish'";
		
		if(!$show_pass_post) $request .= " AND post_password =''";
		
		if($duration !="") 
		{ 
			$request .= " AND DATE_SUB(CURDATE(),INTERVAL ".$duration." DAY) < post_date ";
		}
		
		$request .= " GROUP BY $wpdb->comments.comment_post_ID ORDER BY comment_count DESC LIMIT $no_posts";
		$posts = $wpdb->get_results($request);
		
		$output = '';
		
		if ($posts) 
		{
			foreach ($posts as $post) 
			{
				$post_title = stripslashes($post->post_title);
				$comment_count = $post->comment_count;
				$permalink = get_permalink($post->ID);
				$output .= $before . '<a href="' . $permalink . '" title="' . $post_title.'">' . substr($post_title,0,45) . '...</a> <br>' . $comment_count.' Comentarios' . $after;
			}
		} 
		else 
		{
			$output .= $before . "None found" . $after;
		}
		
		$masComentados = '<ul>'.$output.'</ul>';
		return $masComentados;
	}
	
	
	function getUltimosComentarios()
	{

            /*
             * Funcion devuelve de la base ultimos comentarios.
             * publicando noticias nuevas comentadas recientemente.
             *
             */
		global $wpdb;
  		$sql = "SELECT DISTINCT 
  					ID, 
  					post_title, 
  					post_password, 
  					comment_ID, 
  					comment_post_ID, 
  					comment_author, 
  					comment_date_gmt, 
  					comment_approved, 
  					comment_type,
  					comment_author_url, 
  					SUBSTRING(comment_content,1,45) AS com_excerpt 
  				FROM 
  					$wpdb->comments 
  				LEFT OUTER JOIN 
  					$wpdb->posts 
  				ON 
  					($wpdb->comments.comment_post_ID = $wpdb->posts.ID) 
  				WHERE 
  					comment_approved = '1' 
  				AND 
  					comment_type = '' 
  				AND 
  					post_password = '' 
  				ORDER BY 
  					comment_date_gmt 
  				DESC LIMIT 7";

  		  $comments = $wpdb->get_results($sql);
		  $output = $pre_HTML;
		  $output .= "\n<ul>";
		  foreach ($comments as $comment) {
    	  	$output .= "\n<li>" . "<a href=\"" . get_permalink($comment->ID)."#comment-" . $comment->comment_ID . "\" title=\"En respuesta a ".$comment->post_title . "\">" . strip_tags($comment->com_excerpt)."...</a><br>".strip_tags($comment->comment_author) ."</li>";
  			}
		  $output .= "\n</ul>";
		  $output .= $post_HTML;
		  return $output;
	
	}
	
	
	function getItemsHemeroteca($fecha)
	{

            /*
             * esta funcion extrae un post de busqueda en la biblioteca virtual de el mercurio
             *
             */


		global $wpdb;
		$sql = "SELECT * FROM 
					wp_04vcw8_posts1 
				WHERE  
					post_date >= '".$fecha." 00:00:00' 
				AND 
					post_date <= '".$fecha." 23:59:59' 
				ORDER BY 
					id 
				DESC 
					limit 0,120;";
		
		$itemsArray = $wpdb->get_results($sql);

		if (empty($itemsArray))
		{			
			$sql = "SELECT * FROM 
						wp_04vcw8_posts 
					WHERE  
						post_date >= '".$fecha." 00:00:00' 
					AND 
						post_date <= '".$fecha." 23:59:59' 
					ORDER BY 
						id 
					DESC 
						limit 0,120;";

			$itemsArray = $wpdb->get_results($sql);			

		}
		
		$itemHemeroteca = '<ul>';
		foreach ($itemsArray as $itemArray) 
		{
			$itemHemeroteca .= '<li><a href="/hemeroteca-virtual?noticia='.$itemArray->ID.'">'.$itemArray->post_title.'</a></li>';
		}
		$itemHemeroteca .= '<li>';	
		return $itemHemeroteca;
	}
	
	
	
	function getItemHemerotecaDetalle($noticiaID)
	{

             /*
             * esta funcion extrae un post especifico de busqueda en la biblioteca virtual de el mercurio
             *
             */

		global $wpdb;

		$sql = "SELECT  
					* 
				FROM 
					wp_04vcw8_posts1
				WHERE 
					ID = ".$noticiaID;


		$itemHemerotecaArray = $wpdb->get_results($sql);
		
		if (empty($itemHemerotecaArray))
		{
			$sql = "SELECT  
						* 
					FROM 
						wp_04vcw8_posts
					WHERE 
						ID = ".$noticiaID;


			$itemHemerotecaArray = $wpdb->get_results($sql);			
			
		}
		
		$itemHemerotecaStr = "";
		foreach ($itemHemerotecaArray as $itemHemeroteca) 
		{
		
			$itemHemerotecaStr .= "<h2>{$itemHemeroteca->post_title}</h2>";
			$itemHemerotecaStr .= "<span class='fechaPostSingle'> Fecha:{$itemHemeroteca->post_date}</span>";
			$itemHemerotecaStr .= "<div id='innerContent'>";
			$itemHemerotecaStr .= "<div class='postSingle'>";
			$itemHemerotecaStr .= "<p>".nl2br($itemHemeroteca->post_excerpt)."</p>";
			$itemHemerotecaStr .= "<p>".nl2br($itemHemeroteca->post_content)."</p>";			
			$itemHemerotecaStr .= "</div>";
			$itemHemerotecaStr .= "</div>";
			
			
		
		}
		
		
		return $itemHemerotecaStr;
	}
	
	
	function clasificadosHome()
	{
            /*
             * 
             */

            global $wpdb;
		
		$sql1 = "SELECT 
					catalogid, 
					catalogname 
				FROM 
					notas_clasificados_catalog 
				ORDER BY 
					catalogname;";
		
		$results = $wpdb->get_results($sql1);
		
		$clasificadosStr = '';
		
		foreach ($results as $data) 
		{
		
			$cid = $data->catalogid; 
			
			$clasificadosStr .=  '<div class="post">';
			$clasificadosStr .=  '<h2 style="font-size:24px; line-height:30px;" class="archiveTitle"><a href="/clasificados?cid='.$cid.'">'.$data->catalogname.'</a></h2>';
			$clasificadosStr .=  '<ul>';		
			
			$sql2 = "SELECT 
						* 
					FROM 
						notas_clasificados_news 
					WHERE 
						catalogid = ".$cid." 
					AND 
						adddate <= NOW() 
					AND 
						enddate >= NOW() 
					ORDER BY 
						newsid 
					DESC 
					LIMIT 
						0,2;";
			
			$results2 = $wpdb->get_results($sql2);		
			
			foreach ($results2 as $data2) 
			{
				$clasificadosStr .= '<li><a href="/clasificados?anuncio='.$data2->newsid.'">'.ucfirst(strtolower($data2->title)).'</a></li>';
			}
			
			$clasificadosStr .= '</ul>';
			$clasificadosStr .= '<div class="postinfo"><a href="/clasificados?cid='.$cid.'">Ver m&aacute;s</a></div>'; 
			$clasificadosStr .=  '</div>';
		}	
		
		return $clasificadosStr;
	}
	
	
	function clasificadosEnCategoria($categoria)
	{
		global $wpdb;
		
		$sql1 = "SELECT 
					catalogid, 
					catalogname 
				FROM 
					notas_clasificados_catalog 
				WHERE 
					catalogid = ".$categoria;
		
		$results = $wpdb->get_results($sql1);
		
		$enCategoriaStr = '';		
		$enCategoriaStr .= '<div class="post">';
		
		foreach ($results as $data) 
		{
		
		
			$enCategoriaStr .= '<h2 style="font-size:24px; line-height:30px;"><a href="/clasificados?cid='.$data->catalogid.'">'.$data->catalogname.'</a></h2>';
			$enCategoriaStr .= '<ul>';
		}
		
		$sql2 = "SELECT 
					* 
				FROM 
					notas_clasificados_news 
				WHERE 
					catalogid = ".$categoria." 
				AND 
					adddate <= NOW() 
				AND 
					enddate >= NOW() 
				ORDER BY 
					newsid 
				DESC";
		
		$results2 = $wpdb->get_results($sql2);
		
		foreach ($results2 as $data2) 
		{
			$enCategoriaStr .= '<li><a href="/clasificados?anuncio='.$data2->newsid.'">'.ucfirst(strtolower($data2->title)).'</a></li>';
		}

		$enCategoriaStr .=   '</ul>';
		$enCategoriaStr .=   '</div>';
	
		return	$enCategoriaStr;
	}
	
	function clasificadosDetalle($anuncio)
	{
		global $wpdb;
		
		$sql = "SELECT DISTINCT 
					a . * , b.catalogname
				FROM 
					notas_clasificados_news a, 
					notas_clasificados_catalog b
				WHERE 
					a.catalogid = b.catalogid 
				AND 
					a.newsid = ".$anuncio."  
				AND 
					a.adddate <= NOW() 
				AND 
					a.enddate >= NOW()";
					
		$results2 = $wpdb->get_results($sql);
		
		$clasificadoDetalleStr = '';
		$clasificadoDetalleStr .= '<div id="contenidoPost">';
		foreach ($results2 as $data2) 
		{
			$clasificadoDetalleStr .= '<h2>'.ucfirst(strtolower($data2->title)).'</h2>';
			$clasificadoDetalleStr .= '<table width="100%" border="0" cellspacing="6" cellpadding="7" class="tablaClasificados">';
			$clasificadoDetalleStr .= '<tr>';
			$clasificadoDetalleStr .= '<td height="30" valign="top"><strong>Informaci&oacute;n:</strong></td>';
			$clasificadoDetalleStr .= '<td valign="top">'.$data2->texto.'</td>';
			$clasificadoDetalleStr .= '</tr>';
			$clasificadoDetalleStr .= '<tr>';
			$clasificadoDetalleStr .= '<td width="98" height="30"><strong>Categor&iacute;a:</strong></td>';
			$clasificadoDetalleStr .= '<td width="383" valign="top"><strong>'.$data2->catalogname.'</strong></td>';
			$clasificadoDetalleStr .= '</tr>';
			
			if (!empty($data2->picture)) 
			{
				$clasificadoDetalleStr .= '<tr>';
				$clasificadoDetalleStr .= '<td height="50" valign="top"><strong>Foto: </strong></td>';
				$clasificadoDetalleStr .= '<td valign="top">';
				$clasificadoDetalleStr .= '<img src="/wp-content/uploads/'.$data2->picture.'" /></td>';
				$clasificadoDetalleStr .= '</tr>';			
			}
			$clasificadoDetalleStr .= '<tr>';
			$clasificadoDetalleStr .= '<td>&nbsp;</td>';
			$clasificadoDetalleStr .= '</tr>';
			$clasificadoDetalleStr .= '</table>';			
			
		}		
		$clasificadoDetalleStr .= '</div>';
		
		return $clasificadoDetalleStr;
	}	
		
	function getfecha($debug=false)
	{
            /*
             * Con esta funcion se generaliza la fecha en todo la pag con esta fecha pueden trabajar las funciones de manera global.
             */
		$debug=false;
		date_default_timezone_set("America/Guayaquil");
		return ($debug)?"2010-10-19":date('Y-m-d');
		
	

	}


        function getImagenPeel($images)
        {
            /*
             * Con esto publicamos la imagen de peel que se encuentre en la parte superior derecha de las pages utilizadas
             *
             */

             if(strlen($images)==0)
             {
                    $imagen =  get_bloginfo( 'template_url' )."/images/bannerDefaultPeel.png";

             }
             else
             {
                    $imagen =  get_bloginfo( 'template_url' )."/images/".$theme_options["publiPeel"]."";
             }
             
             return $imagen;

        }

        /* BEGIN SECCION FUNCIONES DEPORTES*/



	function getDestacadasDeportes($seccionId, $fecha)
	{

            /*
             * parametros que se pasan a la funcion
             * $seccionId = es el tipo de slug que se esta utilizado
             * $fecha = es el dia actual o el dia impuesto por el usuario
             *
             * El sql cumple la funcion de sacar las tuplas de noticias DESTACADAS DEPORTES de la base.
             * Esta saca todas tuplas anteriores a dicha fecha y hora
             *
             *
             */

		global $wpdb, $theme_options, $post;
		$theme_options = get_option('elmercurio_options');

		$sql = "
                SELECT
					a.ID, a.post_date, a.post_title, a.post_content, a.post_name, a.post_excerpt, a.comment_status

				FROM 
					wp_04vcw8_posts a, wp_04vcw8_term_relationships b, wp_04vcw8_term_taxonomy c

				WHERE
					a.post_date <= '".$fecha." 23:59:59'

				AND
					a.id = b.object_id

				AND
					b.term_taxonomy_id = c.term_taxonomy_id

				AND
					c.term_id = ".$seccionId."

				AND
					a.post_type = 'post'

				AND
					a.post_status = 'publish'

				ORDER BY
					a.post_date DESC LIMIT 0,".$theme_options["secondaryMidPostCount"]." ";

			$seccionTitulares = $wpdb->get_results($sql);
			$seccionTitularesString = "<ul>";
			
			foreach ($seccionTitulares as $post)
			{
				setup_postdata($post);

				$excerpt = substr(get_the_excerpt(),0,100);
				$imagen =  viva_custom('NpAdvSideFea','4');
				
				
				if (strstr($imagen,"cat4_NpAdvSideFea.jpg"))
				{
					$imagenHtml = "";
					$heigh70 =  "";					
				}
				else
				{
					$imagenHtml = "<img src='".$imagen."'  title='".get_the_title()."' />";	
					$heigh70= ' style="min-height:70px;" ';					
				}
				
				$seccionTitularesString .= "<li><a href='".get_permalink( $post->ID )."'>".$post->post_title."</a>".$imagenHtml."<p ".$heigh70.">".$hora.$excerpt."...</p></li>";									
						
			}
			
			
			$seccionTitularesString .= "</ul>";
			return $seccionTitularesString;	
	}




	function getSeccionSubTitularDeportes($seccionId, $fecha)
	{

            /*
             * parametros que se pasan a la funcion
             * $seccionId = es el tipo de slug que se esta utilizado
             * $fecha = es el dia actual o el dia impuesto por el usuario
             *
             * El sql cumple la funcion de sacar las tuplas de noticias VARIADAS DE DEPORTES de la base.
             * Dependiendo del slug que se le pase esto la funcion nos devuelve la seccion que queremos invocar.
             * Ejemplo. DESTACADAS DEPORTES, DEPORTIVO CUENCA, DEPORTE TUERCA. etc.
             * Esta saca todas tuplas anteriores a dicha fecha y hora
             *
             *
             */

		global $wpdb, $theme_options;
		$theme_options = get_option('elmercurio_options');

		$sql = "        SELECT
					a.ID, a.post_date, a.post_title, a.post_name
				FROM
					wp_04vcw8_posts a, wp_04vcw8_term_relationships b, wp_04vcw8_term_taxonomy c

				WHERE

					a.post_date <= '".$fecha." 23:59:59'

				AND
					a.id = b.object_id

				AND
					b.term_taxonomy_id = c.term_taxonomy_id

				AND
					c.term_id = ".$seccionId."

				AND
					a.post_type = 'post'

				AND
					a.post_status = 'publish'

				ORDER BY
					a.post_date
				DESC
				LIMIT
					0,13";

			$seccionTitulares = $wpdb->get_results($sql);

			$seccionTitularesString = "<ul>";
			foreach ($seccionTitulares as $seccionTitular)
			{
				if (strlen($seccionTitular->post_title) > 45)
				{
					$titular = substr($seccionTitular->post_title,0,45)."...";
				}
				else
				{
					$titular = $seccionTitular->post_title;
				}

				$seccionTitularesString .= "<li><a href='".get_permalink( $seccionTitular->ID )."'>".$titular."</a></li>";
			}
			$seccionTitularesString .= "</ul>";
			return $seccionTitularesString;
	}

	
	function getTablaPosiciones($seccionId, $fecha)
	{


		global $wpdb, $theme_options;
		$theme_options = get_option('elmercurio_options');

		$sql = "        SELECT
					a.ID, a.post_date, a.post_title, a.post_name, a.post_content
				FROM
					wp_04vcw8_posts a, wp_04vcw8_term_relationships b, wp_04vcw8_term_taxonomy c

				WHERE

					a.post_date <= '".$fecha." 23:59:59'

				AND
					a.id = b.object_id

				AND
					b.term_taxonomy_id = c.term_taxonomy_id

				AND
					c.term_id = ".$seccionId."

				AND
					a.post_type = 'post'

				AND
					a.post_status = 'publish'

				ORDER BY
					a.post_date
				DESC
				LIMIT
					0,1";

			$seccionTitulares = $wpdb->get_results($sql);

			
			foreach ($seccionTitulares as $seccionTitular)
			{
				$titular = $seccionTitular->post_content;
				$seccionTitularesString .= $titular;
			}
			
			return $seccionTitularesString;
	}

	function getUltimasNoticiasDeportes( $fecha)
	{
            /*
             * parametros que se pasan a la funcion
             * $fecha = es el dia actual o el dia impuesto por el usuario
             * En este caso la funcion solo recibe fecha para sacar solo las noticias del dia en curos...
             * El sql cumple la funcion de sacar las tuplas de noticias ULTIMAS NOTICIAS DEPORTES de la base.
             * Esta saca todas tuplas anteriores a dicha fecha y hora
             *
             *
             */

		global $wpdb, $theme_options, $post;
		$theme_options = get_option('elmercurio_options');


		$sql = "        SELECT
                                        a.ID, a.post_date, a.post_title, a.post_content, a.post_name, a.post_excerpt, a.comment_status

                                FROM
                                        wp_04vcw8_posts a, wp_04vcw8_term_relationships b, wp_04vcw8_term_taxonomy c

				WHERE
					a.post_date <= '".$fecha." 23:59:59'

				AND
					a.id = b.object_id

				AND
					b.term_taxonomy_id = c.term_taxonomy_id

				AND
					c.term_id = ".$theme_options["postCountBot7"]."

				AND
					a.post_type = 'post'

				AND
					a.post_status = 'publish'

				ORDER BY
					a.post_date DESC LIMIT 0,".$theme_options["secondaryMidPostCount"]."";

			$seccionTitulares = $wpdb->get_results($sql);
			$ultimasNoticiasStr = "<ul>";
			foreach ($seccionTitulares as $post)
			{
				setup_postdata($post);

				$excerpt = substr(get_the_excerpt(),0,150);

				$hora = "<span class='hora'>".get_the_time('H:i')."</span>&nbsp;";

				$imagen = viva_custom('NpAdvSideFea','4');

				if (strstr($imagen,"cat4_NpAdvSideFea.jpg"))
				{
					$imagenHtml = "";
					$heigh70 =  "";
				}
				else
				{
					$imagenHtml = "<img src='".$imagen."'  title'".get_the_title()."' />";
					$heigh70= ' style="min-height:70px;" ';
				}

				$ultimasNoticiasStr .= "<li><a href='".get_permalink( $post->ID )."'>".$post->post_title."</a>".$imagenHtml."<p ".$heigh70.">".$hora.$excerpt."...</p></li>";
			}
			$ultimasNoticiasStr .= "</ul>";
			return $ultimasNoticiasStr;
	}

	function getMultimediaDeportes()
	{
		/*
		* para agregar otro item por ejemplo fotos
		* c.term_id = ID_DE_LA_TAXONOMIA
		*/

		global $wpdb, $theme_options;
		$theme_options = get_option('elmercurio_options');
		$sql = "SELECT
					a.ID, 
					a.post_title, 
					a.post_name, 
					a.post_content, 
					c.term_id
					
					
                FROM
                	wp_04vcw8_posts a, wp_04vcw8_term_relationships b, wp_04vcw8_term_taxonomy c
                WHERE
                	a.id = b.object_id
				AND
					b.term_taxonomy_id = c.term_taxonomy_id
				AND
					c.term_id = ".$this->getSlug('videos-deportes')."
				AND
					a.post_type = 'post'
				AND
					a.post_status = 'publish'
				ORDER BY                                                
					a.post_date 
				DESC 
				LIMIT 
					0,".$theme_options["videoPostCount"]."";

		
			$multimedia = $wpdb->get_results($sql);
			return $multimedia;
	}


        
	
	function getPortadasActual($fecha)
	{

            /*
             * Funcion para devolver las portdas actuales encontradas en la base.
             * con eso se hace la busqueda se hace la busqueda de manera eficiente.
             * Parametros de la funcion.
             * $fecha= es la referencia que utilizamos para sacar portada, de la fecha que necesitamos
             *
             */
		if (!empty($fecha))
		{
			$sql = "SELECT 
						* 
					FROM 
						notas_portadas 
					WHERE 
						fecha = '{$fecha}' 
					LIMIT 
						0,1";
			
			$result = mysql_query($sql);
			if (mysql_num_rows($result) <= 0) {						    
			    return "";
			}			
			$row = mysql_fetch_assoc($result);						
			return $row['issuu'];
		}							
	}
	
	function getPortadasAnteriores()
	{

            /*
             * Funcion para devolver las portdas anteriores encontradas en la base.
             * con eso se hace la busqueda se hace la busqueda de manera eficiente.
             *
             */
		$sql = "SELECT 
					* 
				FROM 
					notas_portadas 
				ORDER BY 
					fecha 
				DESC
				LIMIT
					0,100";
				
		$result = mysql_query($sql);		
		
		if (mysql_num_rows($result) >0) 
		{
			$count = 0;
			$cadena .= "";
			while($row = mysql_fetch_assoc($result)) 
			{
				
				if ($count == 0)
				{
					$cadena .= "<div>";
				}				
				$cadena .= " <a href='?fecha={$row['fecha']}'><img title='Edici&oacute;n:{$row['fecha']}' alt='Edici&oacute;n:{$row['fecha']}' src='/thumb.php?src=/wp-content/uploads/{$row['img1']}&h=229&w=126&zc=0&q=80' /></a>";
								
				$count++;
				if ($count > 9)
				{
					$count = 0;
					$cadena .= "</div>";
				}
			}	
			
			return $cadena;	
		}
		

	
	}


    function getDeportesPrincipal($slug,$fecha)
	{



            /*
             * parametros que se pasan a la funcion
             * $fecha = es el dia actual o el dia impuesto por el usuario
             * $slug = es el parametro para poder sacar la categoria que necesitamos, utilizar
             *
             *
             * En este caso la funcion recibe $slug como parametro principal para poder sacar la categoria y la fecha para la comparacion,
             * sacando con esto las tuplas del dia en curso y las anteriores a dicha fecha, limitando en el mismo sql la cantidad de tuplas
             * El sql cumple la funcion de sacar las tuplas de noticias NOTICIAS DEPORTES PRINCIPAL de la base.
             *
             *
             */

		global $wpdb, $theme_options, $post;
		$theme_options = get_option('elmercurio_options');


			$sql = "SELECT
                                        a.ID, a.post_date, a.post_title, a.post_content, a.post_name, a.post_excerpt, a.comment_status

                                FROM
                                        wp_04vcw8_posts a, wp_04vcw8_term_relationships b, wp_04vcw8_term_taxonomy c

				WHERE
					a.post_date <= '".$fecha." 23:59:59'

				AND
					a.id = b.object_id

				AND
					b.term_taxonomy_id = c.term_taxonomy_id

				AND
					c.term_id = ".$slug."

				AND
					a.post_type = 'post'

				AND
					a.post_status = 'publish'

				ORDER BY
					a.post_date                                        
                DESC
                                                
                LIMIT 
                	0,".$theme_options["secondaryMidPostCount"]."";

			$deportesPrincipal = $wpdb->get_results($sql);
			$deportesPrincipalStr = "<ul>";
			foreach ($deportesPrincipal as $post)
			{
				setup_postdata($post);
                     
                                $imagen = viva_custom('NpAdvSideFea','4');

				if (strstr($imagen,"cat4_NpAdvSideFea.jpg"))
				{
					$imagenHtml = "";
					$heigh70 =  "";
				}
				else
				{
					$imagenHtml = "<img src='".$imagen."'  title'".get_the_title()."' />";
					$heigh70= ' style="min-height:70px;" ';
				}

				$deportesPrincipalStr .= "<li><a href='".get_permalink( $post->ID )."'>".$post->post_title."</a>".$imagenHtml."<p ".$heigh70."></p></li>";
			}
			$deportesPrincipalStr .= "</ul>";
			return $deportesPrincipalStr;
	}

        function getSlug($slug)
        {

                /*
		* Utilizamos la funcion get_category_by_slug para poder extraer el slug de la base de datos
                * Es aplicada en las otras funciones para omitir el id.
		*/

               $idObj = get_category_by_slug($slug);
               $id = $idObj->term_id;
               return $id;
        }

        
	function getLoUltimoDeportes($fecha)
	{
             /*
             * Esta funcion extrae de la base la informacion del dia actual.
             * Parametros de la funcion.
             * $fecha = es el dia actual o el dia impuesto por el usuario
             *
             * Esta funcion se utiliza en home,
             */
	
		global $wpdb, $theme_options;
		
		$theme_options = get_option('elmercurio_options');
	
		
		$sql ="	SELECT 
					a.ID, a.post_date, a.post_title, a.post_name, a.post_excerpt 
				FROM 
					wp_04vcw8_posts a, wp_04vcw8_term_relationships b, wp_04vcw8_term_taxonomy c
	
				WHERE 
					a.post_date >= '".$fecha." 00:00:00' 
				AND 
					a.post_date <= '".$fecha." 23:59:59'
	
				AND 
					a.id = b.object_id
	
				AND 
					b.term_taxonomy_id = c.term_taxonomy_id
	
				AND 
					c.term_id = ".$this->getSlug("portada-deportes")."				
				AND 
					a.post_type = 'post' 
	
				AND 
					a.post_status = 'publish' 
	
				ORDER BY 
					a.post_date 
				DESC 
				LIMIT 
					0,10";					
			$loUltimo = $wpdb->get_results($sql);		
			return 	$loUltimo;			

	}         
	
	function hasImagen($post) 
	{
		
		$attachments = get_children("post_parent=$post->ID&post_type=attachment&post_mime_type=image");
		if ( empty($attachments) ) { 
			return 0;
		}
		else {
			return 1;
		}
	}

	
	function getScrollMultimediaPrincipal()
	{
	

		$multimedia = $this->getMultimedia();

   		$divCount = 1;
   		$noEsPar = count ($multimedia) % 5;
   		$totalItems = count ($multimedia);
   		
   		if ($noEsPar == 1)
   		{
   			$cuantos=0;
   			while (1)
   			{
   				$totalItems ++;
   				if ( $totalItems % 5 == 0)
   				{ 
   					$cuantos++;	
   					break;
   				}
   						
   			}	
   		}
   		
   		$totPages = round($totalItems / 5) ;	   						
   		$pageActual = 1;
   		

		global $post;
        foreach ($multimedia as $post)
        {
        	
			setup_postdata($post);

			if ($divCount == 1) { echo "<div>"; $estilo = 0; } else {$estilo = 1;}

			switch ($post->term_id)	
			{
				case $this->getSlug('videos'):
					$urlYouTube = get_post_meta($post->ID, 'video', true);										
					echo $this->getYoutubeImage($urlYouTube, get_the_title($post->ID),$estilo, get_permalink($post->ID));
					break;

				case $this->getSlug('audios'):
					$imagen = $this->getPostImagenAudio();
					echo $this->getAudio(get_the_title($post->ID), $estilo, get_permalink($post->ID),$imagen);
					break;


			}

			
			if ($totPages == 1)
			{

				if (count($multimedia) < 5 && count($multimedia) == $divCount)
				{
					for ($i = $divCount; $i<5; $i++)
					{
						echo "<div id='item_multimedia'></div>";
						$divCount++;
					}
				}									
			}
               
			if ($totPages > 1)
			{						
				if (($pageActual == $totPages && $noEsPar == 1))
				{
						for ($i = $divCount; $i<5; $i++)
						{
							echo "<div id='item_multimedia'></div>";
							$divCount++;
						}
					
				}
			}								

			if ($divCount == 5) echo "</div>";

			$divCount++;

			if ($divCount == 6) {$divCount = 1; $pageActual++;}
			
			
		}		
	}
	
	
	
	function getScrollMultimediaDeportes() 
	{

		$multimedia = $this->getMultimediaDeportes();

		if (count($multimedia)>0)
		{
			$divCount = 1;
	   		$noEsPar = count ($multimedia) % 5;
	   		$totalItems = count ($multimedia);
	   		
	   		if ($noEsPar == 1)
	   		{
	   			$cuantos=0;
	   			while (1)
	   			{
	   				$totalItems ++;
	   				if ( $totalItems % 5 == 0)
	   				{ 
	   					$cuantos++;	
	   					break;
	   				}
	   						
	   			}	
	   		}
	   		
	   		$totPages = round($totalItems / 5) ;	   						
	   		$pageActual = 1;
	   		
	
			 global $post;	
	         foreach ($multimedia as $post)
	         {
				setup_postdata($post);
	
				if ($divCount == 1) { echo "<div>"; $estilo = 0; } else {$estilo = 1;}
	
				$estilo = 0;
				switch ($post->term_id)	
				{
					case $this->getSlug('videos-deportes'):
						$urlYouTube = get_post_meta($post->ID, 'video', true);										
						echo $this->getYoutubeImage($urlYouTube, get_the_title($post->ID),$estilo, get_permalink($post->ID));
						break;
	
					case $this->getSlug('audio-deportes'):
						$imagen = $this->getPostImagenAudio();
						echo $this->getAudio(get_the_title($post->ID), $estilo, get_permalink($post->ID), $imagen);
						break;
	
	
				}
	
				
				if ($totPages == 1)
				{
	
					if (count($multimedia) < 5 && count($multimedia) == $divCount)
					{
						for ($i = $divCount; $i<5; $i++)
						{
							echo "<div id='item_multimedia'></div>";
							$divCount++;
						}
					}									
				}
	               
				if ($totPages > 1)
				{						
					if (($pageActual == $totPages && $noEsPar == 1))
					{
							for ($i = $divCount; $i<5; $i++)
							{
								echo "<div id='item_multimedia'></div>";
								$divCount++;
							}
						
					}
				}								
	
				if ($divCount == 5) echo "</div>";
	
				$divCount++;
	
				if ($divCount == 6) {$divCount = 1; $pageActual++;}
				
				
			}
		}
		else 
		{		
			echo "<div>";	
			echo "<div id='item_multimedia'><h3>EL MERCURIO 1</h3><img src='".get_bloginfo( 'template_url' )."/images/img-default-portada.jpg'/><p>El Mercurio de Cuenca</p></div>";
			echo "<div  id='item_multimedia'><h3>EL MERCURIO</h3><img src='".get_bloginfo( 'template_url' )."/images/img-default-portada.jpg'/><p>El Mercurio de Cuenca</p></div>";
			echo "<div  id='item_multimedia'><h3>EL MERCURIO</h3><img src='".get_bloginfo( 'template_url' )."/images/img-default-portada.jpg'/><p>El Mercurio de Cuenca</p></div>";
			echo "<div  id='item_multimedia'><h3>EL MERCURIO</h3><img src='".get_bloginfo( 'template_url' )."/images/img-default-portada.jpg'/><p>El Mercurio de Cuenca</p></div>";
			echo "<div  id='item_multimedia'><h3>EL MERCURIO</h3><img src='".get_bloginfo( 'template_url' )."/images/img-default-portada.jpg'/><p>El Mercurio de Cuenca</p></div>";
			echo "</div>";
			
		}	
	}
	
   function getPostsScrollDc($slug,$fecha)
	{



            /*
             * parametros que se pasan a la funcion
             * $fecha = es el dia actual o el dia impuesto por el usuario
             * $slug = es el parametro para poder sacar la categoria que necesitamos, utilizar
             *
             *
             * En este caso la funcion recibe $slug como parametro principal para poder sacar la categoria y la fecha para la comparacion,
             * sacando con esto las tuplas del dia en curso y las anteriores a dicha fecha, limitando en el mismo sql la cantidad de tuplas
             * El sql cumple la funcion de sacar las tuplas de noticias NOTICIAS DEPORTES PRINCIPAL de la base.
             *
             *
             */

		global $wpdb, $theme_options, $post;
		$theme_options = get_option('elmercurio_options');


			$sql = "SELECT
					DISTINCT
						a.ID, a.post_date, a.post_title, a.post_content, a.post_name, a.post_excerpt, a.comment_status

                    FROM
						wp_04vcw8_posts a, wp_04vcw8_term_relationships b, wp_04vcw8_term_taxonomy c

					WHERE
						a.post_date <= '".$fecha." 23:59:59'
	
					AND
						a.id = b.object_id
	
					AND
						b.term_taxonomy_id = c.term_taxonomy_id
	
					AND
						c.term_id = ".$this->getSlug($slug)."
	
					AND
						a.post_type = 'post'
	
					AND
						a.post_status = 'publish'
	
					ORDER BY
						a.post_date                                        
	                DESC
	                                                
	                LIMIT 
	                	0,".$theme_options["secondaryMidPostCount"]."";
			
			
			
			$deportes = $wpdb->get_results($sql);
			return $deportes;
	}		
	
	
	function getSuplementos()
	{
		/*
		* para agregar otro item por ejemplo fotos
		* c.term_id = ID_DE_LA_TAXONOMIA
		*/

		global $wpdb, $theme_options;
		$theme_options = get_option('elmercurio_options');
		$sql = "SELECT
					a.ID, a.post_title, a.post_name,a.post_content, c.term_id
                FROM
                	wp_04vcw8_posts a, wp_04vcw8_term_relationships b, wp_04vcw8_term_taxonomy c
                WHERE
                	a.id = b.object_id
				AND
					b.term_taxonomy_id = c.term_taxonomy_id
				AND
					c.term_id = ".$this->getSlug('suplementos-carrusel')."
				AND
					a.post_type = 'post'
				AND
					a.post_status = 'publish'
				ORDER BY                                                
					a.post_date 
				ASC 
				LIMIT 
					0,6";

		
			$suplementos = $wpdb->get_results($sql);
			return $suplementos;
	}	
	
	function getScrollSuplementos()
	{
	
		$suplementos = $this->getSuplementos();

		if (count($suplementos)>0)
		{
		
	   		$divCount = 1;
	   		$noEsPar = count ($suplementos) % 5;
	   		$totalItems = count ($suplementos);
	   		
	   		if ($noEsPar == 1)
	   		{
	   			$cuantos=0;
	   			while (1)
	   			{
	   				$totalItems ++;
	   				if ( $totalItems % 5 == 0)
	   				{ 
	   					$cuantos++;	
	   					break;
	   				}
	   						
	   			}	
	   		}
	   		
	   		$totPages = round($totalItems / 5) ;	   						
	   		$pageActual = 1;
	   		
			global $post;
	   		
	        foreach ($suplementos as $post)
	        {
				setup_postdata($post);
				
	
				if ($divCount == 1) { echo "<div>"; $estilo = 0; } else {$estilo = 1;}
				
				$imagen=$this->getPostImagen();
				
				
				echo  "<a href='".get_permalink()."'><img src='".$imagen."'  title='".get_the_title()."' /></a>";	
				
				if ($totPages == 1)
				{
	
					if (count($suplementos) < 5 && count($suplementos) == $divCount)
					{
						for ($i = $divCount; $i<5; $i++)
						{
							echo "<div>&nbsp;</div>";
							$divCount++;
						}
					}									
				}
	               
				if ($totPages > 1)
				{						
					if (($pageActual == $totPages && $noEsPar == 1))
					{
							for ($i = $divCount; $i<5; $i++)
							{
								echo "<div>&nbps;</div>";
								$divCount++;
							}
						
					}
				}								
	
				if ($divCount == 5) echo "</div>";
	
				$divCount++;
	
				if ($divCount == 6) {$divCount = 1; $pageActual++;}
				
				
			}
		}
		else 
		{
			echo "<div><img src='".get_bloginfo( 'template_url' )."/images/img-default-portada.jpg'/></div>";				
		}			
	}

	function getScrollDeportes()
	{
	
		$deportes = $this->getPostsScrollDc('portada-deportes',$this->getfecha(true));
   		
		if (count($deportes) > 0)
		{
	   		$totPages = round($totalItems / 5) ;	   						
	   		$pageActual = 1;
	   		
			global $post;
	   		
			
	        foreach ($deportes as $post)
	        {
				setup_postdata($post);
				
				$imagen=$this->getPostImagen();
				echo "<div>";
				//echo  "<a href='".get_permalink()."'><img src='".$imagen."'  title='".get_the_title()."' /></a>";				
				echo  "<a href='".get_permalink()."'><img src='".viva_custom('NpAdvMainFea','1')."'  title='".get_the_title()."' /></a>";				
				echo "<div><p>".$post->post_title."</p></div>";			
				echo "</div>";						
			}
		}
		else
		{
			echo "<div>";
			echo "<img src='".get_bloginfo( 'template_url' )."/images/img-default-portada.jpg'/>";				
			echo "<div><p>El Mercurio de Cuenca</p></div>";			
			echo "</div>";						
			
		}			
	}	

	
	function getScrollCronica()
	{
		global $post;

		$deportes = $this->getPostsScrollDc('policial',$this->getfecha(true));
   		$totPages = round($totalItems / 5) ;	   						
   		$pageActual = 1;
   		
        foreach ($deportes as $post)
        {
			setup_postdata($post);
			
			$imagen=$this->getPostImagen();
			echo "<div>";
			//echo  "<a href='".get_permalink()."'><img src='".$imagen."'  title='".get_the_title()."' /></a>";	
			echo  "<a href='".get_permalink()."'><img src='".viva_custom('NpAdvMainFea','1')."'  title='".get_the_title()."' /></a>";				
			echo "<div><p>".$post->post_title."</p></div>";			
			echo "</div>";						
		}		
	}	
	
	function getPostImagen() 
	{
		global $post, $posts;
		$first_img = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		$first_img = $matches [1] [0];
		
		if(empty($first_img)){
            $first_img = get_bloginfo( 'template_url' )."/images/img-default-portada.jpg";
        }
		
		return $first_img;
	}	

	function getPostImagenAudio()
    {
        global $post;
        $first_img = '';
        ob_start();
        ob_end_clean();
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
        $first_img = $matches [1] [0];

        if(empty($first_img)){
            $first_img = get_bloginfo( 'template_url' )."/images/default-audio.gif";
        }

        return $first_img;
    }

	
	function getDeportesHorizontal($seccionId, $fecha)
    {

        /*
         * parametros que se pasan a la funcion
         * $seccionId = es el tipo de slug que se esta utilizado
         * $fecha = es el dia actual o el dia impuesto por el usuario
         *
         * El sql cumple la funcion de sacar las tuplas de noticias DESTACADAS DEPORTES de la base.
         * Esta saca todas tuplas anteriores a dicha fecha y hora
         *
         *
         */

        global $wpdb, $theme_options, $post;
        $theme_options = get_option('elmercurio_options');

        $sql = "
                SELECT
					a.ID, a.post_date, a.post_title, a.post_content, a.post_name, a.post_excerpt, a.comment_status

				FROM 
					wp_04vcw8_posts a, wp_04vcw8_term_relationships b, wp_04vcw8_term_taxonomy c

				WHERE
					a.post_date <= '".$fecha." 23:59:59'

				AND
					a.id = b.object_id

				AND
					b.term_taxonomy_id = c.term_taxonomy_id

				AND
					c.term_id = ".$seccionId."

				AND
					a.post_type = 'post'

				AND
					a.post_status = 'publish'

				ORDER BY
					a.post_date DESC LIMIT 0,3";

        $seccionTitulares = $wpdb->get_results($sql);
        //$seccionTitularesString = "<ul>";

        foreach ($seccionTitulares as $post)
        {
            setup_postdata($post);

            $excerpt = substr(get_the_excerpt(),0,100);

            if ($this->hasImagen($post))
            {
                $imagenHtml = "<a href='".get_permalink( $post->ID )."'><img src='".viva_custom('el-mercurio-deportes-ecuador-cuenca','1')."'  title='".get_the_title()."' /></a>";
            }
            else {

                $imagenHtml = "<a href='".get_permalink( $post->ID )."'><img  src='".get_bloginfo('template_url')."/images/img-default-portada.jpg"."'  title='".get_the_title()."' /></a>";


            }


            $seccionTitularesString .= "<div class='bDiItem'>".$imagenHtml."<p><a href='".get_permalink( $post->ID )."'>".$post->post_title."</a>".$hora.$excerpt."...</p></div>";

        }


        //$seccionTitularesString .= "</ul>";
        return $seccionTitularesString;
    }
	
	
	function getCabeceraDeportes()
    {

        $imagenesCabecera[1] = get_bloginfo( 'template_url' )."/images/bg-header-deportes-1.png";
        $imagenesCabecera[2] = get_bloginfo( 'template_url' )."/images/bg-header-deportes-2.png";
        $imagenesCabecera[3] = get_bloginfo( 'template_url' )."/images/bg-header-deportes-3.png";
        $imagenesCabecera[3] = get_bloginfo( 'template_url' )."/images/bg-header-deportes-4.png";

        return $imagenesCabecera[rand(1,count($imagenesCabecera))];

    }

	
	function renderBanner($nombreBanner, $tiempoSegundos)
    {
        global $theme_options;

        if (empty($tiempoSegundos) && $tiempoSegundos !=0) $tiempoSegundos = 5;

        $indice = "banner".$nombreBanner;
        $tiempo = $tiempoSegundos * 1000;

        if ($tiempoSegundos == 0)
        {
            $banner = "<div  id='banner".$nombreBanner."'>";
            $banner .= $theme_options[$indice];
            $banner .= "</div>";
        }
        else {
            $banner = "<div  id='banner".$nombreBanner."'>";
            $banner .= $theme_options[$indice];
            $banner .= "</div>";
            $banner .="<script type='text/Javascript'>";
            $banner .="$('#banner".$nombreBanner."').jshowoff({ speed:".$tiempo.", links: false, controls:false });";
            $banner .="</script>";
        }
        return $banner;
    }
	

	function getAgenda()
    {
        global $wpdb, $theme_options, $post;
        $theme_options = get_option('elmercurio_options');
        date_default_timezone_set("America/Guayaquil");
        $now = time();
        $plus7 = $now+(7*24*60*60);


        $sql = "
				SELECT
					a.ID, a.post_date, a.post_title, a.post_content, a.post_name, a.post_excerpt, a.comment_status

                FROM 
                	wp_04vcw8_posts a, wp_04vcw8_term_relationships b, wp_04vcw8_term_taxonomy c

				WHERE 
					a.post_date >= '".date('Y-m-d', $now)." 00:00:00'
				
				AND 

					a.post_date <= '".date('Y-m-d', $plus7)." 23:59:59'
				AND 
					a.id = b.object_id

				AND 
					b.term_taxonomy_id = c.term_taxonomy_id

				AND 
					c.term_id = ".$this->getSlug("agenda")." 

				AND 
					a.post_type = 'post' 


				ORDER BY 
					a.post_date 
               ASC";

        $seccionTitulares = $wpdb->get_results($sql);

        $info = "";

        if (count($seccionTitulares) > 0)
        {

            $info .= '<div id="agenda" class="ez-fr">';
            $info .= "<h3>AGENDA </h3>";
            $info .= "<div id='slidingFeatures'>";
            foreach ($seccionTitulares as $post)
            {
                setup_postdata($post);
                $info .= 	'<div title="'.substr($post->post_title,0,2).'<br/>'.substr($post->post_date,8,2).'"><div class="scrollAgenda"><div class="dentroAgenda">'.$post->post_content.'</div></div></div>';
            }
            $info .= "</div>";
            $info .= "</div>";
            $info .= '<script type="text/javascript">'.
                '$(document).ready(function(){ $("#slidingFeatures").jshowoffCustom({'.
                "effect: 'slideLeft',".
                "controls: false".
                "}); });".
                "</script>";
        }


        return $info;
    }
		
}

?>
