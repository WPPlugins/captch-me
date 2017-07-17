<?php

/*
Plugin-Name: Captch Me admin options
Plugin-URI: http://www.captchme.com
Version-du-document: 1.2.2
Author: Attentive Ads
Email: sos@captchme.com
Author URI: http://www.attentiveads.com/
Created: 20170704_155034

Copyright (c) 2011-2015 by Attentive Ads
*/

/* ----------------------------------------------------------------------------------------
 * Registering settings methods
 * --------------------------------------------------------------------------------------*/

// Add options page in settings menu
function captchme_add_options_menu() {
        add_options_page('Captch Me | Options', 'Captch Me', 'manage_options', 'captchme_options_menu', 'captchme_build_options_panel');
}

// Build options page
function captchme_build_options_panel () {
    if (!current_user_can('manage_options'))  {
        wp_die( __('You do not have sufficient permissions to access this page.','captchme') );
    }
?>
<script type="text/javascript">
  var uvOptions = {};
  (function() {
    var uv = document.createElement('script'); uv.type = 'text/javascript'; uv.async = true;
    uv.src = '<?php echo plugins_url("js/4XedFoWFflCyNL7vcgyaew.js", __FILE__); ?>';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(uv, s);
  })();
</script>
<div class="wrap">
    <style type="text/css"> .form-table th { width: 205px; } /* evite le retour à la ligne avant les : */</style>
    <div id="captchme_header" style="width:100%;padding:2px;background-color:#556270;">
        <img src='<?php echo plugins_url( 'images/h75.jpg', __FILE__ ); ?>' width="150" height="75" alt="Captch Me!"/>
    </div>
    <div id="icon-plugins" class="icon32"></div><h2><?php _e("Captch Me Options","captchme") ?></h2>
    <p><?php _e("Captch Me offers a monetized spam blocking solution.",'captchme') ?></p>
    <p><?php _e("For details, visit the ",'captchme') ?><a href="http://www.attentiveads.com/" target="_blank"><?php _e("Attentive Ads website",'captchme') ?></a>.</p>
    <form method="post" action="options.php">
        <?php settings_fields('captchme_options'); ?>
        <?php do_settings_sections(__FILE__); ?>
        <?php captchme_accessme_settings(); ?>
        <?php captchme_contact_form_7_settings(); ?>
        <div class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </div>
    </form>
    <p class="copyright">&copy; Copyright <?php echo date('Y'); ?>&nbsp;&nbsp;<a href="http://www.attentiveads.com" target="_blank">Attentive Ads SAS</a>.</p>
</div>
<?php
}

// Register settings
function register_captchme_settings() {
    register_setting('captchme_options', 'captchme_options', 'captchme_validate_settings');
    // General settings section
    add_settings_section('captchme-section-misc', __('General Settings','captchme'), 'captchme_general_section', __FILE__);
    // Keys section
    add_settings_section('captchme-section-key', __('API Key Settings','captchme'), 'captchme_key_section', __FILE__);
    // Comment settings section
    add_settings_section('captchme-section-comment', __('Comments Settings','captchme'), 'captchme_comment_section', __FILE__);
    // Registration settings section
    add_settings_section('captchme-section-registration', __('Registration Settings','captchme'), 'captchme_registration_section', __FILE__);
    // Login settings section
    add_settings_section('captchme-section-login', __('Login Settings','captchme'), 'captchme_login_section', __FILE__);
    // ShowMe settings section
    add_settings_section('captchme-section-showme', __('Show Me Settings','captchme'), 'captchme_showme_section', __FILE__);
    // LeaveMe settings section
    add_settings_section('captchme-section-leaveme', __('Leave Me Settings','captchme'), 'captchme_leaveme_section', __FILE__);
}

// Register keys section
function captchme_key_section() {
    echo "<a href='http://www.attentiveads.com/inscription-monetisation.html' target='_blank'>" . __('Get your keys', 'captchme') . "</a>";
    add_settings_field('public_key', __('Public Key:','captchme'), 'captchme_add_public_key', __FILE__, 'captchme-section-key');
    add_settings_field('private_key', __('Private Key:','captchme'), 'captchme_add_private_key', __FILE__, 'captchme-section-key');
    add_settings_field('authent_key', __('Authentification Key:','captchme'), 'captchme_add_authent_key', __FILE__, 'captchme-section-key');
}

