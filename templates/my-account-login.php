<?php
$root = get_template_directory_uri();

/* Template Name: 2019 Account Login Page */
defined( 'ABSPATH' ) || exit;

// 301 to main acct page if user logged in
if (is_user_logged_in()) {
  wp_redirect(site_url() . '/account', 301);
}

get_header();

do_action('k_before_first_section');



?>

<section class="woocommerce-MyAccount-content k-block k-block--md k-login">
	<div class="k-login__bgimg" style="background-image: url(<?php echo $root . '/dist/img/generic-beach.jpg' ?>)"></div>
	<div class="k-login__midimg">
		<figure class="k-figure">
			<div class="k-figure--liner">
				<img data-src="<?php echo $root . '/dist/img/Combo-Strawberry-2000.png'; ?>" alt="Koi Naturals Strawberry 2000mg" class="k-figure--img">
			</div>
		</figure>
	</div>
	<?php
	do_action('woocommerce_before_customer_login_form'); ?>

	<?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>

	<div class="k-login__forms" id="customer_login">
		<div class="k-liner">
			<div class="k-login__form k-login__form--default is-visible">
				<div class="k-login__form__liner">
			<?php endif; ?>

					<h2><?php esc_html_e('Login', 'woocommerce'); ?></h2>

					<form class="woocommerce-form woocommerce-form-login login" method="post">

						<?php do_action('woocommerce_login_form_start'); ?>

						<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
							<input type="text" class="k-input woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo (!empty( $_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
							<label for="username"><?php esc_html_e('Username or email address', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
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
						
						<p><a href="#0" class="k-toggle-register">Create an Account</a></p>
						<p class="woocommerce-LostPassword lost_password">
							<a href="<?php echo home_url(); ?>/wp-login.php?action=lostpassword"><?php esc_html_e('Lost your password?', 'woocommerce'); ?></a>
						</p>
						<p><a href="<?php echo site_url() . '/veteran-program'; ?>">Veteran? Apply for Veteran Discount &rarr;</a></p>

						<?php do_action('woocommerce_login_form_end'); ?>

					</form>

		<?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>
				</div>
			</div>

			<div class="k-login__form k-login__form--register">
				<div class="k-login__form__liner">
					<h2><?php esc_html_e('Register A New Account', 'woocommerce'); ?></h2>

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
							<label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
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

						<p class="woocommerce-FormRow form-row">
							<p><a href="#0" class="k-toggle-register">Already have an account?</a></p>
							<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
							<button type="submit" class="k-button k-button--primary woocommerce-Button button" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
						</p>

						<?php do_action( 'woocommerce_register_form_end' ); ?>

					</form>

				</div>
			</div>
		</div>
		<?php endif; ?>

		<?php do_action( 'woocommerce_after_customer_login_form' ); ?>

	</div>


</section>

<?php
get_footer();
?>