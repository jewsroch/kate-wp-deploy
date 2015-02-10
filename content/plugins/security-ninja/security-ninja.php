<?php
/*
Plugin Name: Security Ninja
Plugin URI: http://security-ninja.webfactoryltd.com/
Description: Check your site for <strong>security vulnerabilities</strong> and get precise suggestions for corrective actions on passwords, user accounts, file permissions, database security, version hiding, plugins, themes and other security aspects.
Author: Web factory Ltd
Version: 1.70
Author URI: http://www.webfactoryltd.com/
*/


if (!function_exists('add_action')) {
  die('Please don\'t open this file directly!');
}


// constants
define('WF_SN_VER', '1.70');
define('WF_SN_DIC', plugin_dir_path(__FILE__) . 'brute-force-dictionary.txt');
define('WF_SN_OPTIONS_KEY', 'wf_sn_results');
define('WF_SN_MAX_USERS_ATTACK', 3);
define('WF_SN_MAX_EXEC_SEC', 200);


require_once 'sn-tests.php';


class wf_sn {
  // init plugin
  static function init() {
    // does the user have enough privilages to use the plugin?
    if (is_admin() && current_user_can('administrator')) {
      // this plugin requires WP v3.7
      if (!version_compare(get_bloginfo('version'), '3.7',  '>=')) {
        add_action('admin_notices', array(__CLASS__, 'min_version_error'));
        return;
      } else {
        // add menu item to tools
        add_action('admin_menu', array(__CLASS__, 'admin_menu'));

        // aditional links in plugin description
        add_filter('plugin_action_links_' . basename(dirname(__FILE__)) . '/' . basename(__FILE__),
                   array(__CLASS__, 'plugin_action_links'));
        add_filter('plugin_row_meta', array(__CLASS__, 'plugin_meta_links'), 10, 2);

        // enqueue scripts
        add_action('admin_enqueue_scripts', array(__CLASS__, 'enqueue_scripts'));

        // register ajax endpoints
        add_action('wp_ajax_sn_run_tests', array(__CLASS__, 'run_tests'));
        add_action('wp_ajax_sn_hide_core_tab', array(__CLASS__, 'hide_core_tab'));
        add_action('wp_ajax_sn_hide_schedule_tab', array(__CLASS__, 'hide_schedule_tab'));
        add_action('wp_ajax_sn_hide_logger_tab', array(__CLASS__, 'hide_logger_tab'));

        // warn if tests were not run
        add_action('admin_notices', array(__CLASS__, 'run_tests_warning'));

        // warn if Wordfence is active
        add_action('admin_notices', array(__CLASS__, 'wordfence_warning'));
      } // if version
    } // if
  } // init


  // add links to plugin's description in plugins table
  static function plugin_meta_links($links, $file) {
    $documentation_link = '<a target="_blank" href="' . plugin_dir_url(__FILE__) . 'documentation/' .
                          '" title="View documentation">Documentation</a>';
    $support_link = '<a target="_blank" href="http://codecanyon.net/user/WebFactory#contact" title="Contact Web factory">Support</a>';

    if ($file == plugin_basename(__FILE__)) {
      $links[] = $documentation_link;
      $links[] = $support_link;
    }

    return $links;
  } // plugin_meta_links


  // add settings link to plugins page
  static function plugin_action_links($links) {
    $settings_link = '<a href="tools.php?page=wf-sn" title="Security Ninja">Analyze site</a>';
    array_unshift($links, $settings_link);

    return $links;
  } // plugin_action_links


  // test if plugin's page is visible
  static function is_plugin_page() {
    $current_screen = get_current_screen();

    if ($current_screen->id == 'tools_page_wf-sn') {
      return true;
    } else {
      return false;
    }
  } // is_plugin_page


  // hide the core add-on ad tab
  static function hide_core_tab() {
    $tmp = (int) set_transient('wf_sn_hide_core_tab', true, 60*60*24*1000);

    die("$tmp");
  } // hide_core_tab


