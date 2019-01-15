<?php
require __DIR__ . '/vendor/autoload.php';
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;



/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://radio.rte.ie
 * @since             1.0.0
 * @package           Rte_Radio_Clip
 *
 * @wordpress-plugin
 * Plugin Name:       RTÉ Radio Clip
 * Plugin URI:        https://radio.rte.ie
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Doug Banville
 * Author URI:        https://radio.rte.ie
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rte-radio-clip
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('PLUGIN_NAME_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-rte-radio-clip-activator.php
 */
function activate_rte_radio_clip()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-rte-radio-clip-activator.php';
    Rte_Radio_Clip_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-rte-radio-clip-deactivator.php
 */
function deactivate_rte_radio_clip()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-rte-radio-clip-deactivator.php';
    Rte_Radio_Clip_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_rte_radio_clip');
register_deactivation_hook(__FILE__, 'deactivate_rte_radio_clip');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-rte-radio-clip.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_rte_radio_clip()
{

    $plugin = new Rte_Radio_Clip();
    $plugin->run();

}
run_rte_radio_clip();

//for url params
function get_request_parameter( $key, $default = '' ) {
    // If not request set
    if ( ! isset( $_REQUEST[ $key ] ) || empty( $_REQUEST[ $key ] ) ) {
        return $default;
    }
 
    // Set so process it
    return strip_tags( (string) wp_unslash( $_REQUEST[ $key ] ) );
}
wp_register_style( 'flowplayer_skin', 'https://releases.flowplayer.org/7.2.4/skin/skin.css"' );
wp_enqueue_style('flowplayer_skin');
wp_register_style( 'flowplayer', 'https://releases.flowplayer.org/audio/flowplayer.audio.css"' );
wp_enqueue_style('flowplayer');


//
wp_register_script('flowplayer','https://releases.flowplayer.org/7.2.4/flowplayer.min.js',null, null, true);
wp_enqueue_script('flowplayer');
wp_register_script('hls_light','https://releases.flowplayer.org/hlsjs/flowplayer.hlsjs.light.min.js',null, null, true);
wp_enqueue_script('hls_light');
wp_register_script('flowplayer_audio','https://releases.flowplayer.org/audio/flowplayer.audio.min.js',null, null, true);
wp_enqueue_script('flowplayer_audio');

wp_register_script('rte-radio-clip-public', plugins_url('js/rte-radio-clip.js', __FILE__), array('jquery'),'1.1', true);





$audioId=get_request_parameter("audioId");
$audio =file_get_contents("https://radio-a8e0f.firebaseio.com/audioclips/".$audioId.".json");
$audioClip = json_decode($audio);
$audioUrl = $audioClip->awsaudio;
$picture = $audioClip->picture;
$title = $audioClip->title;

wp_localize_script('rte-radio-clip-public', 'rte_vars', array(
    'audio' => __($audioUrl, ''),
    'picture' => __($picture, '')
)
);

wp_enqueue_script('rte-radio-clip-public');

function headTags(){
    global $picture, $wp, $audioId;
    $current_url = home_url( add_query_arg( array(), $wp->request ) );
    $current_url = $current_url."?audioId=$audioId";
    echo '<meta property="og:title" content="'.$title.'" />
    <meta property="og:type" content="audio/mpeg" />
    <meta property="og:url" content="'.$current_url.'" />
    <meta property="og:image" content="'.$picture.'" />';
}

add_action('wp_head',"headTags");

function rte_clip($atts)
{
    global $audioUrl;
    
    $a = shortcode_atts(array(
        'id' => 'My Id here',
        // ...etc
    ), $atts);
    

    $html = '<div id="rte" class="fp-outlined">
    <a class="fp-prev"></a>
    <a class="fp-next"></a>
    </div>';
    if($audioUrl){
        return $html;
    }

}

add_shortcode("rte-clip", "rte_clip");