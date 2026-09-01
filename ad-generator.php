<?php
/**
 * Plugin Name:        Ad Generator
 * Plugin URI:         https://github.com/AiratTop/ad-generator
 * Description:        Professional text randomizer and ad generator.
 * Author:             AiratTop
 * Author URI:         https://airat.top
 * Version:            2.3.0
 * Text Domain:        ad-generator
 * Domain Path:        /languages/
 * Requires at least:  7.0
 * Requires PHP:       8.3
 * Release Asset:      true
 * GitHub Plugin URI:  https://github.com/AiratTop/ad-generator
 * License:            Apache-2.0
 * License URI:        https://www.apache.org/licenses/LICENSE-2.0
 */
/**
 * @package    AiratTop/ad-generator
 * @category   Core
 * @author     AiratTop
 * @license    Apache-2.0
 * @link       https://github.com/AiratTop/ad-generator
 * @version    2.3.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ad_generator_shortcode {

	public static $max_res = 10;
	public static $mydomain = 'ad-generator';

	public static function init() {
		add_shortcode( 'ad_generator', array( __CLASS__, 'ad_generator_func' ) );
		add_action( 'plugins_loaded', array( __CLASS__, 'ad_generator_textdomain' ) );
	}

	public static function ad_generator_textdomain() {
		load_plugin_textdomain( self::$mydomain, false, basename( dirname( __FILE__ ) ) . '/languages/' );
	}

	public static function ad_generator_func( $atts ) {
		$ad_text      = self::get_submitted_text();
		$display_text = '' !== $ad_text
			? $ad_text
			: __( 'Это{|, пожалуй,} самый {лучший|прекрасный|отличный} {рандомизатор|рандомайзер} текста, который я только {видел|встречал}. Он такой [+, +удобный|быстрый] и функциональный{, что ничего другого уже не нужно| - мне всё в нем нравится}{!|.|. : )} {Спасибо!|Спасибо большое!|Спасибо, Айрат!}', self::$mydomain );

		self::$max_res = self::get_max_results();

		$result_text  = '<form method="post" action="">';
		$result_text .= sprintf(
			'<textarea id="ad_text" name="ad_text" cols="80" rows="10" maxlength="10000" style="width: 100%%;" placeholder="%s">%s</textarea>',
			esc_attr__( 'Введите шаблон', self::$mydomain ),
			esc_textarea( $display_text )
		);
		$result_text .= '<br /><p>';
		$result_text .= esc_html__( 'Выбор количества отображаемых результатов (по умолчанию 10):', self::$mydomain );

		foreach ( array( 10, 100, 300 ) as $count ) {
			$result_text .= sprintf(
				'<br /><label><input type="radio" name="ad_count" value="%1$d" id="ads_%1$d" %2$s> %1$d</label>',
				$count,
				checked( self::$max_res, $count, false )
			);
		}

		$result_text .= '</p><button id="ad_text_btn" class="btn btn-large btn-primary" type="submit">';
		$result_text .= esc_html__( 'Генерировать', self::$mydomain );
		$result_text .= '</button></form>';

		if ( '' !== $ad_text ) {
			$result_text .= '<br />' . self::get_reset_link() . '<br /><br />';

			require_once plugin_dir_path( __FILE__ ) . '/includes/Randomizer.php';

			$randomizer = new Randomizer( $ad_text );
			$num_var    = $randomizer->numVariant();

			if ( $num_var > 1 ) {
				$max_tmp      = min( $num_var, self::$max_res );
				$result_text .= wp_kses_post(
					sprintf(
						__( '<p><i>Число всех возможных вариантов: <strong>%s</strong>. Вот случайные <strong>%s</strong> из них:</i></p>', self::$mydomain ),
						esc_html( (string) $num_var ),
						esc_html( (string) $max_tmp )
					)
				);

				for ( $i = 0; $i < $max_tmp; ++$i ) {
					$result_text .= '<p id="ad_text_result">' . nl2br( esc_html( $randomizer->getText() ) ) . '</p><hr />';
				}

				if ( $max_tmp >= 10 ) {
					$result_text .= self::get_reset_link() . '<br />';
				}
			} else {
				$result_text .= wp_kses_post( __( '<p><i>Только <strong>1</strong> возможный вариант:</i></p>', self::$mydomain ) );
				$result_text .= '<p id="ad_text_result">' . nl2br( esc_html( $randomizer->getText() ) ) . '</p><hr />';
			}
		}

		return $result_text;
	}

	private static function get_submitted_text(): string {
		if ( ! isset( $_POST['ad_text'] ) || ! is_string( $_POST['ad_text'] ) ) {
			return '';
		}

		return wp_unslash( $_POST['ad_text'] );
	}

	private static function get_max_results(): int {
		if ( ! isset( $_POST['ad_count'] ) || ! is_scalar( $_POST['ad_count'] ) ) {
			return 10;
		}

		$count = (int) wp_unslash( (string) $_POST['ad_count'] );

		return max( 1, min( 300, $count ) );
	}

	private static function get_reset_link(): string {
		$request_uri = isset( $_SERVER['REQUEST_URI'] ) && is_string( $_SERVER['REQUEST_URI'] )
			? wp_unslash( $_SERVER['REQUEST_URI'] )
			: '';

		return sprintf(
			'<a href="%s" id="ad_text_clear_btn">%s</a>',
			esc_url( $request_uri ),
			esc_html__( 'Очистить и начать заново', self::$mydomain )
		);
	}
}

ad_generator_shortcode::init();
