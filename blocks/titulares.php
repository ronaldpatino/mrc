<div id='content' class='row-fluid'>
        <div class='span8 main principal'>
            <?php if ( dynamic_sidebar('portada_titulares') ) : else : endif; ?>
        </div>
        <div class='span4 sidebar'>

        <?php if ( dynamic_sidebar('ultimas_masleidas_portada') ) : else : endif; ?>

        <?php get_template_part( 'blocks/publicidadmasleidas' ); ?>

        </div>
</div>