  // hide the core add-on ad tab
  static function hide_schedule_tab() {
    $tmp = (int) set_transient('wf_sn_hide_schedule_tab', true, 60*60*24*1000);

    die("$tmp");
  } // hide_core_tab

  // hide the logger add-on ad tab
  static function hide_logger_tab() {
    $tmp = (int) set_transient('wf_sn_hide_logger_tab', true, 60*60*24*1000);

    die("$tmp");
  } // hide_logger_tab


  // enqueue CSS and JS scripts on plugin's pages
  static function enqueue_scripts() {
    if (self::is_plugin_page()) {
      $plugin_url = plugin_dir_url(__FILE__);

      wp_enqueue_script('jquery-ui-tabs');
      wp_enqueue_script('sn-jquery-plugins', $plugin_url . 'js/wf-sn-jquery-plugins.js', array(), WF_SN_VER, true);
      wp_enqueue_script('sn-js', $plugin_url . 'js/wf-sn-common.js', array(), WF_SN_VER, true);
      wp_enqueue_style('sn-css', $plugin_url . 'css/wf-sn-style.css', array(), WF_SN_VER);
    } // if
  } // enqueue_scripts


  // add entry to admin menu
  static function admin_menu() {
    add_management_page('Security Ninja', 'Security Ninja', 'manage_options', 'wf-sn', array(__CLASS__, 'options_page'));
  } // admin_menu


  // display warning if test were never run
  static function run_tests_warning() {
    $tests = get_option(WF_SN_OPTIONS_KEY);

    if (self::is_plugin_page() && !$tests['last_run']) {
      echo '<div id="message" class="error"><p>Security Ninja <strong>tests were never run.</strong> Click "Run tests" to run them now and analyze your site for security vulnerabilities.</p></div>';
    } elseif (self::is_plugin_page() && (current_time('timestamp') - 30*24*60*60) > $tests['last_run']) {
      echo '<div id="message" class="error"><p>Security Ninja <strong>tests were not run for more than 30 days.</strong> It\'s advisable to run them once in a while. Click "Run tests" to run them now and analyze your site for security vulnerabilities.</p></div>';
    }
  } // run_tests_warning


  // display warning if Wordfence plugin is active
  static function wordfence_warning() {
    if (defined('WORDFENCE_VERSION') && WORDFENCE_VERSION) {
      echo '<div id="message" class="error"><p>Please <strong>deactivate Wordfence plugin</strong> before running Security Ninja tests. Some tests are detected as site attacks by Wordfence and hence can\'t be performed properly. Activate Wordfence once you\'re done testing.</p></div>';
    }
  } // wordfence_warning


  // display warning if test were never run
  static function min_version_error() {
    echo '<div id="message" class="error"><p>Security Ninja <b>requires WordPress version 3.7</b> or higher to function properly. You\'re using WordPress version ' . get_bloginfo('version') . '. Please <a href="' . admin_url('update-core.php') . '" title="Update WP core">update</a>.</p></div>';
  } // min_version_error


