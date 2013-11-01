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
                        <h1>Olvido su clave de acceso</h1>
                    </div>

                    <?php

                    $mostrar_form = true;
                    $error = null;
                    if (isset($_POST['user_login'])){
                        global $wpdb;
                        $username = trim($_POST['user_login']);
                        $user_exists = false;

                        if ($username !== "admin")
                        {
                            // First check by username
                            if (username_exists($username)) {
                                $user_exists = true;
                                $user = get_user_by('login', $username);
                            } // Then, by e-mail address
                            elseif (email_exists($username)) {
                                $user_exists = true;
                                $user = get_user_by( 'email', $username );
                            }
                            else {
                                $error[] = __('El Nombre de usuario o Email no est&aacute;n registrados, intente nuevamente!');
                            }
                        }
                        else
                        {
                            $error[] = __('El Nombre de usuario o Email no est&aacute;n registrados, intente nuevamente! ;)');
                        }




                        if ($user_exists) {
                            $user_login = $user->user_login;
                            $user_email = $user->user_email;

                            $key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
                            if (empty($key)) {
                                // Generate something random for a key...
                                $key = wp_generate_password(20, false);
                                do_action('retrieve_password_key', $user_login, $key);
                                // Now insert the new md5 key into the db
                                $wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));
                            }

                            //create email message
                            $message = __('Alguien ha solicitado el cambio de su claver en www.elmercurio.com.ec.') . "\r\n\r\n";
                            $message .= get_option('siteurl') . "\r\n\r\n";
                            $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
                            $message .= __('Para resetear su clave visite la siguiente direcci&oacute;n, en otro caso ignore este email.') . "\r\n\r\n";
                            $message .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . "&redirect_to=" . urlencode(get_option('siteurl')) . "\r\n";
                            //send email meassage
                            if (false == wp_mail($user_email, sprintf(__('[%s] Recuperar Clave'), get_option('blogname')), $message))
                            {
                                $error[] = '<p>' . __('El correo de confirmaci&oacute;n no pudo ser enviado.') . '</p>';
                            }

                        }
                        if (count($error) > 0) {

                            echo '<div class="alert alert-error">';
                            echo '<h4>Lo Sentimos! </h4>';

                            foreach ($error as $e) {
                                echo $e . "<br/>";
                            }
                            echo "</div>";
                        }
                        else {
                            $mostrar_form = false;
                            echo '<p>' . __('Se le ha enviado un email con las instrucciones para cambiar su clave.') . '</p>';
                        }
                    }

                    ?>

                    <?php if ($mostrar_form) :?>
                        <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                            <label for="user_login">Nombre de Usuario o Email</label>
                            <input type="text" name="user_login" value="" size="20" id="user_login" tabindex="1001" />
                            <br>
                            <input type="submit" value="Recuperar Clave" id="register" class="btn btn-primary"/>
                            <hr />
                            <p class="statement">Su contraseña ser&aacute; enviada a su email.</p>
                        </form>
                    <?php endif;?>
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
