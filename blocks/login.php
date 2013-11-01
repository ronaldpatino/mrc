<div class="row-fluid" id="ingresar_elmercurio">
    <div class="span6">
        <form action="<?php echo site_url( 'wp-login.php', 'login'); ?>" name="loginform" id="loginform" method="post">
            <fieldset>
                <legend>Ya esta registrado?</legend>
                <label>Usuario</label>
                <input type="text" name="log" id="user_login">
                <label>Password</label>
                <input type="password" name="pwd" id="user_pass" t>
                <label class="checkbox">
                    <input type="checkbox" name="rememberme" id="rememberme" value="forever"> Recordarme en www.elmercurio.com.ec
                </label>
                <button type="submit" name="wp-submit" id="submit" class="btn">Ingresar</button>
                <?php if(isset($_GET['replytocom'])):?>
                <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI'] . '?'.  strip_tags($_GET['replytocom']) ; ?>"/>
                <?php else:?>
                    <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
                <?php endif;?>
            </fieldset>
        </form>
        <a  href="<?php bloginfo('url'); ?>/recuperar" class="">Olvido su clave</a>
        <?php if(isset($_GET['login']) && $_GET['login'] == 'failed'):?>
            <div class="alert alert-error">
                <h4>Lo Sentimos!</h4>
                Su nombre de usuario o contraseña son incorrectos.
            </div>
        <?php endif;?>

    </div>
    <div class="span6">
        <legend>Registrese y comente</legend>

        <a  href="<?php echo get_permalink(get_page_by_title( 'registro'));?>" class="btn btn-primary">Registrarse</a>

    </div>
</div>