  // ad for add-on
  static function core_ad_page() {
    echo '<p><b>Core Scanner</b> is an add-on available for Security Ninja. It gives you a peace of mind by scanning all your core WP files (600+) to ensure they have not been modified by
    a 3rd party.<br>Add-on offers the following functionality;</p>';
    
    echo '<table width="100%"><tr><td width="50%" valign="top">';
    echo '<ul class="sn-list">
<li>scan WP core files with <strong>one click</strong></li>
<li>quickly identify <strong>problematic files</strong></li>
<li><strong>restore modified files</strong> with one click</li>
<li>great for removing <strong>exploits</strong> and fixing accidental file edits/deletes</li>
<li>view files\' <strong>source</strong> to take a closer look</li>
<li><strong>fix</strong> broken WP auto-updates</li>
<li>detailed help and description</li>
<li><strong>color-coded results</strong> separate files into 5 categories:
<ul>
<li>files that are modified and should not have been</li>
<li>files that are missing and should not be</li>
<li>files that are modified and they are supposed to be</li>
<li>files that are missing but they are not vital to WP</li>
<li>files that are intact</li>
</ul></li>
<li>complete integration with Ninja\'s easy-to-use GUI</li>
</ul>';

    echo '<p><br /><a target="_blank" href="http://codecanyon.net/item/core-scanner-addon-for-security-ninja/2927931/?ref=WebFactory" class="button-primary">View details and get the Core Scanner add-on for only $6</a>
  &nbsp;&nbsp;&nbsp;&nbsp;<a id="sn_hide_core_ad" href="#" title="Hide this tab"><i>No thank you, I\'m not interested (hide this tab)</i></a></p>';
  
    echo '</td><td>';
    echo '<a target="_blank" href="http://codecanyon.net/item/core-scanner-addon-for-security-ninja/2927931/?ref=WebFactory" title="Core Scanner add-on"><img style="max-width: 100%;" src="' .  plugin_dir_url(__FILE__) . 'images/core-scanner.jpg" title="Core Scanner add-on" alt="Core Scanner add-on" /></a>';
    echo '</td></tr></table>';
  } // core_ad_page


  // ad for add-on
  static function schedule_ad_page() {
    echo '<p><b>Scheduled Scanner</b> is an add-on available for Security Ninja. It gives you an additional peace of mind by automatically running Security Ninja and Core Scanner tests every day. If any changes occur or your site gets hacked you\'ll immediately get notified via email.<br>Add-on offers the following functionality;</p>';
    
    echo '<table width="100%"><tr><td width="50%" valign="top">';
    echo '<ul class="sn-list">
<li>give yourself a peace of mind with <strong>automated scans</strong> and email reports</li>
<li><strong>get alerted</strong> when your site is <strong>hacked</strong></li>
<li>compatible with both <strong>Security Ninja & Core Scanner add-on</strong></li>
<li>extremely <strong>easy</strong> to setup - set once and forget</li>
<li>optional <strong>email reports</strong> - get them after every scan or only after changes occur on your site</li>
<li>detailed, color-coded <strong>scan log</strong></li>
<li>complete integration with Ninja\'s easy-to-use GUI</li>
</ul>';

    echo '<p><br /><a target="_blank" href="http://codecanyon.net/item/scheduled-scanner-addon-for-security-ninja/3686330?ref=WebFactory" class="button-primary">View details and get the Scheduled Scanner add-on for only $6</a>
  &nbsp;&nbsp;&nbsp;&nbsp;<a id="sn_hide_schedule_ad" href="#" title="Hide this tab"><i>No thank you, I\'m not interested (hide this tab)</i></a></p>';
  
    echo '</td><td>';
    echo '<a target="_blank" href="http://codecanyon.net/item/scheduled-scanner-addon-for-security-ninja/3686330?ref=WebFactory" title="Scheduled Scanner add-on"><img style="max-width: 100%;" src="' .  plugin_dir_url(__FILE__) . 'images/scheduled-scanner.jpg" title="Scheduled Scanner add-on" alt="Scheduled Scanner add-on" /></a>';
    echo '</td></tr></table>';
  } // schedule_ad_page

  
  // ad for add-on
  static function logger_ad_page() {
    echo '<p><b>Events Logger</b> is an add-on available for Security Ninja. It monitors, tracks and reports every change on your WordPress site, both in the admin and on the frontend.<br>It offers the following functionality;</p>';
    
    echo '<table width="100%"><tr><td width="50%" valign="top">';
    echo '<ul class="sn-list">';
    echo '<li>monitor, track and <b>log more than 50 events</b> on the site in great detail</li>
          <li><b>know what happened</b> on the site at any time, in the admin and on the frontend</li>
          <li>prevent <b>"I didn\'t do it"</b> conversations with clients - Events Logger doesn\'t forget or lie</li>
          <li>easily <b>filter</b> trough the data</li>
          <li>know exactly when and <b>how an action happened</b>, and who did it</li>
          <li>receive <b>email alerts</b> for selected groups of events</li>
          <li>each logged event has the following details:<ul>
             <li>date and time</li>
             <li>event description (ie: "Search widget was added to Primary sidebar" or "Failed login attempt with username asdf.")</li>
             <li>username and role of user who did the action</li>
             <li>IP and user agent of the user</li>
             <li>module</li>
             <li>WordPress action/filter</li></ul></li>
          <li>complete integration with Ninja\'s easy-to-use GUI</li>
          <li>it\'s compatible with all themes and plugins</li>';
    echo '</ul>';
    echo '<p><br /><a target="_blank" href="http://security-ninja.webfactoryltd.com/get-events-logger/" class="button-primary">View details and get the Events Logger add-on for only $7</a>
  &nbsp;&nbsp;&nbsp;&nbsp;<a id="sn_hide_logger_ad" href="#" title="Hide this tab"><i>No thank you, I\'m not interested (hide this tab)</i></a></p>';
    echo '</td><td>';
    echo '<a target="_blank" href="http://security-ninja.webfactoryltd.com/get-events-logger/" title="Events Logger add-on"><img style="max-width: 100%;" src="' .  plugin_dir_url(__FILE__) . 'images/events-logger.jpg" title="Events Logger add-on" alt="Events Logger add-on" /></a>';
    echo '</td></tr></table>';
  } // logger_ad_page


