<?php
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap">
    <h1>Shipping Price Calculator</h1>
    <form method="post" action="options.php">
        <?php
        settings_fields('spc_settings_group');
        do_settings_sections('spc_settings_group');
        ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">API Endpoint</th>
                <td><input type="text" name="spc_api_endpoint" value="<?php echo esc_attr(get_option('spc_api_endpoint')); ?>" size="50"/></td>
            </tr>
            <tr valign="top">
                <th scope="row">API Key</th>
                <td><input type="password" name="spc_api_key" value="<?php echo esc_attr(get_option('spc_api_key')); ?>" size="50"/></td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