// Register general settings section
function captchme_general_section() {
    add_settings_field('lang', __('Language:','captchme'), 'captchme_add_language', __FILE__, 'captchme-section-misc');
    add_settings_field('theme', __('Theme:','captchme'), 'captchme_add_theme', __FILE__, 'captchme-section-misc');
    add_settings_field('title', __('Title:','captchme'), 'captchme_add_title', __FILE__, 'captchme-section-misc');
    add_settings_field('instruction', __('Instruction:','captchme'), 'captchme_add_instruction', __FILE__, 'captchme-section-misc');
    add_settings_field('ssl', __('SSL:','captchme'), 'captchme_add_ssl', __FILE__, 'captchme-section-misc');
    add_settings_field('adb', __('ABP:','captchme'), 'captchme_add_adb', __FILE__, 'captchme-section-misc');

}

// Register comment settings section
function captchme_comment_section() {
    add_settings_field('comment_enable', __('Activate Captch Me on comments:','captchme'), 'captchme_add_comment_enable', __FILE__, 'captchme-section-comment');
    add_settings_field('comment_spam_delete', __('Automatically delete spam comments:','captchme'), 'captchme_add_comment_spam_delete', __FILE__, 'captchme-section-comment');
    add_settings_field('comment_tabindex', __('Tabindex:','captchme'), 'captchme_add_comment_tabindex', __FILE__, 'captchme-section-comment');
}

// Register registration settings section
function captchme_registration_section() {
    add_settings_field('registration_enable', __('Activate Captch Me on registration form:','captchme'), 'captchme_add_registration_enable', __FILE__, 'captchme-section-registration');
    add_settings_field('registration_spam_delete', __('Automatically delete spam registration:','captchme'), 'captchme_add_registration_spam_delete', __FILE__, 'captchme-section-registration');
    add_settings_field('registration_tabindex', __('Tabindex:','captchme'), 'captchme_add_registration_tabindex', __FILE__, 'captchme-section-registration');
}

// Register login settings section
function captchme_login_section() {
    add_settings_field('login_enable', __('Activate Captch Me on login form:','captchme'), 'captchme_add_login_enable', __FILE__, 'captchme-section-login');
    add_settings_field('login_tabindex', __('Tabindex:','captchme'), 'captchme_add_login_tabindex', __FILE__, 'captchme-section-login');
}

// Register showme settings section
function captchme_showme_section() {
    add_settings_field('showme_enable', __('Activate Show Me:','captchme'), 'captchme_add_showme_enable', __FILE__, 'captchme-section-showme');
    add_settings_field('showme_position', __('Position:','captchme'), 'captchme_add_showme_position', __FILE__, 'captchme-section-showme');
}

// Register leave settings section
function captchme_leaveme_section() {
    add_settings_field('leaveme_enable', __('Activate Leave Me:','captchme'), 'captchme_add_leaveme_enable', __FILE__, 'captchme-section-leaveme');
    add_settings_field('leaveme_message', __('Message:','captchme'), 'captchme_add_leaveme_message', __FILE__, 'captchme-section-leaveme');
}


