<?php

defined('ABSPATH') or die("No script kiddies please!");

function chathispano_webchat_page( $atts ) {
    $url = CHATHISPANO_WEBCHAT_URLBASE."?";

    if (get_option('chathispano_webchat_theme') != '')
        $url = $url."theme=".get_option('chathispano_webchat_theme');

    if (get_option('chathispano_webchat_autoload'))
        $url = $url."&autoload=true";

    if (get_option('chathispano_webchat_autojoin'))
        $url = $url."&autojoin=true";

    if (get_option('chathispano_webchat_nick') != '')
        $url = $url."&nick=".get_option('chathispano_webchat_nick');

    $channels = isset($atts['chan']) ? $atts['chan'] : '';
    if ($channels == '')
        $channels = get_option('chathispano_webchat_chan');
    if ($channels != '')
        $url = $url."&chan=".$channels;

?>
    <center>
        <iframe
            marginwidth="0"
            marginheight="0"
            src="<?php echo $url; ?>"
<?php
    if (get_option('chathispano_webchat_width') != '')
        echo "width=\"".get_option('chathispano_webchat_width')."\"";
    if (get_option('chathispano_webchat_height') != '')
        echo "height=\"".get_option('chathispano_webchat_height')."\"";
?>
            scrolling="no"
            frameborder="0">
        </iframe>
    </center>
<?php
}

function chathispano_webchat( $atts ) {
    ob_start();
    chathispano_webchat_page( $atts );

    return ob_get_clean();
}

function chathispano_webchat_kiwi_page( $atts ) {
    $url = CHATHISPANO_KIWI_URLBASE."?";

    if (get_option('chathispano_kiwi_theme') != '')
        $url = $url."theme=".get_option('chathispano_kiwi_theme');

    if (get_option('chathispano_kiwi_autoload'))
        $url = $url."&entrar=true";

    if (get_option('chathispano_kiwi_autojoin'))
        $url = $url."&autojoin=true";

    if (get_option('chathispano_kiwi_nick') != '')
        $url = $url."&nick=".get_option('chathispano_kiwi_nick');

    if (get_option('chathispano_kiwi_quit') != '')
        $url = $url."&quit=".urlencode(get_option('chathispano_kiwi_quit'));

    $channels = isset($atts['chan']) ? $atts['chan'] : '';
    if ($channels == '')
        $channels = get_option('chathispano_kiwi_chan');
    if ($channels != '')
        $url = $url."&chan=".$channels;

    if (get_option('chathispano_kiwi_quit') != '')
        $url = $url."&quit=".get_option('chathispano_kiwi_quit');


?>

    <center>
        <iframe
            marginwidth="0"
            marginheight="0"
            src="<?php echo $url; ?>"
<?php
    if (get_option('chathispano_kiwi_width') != '')
        echo "width=\"".get_option('chathispano_kiwi_width')."\"";
    if (get_option('chathispano_kiwi_height') != '')
        echo "height=\"".get_option('chathispano_kiwi_height')."\"";
?>
            scrolling="no"
            frameborder="0">
        </iframe>
    </center>
<?php
}

function chathispano_webchat_kiwi( $atts ) {
    ob_start();
    chathispano_webchat_kiwi_page( $atts );

    return ob_get_clean();
}

add_shortcode( 'chathispano_webchat', 'chathispano_webchat' );
add_shortcode( 'chathispano_kiwi', 'chathispano_webchat_kiwi' );
?>
