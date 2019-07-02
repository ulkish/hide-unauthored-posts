<?php
/**
* Plugin Name: Hide Unauthored Posts
* Plugin URI: https://tipit.net/
* Description: Hide posts in the dashboard if the current user is not the author.
* Version: 1.0
* Author: Hugo Moran
* Author URI: https://tipit.net
* License: License: GPL2+
**/

function posts_for_current_author($query) {
        $is_author = current_user_can('author');
        if($query->is_admin && $is_author) {
                global $user_ID;
                $query->set('author',  $user_ID);
        }
        return $query;
}
add_filter('pre_get_posts', 'posts_for_current_author');

function jquery_remove_posts_count() {
        global $pagenow;
        $is_author = current_user_can('author');
        if($is_author && $pagenow == 'edit.php') { ?>
                <script type="text/javascript">
                jQuery(function($){
                        $("ul.subsubsub li.all").remove();
                        $("ul.subsubsub li.draft").find("span.count").remove();
                        $("ul.subsubsub li.publish").find("span.count").remove();
                        $("ul.subsubsub li.private").find("span.count").remove();
                        $("ul.subsubsub li.trash").find("span.count").remove();
                });
                </script>
                <?php
        }
}
add_action('admin_footer', 'jquery_remove_posts_count');
