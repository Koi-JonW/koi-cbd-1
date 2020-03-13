<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if (!defined('ABSPATH')) {
	exit;
}

do_action('woocommerce_before_account_navigation');

?>
<?php 
	$current_user = wp_get_current_user();
	$username = $current_user->display_name;
?>

<nav class="woocommerce-MyAccount-navigation">
	<div class="k-dashboard--sidebar__liner">
		<span class="k-dashboard__greeting">
			<span class="k-headline k-headline--sm">Hi, <?php echo $username; ?></span>
		</span>
		<ul>
			<?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
				<li class="<?php echo wc_get_account_menu_item_classes($endpoint); ?>">
					<a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>"><?php echo esc_html($label); ?></a>
					<?php if(esc_html($label) == "Dashboard"){ ?> 
					</li>
					<li>
						<a href="<?php echo esc_url( home_url( '/005-koi-cbd-account-web' ) ); ?>">My Rewards</a>
					<?php } ?>
				</li>
			<?php endforeach; ?>
		</ul>
		<div class="k-dashboard--sidebar__wrong-user">
			<!-- <p class="k-wrong-account">
				<a href="#0" class="k-button k-button--primary k-customer-logout">Log out</a>
			</p> -->
		</div>
	</div>
</nav>

<?php do_action('woocommerce_after_account_navigation'); ?>
