<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ){
    return;
}

    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $required_text = "";

    $args = array(
        'id_form'           => 'commentform',
        'id_submit'         => 'submit',
        'title_reply'       => __( '' ),
        'title_reply_to'    => __( 'Deje un comentario a %s' ),
        'cancel_reply_link' => __( 'Cancelar Respuesta' ),
        'label_submit'      => __( 'Enviar Comentario' ),

        'comment_field' =>  '<p class="comment-form-comment"><textarea  class="input-block-level" id="comment" name="comment"  rows="3" aria-required="true">' .
        '</textarea></p>',

        'must_log_in' => '<p class="must-log-in"> ' .
        sprintf(
            __( 'Ingrese a <a href="%s">El Mercurio</a> para comentar.' ),
            wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
        ) . '</p>',

        'logged_in_as' => '<p class="logged-in-as">' .
        sprintf(
            __( 'Bienvenido <a href="%1$s">%2$s</a> deje su comentario. <a href="%3$s" title="Salir de El Mercurio">Salir?</a>' ),
            admin_url( 'profile.php' ),
            $user_identity,
            wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
        ) . '</p>',

        'comment_notes_before' => '<p class="comment-notes">' .
        __( 'Su correo no ser&aacute;.' ) . ( $req ? $required_text : '' ) .
        '</p>',

        'comment_notes_after' => '',

        'fields' => apply_filters( 'comment_form_default_fields', array(
                'author' =>
                '<p class="comment-form-author">' .
                '<label for="author">' . __( 'Name', 'domainreference' ) . '</label> ' .
                ( $req ? '<span class="required">*</span>' : '' ) .
                '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
                '" size="30"' . $aria_req . ' /></p>',

                'email' =>
                '<p class="comment-form-email"><label for="email">' . __( 'Email', 'domainreference' ) . '</label> ' .
                ( $req ? '<span class="required">*</span>' : '' ) .
                '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
                '" size="30"' . $aria_req . ' /></p>',

                'url' =>
                '<p class="comment-form-url"><label for="url">' .
                __( 'Website', 'domainreference' ) . '</label>' .
                '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
                '" size="30" /></p>'
            )
        ),
    );

    if ( have_comments() ) {
        wp_list_comments(array(
                                'style'             => 'div',
                                'callback'          => 'mrc_comments',
                                'end-callback'      => 'mrc_comments_end',
                                'reply_text'        => 'Respoder',
                                'avatar_size'       => 32,
                                ));

    }

    if ( ! comments_open() ) {
        echo '<p class="no-comments">' . _e( 'Comentarios cerrados para esta noticia.'  ) . '</p>';
    }
    mrc_comment_form($args);


