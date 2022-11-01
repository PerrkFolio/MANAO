<?php
//require dirname( __FILE__, 3 ) . '/includes/yookassa/lib/autoload.php';
//use YooKassa\Client;
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/L0L1K1510/yoomoney-wp
 * @since      1.0.0
 *
 * @package    Yoomoney-WP
 * @subpackage Yoomoney-WP/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
	<h1>Настройки Yoomoney</h1>

	<form method="post" action="options.php">
		<?php wp_nonce_field('update-options'); ?>

		<table class="form-table">
			<tr valign="top">
				<th scope="row"><h2>Данные кассы</h2></th>
			</tr>

			<tr valign="top">
				<th scope="row">Shop ID</th>
				<td><input type="text" name="shopid" value="<?php echo get_option('shopid'); ?>" /></td>
			</tr>
			 
			<tr valign="top">
				<th scope="row">Secret Key</th>
				<td><input type="text" name="secretkey" value="<?php echo get_option('secretkey'); ?>" /></td>
			</tr>

			<tr valign="top">
				<th scope="row"><h2>Прочие настройки</h2></th>
			</tr>

			<tr valign="top">
				<th scope="row">URL возврата</th>
				<td><input type="text" name="tyurl" value="<?php echo get_option('tyurl'); ?>" /></td>
			</tr>


		</table>

			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="page_options" value="shopid,secretkey,tyurl" />

		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>

	</form>
</div>

<small><a href="https://yookassa.ru/docs/support/merchant/payments/implement/keys">Как выпустить секретный ключ?</a></small>
