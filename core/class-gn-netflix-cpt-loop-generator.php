<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'Gn_Netflix_Cpt_Loop_Generator' ) ) :

	/**
	 * Main Gn_Netflix_Cpt_Loop_Generator Class.
	 *
	 * @package		GNNETFLIXC
	 * @subpackage	Classes/Gn_Netflix_Cpt_Loop_Generator
	 * @since		1.0.0
	 * @author		George Nicolaou
	 */
	final class Gn_Netflix_Cpt_Loop_Generator {

		/**
		 * The real instance
		 *
		 * @access	private
		 * @since	1.0.0
		 * @var		object|Gn_Netflix_Cpt_Loop_Generator
		 */
		private static $instance;

		/**
		 * GNNETFLIXC helpers object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Gn_Netflix_Cpt_Loop_Generator_Helpers
		 */
		public $helpers;

		/**
		 * GNNETFLIXC settings object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Gn_Netflix_Cpt_Loop_Generator_Settings
		 */
		public $settings;

		/**
		 * Throw error on object clone.
		 *
		 * Cloning instances of the class is forbidden.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to clone this class.', 'gn-netflix-cpt-loop-generator' ), '1.0.0' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to unserialize this class.', 'gn-netflix-cpt-loop-generator' ), '1.0.0' );
		}

		/**
		 * Main Gn_Netflix_Cpt_Loop_Generator Instance.
		 *
		 * Insures that only one instance of Gn_Netflix_Cpt_Loop_Generator exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @access		public
		 * @since		1.0.0
		 * @static
		 * @return		object|Gn_Netflix_Cpt_Loop_Generator	The one true Gn_Netflix_Cpt_Loop_Generator
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Gn_Netflix_Cpt_Loop_Generator ) ) {
				self::$instance					= new Gn_Netflix_Cpt_Loop_Generator;
				self::$instance->base_hooks();
				self::$instance->includes();
				self::$instance->helpers		= new Gn_Netflix_Cpt_Loop_Generator_Helpers();
				self::$instance->settings		= new Gn_Netflix_Cpt_Loop_Generator_Settings();

				//Fire the plugin logic
				new Gn_Netflix_Cpt_Loop_Generator_Run();

				/**
				 * Fire a custom action to allow dependencies
				 * after the successful plugin setup
				 */
				do_action( 'GNNETFLIXC/plugin_loaded' );
			}

			return self::$instance;
		}

		/**
		 * Include required files.
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function includes() {
			require_once GNNETFLIXC_PLUGIN_DIR . 'core/includes/classes/class-gn-netflix-cpt-loop-generator-helpers.php';
			require_once GNNETFLIXC_PLUGIN_DIR . 'core/includes/classes/class-gn-netflix-cpt-loop-generator-settings.php';

			require_once GNNETFLIXC_PLUGIN_DIR . 'core/includes/classes/class-gn-netflix-cpt-loop-generator-run.php';
		}

		/**
		 * Add base hooks for the core functionality
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function base_hooks() {
			add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
		}

		/**
		 * Loads the plugin language files.
		 *
		 * @access  public
		 * @since   1.0.0
		 * @return  void
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'gn-netflix-cpt-loop-generator', FALSE, dirname( plugin_basename( GNNETFLIXC_PLUGIN_FILE ) ) . '/languages/' );
		}

	}

endif; // End if class_exists check.