  // whole options page
  static function options_page() {
    // does the user have enough privilages to access this page?
    if (!current_user_can('administrator'))  {
      wp_die('You do not have sufficient permissions to access this page.');
    }

    $tabs = array();
    $tabs[] = array('id' => 'sn_tests', 'class' => '', 'label' => 'Tests', 'callback' => array('self', 'tests_table'));
    $tabs[] = array('id' => 'sn_help', 'class' => 'sn_help', 'label' => 'Test details, tips &amp; help', 'callback' => array('self', 'help_table'));
    if (!get_transient('wf_sn_hide_core_tab')) {
      $tabs[] = array('id' => 'sn_core', 'class' => 'sn_core_ad', 'label' => 'Core Scanner (add-on)', 'callback' => array('self', 'core_ad_page'));
    }
    if (!get_transient('wf_sn_hide_schedule_tab')) {
      $tabs[] = array('id' => 'sn_schedule', 'class' => 'sn_schedule_ad', 'label' => 'Scheduled Scanner (add-on)', 'callback' => array('self', 'schedule_ad_page'));
    }
    if (!get_transient('wf_sn_hide_logger_tab')) {
      $tabs[] = array('id' => 'sn_logger', 'class' => 'sn_logger_ad', 'label' => 'Events Logger (add-on)', 'callback' => array('self', 'logger_ad_page'));
    }
    $tabs = apply_filters('sn_tabs', $tabs);

    echo '<div class="wrap">' . get_screen_icon('sn-lock');
    echo '<h2>Security Ninja</h2>';

    echo '<div id="tabs">';
    echo '<ul>';
    foreach ($tabs as $tab) {
      echo '<li><a href="#' . $tab['id'] . '" class="' . $tab['class'] . '">' . $tab['label'] . '</a></li>';
    }
    echo '</ul>';

    foreach ($tabs as $tab) {
      echo '<div style="display: none;" id="' . $tab['id'] . '">';
      call_user_func($tab['callback']);
      echo '</div>';
    }

    echo '</div>'; // tabs
    echo '</div>'; // wrap
  } // options_page


  // display tests help & info
  static function help_table() {
    require_once 'tests-description.php';
  } // help_table


