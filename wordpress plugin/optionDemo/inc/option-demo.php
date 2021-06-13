<?php 



class OptionDemo {
	private $option_demo_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'option_demo_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'option_demo_page_init' ) );
        add_action("plugins_loaded",array($this,"option_demo_laod_textdomain"));
        add_action("plugin_action_links_".plugin_basename(__FILE__),array($this,"option_demo_setting_links"));
	}
    public function option_demo_setting_links($links){
        $newLinks=sprintf('<a href="%s">%s</a>','options-general.php?page=option-demo','Settings');
        $links[]=$newLinks;
        return $links;
    }
    public function option_demo_laod_textdomain(){
        load_plugin_textdomain("option-demo",false,dirname(__FILE__)."languages");
    }
	public function option_demo_add_plugin_page() {
		add_options_page(
			'Option demo', // page_title
			'Option demo', // menu_title
			'manage_options', // capability
			'option-demo', // menu_slug
			array( $this, 'option_demo_create_admin_page' ) // function
		);
	}

	public function option_demo_create_admin_page() {
		$this->option_demo_options = get_option( 'option_demo_option_name' ); ?>

		<div class="wrap">
			<h2>Option demo</h2>
			<p>This is option demo page settings</p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'option_demo_option_group' );
					do_settings_sections( 'option-demo-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function option_demo_page_init() {
		register_setting(
			'option_demo_option_group', // option_group
			'option_demo_option_name', // option_name
			array( $this, 'option_demo_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'option_demo_setting_section', // id
			'Settings', // title
			array( $this, 'option_demo_section_info' ), // callback
			'option-demo-admin' // page
		);

		add_settings_field(
			'latitude_0', // id
			'latitude', // title
			array( $this, 'latitude_0_callback' ), // callback
			'option-demo-admin', // page
			'option_demo_setting_section' // section
		);

		add_settings_field(
			'lontitude_1', // id
			'lontitude', // title
			array( $this, 'lontitude_1_callback' ), // callback
			'option-demo-admin', // page
			'option_demo_setting_section' // section
		);

		add_settings_field(
			'zoom_label_2', // id
			'zoom label', // title
			array( $this, 'zoom_label_2_callback' ), // callback
			'option-demo-admin', // page
			'option_demo_setting_section' // section
		);

		add_settings_field(
			'api_key_3', // id
			'api key', // title
			array( $this, 'api_key_3_callback' ), // callback
			'option-demo-admin', // page
			'option_demo_setting_section' // section
		);

		add_settings_field(
			'external_css_4', // id
			'external css', // title
			array( $this, 'external_css_4_callback' ), // callback
			'option-demo-admin', // page
			'option_demo_setting_section' // section
		);
	}

	public function option_demo_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['latitude_0'] ) ) {
			$sanitary_values['latitude_0'] = sanitize_text_field( $input['latitude_0'] );
		}

		if ( isset( $input['lontitude_1'] ) ) {
			$sanitary_values['lontitude_1'] = sanitize_text_field( $input['lontitude_1'] );
		}

		if ( isset( $input['zoom_label_2'] ) ) {
			$sanitary_values['zoom_label_2'] = sanitize_text_field( $input['zoom_label_2'] );
		}

		if ( isset( $input['api_key_3'] ) ) {
			$sanitary_values['api_key_3'] = sanitize_text_field( $input['api_key_3'] );
		}

		if ( isset( $input['external_css_4'] ) ) {
			$sanitary_values['external_css_4'] = sanitize_text_field( $input['external_css_4'] );
		}

		return $sanitary_values;
	}

	public function option_demo_section_info() {
		echo "This is nazrul rafi";
	}

	public function latitude_0_callback() {
		printf(
			'<input class="regular-text" type="text" name="option_demo_option_name[latitude_0]" id="latitude_0" value="%s">',
			isset( $this->option_demo_options['latitude_0'] ) ? esc_attr( $this->option_demo_options['latitude_0']) : ''
		);
	}

	public function lontitude_1_callback() {
		printf(
			'<input class="regular-text" type="text" name="option_demo_option_name[lontitude_1]" id="lontitude_1" value="%s">',
			isset( $this->option_demo_options['lontitude_1'] ) ? esc_attr( $this->option_demo_options['lontitude_1']) : ''
		);
	}

	public function zoom_label_2_callback() {
		printf(
			'<input class="regular-text" type="text" name="option_demo_option_name[zoom_label_2]" id="zoom_label_2" value="%s">',
			isset( $this->option_demo_options['zoom_label_2'] ) ? esc_attr( $this->option_demo_options['zoom_label_2']) : ''
		);
	}

	public function api_key_3_callback() {
		printf(
			'<input class="regular-text" type="text" name="option_demo_option_name[api_key_3]" id="api_key_3" value="%s">',
			isset( $this->option_demo_options['api_key_3'] ) ? esc_attr( $this->option_demo_options['api_key_3']) : ''
		);
	}

	public function external_css_4_callback() {
		printf(
			'<input class="regular-text" type="text" name="option_demo_option_name[external_css_4]" id="external_css_4" value="%s">',
			isset( $this->option_demo_options['external_css_4'] ) ? esc_attr( $this->option_demo_options['external_css_4']) : ''
		);
	}

}
if ( is_admin() )
	$option_demo = new OptionDemo();

/* 
 * Retrieve this value with:
 * $option_demo_options = get_option( 'option_demo_option_name' ); // Array of All Options
 * $latitude_0 = $option_demo_options['latitude_0']; // latitude
 * $lontitude_1 = $option_demo_options['lontitude_1']; // lontitude
 * $zoom_label_2 = $option_demo_options['zoom_label_2']; // zoom label
 * $api_key_3 = $option_demo_options['api_key_3']; // api key
 * $external_css_4 = $option_demo_options['external_css_4']; // external css
 */
