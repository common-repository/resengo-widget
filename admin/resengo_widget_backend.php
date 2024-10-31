<div class="wrap">
<h1><?php esc_html_e('Resengo Widget Settings', 'resengo-widget'); ?></h1>

<form method="post" action="">
<table class="form-table" role="presentation">
  <tbody>
    <tr>
      <th scope="row"><label for="resengo_company_id"><?php echo esc_html_e('Company ID', 'resengo-widget'); ?></label></th>
      <td><input name="resengo_company_id" type="text" value="<?php echo esc_attr(((get_option('resengo_company_id') != '') ? get_option('resengo_company_id') : '')); ?>" id="resengo_company_id" value="<?php echo esc_attr(get_option('ab_app_id')); ?>" class="regular-text" /></td>
    </tr>
    <tr>
      <th scope="row"><label for="framed"><?php esc_html_e('Language', 'resengo-widget'); ?></label></th>
      <td>
        <select name="resengo_language" id="resengo_language" class="regular-text" >
          <option value="NL" <?php echo esc_attr((get_option('resengo_language') == 'NL' || get_option('resengo_language') == '') ? 'selected' : ''); ?>>NL</option>
          <option value="FR" <?php echo esc_attr((get_option('resengo_language') == 'FR') ? 'selected' : ''); ?>>FR</option>
          <option value="EN" <?php echo esc_attr((get_option('resengo_language') == 'EN') ? 'selected' : ''); ?>>EN</option>
          <option value="ES" <?php echo esc_attr((get_option('resengo_language') == 'ES') ? 'selected' : ''); ?>>ES</option>
        </select>
      </td>
    </tr>
  </tbody>
</table>

<p class="submit"><input type="submit" name="resengo_submit" id="resengo_submit" class="button button-primary" value="<?php esc_attr_e('Save Changes', 'resengo-widget'); ?>"></p></form>

</div>