  // display tests table
  static function tests_table() {
    // get test results from cache
    $tests = get_option(WF_SN_OPTIONS_KEY);

    echo '<p class="submit"><input type="submit" value=" Run tests " id="run-tests" class="button-primary" name="Submit" />&nbsp;&nbsp;';

    if ($tests['last_run']) {
      echo '<span class="sn-notice">Tests were last run on: ' . date(get_option('date_format') . ' ' . get_option('time_format'), $tests['last_run']) . '.</span>';
    }

    echo '</p>';

    echo '<p><strong>Please read!</strong> These tests only serve as suggestions! Although they cover years of best practices getting all test <i>green</i> will not guarantee your site will not get hacked. Likewise, getting them all <i>red</i> doesn\'t mean you\'ll certainly get hacked. Please read each test\'s detailed information to see if it represents a real security issue for your site. Suggestions and test results apply to public, production sites, not local, development ones. <br /> If you need an in-depth security analysis please hire a security expert.</p><br />';

    if ($tests['last_run']) {
      echo '<table class="wp-list-table widefat" cellspacing="0" id="security-ninja">';
      echo '<thead><tr>';
      echo '<th class="sn-status">Status</th>';
      echo '<th>Test description</th>';
      echo '<th>Test results</th>';
      echo '<th>&nbsp;</th>';
      echo '</tr></thead>';
      echo '<tbody>';

      if (is_array($tests['test'])) {
        // test Results
        foreach($tests['test'] as $test_name => $details) {
          echo '<tr>
                  <td class="sn-status">' . self::status($details['status']) . '</td>
                  <td>' . $details['title'] . '</td>
                  <td>' . $details['msg'] . '</td>
                  <td class="sn-details"><a href="#' . $test_name . '" class="button action">Details, tips &amp; help</a></td>
                </tr>';
        } // foreach ($tests)
      } else { // no test results
        echo '<tr>
                <td colspan="4">No test results are available. Click "Run tests" to run tests now.</td>
              </tr>';
      } // if tests

      echo '</tbody>';
      echo '<tfoot><tr>';
      echo '<th class="sn-status">Status</th>';
      echo '<th>Test description</th>';
      echo '<th>Test results</th>';
      echo '<th>&nbsp;</th>';
      echo '</tr></tfoot>';
      echo '</table>';
    } // if $results
  } // tests_table


  // run all tests; via AJAX
  static function run_tests($return = false) {
    @set_time_limit(WF_SN_MAX_EXEC_SEC);
    $test_count = 0;
    $start_time = microtime(true);
    $test_description['last_run'] = current_time('timestamp');

    foreach(wf_sn_tests::$security_tests as $test_name => $test){
      if ($test_name[0] == '_') {
        continue;
      }
      $response = wf_sn_tests::$test_name();

      $test_description['test'][$test_name]['title'] = $test['title'];
      $test_description['test'][$test_name]['status'] = $response['status'];

      if (!isset($response['msg'])) {
        $response['msg'] = '';
      }

      if ($response['status'] == 10) {
        $test_description['test'][$test_name]['msg'] = sprintf($test['msg_ok'], $response['msg']);
      } elseif ($response['status'] == 0) {
        $test_description['test'][$test_name]['msg'] = sprintf($test['msg_bad'], $response['msg']);
      } else {
        $test_description['test'][$test_name]['msg'] = sprintf($test['msg_warning'], $response['msg']);
      }
      $test_count++;
    } // foreach
    
    do_action('security_ninja_done_testing', $test_description, microtime(true) - $start_time);

    if ($return) {
      return $test_description;
    } else {
      update_option(WF_SN_OPTIONS_KEY, $test_description);
      die('1');
    }
  } // run_test


  // convert status integer to button
  static function status($int) {
    if ($int == 0) {
      $string = '<span class="sn-error">Bad</span>';
    } elseif ($int == 10) {
      $string = '<span class="sn-success">OK</span>';
    } else {
      $string = '<span class="sn-warning">Warning</span>';
    }

    return $string;
  } // status


  // clean-up when deactivated
  static function deactivate() {
    delete_option(WF_SN_OPTIONS_KEY);
  } // deactivate
} // wf_sn class


// hook everything up
add_action('init', array('wf_sn', 'init'));

// when deativated clean up
register_deactivation_hook( __FILE__, array('wf_sn', 'deactivate'));