<?php defined('ABSPATH') || exit;

class jk_wp_post_views
{

    public static function the_views($post_id)
    {

        $views = get_post_meta($post_id, 'post_views_' . $post_id);

        print_r($views[0]);

    }

    public static function ajax_handler($post_id, $user_id)
    {

        $views = get_post_meta($post_id, 'post_views_' . $post_id);

        $viewed_posts = get_option('post_views_user_' . $user_id);

        if (empty($viewed_posts)):

            $viewed_posts = array();

        endif;

        if (empty($views)):

            $views[0] = 0;

        endif;

        $views = (int)$views[0] + 1;

        update_post_meta($post_id, 'post_views_' . $post_id, $views);

        if (!in_array($post_id, $viewed_posts)):

            array_push($viewed_posts, $post_id);

            update_option('post_views_user_' . $user_id, $viewed_posts);

        endif;

    }

    public function ajax_init()
    {

        add_action('wp_ajax_nopriv_jk_views', [$this, 'ajax_handler']);

        add_action('wp_ajax_jk_views', [$this, 'ajax_handler']);

    }

}