function captchme_validate_settings($options) {
  $new_options = default_captchme_options();
  $new_options['public_key'] = sanitize_text_field(trim($options['public_key']));
  $new_options['private_key'] = sanitize_text_field(trim($options['private_key']));
  $new_options['authent_key'] = sanitize_text_field(trim($options['authent_key']));
  $new_options['lang'] = sanitize_text_field(trim($options['lang']));
  $new_options['title'] = sanitize_text_field(trim($options['title']));
  $new_options['instruction'] = sanitize_text_field(trim($options['instruction']));
  $new_options['ssl'] = sanitize_text_field(trim($options['ssl']));
  $new_options['adb'] = sanitize_text_field(trim($options['adb']));
  $new_options['theme'] = sanitize_text_field(trim($options['theme']));
  $new_options['comment_enable'] = sanitize_text_field(trim($options['comment_enable']));
  $new_options['comment_spam_delete'] = sanitize_text_field(trim($options['comment_spam_delete']));
  $new_options['comment_tabindex'] = sanitize_text_field(trim($options['comment_tabindex']));
  $new_options['registration_enable'] = sanitize_text_field(trim($options['registration_enable']));
  $new_options['registration_spam_delete'] = sanitize_text_field(trim($options['registration_spam_delete']));
  $new_options['registration_tabindex'] = sanitize_text_field(trim($options['registration_tabindex']));
  $new_options['login_enable'] = sanitize_text_field(trim($options['login_enable']));
  $new_options['login_tabindex'] = sanitize_text_field(trim($options['login_tabindex']));
  $new_options['showme_enable'] = sanitize_text_field(trim($options['showme_enable']));
  $new_options['showme_position'] = sanitize_text_field(trim($options['showme_position']));
  $new_options['leaveme_enable'] = sanitize_text_field(trim($options['leaveme_enable']));
  $new_options['leaveme_message'] = sanitize_text_field(trim(addslashes($options['leaveme_message'])));

  // Check keys format
  if(!preg_match('/^[a-zA-Z0-9_-]{64}$/', $new_options['public_key'])) {
    $new_options['public_key'] = '';
    add_settings_error('public_key', 'public_key_invalid', __('Invalid public key. It should be 64 alphanumeric characters long.','captchme'), 'error');
  }

  if(!preg_match('/[A-Za-z0-9-_]{64}/', $new_options['private_key'])) {
    $new_options['private_key'] = '';
    add_settings_error('public_key', 'private_key_invalid', __('Invalid private key. It should be 64 alphanumeric characters long.','captchme'), 'error');
  }

  if(!preg_match('/[A-Za-z0-9-_]{64}/', $new_options['authent_key'])) {
    $new_options['authent_key'] = '';
    add_settings_error('public_key', 'authent_key_invalid', __('Invalid authentification key. It should be 64 alphanumeric characters long.','captchme'), 'error');
  }

  // Default language to french if not provided
  if ( $new_options['lang'] == FALSE || $new_options['lang'] == ''){
    $new_options['lang']='fr';
  }

  // Default comment theme if not provided
  if ( $new_options['theme'] == FALSE || $new_options['theme'] == ''){
    $new_options['theme']='gray';
  }

  // Default title if not provided
  if ( $new_options['title'] == FALSE || $new_options['title'] == ''){
    $new_options['title']='0';
  }

  // Default instruction if not provided
  if ( $new_options['instruction'] == FALSE || $new_options['instruction'] == ''){
    $new_options['instruction']='0';
  }

  // Default ssl if not provided
  if ( $new_options['ssl'] == FALSE || $new_options['ssl'] == ''){
    $new_options['ssl']='0';
  }

  // Default adb if not provided
  if ( $new_options['adb'] == FALSE || $new_options['adb'] == ''){
    $new_options['adb']='1';
  }

  // Default showme position if not provided
  if ( $new_options['showme_position'] == FALSE || $new_options['showme_position'] == ''){
    $new_options['showme_position']='left';
  }

  if(!preg_match('/[0-9]+/', $new_options['comment_tabindex'])) {
    $new_options['comment_tabindex'] = '';
    add_settings_error('comment_tabindex', 'tabindex_invalid', __('Invalid tabindex. It should be a numerical value.','captchme'), 'error');
  }

  if(!preg_match('/[0-9]+/', $new_options['registration_tabindex'])) {
    $new_options['registration_tabindex'] = '';
    add_settings_error('registration_tabindex', 'tabindex_invalid', __('Invalid tabindex. It should be a numerical value.','captchme'), 'error');
  }

  if(!preg_match('/[0-9]+/', $new_options['login_tabindex'])) {
    $new_options['login_tabindex'] = '';
    add_settings_error('login_tabindex', 'tabindex_invalid', __('Invalid tabindex. It should be a numerical value.','captchme'), 'error');
  }


  return $new_options;
}

