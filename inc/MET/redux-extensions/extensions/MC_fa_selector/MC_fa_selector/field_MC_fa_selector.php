<?php
/**
 * Redux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Redux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Redux Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     ReduxFramework
 * @author      Dovy Paukstys
 * @version     3.1.5
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;


add_filter('met_redux_fa_input_extension_dir','met_redux_fa_input_extension_dir');
function met_redux_fa_input_extension_dir($url){
	global $global_met_redux_fa_input_extension_dir;
	$global_met_redux_fa_input_extension_dir = $url;
}

function add_fa_mfp_admin_footer($extension_url = null){
	global $global_met_redux_fa_input_extension_dir;
	/**
	 * Magnific Popup -> Font Awesome
	 *
	 * @since 1.0.0
	 */

	$fa_mfp = '';

	$pattern = '/\.(fa-(?:\w+(?:-)?)+):before{content:/';
	$subject = file_get_contents($global_met_redux_fa_input_extension_dir. 'fontawesome/style.css');

	preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

	$fontAwesome = array();

	foreach($matches as $match){
		$fontAwesome[] = $match[1];
	}

	$fa_mfp .= '<div id="met_mfp_fa_icon_selector" class="mfp-hide">';

	$fa_mfp .= '<div id="met_mfp_fa_icon_list">';
	foreach ( $fontAwesome as $icon ){
		$fa_mfp .= '<span class="button" data-icon="'.$icon.'"><i class="fa '.$icon.'"></i></span>';
	}
	$fa_mfp .= '</div>';

	$fa_mfp .= '<br />';
	$fa_mfp .= '<a class="met_mfp_fa_cancel button">'.__('Close','met_mega_menu').'</a>';
	$fa_mfp .= '<input type="hidden" class="met_fa_rel" value="" />';

	$fa_mfp .= '</div>';

	echo $fa_mfp;
} add_action('admin_footer', 'add_fa_mfp_admin_footer');

// Don't duplicate me!
if( !class_exists( 'ReduxFramework_MC_fa_selector' ) ) {

    /**
     * Main ReduxFramework_custom_field class
     *
     * @since       1.0.0
     */
    class ReduxFramework_MC_fa_selector extends ReduxFramework {
    
        /**
         * Field Constructor.
         *
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        function __construct( $field = array(), $value ='', $parent ) {
            
            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;

            if ( empty( $this->extension_dir ) ) {
                $this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
                $this->extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->extension_dir ) );
            }

            // Set default args for this field to avoid bad indexes. Change this to anything you use.
            $defaults = array(
                'options'           => array(),
                'stylesheet'        => '',
                'output'            => true,
                'enqueue'           => true,
                'enqueue_frontend'  => true
            );
            $this->field = wp_parse_args( $this->field, $defaults );

			apply_filters('met_redux_fa_input_extension_dir',$this->extension_dir);
        }

        /**
         * Field Render Function.
         *
         * Takes the vars and outputs the HTML for the field in the settings
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function render() {

			if ( ! empty( $this->field['data'] ) && empty( $this->field['options'] ) ) {
				if ( empty( $this->field['args'] ) ) {
					$this->field['args'] = array();
				}

				$this->field['options'] = $this->parent->get_wordpress_data( $this->field['data'], $this->field['args'] );
				$this->field['class'] .= " hasOptions ";
			}

			if ( empty( $this->value ) && ! empty( $this->field['data'] ) && ! empty( $this->field['options'] ) ) {
				$this->value = $this->field['options'];
			}

			$placeholder = ( isset( $this->field['placeholder'] ) && ! is_array( $this->field['placeholder'] ) ) ? ' placeholder="' . esc_attr( $this->field['placeholder'] ) . '" ' : '';

			echo '
			<div class="met-fa-wrap met-fa-wrap-' . $this->field['id'] . ' input-prepend">
			<span class="add-on"><i class="fa '.((empty($this->value)) ? 'fa-times fa-none' : $this->value).'"></i></span>
			<input id="met-fa-input-' . $this->field['id'] . '" type="text" readonly="readonly" '.$placeholder.' class="met-fa-input' . $this->field['class'] . '"  value="' . esc_attr( $this->value ) . '" name="' . $this->field['name'] . $this->field['name_suffix'] . '">


			</div>
			<br><br>
			<a href="#met_mfp_fa_icon_selector" id="button-'.$this->field['id'].'" rel="'.$this->field['id'].'" class="met_fa_trigger_button mmm_mfp button">Select Icon</a>
			<a href="javascript:;" id="button-del-'.$this->field['id'].'" rel="'.$this->field['id'].'" class="met_fa_clear_button button removeCSS">Clear</a>';

        }
    
        /**
         * Enqueue Function.
         *
         * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function enqueue() {

            $extension = ReduxFramework_extension_MC_fa_selector::getInstance();
        
            wp_enqueue_script(
                'redux-field-MC_fa_selector-js',
                $this->extension_url . 'field_MC_fa_selector.js',
                array( 'jquery' ),
                time(),
                true
            );

			wp_enqueue_script(
				'MC_fa_selector_magnific-popup-js',
				$this->extension_url . 'magnific-popup.inline.min.js',
				array( ),
				time(),
				true
			);

            wp_enqueue_style(
                'redux-field-MC_fa_selector-css',
                $this->extension_url . 'field_MC_fa_selector.css',
                time(),
                true
            );

			wp_enqueue_style(
				'MC_fa_selector_magnific-popup-css',
				$this->extension_url . 'magnific-popup.css',
				time(),
				true
			);
        
        }
        
        /**
         * Output Function.
         *
         * Used to enqueue to the front-end
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */        
        public function output() {

            if ( $this->field['enqueue_frontend'] ) {

            }
            
        }        
        
    }
}
