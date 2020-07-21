<div style="background-color:#f4b13e; width:100%; max-width:1150px; margin:0 auto; padding:15px 10px; box-sizing:border-box; border-radius:3px; line-height:20px; clear:both; color:#fff;">
<table cellspacing="10" cellspadding="10" border="0">
<tr>
<td><i id="show thi" class="icon-info" style="color:#B76706; font-size:45px;"></i></td>
<td><span style="text-shadow:1px 1px 2px #B76706">To continue with the payment process it is necessary to log in with your account or if you do not have one you can create it by filling out the registration form.</span></td>
</tr>
</table>
</div>
<section class="k-block k-block--md k-login">
	<div class="k-login__bgimg" style="background-image: url(<?php echo $root . '/dist/img/generic-beach.jpg' ?>)"></div>
	<!-- <div class="k-login__midimg">
		<figure class="k-figure">
			<div class="k-figure--liner">
				<img data-src="<?php echo $root . '/dist/img/Combo-Strawberry-2000.png'; ?>" alt="Koi Naturals Strawberry 2000mg" class="k-figure--img">
			</div>
		</figure>
	</div> -->
	<?php
	do_action('woocommerce_before_customer_login_form'); ?>

	<?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>

	<div class="k-login__forms" id="customer_login" style="width:100%; position:relative; overflow:auto !important;">
		<div class="k-liner">
			<div class="k-login__form k-login__form--default <?php if($regadd == "1"){ }else{ echo 'is-visible'; } ?>">
				<div class="k-login__form__liner">
			<?php endif; ?>

					<h2><?php esc_html_e('Login', 'woocommerce'); ?></h2>
<div style="color:#666; font-weight:lighter; line-height:22px; visibility:hidden;">[<br/>]</div>
					<form class="woocommerce-form woocommerce-form-login login" method="post" style="border:1px solid #ccc !important;">

						<?php do_action('woocommerce_login_form_start'); ?>

						<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
							<input type="text" class="k-input woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo (!empty( $_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
							<label for="username"><?php esc_html_e('', 'woocommerce'); ?></label>
							<label for="reg_password"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
						</p>
						<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
							<input class="k-input woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
							<label for="password"><?php esc_html_e('Password', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
						</p>

						<?php do_action('woocommerce_login_form'); ?>

						<p class="form-row k-login__rememberme">
							<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" />
							<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme" for="rememberme"><?php esc_html_e('Remember me', 'woocommerce'); ?></label>
							<?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
						</p>
						<div class="form-row">
							<button type="submit" class="k-button k-button--primary woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e('Log in', 'woocommerce'); ?>"><?php esc_html_e('Log in &rarr;', 'woocommerce'); ?></button>
						</div>
						
						<!--<p><a href="#0" id="adslink" class="k-toggle-register">Create an Account</a></p>-->
						<p class="woocommerce-LostPassword lost_password">
							<a href="<?php echo home_url(); ?>/wp-login.php?action=lostpassword"><?php esc_html_e('Lost your password?', 'woocommerce'); ?></a>
						</p>
						<p><a href="<?php echo site_url() . '/veteran-program'; ?>">Veteran? Apply for Veteran Discount &rarr;</a></p>

						<?php do_action('woocommerce_login_form_end'); ?>

					</form>

		<?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>
				</div>
			</div>

			<div class="k-login__form k-login__form--register is-visible <?php if($regadd == "1"){ echo 'is-visible'; }else{ } ?>">
				<div class="k-login__form__liner">
					<h2><?php esc_html_e('Register A New Account', 'woocommerce'); ?></h2>
					<div style="color:#666; font-weight:lighter; line-height:22px;">Experience faster checkout and earn rewards on all purchases when you create an account.</div>

					<form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

						<?php do_action('woocommerce_register_form_start'); ?>

						<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

							<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
								<input type="text" class="k-input woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
								<label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
							</p>
						<?php endif; ?>
						<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
							<input type="email" class="k-input woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
							<label for="reg_email"><?php esc_html_e( '', 'woocommerce' ); ?>&nbsp;</label>
							<label for="reg_password"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
						</p>
						<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

							<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
								<input type="password" class="k-input woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
								<label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
							</p>

						<?php else : ?>

							<p><?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?></p>

						<?php endif; ?>
						<?php do_action( 'woocommerce_register_form' ); ?>

							
							<!-- <p class="form-row k-login__rememberme">
							<input class="" name="marketing-opt-in" type="checkbox" id="subscribe" value="yes" />
							<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme" for="subscribe"><?php //esc_html_e('I\'d like to receive marketing emails', 'woocommerce'); ?></label>
													</p>-->
					

						<p class="woocommerce-FormRow form-row">
							<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
							<button type="submit" class="k-button k-button--primary woocommerce-Button button" style="background-color:#f4b13e !important; color:#fff; padding:1.25em 1.15em !important;" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
							<!--<p><a href="#0" class="k-toggle-register">Already have an account?</a></p>-->
						</p>

						<?php do_action( 'woocommerce_register_form_end' ); ?>
<!-- <input  name="marketing-opt-in" type="checkbox" id="subscribe" value="yes" style="position:relative !impotant; display:inline !important; opacity:1 !important; width:15px !important; height:15px !important;">-->
					</form>

				</div>
			</div>
		</div>
		<?php endif; ?>

		<?php do_action( 'woocommerce_after_customer_login_form' ); ?>

	</div>


</section>