/* ----------------------------------------------------------------------------------------
 * Builds input fields methods
 * --------------------------------------------------------------------------------------*/
function captchme_add_public_key() {
    $options = get_option('captchme_options');
    echo "<input name='captchme_options[public_key]' type='text' value='{$options['public_key']}' maxlength=64 size=85/>";
}

function captchme_add_private_key() {
    $options = get_option('captchme_options');
    echo "<input name='captchme_options[private_key]' type='text' value='{$options['private_key']}' maxlength=64 size=85/>";
}

function captchme_add_authent_key() {
    $options = get_option('captchme_options');
    echo "<input name='captchme_options[authent_key]' type='text' value='{$options['authent_key']}' maxlength=64 size=85/>";
}

function captchme_add_language() {
    $options = get_option('captchme_options');
    $languages = array('fr' => __('French','captchme'),
                       'en' => __('English','captchme'),
                       'es' => __('Spanish','captchme'),
                       '\'\''   => __('Web User','captchme'));
    echo '<select name="captchme_options[lang]" id="lang">';
    foreach ($languages as $key => $lang ) {
        $selected='';
        if ($options['lang'] == $key) {
            $selected = 'selected=\"selected\"';
        }
        echo "<option value=\"$key\" $selected>$lang</option>";
    }
    echo '</select>';
}

function captchme_add_title() {
    $options = get_option('captchme_options');
    $title = array('1' => __('Show','captchme'),
                       '0' => __('Hide','captchme'));
    echo '<select name="captchme_options[title]" id="title">';
    foreach ($title as $key => $value ) {
        $selected='';
        if ($options['title'] == $key) {
            $selected = 'selected=\"selected\"';
        }
        echo "<option value=\"$key\" $selected>$value</option>";
    }
    echo '</select>';
}

function captchme_add_instruction() {
    $options = get_option('captchme_options');
    $instruction = array('1' => __('Show','captchme'),
                       '0' => __('Hide','captchme'));
    echo '<select name="captchme_options[instruction]" id="instruction">';
    foreach ($instruction as $key => $value ) {
        $selected='';
        if ($options['instruction'] == $key) {
            $selected = 'selected=\"selected\"';
        }
        echo "<option value=\"$key\" $selected>$value</option>";
    }
    echo '</select>';
}

function captchme_add_ssl() {
    $options = get_option('captchme_options');
    $ssl = array('1' => __('Activated','captchme'),
                       '0' => __('Deactivated','captchme'));
    echo '<select name="captchme_options[ssl]" id="ssl">';
    foreach ($ssl as $key => $value ) {
        $selected='';
        if ($options['ssl'] == $key) {
            $selected = 'selected=\"selected\"';
        }
        echo "<option value=\"$key\" $selected>$value</option>";
    }
    echo '</select>';
}

function captchme_add_adb() {
    $options = get_option('captchme_options');
    $adb = array('1' => __('Activated','captchme'),
                       '0' => __('Deactivated','captchme'));
    echo '<select name="captchme_options[adb]" id="adb">';
    foreach ($adb as $key => $value ) {
        $selected='';
        if ($options['adb'] == $key) {
            $selected = 'selected=\"selected\"';
        }
        echo "<option value=\"$key\" $selected>$value</option>";
    }
    echo '</select>';
}

function captchme_add_comment_enable() {
    captchme_add_enable('comment');
}

function captchme_add_registration_enable() {
    captchme_add_enable('registration');
}

function captchme_add_login_enable() {
    captchme_add_enable('login');
}

function captchme_add_showme_enable() {
    captchme_add_enable('showme');
}

function captchme_add_leaveme_enable() {
    captchme_add_enable('leaveme');
}

function captchme_add_enable($prefix) {
    $options = get_option('captchme_options');
    $checked = '';
    if( $options[$prefix.'_enable'] == true ) {
        $checked='checked';
    }
    echo "<input name='captchme_options[{$prefix}_enable]' type='checkbox' value='1' $checked/>";
}

function captchme_add_comment_spam_delete() {
    captchme_add_spam_delete('comment');
}

