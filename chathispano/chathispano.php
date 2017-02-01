<?php
/*
Plugin name: ChatHispano Plugin
Plugin URI: http://github.com/IRCHispano
Description: Plugin de Wordpress para poner Webchat de ChatHispano en su Wordpress
Version: 1.0
Author: ChatHispano
Author URI: http://github.com/IRCHispano
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: chathispano
*/

/*  Copyright 2017 Toni Garcia <zoltan@chathispano.com>

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define( 'CHATHISPANO_VERSION', '1.0' );

define( 'CHATHISPANO__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

define( 'CHATHISPANO_WEBCHAT_URLBASE', 'https://chatmovil.chathispano.com' );
define( 'CHATHISPANO_KIWI_URLBASE', 'https://kiwi.chathispano.com' );


if ( is_admin() ) {
    require_once( CHATHISPANO__PLUGIN_DIR . 'admin/admin.php' );
}
require_once( CHATHISPANO__PLUGIN_DIR . 'public/index.php' );


function chathispano_plugin_links( $actions, $plugin_file ) {
    static $plugin;

    if ( !isset($plugin) )
        $plugin = plugin_basename(__FILE__);

    if ( $plugin == $plugin_file ) {
        $settings = array('settings' => '<a href="admin.php?page=chathispano">Configuracion</a>');
        $site_link = array('support' => '<a href="https://github.com/IRCHispano" target="_blank">Soporte</a>');
        $actions = array_merge($site_link, $actions);
        $actions = array_merge($settings, $actions);
    }
    return $actions;
}

add_filter( 'plugin_action_links', 'chathispano_plugin_links', 10, 5 );

?>

