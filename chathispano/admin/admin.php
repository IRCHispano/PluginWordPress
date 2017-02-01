<?php
if ( !defined( 'ABSPATH' ) ) exit;

/*
 * Funcion que genera una entrada en el menu de Administracion
 */
function chathispano_plugin_menu() {
    add_menu_page('Configuracion del ChatHispano Plugin', //Titulo pagina
        'ChatHispano',                        //Titulo menu
        'administrator',                      //Rol con permisos
        'chathispano_settings',                //Id de la pagina
        'chathispano_settingspage',            //Funcion de render
        plugins_url('chathispano/images/icon.png'), //Icono
        60                                     //Posicion
        );

    add_submenu_page('chathispano_settings',
        'Configuracion',
        'Información',
        'administrator',                      //Rol con permisos
        'chathispano_settings',               //Id de la pagina
        'chathispano_settingspage');          //Funcion de render


    add_submenu_page('chathispano_settings',
        'Configuracion',
        'Webchat responsive',
        'administrator',                      //Rol con permisos
        'chathispano_settings_webchat',       //Id de la pagina
        'chathispano_settingspage_webchat');  //Funcion de render

    add_submenu_page('chathispano_settings',
        'Configuracion',
        'Webchat Kiwi',
        'administrator',                      //Rol con permisos
        'chathispano_settings_kiwi',       //Id de la pagina
        'chathispano_settingspage_kiwi');  //Funcion de render
}

add_action('admin_menu', 'chathispano_plugin_menu');

/*
 * Funcion que registra los valores en la DB interna
 */
function chathispano_settings() {

    register_setting('chathispano-settings-webchat-group',
                     'chathispano_webchat_nick');
    register_setting('chathispano-settings-webchat-group',
                     'chathispano_webchat_chan');
    register_setting('chathispano-settings-webchat-group',
                     'chathispano_webchat_autojoin');
    register_setting('chathispano-settings-webchat-group',
                     'chathispano_webchat_autoload');
    register_setting('chathispano-settings-webchat-group',
                     'chathispano_webchat_theme');
    register_setting('chathispano-settings-webchat-group',
                     'chathispano_webchat_height');
    register_setting('chathispano-settings-webchat-group',
                     'chathispano_webchat_width');

    register_setting('chathispano-settings-kiwi-group',
                     'chathispano_kiwi_nick');
    register_setting('chathispano-settings-kiwi-group',
                     'chathispano_kiwi_chan');
    register_setting('chathispano-settings-kiwi-group',
                     'chathispano_kiwi_quit');
    register_setting('chathispano-settings-kiwi-group',
                     'chathispano_kiwi_autojoin');
    register_setting('chathispano-settings-kiwi-group',
                     'chathispano_kiwi_autoload');
    register_setting('chathispano-settings-kiwi-group',
                     'chathispano_kiwi_theme');
    register_setting('chathispano-settings-kiwi-group',
                     'chathispano_kiwi_height');
    register_setting('chathispano-settings-kiwi-group',
                     'chathispano_kiwi_width');
}

add_action('admin_init', 'chathispano_settings');


/*
 * Funcion que renderiza la pagina principal de configuracion
 */
