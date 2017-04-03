<div class="thim-link-login thim-login-popup">
	<?php if ( is_user_logged_in() ): ?>
		<?php if ( thim_plugin_active( 'learnpress/learnpress.php' ) ) : ?>
			<?php if ( thim_is_new_learnpress() ) : ?>
				<a class="profile" href="<?php echo esc_url( learn_press_user_profile_link() ); ?>"><i class="fa fa-user" aria-hidden="true"></i> <?php esc_html_e( 'Profile', 'eduma' ); ?></a>
			<?php else: ?>
				<a class="profile" href="<?php echo esc_url( apply_filters( 'learn_press_instructor_profile_link', '#', get_current_user_id(), '' ) ); ?>"><i class="fa fa-user" aria-hidden="true"></i> <?php esc_html_e( 'Profile', 'eduma' ); ?></a>
			<?php endif; ?>
		<?php endif; ?>

		<a class="logout" href="<?php echo esc_url( wp_logout_url( apply_filters('thim_default_logout_redirect', 'http://'.$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ) ) ); ?>"><i class="fa fa-sign-out" aria-hidden="true"></i> <?php echo esc_html( $instance['text_logout'] ); ?></a>
		<a class="profile" href="<?php echo get_site_url().'/cart/';?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i> รายการสั่งซื้อ</a>
	<?php else : ?>
		<?php
		$registration_enabled = get_option( 'users_can_register' );
		if ( $registration_enabled ) :
			?>
			<a class="register" href="<?php echo esc_url( thim_get_register_url() ); ?>"><i class="fa fa-user-plus" aria-hidden="true"></i> <?php echo esc_html( $instance['text_register'] ); ?></a>
		<?php endif; ?>
		<a class="login" href="<?php echo esc_url( thim_get_login_page_url() ); ?>"><i class="fa fa-sign-in" aria-hidden="true"></i> <?php echo esc_html( $instance['text_login'] ); ?></a>
		<a class="profile" href="<?php echo get_site_url().'/cart/';?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i> รายการสั่งซื้อ</a>
	<?php endif; ?>
	
</div>

<?php if ( !is_user_logged_in() ): ?>
	<div id="thim-popup-login" class="<?php echo ( ! empty( $instance['shortcode'] ) ) ? 'has-shortcode' : '' ; ?>">
		<div class="thim-login-container">

			<?php
			if ( ! empty( $instance['shortcode'] ) ) {
				echo do_shortcode( $instance['shortcode'] );
			} 
			?>
			
			<div class="thim-login">
				<h2 class="title"><?php esc_html_e( 'Login with your site account', 'eduma' ); ?></h2>
				<div class="content-login">
				 <div class="social-login"> 
			        <div class="facebook-login"> 
			         <a href="<?php echo get_site_url()?>/wp-login.php?loginFacebook=1&redirect=<?php echo get_site_url()?>/profile/" onclick="window.location = '<?php echo get_site_url()?>/wp-login.php?loginFacebook=1&redirect='+window.location.href; return false;"><i class="fa fa-facebook" aria-hidden="true"></i> Facebook Login</a>
			       </div>
			       <div class="google-login"> 
			         <a href="<?php echo get_site_url()?>/wp-login.php?loginGoogle=1&redirect=<?php echo get_site_url()?>/profile/" onclick="window.location = '<?php echo get_site_url()?>/wp-login.php?loginGoogle=1&redirect='+window.location.href; return false;"><i class="fa fa-google-plus" aria-hidden="true"></i> Google Login</a>
			       </div> 
			       <div class="row-register"> 
                      <a href="<?php echo get_site_url()?>/account/?action=register"><?php echo esc_html__( 'Register now', 'eduma' ) ?></a>
			          <?php
					   
					   /*$registration_enabled = get_option( 'users_can_register' );
					     if ( $registration_enabled ) :
						  ?>
						 <?php echo '<p class="link-bottom">' . esc_html__( 'Not a member yet? ', 'eduma' ) . '<a href="' . esc_url( thim_get_register_url() ) . '">' . esc_html__( 'Register now', 'eduma' ) . '</a></p>'; ?>
					      <?php endif; */?>
			       </div> 
			     </div>
				  <div class="site_login">
								<form name="loginform" id="loginform" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post">
					<p class="login-username">
						<input type="text" name="user_login" placeholder="<?php esc_html_e( 'Username or email', 'eduma' ); ?>" id="thim_login" class="input" value="" size="20" /></label>
					</p>
					<p class="login-password">
						<input type="password" name="user_password" placeholder="<?php esc_html_e( 'Password', 'eduma' ); ?>" id="thim_pass" class="input" value="" size="20" /></label>
					</p>
					<?php
					/**
					 * Fires following the 'Password' field in the login form.
					 *
					 * @since 2.1.0
					 */
					do_action( 'login_form' );
					?>
					<?php echo '<a class="lost-pass-link" href="' . thim_get_lost_password_url() . '" title="' . esc_attr__( 'Lost Password', 'eduma' ) . '">' . esc_html__( 'Lost your password?', 'eduma' ) . '</a>'; ?>
					<p class="forgetmenot login-remember">
						<label for="rememberme"><input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php esc_html_e( 'Remember Me' ); ?>
						</label></p>
					<p class="submit login-submit">
						<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php esc_attr_e( 'Login', 'eduma' ); ?>" />
						<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect ); ?>" />
						<input type="hidden" name="testcookie" value="1" />
					</p>
				</form>
				</div>
			</div>
			</div>
			<span class="close-popup"><i class="fa fa-times" aria-hidden="true"></i></span>
		</div>
	</div>
<?php endif; ?>