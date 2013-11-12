<!-- Opinion-->
<div class='container margen-container'>
    <div class="row-fluid" id='opinion'>
        <div class="span4" style="margin-left: 0px;">
            <?php if ( dynamic_sidebar('caricatura') ) : else : endif; ?>
        </div>


        <div class="span4">
            <?php if ( dynamic_sidebar('bloqueopinion') ) : else : endif; ?>
        </div>

        <div class="span4">
            <?php if ( dynamic_sidebar('bloquetemas') ) : else : endif; ?>
        </div>
    </div>
</div>
<!-- Fin Opinion-->