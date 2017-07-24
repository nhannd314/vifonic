<?php

// ============ Register widgets ==========
add_action('widgets_init', 'vifonic_register_widgets');

function vifonic_register_widgets()
{
    register_widget('Vifonic_Recent_Posts_Widget');
}

// =========== Class Vifonic_Recent_Posts_Widget ==========
if (!class_exists('Vifonic_Recent_Posts_Widget'))
{
    class Vifonic_Recent_Posts_Widget extends WP_Widget
    {
        function __construct() {
            /* Widget settings. */
            $widget_ops = array( 'classname' => 'vifonic-recent-posts-widget', 'description' => 'Recent Posts Widget, recent posts with thumbnail' );
            /* Widget control settings. */
            $control_ops = array( 'id_base' => 'vifonic-recent-posts-widget' );
            /* Create the widget. */
            parent::__construct('vifonic-recent-posts-widget', 'Recent Posts Widget', $widget_ops, $control_ops);
        }

        function form( $instance ) {

            $default = array(
                'title' => __('Recent Posts', 'vifonic'),
                'post_type' => 'post',
                'post_number' => 5,
                'category_id' => ''
            );
            $instance = wp_parse_args( (array) $instance, $default );
            $title = esc_attr($instance['title']);
            $post_type = esc_attr($instance['post_type']);
            $post_number = esc_attr($instance['post_number']);
            $category_id = esc_attr($instance['category_id']);

            echo '<p>'.__('Widget title', 'vifonic').' <input type="text" class="widefat" name="'.$this->get_field_name('title').'" value="'.$title.'" /></p>';
            echo '<p>'.__('Post type', 'vifonic').' <input type="text" class="widefat" name="'.$this->get_field_name('post_type').'" value="'.$post_type.'" /></p>';
            echo '<p>'.__('Number of posts', 'vifonic').' <input type="text" class="widefat" name="'.$this->get_field_name('post_number').'" value="'.$post_number.'" /></p>';
            echo '<p>'.__('Category id', 'vifonic').' <input type="text" class="widefat" name="'.$this->get_field_name('category_id').'" value="'.$category_id.'" /></p>';

        }

        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;

            $instance['title'] = strip_tags($new_instance['title']);
            $instance['post_type'] = strip_tags($new_instance['post_type']);
            $instance['post_number'] = strip_tags($new_instance['post_number']);
            $instance['category_id'] = strip_tags($new_instance['category_id']);

            return $instance;
        }

        function widget( $args, $instance ) {
            extract($args);
            $title = apply_filters( 'widget_title', $instance['title'] );
            $post_type = $instance['post_type'];
            $post_number = $instance['post_number'];
            $category_id = $instance['category_id'];

            echo $before_widget; ?>

            <h3 class="widget-title"><span><?= $title ?></span></h3>
            <div class="widget-content">

                <?php
                $args = array(
                    'post_type' => $post_type,
                    'posts_per_page' => $post_number
                );

                if ($category_id != '') $args['cat'] = $category_id;
                query_posts( $args );
                ?>

                <ul class="list-unstyled">

                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                        <li class="clearfix small-thumbnail-left">
                            <?php vifonic_post_thumbnail('small') ?>
                            <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                            <div class="post-meta"><?php the_time('d/M/Y') ?></div>
                        </li>

                    <?php endwhile; endif; ?>
                    <?php wp_reset_query() ?>

                </ul>

            </div>

            <?php echo $after_widget;
        }
    }
    // end class
}