<?php

namespace WoocommerceUsersBadges\Shortcode;

use WoocommerceUsersBadges\Core\CoreClass;
use WoocommerceUsersBadges\Woocommerce_Users_Badges;

/**
 * Class UserShortcodeClass
 * @package WoocommerceUsersBadges\Shortcode
 */
class UserShortcodeClass {

	protected $core;

	public function __construct() {
		$this->core = new CoreClass();
		add_shortcode( 'user_details', array( $this, 'user_details_cb' ) );
	}

	public function user_details_cb( $atts, $content ) {
		$a = shortcode_atts( array(
			'badge'    => 'yes',
			'username' => 'no'
		), $atts );

		ob_start();

		$user      = wp_get_current_user();
		$rules     = $this->core->get_user_options( true );
		$get_badge = $this->core->get_badge_info( $user->ID );

		?>
		<?php if ( $a['username'] == 'yes' ): ?>
			<p>
				<span>
				<?php echo $content; ?>
				<?php echo $user->user_login ?>
				</span>
			</p>
		<?php endif; ?>
		<?php if ( ! empty( $get_badge ) ) : ?>
			<div class="badges-container">
				<h3><?php _e( 'My Badges', Woocommerce_Users_Badges::TEXTDOMAIN ) ?></h3>
				<?php foreach ( $get_badge as $badge ) : ?>
					<img src="<?php echo $badge['image_src'] ?>" alt="<?php echo $badge['desc'] ?>"
					     title="<?php echo $badge['desc'] ?>"
					     width="<?php echo ! empty( $rules['badge_width'] ) ? $rules['badge_width'] : '70' ?>"
					     height="<?php echo ! empty( $rules['badge_height'] ) ? $rules['badge_height'] : '70' ?>"/>

				<?php endforeach; ?>
			</div> <!-- end badges container -->
		<?php endif; ?>
		<?php

		return ob_get_clean();
	}
}