function captchme_add_registration_spam_delete() {
    captchme_add_spam_delete('registration');
}

function captchme_add_spam_delete($prefix) {
    $options = get_option('captchme_options');
    $checked = '';
    if( $options[$prefix.'_spam_delete'] == true ) {
        $checked='checked';
    }
    echo "<input name='captchme_options[{$prefix}_spam_delete]' type='checkbox' value='1' $checked/>";
}


function captchme_add_theme() {
    $options = get_option('captchme_options');
    $themes = array('gray'  => __('Gray','captchme'),
                    'white' => __('White','captchme'));
    echo '<select name="captchme_options[theme]" id="theme">';
    foreach ($themes as $key => $theme ) {
        $selected='';
        if ($options['theme'] == $key) {
            $selected = 'selected=\"selected\"';
        }
        echo "<option value=\"$key\" $selected>$theme</option>";
    }
    echo '</select>';
}

function captchme_add_comment_tabindex() {
    captchme_add_tabindex('comment');
}

function captchme_add_registration_tabindex() {
    captchme_add_tabindex('registration');
}

function captchme_add_login_tabindex() {
    captchme_add_tabindex('login');
}

function captchme_add_tabindex($prefix) {
    $options = get_option('captchme_options');
    echo "<input name='captchme_options[{$prefix}_tabindex]' type='text' value='{$options[$prefix.'_tabindex']}'/>";
}

function captchme_add_showme_position() {
    $options = get_option('captchme_options');
    $showme_positions = array('left'  => __('Left','captchme'),
                    'right' => __('Right','captchme'));
    echo '<select name="captchme_options[showme_position]" id="showme_position">';
    foreach ($showme_positions as $key => $showme_position ) {
        $selected='';
        if ($options['showme_position'] == $key) {
            $selected = 'selected=\"selected\"';
        }
        echo "<option value=\"$key\" $selected>$showme_position</option>";
    }
    echo '</select>';
}

function captchme_add_leaveme_message() {
    $options = get_option('captchme_options');
    echo "<input name='captchme_options[leaveme_message]' type='text' value='" . htmlentities(stripcslashes("{$options['leaveme_message']}"), ENT_QUOTES) . "' maxlength=85 size=85/>";
}


/* ----------------------------------------------------------------------------------------
 * Handle plugin options persistence
 * --------------------------------------------------------------------------------------*/

function create_captchme_options() {
    add_option('captchme_options',default_captchme_options());
}

function delete_captchme_options() {
    delete_option('captchme_options');
}

function default_captchme_options() {
    $options = array(
        'version' => '1.2.2',
        'public_key' => '',
        'private_key' => '',
        'authent_key' => '',
        'theme' => 'white',
        'lang' => 'fr',
        'showtitle' => 1,
        'showinstruction' => 1,
        'ssl' => 0,
        'adb' => 1,
        'comment_enable' => 1,
        'comment_spam_delete' => 0,
        'comment_tabindex' => 0,
        'registration_enable' => 1,
        'registration_spam_delete' => 0,
        'registration_tabindex' => 30,
        'login_enable' => 1,
        'login_tabindex' => 30,
        'showme_enable' => 0,
        'showme_position' => 'left',
        'leaveme_enable' => 0,
        'leaveme_message' => ''
        
        );
    return $options;
}

/* ----------------------------------------------------------------------------------------
 * Add settings link in plugin page
 * --------------------------------------------------------------------------------------*/
function captchme_add_settings_link($links, $file) {
    if ($file == plugin_basename('captch-me/captchme.php')) {
       $settings_title = __('Captch Me settings', 'captchme');
       $settings = __('Settings', 'captchme');
       $settings_link = '<a href="options-general.php?page=captchme_options_menu" title="' . $settings_title . '">' . $settings . '</a>';
       array_unshift($links, $settings_link);
    }

    return $links;
}

/* ----------------------------------------------------------------------------------------
 * Add options menu
 * --------------------------------------------------------------------------------------*/
  add_action('admin_init', 'register_captchme_settings');
  add_action('admin_menu', 'captchme_add_options_menu');
  add_filter("plugin_action_links", 'captchme_add_settings_link', 10, 2);


