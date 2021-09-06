<?php



add_action('after_setup_theme', 'sol_theme_setup');
function sol_theme_setup()
{
    load_theme_textdomain('sol_theme', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('search-form'));
    global $content_width;
    if (!isset($content_width)) {
        $content_width = 1920;
    }
    
    register_nav_menus(array('main-menu' => esc_html__('Main Menu', 'sol_theme')));
}
add_action('admin_notices', 'sol_theme_admin_notice');
function sol_theme_admin_notice()
{
    $user_id = get_current_user_id();
    if (!get_user_meta($user_id, 'sol_theme_notice_dismissed_3') && current_user_can('manage_options'))
        echo '<div class="notice notice-info"><p>' . __('<big><strong>sol_theme</strong>:</big> Help keep the project alive! <a href="?notice-dismiss" class="alignright">Dismiss</a> <a href="https://calmestghost.com/donate" class="button-primary" target="_blank">Make a Donation</a>', 'sol_theme') . '</p></div>';
}
add_action('admin_init', 'sol_theme_notice_dismissed');
function sol_theme_notice_dismissed()
{
    $user_id = get_current_user_id();
    if (isset($_GET['notice-dismiss']))
        add_user_meta($user_id, 'sol_theme_notice_dismissed_3', 'true', true);
}


/**
 * ADD SCRIPTS
 */
add_action('wp_enqueue_scripts', 'sol_theme_enqueue');
function sol_theme_enqueue()
{
    wp_enqueue_style('materialize', get_template_directory_uri() . '/assets/materialize.min.css', array(), '1.1', 'all');
    wp_enqueue_style('swiper', get_template_directory_uri() . '/assets/swiper-bundle.min.css', array(), '1.1', 'all');
    wp_enqueue_style('sol_theme-style', get_stylesheet_uri());
    wp_enqueue_script('jquery');
    /** 
     * ADD CUSTOM CSS
     */
    wp_enqueue_style('sol21', get_template_directory_uri() . '/assets/sol21.css', array(), '1.1', 'all');
    
    wp_enqueue_script('materialize-js', get_template_directory_uri() . '/assets/materialize.min.js', array(), '1.1', true);
    wp_enqueue_script('swiper-js', get_template_directory_uri() . '/assets/swiper-bundle.min.js', array(), '1.1', true);
    wp_enqueue_script('sol21', get_template_directory_uri() . '/assets/sol21.js', array(), '1.1', true);
    wp_enqueue_script('sol21-js', get_template_directory_uri() . '/assets/index.js', array(), '1.1', true);
}


add_action('wp_footer', 'sol_theme_footer');
function sol_theme_footer()
{
?>
    <script>
        jQuery(document).ready(function($) {
            var deviceAgent = navigator.userAgent.toLowerCase();
            if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
                $("html").addClass("ios");
            }
            if (navigator.userAgent.search("MSIE") >= 0) {
                $("html").addClass("ie");
            } else if (navigator.userAgent.search("Chrome") >= 0) {
                $("html").addClass("chrome");
            } else if (navigator.userAgent.search("Firefox") >= 0) {
                $("html").addClass("firefox");
            } else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
                $("html").addClass("safari");
            } else if (navigator.userAgent.search("Opera") >= 0) {
                $("html").addClass("opera");
            }
        });
    </script>
<?php
}
add_filter('document_title_separator', 'sol_theme_document_title_separator');
function sol_theme_document_title_separator($sep)
{
    $sep = '|';
    return $sep;
}
add_filter('the_title', 'sol_theme_title');
function sol_theme_title($title)
{
    if ($title == '') {
        return '...';
    } else {
        return $title;
    }
}
add_filter('nav_menu_link_attributes', 'sol_theme_schema_url', 10);
function sol_theme_schema_url($atts)
{
    $atts['itemprop'] = 'url';
    return $atts;
}
if (!function_exists('sol_theme_wp_body_open')) {
    function sol_theme_wp_body_open()
    {
        do_action('wp_body_open');
    }
}
add_action('wp_body_open', 'sol_theme_skip_link', 5);
function sol_theme_skip_link()
{
    echo '<a href="#content" class="skip-link screen-reader-text">' . esc_html__('Skip to the content', 'sol_theme') . '</a>';
}
add_filter('the_content_more_link', 'sol_theme_read_more_link');
function sol_theme_read_more_link()
{
    if (!is_admin()) {
        return ' <a href="' . esc_url(get_permalink()) . '" class="more-link">' . sprintf(__('...%s', 'sol_theme'), '<span class="screen-reader-text">  ' . esc_html(get_the_title()) . '</span>') . '</a>';
    }
}
add_filter('excerpt_more', 'sol_theme_excerpt_read_more_link');
function sol_theme_excerpt_read_more_link($more)
{
    if (!is_admin()) {
        global $post;
        return ' <a href="' . esc_url(get_permalink($post->ID)) . '" class="more-link">' . sprintf(__('...%s', 'sol_theme'), '<span class="screen-reader-text">  ' . esc_html(get_the_title()) . '</span>') . '</a>';
    }
}
add_filter('big_image_size_threshold', '__return_false');
add_filter('intermediate_image_sizes_advanced', 'sol_theme_image_insert_override');
function sol_theme_image_insert_override($sizes)
{
    unset($sizes['medium_large']);
    unset($sizes['1536x1536']);
    unset($sizes['2048x2048']);
    return $sizes;
}
add_action('widgets_init', 'sol_theme_widgets_init');
function sol_theme_widgets_init()
{
    register_sidebar(array(
        'name' => esc_html__('Sidebar Widget Area', 'sol_theme'),
        'id' => 'primary-widget-area',
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('wp_head', 'sol_theme_pingback_header');
function sol_theme_pingback_header()
{
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s" />' . "\n", esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('comment_form_before', 'sol_theme_enqueue_comment_reply_script');
function sol_theme_enqueue_comment_reply_script()
{
    if (get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
function sol_theme_custom_pings($comment)
{
?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo esc_url(comment_author_link()); ?></li>
<?php
}
add_filter('get_comments_number', 'sol_theme_comment_count', 0);
function sol_theme_comment_count($count)
{
    if (!is_admin()) {
        global $id;
        $get_comments = get_comments('status=approve&post_id=' . $id);
        $comments_by_type = separate_comments($get_comments);
        return count($comments_by_type['comment']);
    } else {
        return $count;
    }
}
