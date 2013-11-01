<?php get_header(); ?>


<!-- Cabecera, titulares -->
<div class='container'>

    <?php get_template_part('blocks/menutop'); ?>
    <?php get_template_part('blocks/logo'); ?>
    <?php get_template_part('blocks/navbartop'); ?>
</div>

<?php get_template_part('blocks/publicidadcabecera'); ?>

<!-- Fin cabecera, titulares -->

<div class='container'>
    <?php get_template_part('blocks/masleido'); ?>

    <div id='content' class='row-fluid'>
        <div class='span8 main'>

            <?php if(isset($_GET['e']) && $_GET['e'] ==="done"): ?>
                <h1>Gracias por registrarse</h1>
                <p>Por favor revise su correo electr&oacute;nico por su password temporal</p>
            <?php else:?>
                <div id="register-form">
                    <div class="title">
                        <h1>Registrese en www.elmercurio.com</h1>
                    </div>
                    <?php if(isset($_GET['e']) && !empty($_GET['e']) ):?>
                        <div class="alert alert-error">
                            <h4>Lo Sentimos! </h4>
                            <?php echo get_error_mask($_GET['e']);?>
                        </div>
                    <?php endif;?>
                    <form action="<?php echo site_url('wp-login.php?action=register', 'login_post') ?>" method="post">

                        <label for="user_login">Nombre de Usuario</label>
                        <input type="text" name="user_login" value="" id="user_login" class="input" size="20" />

                        <label for="user_email">Direcci&oacute;n de Correo electr&oacute;nico</label>
                        <input type="text" name="user_email" id="user_email" class="input" value=""  />

                        <label for="first_name">Nombres</label>
                        <input type="text" name="first_name" id="first_name" class="input" value=""  />

                        <label for="last_name">Apellidos</label>
                        <input type="text" name="last_name" id="last_name" size="25" class="input" value=""  />

                        <label for="cedula">C&eacute;dula</label>
                        <input type="text" name="cedula" id="cedula" size="10" class="input" value=""  />
                        <input type="hidden" name="redirect_to" value="registro/?e=done">
                        <br>
                        <input type="submit" value="Registrarse" id="register" class="btn btn-primary"/>
                        <hr />
                        <p class="statement">Su contraseña ser&aacute; enviada a su email.</p>

                    </form>
                </div>


            <?php endif;?>
        </div>
        <div class='span4 sidebar'>

            <?php if ( dynamic_sidebar('detallenoticia') ) : else : endif; ?>

        </div>
    </div>

</div>

<?php get_template_part('blocks/pie'); ?>
<?php get_template_part('blocks/twitter'); ?>

<?php get_footer(); ?>