/* ----------------------------------------------------------------------------------------
 * Access Me instructions
 * --------------------------------------------------------------------------------------*/
function captchme_accessme_settings() {
  echo "<div>
    <h2>Access Me</h2>
    <h4>" . __('You can use Access Me to protect links or to hide a part of the page while the captcha is not validate', 'captchme') . "</h4>
    <p>" . __('Use <code>[accessme]</code> tag (with required and optional attributes) to protect links.', 'captchme') . "</p>
    <p>" . __('Use <code>[accessme] YOUR CONTENT TO HIDE [/accessme]</code> tag (with optional attributes) to hide a part of your page.', 'captchme') . "</p>
    <a id='see_attributs' onclick='see_attributs_table();'>" . __('See attributes', 'captchme') . " &darr;</a>
    <a id='hide_attributs' style='display:none;' onclick='hide_attributs_table();'>" . __('Hide attributes', 'captchme') . " &uarr;</a>
    <script>
    function see_attributs_table() {
      document.getElementById('attributs_table').style.display = 'block';
      document.getElementById('see_attributs').style.display = 'none';
      document.getElementById('hide_attributs').style.display = 'block';
    }
    function hide_attributs_table() {
      document.getElementById('attributs_table').style.display = 'none';
      document.getElementById('see_attributs').style.display = 'block';
      document.getElementById('hide_attributs').style.display = 'none';
    }
    function use_protect() {
      document.getElementById('use_hide').style.display = 'none';
      document.getElementById('use_protect').style.display = 'block';
    }
    function use_hide() {
        document.getElementById('use_protect').style.display = 'none';
        document.getElementById('use_hide').style.display = 'block';
    }
    </script>
    <style>
      #attributs_table table {
        border-collapse: collapse;
        width: 1110px;
      }
      #attributs_table th, #attributs_table td {
        border: 1px solid #333;
      }
      #attributs_table td {
        padding: 2px 5px;
      }
    </style>
    <div id='attributs_table' style='display:none;'>
    <h4>" . __('Protect link attributes', 'captchme') . "</h4>
    <table>
      <tr>
        <th style='width: 75px;'>" . __('Attribute', 'captchme') . "</th>
        <th style='width: 405px;'>Description</th>
        <th>" . __('Value', 'captchme') . "</th>
      </tr>
      <tr>
        <td>url</td>
        <td>" . __('List of URL (separated by commas) to protect with Access Me', 'captchme') . "</td>
        <td><code>http://www.link.com</code> " . __('or', 'captchme') . " <code>http://www.link1.com, www.link2.com, ...</code><br><i>(" . __('required', 'captchme') . ")</i></td>
      </tr>
      <tr>
        <td>urltext</td>
        <td>" . __('Text for each link', 'captchme') . "</td>
        <td><code>Link</code> " . __('or', 'captchme') . " <code>Link 1, Link 2, ...</code><br><i>(" . __('required', 'captchme') . ", " . __('same number as url', 'captchme') . ")</i></td>
      </tr>
    </table>
    
    <h4>" . __('Hide page attributes', 'captchme') . "</h4>
    <table>
      <tr>
        <th style='width: 75px;'>" . __('Attribute', 'captchme') . "</th>
        <th style='width: 405px;'>Description</th>
        <th>" . __('Value', 'captchme') . "</th>
      </tr>
      <tr>
        <td>button_title</td>
        <td>" . __('Button (or link) title', 'captchme') . "</td>
        <td><i>(" . __('optional', 'captchme') . ", " . __('default', 'captchme') . " : <code>" . __('Read more', 'captchme') . "</code>)</i></td>
      </tr>
    </table>
    
    <h4>" . __('Shared attributes', 'captchme') . "</h4>
    <table>
      <tr>
        <th style='width: 75px;'>" . __('Attribute', 'captchme') . "</th>
        <th>Description</th>
        <th>" . __('Value', 'captchme') . "</th>
      </tr>
      <tr>
        <td>type</td>
        <td>" . __('Type of element (button or link)', 'captchme') . "</td>
        <td><code>button</code>, <code>link</code><br><i>(" . __('optional', 'captchme') . ", " . __('default', 'captchme') . " : <code>button</code>)</i></td>
      </tr>
      <tr>
        <td>position</td>
        <td>" . __('Element position (center, left or right) in the page', 'captchme') . "</td>
        <td><code>center</code>, <code>left</code>, <code>right</code><br><i>(" . __('optional', 'captchme') . ", " . __('default', 'captchme') . " : <code>center</code>)</i></td>
      </tr>
      <tr>
        <td>message</td>
        <td>" . __('Message to be displayed above the Access Me module', 'captchme') . "</td>
        <td><i>(" . __('optional', 'captchme') . ", " . __('default', 'captchme') . " : " . __('none', 'captchme') . ")</i></td>
      </tr>
      <tr>
        <td>mandatory</td>
        <td>" . __('Makes Access Me mandatory. Possible values are:', 'captchme') . "<br>
          &bull; " . __('Non-blocking (value to be used "0"). Access Me can be closed by the user by clicking on a cross in the top right of the screen', 'captchme') . "<br>
          &bull; " . __('Blocking (value to be used "1"). Access Me can not be closed. The user must validate the captcha to continue', 'captchme') . "</td>
        <td><code>0</code>, <code>1</code><br><i>(" . __('optional', 'captchme') . ", " . __('default', 'captchme') . " : <code>0</code>)</i></td>
      </tr>
      <tr>
        <td>opacity</td>
        <td>" . __('This value determines the opacity of the background image used', 'captchme') . "</td>
        <td>" . __('from', 'captchme') . " <code>0.1</code> " . __('to', 'captchme') . " <code>1</code> (" . __('step', 'captchme') . " : 0.1)<br><i>(" . __('optional', 'captchme') . ", " . __('default', 'captchme') . " : <code>0.8</code>)</i></td>
      </tr>
      <tr>
        <td>extra_css</td>
        <td>" . __('URL of a style sheet to define the background image used for Access Me. This sheet should follow the template below:', 'captchme') . "<br>
