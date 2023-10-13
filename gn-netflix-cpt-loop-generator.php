<?php
/**
 * GN Netflix CPT Loop Generatot
 *
 * @package       GNNETFLIXC
 * @author        George Nicolaou
 * @license       gplv2
 * @version       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:   GN Netflix CPT Loop Generatot
 * Plugin URI:    https://www.georgenicolaou.me/plugins/gn-netflix-cpt-loop-generator
 * Description:   Create a Netflix type interface as a loop layout for a Custom Post Type
 * Version:       1.0.0
 * Author:        George Nicolaou
 * Author URI:    https://www.georgenicolaou.me/
 * Text Domain:   gn-netflix-cpt-loop-generator
 * Domain Path:   /languages
 * License:       GPLv2
 * License URI:   https://www.gnu.org/licenses/gpl-2.0.html
 *
 * You should have received a copy of the GNU General Public License
 * along with GN Netflix CPT Loop Generatot. If not, see <https://www.gnu.org/licenses/gpl-2.0.html/>.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
// Plugin name
define( 'GNNETFLIXC_NAME',			'GN Netflix CPT Loop Generatot' );

// Plugin version
define( 'GNNETFLIXC_VERSION',		'1.0.0' );

// Plugin Root File
define( 'GNNETFLIXC_PLUGIN_FILE',	__FILE__ );

// Plugin base
define( 'GNNETFLIXC_PLUGIN_BASE',	plugin_basename( GNNETFLIXC_PLUGIN_FILE ) );

// Plugin Folder Path
define( 'GNNETFLIXC_PLUGIN_DIR',	plugin_dir_path( GNNETFLIXC_PLUGIN_FILE ) );

// Plugin Folder URL
define( 'GNNETFLIXC_PLUGIN_URL',	plugin_dir_url( GNNETFLIXC_PLUGIN_FILE ) );

/**
 * Load the main class for the core functionality
 */
require_once GNNETFLIXC_PLUGIN_DIR . 'core/class-gn-netflix-cpt-loop-generator.php';

/**
 * The main function to load the only instance
 * of our master class.
 *
 * @author  George Nicolaou
 * @since   1.0.0
 * @return  object|Gn_Netflix_Cpt_Loop_Generator
 */
function GNNETFLIXC() {
	return Gn_Netflix_Cpt_Loop_Generator::instance();
}

GNNETFLIXC();
$myUpdateChecker = PucFactory::buildUpdateChecker(
    'https://github.com/GeorgeWebDevCy/gn-netflix-cpt-loop-generator',
    __FILE__,
    'gn-netflix-cpt-loop-generator'
);

// Set the branch that contains the stable release.
$myUpdateChecker->setBranch('main');
