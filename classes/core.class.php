<?php

namespace WoocommerceUsersBadges\Core;

	/**
	 * Class CoreClass
	 * @package WoocommerceUsersBadges\Core
	 */
	/**
	 * Class CoreClass
	 * @package WoocommerceUsersBadges\Core
	 */
	/**
	 * Class CoreClass
	 * @package WoocommerceUsersBadges\Core
	 */
/**
 * Class CoreClass
 * @package WoocommerceUsersBadges\Core
 */
class CoreClass {

	/**
	 * @param $user_id
	 *
	 * @param array $status
	 *
	 * @return array return the orders for the user
	 *
	 * return the orders for the user
	 */
	public function get_user_orders( $user_id, $status ) {
		$orders = get_posts( array(
			'post_type'   => 'shop_order',
			'post_author' => intval( $user_id ),
			'post_status' => $status
		) );

		return $orders;
	}


	/**
	 * @param $all_options
	 *
	 * @return mixed|void
	 */
	public function get_user_options( $all_options ) {
		$options = get_option( 'user_badges' );

		if ( $all_options ) {
			return $options;
		}

		return $options['rules'];
	}

	/**
	 * @param $user_id
	 *
	 * @return array
	 * @internal param $type
	 *
	 */
	public function get_badge_info( $user_id ) {
		$rules = $this->get_user_options( false );

		foreach ( $rules as $rule ) {
			if ( $rule['compare_element'] == 'order' ) {
				$orders_count = count( $this->get_user_orders( $user_id, 'wc-completed' ) );

				if ( $this->passed( $orders_count, $rule ) && $rule['compare_element'] == 'order' ) {
					$results[] = array(
						'image_src' => $rule['user_badge_img']['src'],
						'desc'      => $rule['desc']
					);
				};


			} elseif ( $rule['compare_element'] == 'registration' ) {
				$register_date                = $this->get_registeration_date( $user_id );
				$days_diff_from_registeration = $this->get_current_date_diff( $register_date );         // Difference in days from the registeration time

				if ( $this->passed( $days_diff_from_registeration, $rule ) && $rule['compare_element'] == 'registration' ) {
					$results[] = array(
						'image_src' => $rule['user_badge_img']['src'],
						'desc'      => $rule['desc']
					);
				};

			}
		}


		return $results;

	}


	/**
	 * @param $count
	 * @param $rule
	 *
	 * @return bool Compare the compare value with the count passed
	 * Compare the compare value with the order count
	 * @internal param $orders_count
	 */
	private function passed( $count, $rule ) {
		// check the passed value if less than 0 then return 0
		$compare_value = max( intval( $rule['compare_value'] ), 0 );

		if ( $compare_value == 0 ) {
			$compare_value = 1;
		}

//		echo "<pre>";
//		print_r( $rule['compare_parameter'] . ' ' . $count . ' ' . $compare_value );
//		echo "</pre>";

		// check the conditions
		if ( $rule['compare_parameter'] == '1' && $count == $compare_value ) {
			return true;
		} elseif ( $rule['compare_parameter'] == '2' && $count != $compare_value ) {
			return true;
		} elseif ( $rule['compare_parameter'] == '3' && $count < $compare_value ) {
			return true;
		} elseif ( $rule['compare_parameter'] == '4' && $count <= $compare_value ) {
			return true;
		} elseif ( $rule['compare_parameter'] == '5' && $count > $compare_value ) {
			return true;
		} elseif ( $rule['compare_parameter'] == '6' && $count >= $compare_value ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @param $user_id
	 *
	 * @return string
	 */
	public function get_registeration_date( $user_id ) {
		$user_data = get_userdata( $user_id );

		return $user_data->user_registered;
	}

	/**
	 * @param $datetime
	 *
	 * @return float
	 *
	 * Get current date
	 */
	public function get_current_date_diff( $datetime ) {
		$current   = time();
		$date      = strtotime( $datetime );
		$date_diff = $current - $date;

		return floor( $date_diff / ( 60 * 60 * 24 ) );
	}


}