function chathispano_settingspage() {
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
?>

    <div class="wrap">
        <h1>Información sobre el Plugin de ChatHispano</h1>
        <p>El plugin de ChatHispano para WordPress te permitirá utilizar en tu página Web los distintos servicios que la red ChatHispano ofrece a los Webmasters para sus Web.</p>
        <p>Los servicios disponibles son:</p>
        <br/>
        <h2>Webchat responsive</h2>
        <p>Webchat totalmente adaptable al tamaño de la pantalla en la que se muestra, modificándose su usabilidad para que sea más sencillo su uso. Incluye características como compartir imágenes o “Gente cerca” con la que podrás encontrar amigos cerca de tu localización. Es nuestro webchat principal.</p>
        <div class="card pressthis">
            <h3>Instrucciones de uso</h3>
            <p>Insertar el siguiente codigo en una pagina:</p>
            <p>[chathispano_webchat]</p>
            <br/>
            <p>Puedes especificar canal para una pagina especifica en vez de usar el canal por defecto configurado con:</p>
            <p>[chathispano_webchat chan=#Madrid]</p>
            <br/>
        </div>
        <br/>
        <h2>Webchat Kiwi</h2>
        <p>Webchat basado en el conocido Kiwi IRC ofrece una gran compatibilidad con los comandos usados por la mayor parte de los clientes chat de escritorio. Es ideal para cualquier usuario acostumbrado al uso del irc en el escritorio.</p>
        <div class="card pressthis">
            <h3>Instrucciones de uso</h3>
            <p>Insertar el siguiente codigo en una pagina:</p>
            <p>[chathispano_kiwi]</p>
            <br/>
            <p>Puedes especificar canal para una pagina especifica en vez de usar el canal por defecto configurado con:</p>
            <p>[chathispano_kiwi chan=#Barcelona]</p>
            <br/>
        </div>

    </div>
<?php
}


/*
 * Funcion que renderiza la pagina principal de configuracion
 */
function chathispano_settingspage_webchat() {
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }

    //Mensaje de error
    if (isset($_GET['settings-updated'])) {
        add_settings_error('hispano_messages', 'hispano_message_ok', ('Valores actualizados'), 'updated');
    }
    if (isset($_GET['settings-error'])) {
        add_settings_error('hispano_messages', 'hispano_message_error', ('Ha habido un error al guardar'), 'error');
    }

    settings_errors('hispano_messages');
?>

    <div class="wrap">
        <h1>Configuración Webchat responsive de ChatHispano</h1>
        <p>Desde este apartado se podrá configurar el comportamiento del Webchat responsive de ChatHispano en su WordPress.</p>
        <form method="POST" action="options.php">
            <?php
                settings_fields('chathispano-settings-webchat-group');
                do_settings_sections('chathispano-settings-webchat-group');
            ?>
        <br/>
        <table class="form-table">
            <h2>Datos de Conexion</h2>
            <tbody>
                <tr>
                    <th scope="row">Nick</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">...</legend>
                            <input  type="text"
                                    class="regular-text code"
                                    name="chathispano_webchat_nick"
                                    id="chathispano_webchat_nick"
                                    value="<?php echo get_option('chathispano_webchat_nick'); ?>"/>
                            <p class="description">Nick del usuario por defecto, si se especifica ?, se sustituirá por 5 números aleatorios.</p>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Canal</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">...</legend>
                            <input  type="text"
                                    class="regular-text code"
                                    name="chathispano_webchat_chan"
                                    id="chathispano_webchat_chan"
                                    value="<?php echo get_option('chathispano_webchat_chan'); ?>"/>
                            <p class="description">Canal que entrará en el usuario, se puede poner varios separados por comas.</p>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>

        <br/>
        <table class="form-table">
            <h2>Comportamiento</h2>
            <tbody>
                <tr>
                    <th scope="row">Autojoin geográfico</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">...</legend>
                            <input  type="checkbox"
                                    name="chathispano_webchat_autojoin"
                                    id="chathispano_webchat_autojoin"
                                    value="1" <?php checked(1, get_option('chathispano_webchat_autojoin'), true); ?> />
                            <label>Si está activado, el usuario entrará en el canal que más se ajusta según su localización geográfica y en el canal #irc-hispano.</label>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Entrada automática</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">...</legend>
                            <input  type="checkbox"
                                    name="chathispano_webchat_autoload"
                                    id="chathispano_webchat_autoload"
                                    value="1" <?php checked(1, get_option('chathispano_webchat_autoload'), true); ?> />
                            <label>Si está activado, el chat entrará directamente con un usuario por defecto pudiendo el usuario cambiarlo una vez conectado, si está desactivado se mostrará la ventana de selección de nick.</label>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>

        <br/>
        <table class="form-table">
            <h2>Apariencia</h2>
            <tbody>
                <tr>
                    <th scope="row">Tema</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">...</legend>
                            <select name="chathispano_webchat_theme"
                                    id="chathispano_webchat_theme">
                                <option value="chathispano" <?php selected(get_option('chathispano_webchat_theme'), "chathispano"); ?>>Chathispano</option>
                                <option value="pokemon" <?php selected(get_option('chathispano_webchat_theme'), "pokemon"); ?>>Pokemon</option>
                                <option value="chathetero" <?php selected(get_option('chathispano_webchat_theme'), "chathetero"); ?>>Sexo</option>
                                <option value="chatgay" <?php selected(get_option('chathispano_webchat_theme'), "chatgay"); ?>>Gay</option>
                            </select>
                            <label>Tema visual a aplicar en el Webchat.</label>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Alto del frame</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">...</legend>
                            <input  type="text"
                                    class="small-text code"
                                    name="chathispano_webchat_height"
                                    id="chathispano_webchat_height"
                                    value="<?php echo get_option('chathispano_webchat_height'); ?>"/>
                            <p class="description">Altura en pixeles o en porcentaje del frame.</p>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Ancho del frame</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">...</legend>
                            <input  type="text"
                                    class="small-text code"
                                    name="chathispano_webchat_width"
                                    id="chathispano_webchat_width"
                                    value="<?php echo get_option('chathispano_webchat_width'); ?>"/>
                            <p class="description">Ancho en pixeles o en porcentaje del frame. Se recomienda poner 100% para ser responsive.</p>
                        </fieldset>
                    </td>
                </tr>

            </tbody>
        </table>
        <p style="font-weight: bold;">NOTA: Las preferencias de los usuarios tendrán siempre prioridad ante esta configuración del Webchat. Por ejemplo, si un usuario configura que se utilice determinado nick y se acceda a determinado canal, siempre prevalecerá esa configuración sobre la de esta configuración, aunque entrará al canal que le indique en la configuración.</p>
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}


/*
 * Funcion que renderiza la pagina principal de configuracion
 */
function chathispano_settingspage_kiwi() {
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }

    //Mensaje de error
    if (isset($_GET['settings-updated'])) {
        add_settings_error('hispano_messages', 'hispano_message_ok', ('Valores actualizados'), 'updated');
    }
    if (isset($_GET['settings-error'])) {
        add_settings_error('hispano_messages', 'hispano_message_error', ('Ha habido un error al guardar'), 'error');
    }

    settings_errors('hispano_messages');
?>

    <div class="wrap">
        <h1>Configuración Webchat Kiwi de ChatHispano</h1>
        <p>Desde este apartado se podrá configurar el comportamiento del Webchat Kiwi de ChatHispano en su WordPress.</p>
        <form method="POST" action="options.php">
            <?php
                settings_fields('chathispano-settings-kiwi-group');
                do_settings_sections('chathispano-settings-kiwi-group');
            ?>
        <br/>
        <table class="form-table">
            <h2>Datos de Conexion</h2>
            <tbody>
                <tr>
                    <th scope="row">Nick</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">...</legend>
                            <input  type="text"
                                    class="regular-text code"
                                    name="chathispano_kiwi_nick"
                                    id="chathispano_kiwi_nick"
                                    value="<?php echo get_option('chathispano_kiwi_nick'); ?>"/>
                            <p class="description">Nick del usuario por defecto, si se especifica ?, se sustituirá por 5 números aleatorios.</p>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Canal</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">...</legend>
                            <input  type="text"
                                    class="regular-text code"
                                    name="chathispano_kiwi_chan"
                                    id="chathispano_kiwi_chan"
                                    value="<?php echo get_option('chathispano_kiwi_chan'); ?>"/>
                            <p class="description">Canal que entrará en el usuario, se puede poner varios separados por comas.</p>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Mensaje de salida</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">...</legend>
                            <input  type="text"
                                    class="regular-text code"
                                    name="chathispano_kiwi_quit"
                                    id="chathispano_kiwi_quit"
                                    value="<?php echo get_option('chathispano_kiwi_quit'); ?>"/>
                            <p class="description">Mensaje de salida por defecto cuando un usuario sale de la red. Si está en algún canal +u, dicho mensaje no se mostrará.</p>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>

        <br/>
        <table class="form-table">
            <h2>Comportamiento</h2>
            <tbody>
<!-- No está disponible
                <tr>
                    <th scope="row">Autojoin geográfico</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">...</legend>
                            <input  type="checkbox"
                                    name="chathispano_kiwi_autojoin"
                                    id="chathispano_kiwi_autojoin"
                                    value="1" <?php checked(1, get_option('chathispano_kiwi_autojoin'), true); ?> />
                            <label>Si está activado, el usuario entrará en el canal que más se ajusta según su localización geográfica y en el canal #irc-hispano.</label>
                        </fieldset>
                    </td>
                </tr>
-->
                <tr>
                    <th scope="row">Entrada automática</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">...</legend>
                            <input  type="checkbox"
                                    name="chathispano_kiwi_autoload"
                                    id="chathispano_kiwi_autoload"
                                    value="1" <?php checked(1, get_option('chathispano_kiwi_autoload'), true); ?> />
                            <label>Si está activado, el chat entrará directamente con un usuario por defecto pudiendo el usuario cambiarlo una vez conectado, si está desactivado se mostrará la ventana de selección de nick.</label>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>

        <br/>
        <table class="form-table">
            <h2>Apariencia</h2>
            <tbody>
                <tr>
                    <th scope="row">Tema</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">...</legend>
                            <select name="chathispano_kiwi_theme"
                                    id="chathispano_kiwi_theme">
                                <option value="chathispano" <?php selected(get_option('chathispano_kiwi_theme'), "chathispano"); ?>>ChatHispano</option>
                                <option value="relaxed" <?php selected(get_option('chathispano_kiwi_theme'), "relaxed"); ?>>Relaxed (Verde)</option>
                                <option value="cli" <?php selected(get_option('chathispano_kiwi_theme'), "cli"); ?>>Cli (Negro)</option>
                                <option value="basic" <?php selected(get_option('chathispano_kiwi_theme'), "basic"); ?>>Basic (Gris)</option>
                                <option value="mini" <?php selected(get_option('chathispano_kiwi_theme'), "mini"); ?>>Mini (móvil)</option>
                            </select>
                            <label>Tema visual a aplicar en el Webchat.</label>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Alto del frame</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">...</legend>
                            <input  type="text"
                                    class="small-text"
                                    name="chathispano_kiwi_height"
                                    id="chathispano_kiwi_height"
                                    value="<?php echo get_option('chathispano_kiwi_height'); ?>"/>
                            <p class="description">Altura en pixeles o en porcentaje del frame.</p>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Ancho del frame</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">...</legend>
                            <input  type="text"
                                    class="small-text"
                                    name="chathispano_kiwi_width"
                                    id="chathispano_kiwi_width"
                                    value="<?php get_option('chathispano_kiwi_width'); ?>"/>
                            <p class="description">Ancho en pixeles o en porcentaje del frame. Se recomienda poner 100% para ser responsive.</p>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}
?>
