<?php
/**
 * Plugin Name: Resengo Widget
 * Plugin URI:
 * Description: Resengo Widget
 * Version:     1.1.6
 * Author:      Resengo
 * Author URI:  https://pro.resengo.com/
 * License:     GPL v3
 * License URI: http://www.gnu.org/licenses/gpl-3.0.en.html
 * Text Domain: resengo-widget
 */

if (! class_exists('resengo_widget')) {
  class resengo_widget {
    public function __construct() {
      add_action('admin_menu', array($this, 'resengo_widget_admin_menu'));
      add_action('wp_footer', array($this, 'resengo_widget_js'));
      add_action('admin_notices', array($this, 'resengo_missing_id_setting'));
      add_filter('plugin_action_links_'.plugin_basename(__FILE__), array($this, 'resengo_widget_settings_link'));
    }

    public function resengo_widget_settings_link($links) {
      $links[] = '<a href="'.admin_url('options-general.php?page=resengo-widget-options').'">'.__('Settings', 'resengo-widget').'</a>';
      return $links;
    }

    public function resengo_widget_admin_menu() {
      add_options_page(
        __('Resengo Widget', 'resengo-widget'),
        __('Resengo Widget', 'resengo-widget'),
        'manage_options',
        'resengo-widget-options',
        array($this, 'resengo_widget_option')
      );
    }

    private function resengo_widget_option_get_data() {
      $data = [];
      if (isset($_POST['resengo_submit'])) {
        $data['resengo_company_id'] = (isset($_POST['resengo_company_id']) ? sanitize_text_field($_POST['resengo_company_id']) : '');
        $data['resengo_language'] = (isset($_POST['resengo_language']) ? sanitize_text_field($_POST['resengo_language']) : '');
      }
      return $data;
    }

    public function resengo_widget_option() {
      $data = $this->resengo_widget_option_get_data();
      foreach ($data as $key => $value) {
        update_option($key, $value);
      }
      include_once('admin/resengo_widget_backend.php');
    }

    public function resengo_missing_id_setting() {
      $show_notice = false;
      $data = $this->resengo_widget_option_get_data();
      if (!empty($data) && '' == $data['resengo_company_id']) {
        $show_notice = true;
      }
      if (empty($data) && '' == get_option('resengo_company_id')) {
        $show_notice = true;
      }

      if ($show_notice) {
      ?>
        <div class="notice-warning settings-error notice is-dismissible">
          <p>
            <?php echo esc_html(__('Resengo: Company ID is required please add it here', 'resengo-widget')) ?>
            <a href="<?php echo esc_attr(admin_url('options-general.php?page=resengo-widget-options')); ?>">
              <?php echo esc_html(__('Setting', 'resengo-widget')); ?>
            </a>
          </p>
        </div>
      <?php
      }
    }

    public function resengo_widget_js() {
      $resengo_company_id = get_option('resengo_company_id');
      $resengo_language 	= get_option('resengo_language');

      if ($resengo_company_id != '') {
    ?>
      <script type="text/javascript">
        window.resengoWidgetOptions = { companyId: '<?php echo esc_js($resengo_company_id); ?>', language: '<?php echo esc_js($resengo_language); ?>' };
        (function(){var f=function(a,b,c,d){if(!a.getElementById(c)){var e=a.getElementsByTagName(b)[0];a=a.createElement(b);a.id=c;a.src="https://static.resengo.com/resengowidget";d&&(a.onload=d);e.parentNode.insertBefore(a,e)}},b=function(){return f(document,"script","resengo-flow-widget-script",function(){RESENGO_WIDGET(window.resengoWidgetOptions)})};window.attachEvent?window.attachEvent("onload",b):window.addEventListener("load",b,!1)})();
      </script>
    <?php
      } //Closing of if condition
    }
  }

  if (!function_exists('deactivate_resengo_widget')) {
    register_uninstall_hook(__FILE__, 'deactivate_resengo_widget');
    function deactivate_resengo_widget() {
      $data = ['resengo_company_id', 'resengo_language'];
      foreach ($data as $value) {
        delete_option($value);
      }
    }
  }

  $resengo_widget = new resengo_widget();
}
