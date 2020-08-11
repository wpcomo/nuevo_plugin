<?php 
/** 
* Plugin Name: Plugin_nuevo2
* Plugin URI: https://miweb/plugin_nuevo 
* Description: Mi nuevo plugin básico. 
* Version: 0.0.3 
* Requires at least: 5.2 
* Requires PHP: 7.2 
* Author: El Nombre del autor2
* Author URI: https://WEBDELAUTOR/ 
* License: GPL v2 or later 
* License URI: https://www.gnu.org/licenses/gpl-2.0.html 
* Text Domain: Plugin_nuevo
* Domain Path: /languages 
**/ 

//Aqui va el codigo

function custom_logo() { 
    ?> 
    <style type="text/css"> 
        #login h1 a, .login h1 a { 
            background-image: url(<?php echo get_nuevo_plugin_logo_url();?>) !important; 
            background-repeat: no-repeat; padding-bottom: 30px; 
        } 
        
        .wp-core-ui .button-secondary { 
            color:<?php echo get_nuevo_plugin_color();?> !important; 
        } 
        
        body.login div#login form#loginform .button-primary { 
            background-color: <?php echo get_nuevo_plugin_color();?> !important; 
            border-color: <?php echo get_nuevo_plugin_color();?> !important; 
        } 
        
        body.login div#login form#loginform .button-primary:hover { 
            background-color: <?php echo get_nuevo_plugin_color();?> !important; 
            border-color: <?php echo get_nuevo_plugin_color();?> !important; 
        } 
        </style> 
    <?php } 
    
add_action( 'login_enqueue_scripts', 'custom_logo' ); 

//Modificar URL del enlace 
function custom_logo_url() { 
    return home_url(); 
} 
add_filter( 'login_headerurl', 'custom_logo_url' ); 
    
//modificar titulo del enlace 
function custom_logo_url_title() { 
    return 'Titulo de la pagina'; 
} 
    
add_filter( 'login_headertitle', 'custom_logo_url_title' );

//A partir de aqui el codigo del plugin avanzado 

//MENU
function nuevo_plugin_menu(){
    $page_title = 'Nuevo Plugin settings';
    $menu_title = 'Nuevo Plugin settings';
    $capability = 'manage_options';
    $menu_slug  = 'nuevo-plugin';
    $function   = 'nuevo_plugin_page';
    $icon_url   = 'dashicons-media-code';
    $position   = 4;
    add_menu_page( 
        $page_title, 
        $menu_title, 
        $capability, 
        $menu_slug,
        $function, 
        $icon_url, 
        $position 
    ); 
}
add_action( 'admin_menu', 'nuevo_plugin_menu' );  

//PAGINA
if( !function_exists("nuevo_plugin_page") ) { 
    function nuevo_plugin_page(){ ?>   
        <h1>Nuevo Plugin Settings</h1> 
        <form method="post" action="options.php">
        <?php settings_fields('nuevo-plugin-settings'); ?>
        <?php do_settings_sections( 'nuevo-plugin-settings' ); ?>
            <table class="form-table"><tr valign="top"><th scope="row">Color:</th>
            </tr>
            <tr>
                <td>
                    <input type="color" name="nuevo_plugin_color" 
                        value="<?php echo get_option( 'nuevo_plugin_color' ); ?>"/>
                </td>
            </tr>
            <tr valign="top"><th scope="row">Url:</th>
            </tr>
            <tr>
                <td>
                    <input type="url" name="nuevo_plugin_logo_url" 
                        value="<?php echo get_option( 'nuevo_plugin_logo_url' ); ?>"/>
                </td>
            </tr>
            </table>
        <?php submit_button(); ?>
        </form>
        <?php 
    } 
} 

if( !function_exists("update_nuevo_plugin_settings") ) { 
    function update_nuevo_plugin_settings() {   
        register_setting( 'nuevo-plugin-settings', 'nuevo_plugin_color' ); 
        register_setting( 'nuevo-plugin-settings', 'nuevo_plugin_logo_url' ); 
    } 

}
add_action( 'admin_init', 'update_nuevo_plugin_settings' ); 


if( !function_exists("get_nuevo_plugin_color") ) {    
    function get_nuevo_plugin_color()   {     
        $n_color = get_option( 'nuevo_plugin_color' );
        if (empty($n_color) )
            $n_color = "red";    
        return $n_color;
    }   
}

if( !function_exists("get_nuevo_plugin_logo_url") ) {    
    function get_nuevo_plugin_logo_url()   {     
        $n_logo = get_option( 'nuevo_plugin_logo_url' );
        if (empty($n_logo) )
            $n_logo = "/wp-admin/images/w-logo-white.png";    
        return $n_logo;
    }   
}


if( !function_exists("nuevo_plugin_logo") ) {    
    function nuevo_plugin_color($content)   {     
        $n_logo = get_nuevo_plugin_logo_url();
        return $content .'<img src="'.$n_logo.
            '" style="width:150px;height:150px;" alt="$n_logo">';   
    }  
    add_filter( 'the_content', 'nuevo_plugin_color' );  
}
