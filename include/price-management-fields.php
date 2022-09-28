<?php
/**
 * Display a Price Management menu page
 */
function my_custom_menu_page(){
    ?><h1><?php esc_html_e( 'Price Management', 'textdomain' );?></h1>
    <div class="wrap">
        <form method="post" id="forms" action="options.php">
            <?php
                settings_fields("section");
                do_settings_sections("theme-options");
            ?>          
        </form>
        </div>
    <?php 
}
function display_user_element()
{
    $user_role = get_option('user_role');
    $management_save = get_option( 'management_save' );
    global $wp_roles;
    $roles = $wp_roles->roles;
    ?>
        <select name="user_role" class="user_role" id="user_role">
            <option value="">---Select Role---</option>
            <?php foreach ($roles as $key => $value) { ?>
            <option value="<?php echo $key; ?>"><?php echo $key; ?></option>
            <?php } ?>
        </select>

    <?php
}
function display_price_element()
{
    ?>
        <input type="text" name="price" id="price" class="price" placeholder="Add Price">
        <br/>
        <input type="submit" id="btn" class="save_price_management" value="Save">

    <?php
}

function display_theme_panel_fields()
{
    add_settings_section("section", "All Settings", null, "theme-options");
    add_settings_field("user_role", "Select User Role", "display_user_element", "theme-options", "section");
    add_settings_field("user_price", "Add Price", "display_price_element", "theme-options", "section");
    register_setting("section", "user_role");
    register_setting("section", "user_price");
}
add_action("admin_init", "display_theme_panel_fields");