<?php
/**
 * GN Netflix CPT Loop Generatot
 *
 * @package       GNNETFLIXC
 * @author        George Nicolaou
 * @license       gplv2
 * @version       1.0.1
 *
 * @wordpress-plugin
 * Plugin Name:   GN Netflix CPT Loop Generatot
 * Plugin URI:    https://www.georgenicolaou.me/plugins/gn-netflix-cpt-loop-generator
 * Description:   Create a Netflix type interface as a loop layout for a Custom Post Type
 * Version:       1.0.1
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
define( 'GNNETFLIXC_VERSION',		'1.0.1' );

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
require 'plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;


function project_year_images_shortcode() {
    ob_start();
    
    // Assuming you have the projects post type and ACF field 'field_6364db1fd90a8'
    $args = array(
        'post_type' => 'projects',
        'posts_per_page' => -1, // To retrieve all posts
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $years = array(); // Store unique years

        while ($query->have_posts()) {
            $query->the_post();
            $year = get_field('field_6364db1fd90a8'); // Replace with your ACF field name

            if ($year && !in_array($year, $years)) {
                $years[] = $year;
            }
        }

        // Output HTML
        foreach ($years as $year) {
            echo '<div class="location" id="home">';
            echo '<h1 id="home">' . $year . '</h1>';
            echo '<div class="box">';

            $query->rewind_posts(); // Rewind the loop to get posts again

            $imageCount = 1; // For naming image variables

            while ($query->have_posts()) {
                $query->the_post();
                $post_year = get_field('field_6364db1fd90a8'); // Replace with your ACF field name

                if ($post_year == $year) {
                    $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
                    $project_link = get_permalink();

                    if ($featured_image) {
                        echo '<a href="' . $project_link . '">';
                        echo '<img src="' . $featured_image . '" alt=""></a>';

                        // Increment the image count and add a new line after every 6 images
                        $imageCount++;
                        if ($imageCount > 6) {
                            $imageCount = 1;
                            echo '<br>';
                        }
                    }
                }
            }

            echo '</div>'; // Close the box div
            echo '</div>'; // Close the location div
        }

        wp_reset_postdata(); // Restore the global post data
    } else {
        // No projects found
    }
    
    return ob_get_clean();
}

add_shortcode('project_year_images', 'project_year_images_shortcode');

function enqueue_custom_styles() {
    wp_enqueue_style('custom-styles', plugins_url('style.css', __FILE__));
}

add_action('wp_enqueue_scripts', 'enqueue_custom_styles');
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