<pre>#captchme_interVeil{
  background: url(//mondomain.com/bureau.jpg) !important;
  position: fixed !important;
  filter:progid:DXImageTransform.Microsoft.alpha(opacity=100) !important;
  background-size: cover !important;
  background-repeat : no-repeat !important;
  background-height : 100% !important;
  background-width : auto !important;
}</pre></td>
        <td><i>(" . __('optional', 'captchme') . ", " . __('default', 'captchme') . " : " . __('none', 'captchme') . ")</i></td>
      </tr>
    </table>
  </div>
  <h4>" . __('Access Me tag generator', 'captchme') . "</h4>
  <div>
    <input type='radio' id='accessme_use_protect' name='accessme_use' onclick='use_protect();' value='protect' checked>" . __('Protect link', 'captchme') . "<br>
    <input type='radio' id='accessme_use_hide' name='accessme_use' onclick='use_hide();' value='hide'>" . __('Hide page', 'captchme') . "<br>
    <div id='use_protect' style='margin-top:10px;'>
      url* : <input id='accessme_url' type='text'>
      urltext* : <input id='accessme_urltext' type='text'>
    </div>
    <div id='use_hide' style='display:none; margin-top:10px;'>
      button_title : <input id='accessme_button_title'type='text'>
    </div>
    <div>
      type : <select id='accessme_type'><option value=''></option><option value='button'>" . __('button', 'captchme') . "</option><option value='link'>" . __('link', 'captchme') . "</option></select>
      position : <select id='accessme_position'><option value=''></option><option value='center'>" . __('center', 'captchme') . "</option><option value='left'>" . __('left', 'captchme') . "</option><option value='right'>" . __('right', 'captchme') . "</option></select>
      message : <input id='accessme_message' type='text'>
      mandatory : <select id='accessme_mandatory'><option value=''></option><option value='0'>" . __('non-blocking', 'captchme') . "</option><option value='1'>" . __('blocking', 'captchme') . "</option></select>
      opacity : <input id='accessme_opacity' type='number' min='0' max='1' step='0.1'>
      extra_css : <input id='accessme_extra_css' type='text'>
    </div>
    <button style='margin-top:10px;' onclick='generate_accessme(); return false;'>" . __('Generate Access Me tag', 'captchme') . "</button>
    <script>
      function generate_accessme() {
      var accessme_use = document.querySelector('input[name=accessme_use]:checked').value;
      
      var accessme_type = document.getElementById('accessme_type').value;
      var accessme_position = document.getElementById('accessme_position').value;
      var accessme_message = document.getElementById('accessme_message').value.trim();
      var accessme_mandatory = document.getElementById('accessme_mandatory').value;
      var accessme_opacity = document.getElementById('accessme_opacity').value;
      var accessme_extra_css = document.getElementById('accessme_extra_css').value.trim();
      
      var options = '';
      if(accessme_type != '' && (accessme_type == 'button' || accessme_type == 'link'))
        options += ' type=\"' + accessme_type + '\"';
      if(accessme_position != '' && (accessme_position == 'center' || accessme_position == 'left' || accessme_position == 'right'))
        options += ' position=\"' + accessme_position + '\"';
      if(accessme_message != '')
        options += ' message=\"' + accessme_message + '\"';
      if(accessme_mandatory != '' && (accessme_mandatory == '0' || accessme_mandatory == '1'))
        options += ' mandatory=\"' + accessme_mandatory + '\"';
      if(accessme_opacity != '' && accessme_opacity >= '0' && accessme_opacity <= '1')
        options += ' opacity=\"' + accessme_opacity + '\"';
      if(accessme_extra_css != '')
        options += ' extra_css=\"' + accessme_extra_css + '\"';
      
      var result = '';
      if(accessme_use == 'protect') {
        var accessme_url = document.getElementById('accessme_url').value.trim();
        var accessme_urltext = document.getElementById('accessme_urltext').value.trim();
        if(accessme_url == '' || accessme_urltext == '') {
          result = '" . __('Error url and urltext are required', 'captchme') . "';
        } else {
          var urls = accessme_url.split(',');
          var urlstexts = accessme_urltext.split(',');
          if(urls.length != urlstexts.length)
            result = '" . __('Number of urls and texts do not match', 'captchme') . "';
          else
            result = '[accessme url=\"' + accessme_url + '\" urltext=\"' + accessme_urltext + '\"' + options + ']';
        }
      } else if(accessme_use == 'hide') {
        var accessme_button_title = document.getElementById('accessme_button_title').value.trim();
        result = '[accessme';
        if(accessme_button_title != '')
          result += ' button_title=\"' + accessme_button_title + '\"';
        result += options + '] " . __('YOUR CONTENT TO HIDE', 'captchme') . " [/accessme]';
      }
      
      
        document.getElementById('accessme_result').value = result;
      }
    </script>
    <div style='margin-top:10px;'>
      <label for='accessme_result'>" . __('Add this tag in your page:', 'captchme') . "</label><br>
      <input id='accessme_result' type='text' size='140' readonly onclick='this.select();'>
    </div>
  </div>
  
  </div>";
}

/* ----------------------------------------------------------------------------------------
 * Contact Form 7 instructions
 * --------------------------------------------------------------------------------------*/
function captchme_contact_form_7_settings() {
  echo "<div>
    <h2>Contact Form 7</h2>
    <h4>" . __("Captch Me is compatible with the plugin Contact Form 7", 'captchme') . "</h4>
    <ul>
      <li>&bull; " . __("Install and activate the plugin", 'captchme') . " <a href='https://wordpress.org/plugins/contact-form-7/'><strong>Contact Form 7</strong></a></li>
      <li>&bull; " . __("Create your form", 'captchme') . " (menu &laquo;<a href='admin.php?page=wpcf7-new'><strong>Contact</strong></a>&raquo;)</li>
      <li>&bull; " . __("Add tag", 'captchme') . " <code>[captchme]</code> " . __("before tag", 'captchme') . " <code>[submit]</code></li>
      <li>&bull; " . __("Add this form to your page", 'captchme') . "</li>
    </ul>
  </div>";
}

 ?>
