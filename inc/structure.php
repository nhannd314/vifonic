<?php
if (!function_exists('vifonic_breadcrumb')){
	function vifonic_breadcrumb(){
		if ( function_exists('yoast_breadcrumb') ) {
			yoast_breadcrumb('<div id="breadcrumbs">','</div>');
		}
	}
}
// ============== Display post thumbnail ===========

if (!function_exists('vifonic_post_thumbnail'))
{
	function vifonic_post_thumbnail($size = 'thumbnail', $args = array())
	{
		if (has_post_thumbnail() && !post_password_required() || has_post_format('image')) {
			the_post_thumbnail($size, $args);
        } else {
            echo '<img class="post-none-image" src="'.get_stylesheet_directory_uri().'/img/none-image.jpg">';
        }
	}
}


// ============== Display post entry meta ===========

if (!function_exists('vifonic_entry_meta'))
{
	function vifonic_entry_meta($is_single = false)
	{
		?>
        <div class="post-meta">
            <span class="author"><?php the_author_posts_link(); ?></span> |
            <span itemprop="datePublished"><?php the_time('d/m/Y') ?></span>
			<?php if ($is_single): ?>
                | <span class="list-categories"><?php echo get_the_category_list(', ') ?></span>
			<?php endif; ?>
        </div>
		<?php
	}
}

// ============== Facebook SDK ================

if (!function_exists('vifonic_facebook_sdk')) {
	function vifonic_facebook_sdk(){
		global $locale;
		$lang = "";
		if ($locale == "vi") {
			$lang = "vi_VN";
		} elseif($locale == "en"){
			$lang = "en_US";
		}
		?>
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/<?php echo $lang; ?>/sdk.js#xfbml=1&version=v2.10&appId=355627444798303";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
		<?php
	}
	add_action("wp_head", "vifonic_facebook_sdk");
}

// ============== Social links ===========

if (!function_exists('vifonic_social_links'))
{
	function vifonic_social_links()
	{
		$title = get_the_title();
		$link = get_permalink();
		?>

        <ul class="vifonic-social-share list-inline clearfix">
            <li>
                <a onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo $link ?>','Share', 'toolbar=0,status=0,width=620,height=280');" data-toggle="tooltip" title="<?php _e('Share on Facebook','vifonic'); ?>" href="javascript:" data-original-title="<?php _e('Share on Facebook','vifonic'); ?>"><i class="fa fa-facebook"></i></a>
            </li>
            <li>
                <a onclick="popUp=window.open('http://twitter.com/home?status=<?php echo $title ?> <?php echo $link ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;" data-toggle="tooltip" title="<?php _e('Share on Twitter','vifonic'); ?>" href="javascript:" data-original-title="<?php _e('Share on Twitter','vifonic'); ?>"><i class="fa fa-twitter"></i></a>
            </li>
            <li>
                <a data-toggle="tooltip" title="<?php _e('Share on Google +','vifonic'); ?>" href="javascript:" onclick="popUp=window.open('https://plus.google.com/share?url=<?php echo $link ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;" data-original-title="<?php _e('Share on Google +','vifonic'); ?>"><i class="fa fa-google-plus"></i></a>
            </li>
            <li>
                <a data-toggle="tooltip" title="<?php _e('Share on Linkedin','vifonic'); ?>" onclick="popUp=window.open('http://linkedin.com/shareArticle?mini=true&amp;url=<?php echo $link ?>&amp;title=<?php echo $title ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;" href="javascript:" data-original-title="<?php _e('Share on Linkedin','vifonic'); ?>"><i class="fa fa-linkedin"></i></a>
            </li>
            <li>
                <a data-toggle="tooltip" title="<?php _e('Share on Tumblr','vifonic'); ?>" onclick="popUp=window.open('http://www.tumblr.com/share/link?url=<?php echo $link ?>&amp;name=<?php echo $title ?>&amp;description=<?php the_excerpt() ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;" href="javascript:" data-original-title="<?php _e('Share on Tumblr','vifonic'); ?>"><i class="fa fa-tumblr"></i></a>
            </li>
            <li>
                <a data-toggle="tooltip" title="<?php _e('Pin on Pinterest','vifonic'); ?>" onclick="popUp=window.open('http://pinterest.com/pin/create/button/?url=<?php echo $link ?>&amp;description=<?php echo $title ?>&amp;media=<?php the_post_thumbnail_url('full') ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;" href="javascript:" data-original-title="<?php _e('Pin on Pinterest','vifonic'); ?>"><i class="fa fa-pinterest"></i></a>
            </li>
        </ul>

		<?php
	}
}


// ============= Comment Facebook ==============

if (!function_exists('vifonic_comment_facebook'))
{
	function vifonic_comment_facebook($link = '')
	{
		if ($link == '') $link = home_url('/');
		?>
        <div class="clearfix"></div>
        <div class="facebook-comment responsive" style="border: 1px solid #3B5998;">
            <h4 class="title" style="background-color: #3B5998;padding: 5px 20px;color: #fff;font-weight: 700;margin-top: 0;">
                <i class="fa fa-comment-o" aria-hidden="true" style="margin-right: 5px;"></i>
				<?php _e('Your comment', 'vifonic') ?>
            </h4>
            <div class="fb-comments" data-href="<?php echo $link ?>" data-width="100%" data-numposts="20"></div>
        </div>
		<?php
	}
}


// ============== Show Related Posts =============

function vifonic_related_posts($ID, $content_template = '')
{
	$terms = wp_get_post_tags($ID);
	if ($terms) {
		$term_ids = array();
		foreach ($terms as $item) $term_ids[] = $item->term_id;
		$args = array(
			'tag__in' => $term_ids,
			'post__not_in' => array($ID),
			'posts_per_page' => 3,
			'ignore_sticky_posts' => 1
		);
		query_posts($args);
		if (have_posts()) {
			vifonic_title(__('Related Post', 'vifonic'), '','left');
		    echo '<div class="row related-posts">';
			while (have_posts()) {
				the_post();
				echo '<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">';
				get_template_part('templates/loop/content', $content_template);
				echo '</div>';
			}
			echo '</div>';
		}
		wp_reset_query();
	}
}


// ============== Get excerpt ==============

function vifonic_get_the_excerpt($limit = 30)
{
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	if (count($excerpt) >= $limit) {
		array_pop($excerpt);
		$excerpt = implode(" ", $excerpt) . ' ...';
	} else {
		$excerpt = implode(" ", $excerpt);
	}
//    $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	return $excerpt;
}

function vifonic_the_excerpt($limit = 30)
{
	echo vifonic_get_the_excerpt($limit);
}

// ================ Pagination ===============

function vifonic_pagination()
{
	global $wp_query;
	if ($wp_query->max_num_pages > 1) : ?>
        <div class="pagination">
			<?php
			if (get_previous_posts_link()) echo '<li class="archive-nav-newer">' . get_previous_posts_link('&larr; ' . __('Previous', 'vifonic')) . '</li>';
			$paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
			$max = intval($wp_query->max_num_pages);
			/**    Add current page to the array */
			if ($paged >= 1)
				$links[] = $paged;
			/**    Add the pages around the current page to the array */
			if ($paged >= 3) {
				$links[] = $paged - 1;
				$links[] = $paged - 2;
			}
			if (($paged + 2) <= $max) {
				$links[] = $paged + 2;
				$links[] = $paged + 1;
			}
			/**    Link to first page, plus ellipses if necessary */
			if (!in_array(1, $links)) {
				$class = 1 == $paged ? ' active' : '';
				printf('<li class="number%s"><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');
				if (!in_array(2, $links))
					echo '<li>...</li>';
			}
			/**    Link to current page, plus 2 pages in either direction if necessary */
			sort($links);
			foreach ((array)$links as $link) {
				$class = $paged == $link ? ' active' : '';
				printf('<li class="number%s"><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
			}
			/**    Link to last page, plus ellipses if necessary */
			if (!in_array($max, $links)) {
				if (!in_array($max - 1, $links))
					echo '<li class="number">...</li>' . "\n";
				$class = $paged == $max ? ' active' : '';
				printf('<li class="number%s"><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
			}
			if (get_next_posts_link()) echo '<li class="archive-nav-older">' . get_next_posts_link(__('Next', 'vifonic') . ' &rarr;') . '</li>';
			?>
            <div class="clear"></div>
        </div> <!-- /archive-nav -->
	<?php endif;
}

// ============== Site favicon ============

function vifonic_site_favicon() {
	global $vifonic_options;
	return $vifonic_options['site_favicon']['url'];
}

function vifonic_site_logo() {
	global $vifonic_options;
	return '<img src="' . $vifonic_options['site_logo']['url'] .'" alt="' . get_bloginfo('name') .'" />';
}


// ============== Title ============
if (!function_exists('vifonic_title'))
{
	function vifonic_title($main_title = 'Main Title', $sub_title = '', $text_align = 'center'){
		?>
        <div class="section-title-container">
            <h2 class="section-title section-title-<?php echo $text_align ?>">
                <span class="section-title-main"><?php echo __($main_title); ?></span>
            </h2>
			<?php
			if ($sub_title != '') {
				echo '<p class="section-title-sub section-title-center">'.__($sub_title).'</p>';
			}
			?>
        </div>
		<?php
	}
}

// ============== Button ============
if (!function_exists('vifonic_button'))
{
	function vifonic_button($link = '#', $button_text = 'Button Text', $text_align = 'center', $is_icon = false){
		?>
        <div class="text-<?php echo $text_align ?>">
            <a href="<?php echo esc_url($link); ?>"  class="btn btn-primary vifonic-button">
                <span class="<?php if ($is_icon)  echo esc_attr('has-icon'); ?>"><?php echo __($button_text); ?></span>
            </a>
        </div>
		<?php
	}
}

// ============== Price =============
if (!function_exists('vifonic_price_format'))
{
	function vifonic_price_format($price){
		$formatted_price = number_format (intval($price), 0, '.', ',');
		return $formatted_price.'đ';
	}
}

// ============== Show list Courses ============
if (!function_exists('vifonic_show_list_courses_by_category'))
{
	function vifonic_show_list_courses_by_category($course_cat = '', $number_of_course = 8){
		$args = array(
			'post_type' => 'course',
			'posts_per_page' => $number_of_course,
			'post_status' => 'publish',
		);
		if ($course_cat != ''){
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'course_category',
					'field'    => 'slug',
					'terms'    => array( $course_cat ),
				),
			);
		}

		$queryCourse = new WP_Query($args);
		if ($queryCourse->have_posts()){
			echo '<div class="container"><div class="row">';
			$i = 0;
			while ($queryCourse->have_posts()) {
				$queryCourse->the_post();

				echo '<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">';
				get_template_part('templates/loop/content', 'course');
				echo '</div>';

				$i++;
				if ($i%4==0){ echo '<div class="clearfix"></div>'; }
			}
			echo '</div></div>';
			vifonic_button(get_term_link($course_cat, 'course_category'),'XEM TẤT CẢ', 'center', true);
		}
	}
}

// ============== Show Featured Courses ============
if (!function_exists('vifonic_show_featured_courses_slider_by_category'))
{
	function vifonic_show_featured_courses_slider_by_category($course_cat = '', $number_of_course = 8){
		$args = array(
			'post_type' => 'course',
			'posts_per_page' => $number_of_course,
			'post_status' => 'publish',
//Khóa học nổi bật
			'meta_query' => array (
				array(
					'key'     => 'featured_course',
					'value'   => '1',
					'compare' => '=='
				),
			),
		);
		if ($course_cat != ''){
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'course_category',
					'field'    => 'slug',
					'terms'    => array( $course_cat ),
				),
			);
		}

		$queryCourse = new WP_Query($args);
		if ($queryCourse->have_posts()){
			echo '<div id="featured-course" class="owl-carousel owl-theme courses-slider">';
			while ($queryCourse->have_posts()) {
				$queryCourse->the_post();
				echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 course-item">';
				get_template_part('templates/loop/content', 'course');
				echo '</div>';
			}
			echo '</div>';
			echo '<script>
                    jQuery(document).ready(function(){
                        jQuery("#featured-course").owlCarousel({
                            loop:true,
                            margin:10,
                            autoplay: true,
                            navText: ["<i class=\"fa fa-chevron-left\"></i>", "<i class=\"fa fa-chevron-right\"></i>"],
                            dots: false,
                            autoplayTimeout: 3000,
                            responsiveClass:true,
                            responsive:{
                                0:{
                                    items:1,
                                    nav:false
                                },
                                600:{
                                    items:3,
                                    nav:false
                                },
                                1000:{
                                    items:4,
                                    nav:true,
                                    loop:true
                                }
                            },
                        });
                    });
                    </script>';
		}
	}
}

// ============== Show Free Courses ============
if (!function_exists('vifonic_show_free_courses_slider_by_category'))
{
	function vifonic_show_free_courses_slider_by_category($course_cat = '', $number_of_course = 8){
		$args = array(
			'post_type' => 'course',
			'posts_per_page' => $number_of_course,
			'post_status' => 'publish',
//Khóa học nổi bật
			'meta_query' => array (
				array(
					'key'     => 'free_course',
					'value'   => '1',
					'compare' => '=='
				),
			),
		);
		if ($course_cat != ''){
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'course_category',
					'field'    => 'slug',
					'terms'    => array( $course_cat ),
				),
			);
		}

		$queryCourse = new WP_Query($args);
		if ($queryCourse->have_posts()){
			echo '<div id="free-course" class="owl-carousel owl-theme courses-slider">';
			while ($queryCourse->have_posts()) {
				$queryCourse->the_post();
				echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 course-item">';
				get_template_part('templates/loop/content', 'course');
				echo '</div>';
			}
			echo '</div>';
			echo '<script>
                    jQuery(document).ready(function(){
                        jQuery("#free-course").owlCarousel({
                            loop:true,
                            margin:10,
                            autoplay: true,
                            navText: ["<i class=\"fa fa-chevron-left\"></i>", "<i class=\"fa fa-chevron-right\"></i>"],
                            dots: false,
                            autoplayTimeout: 3000,
                            responsiveClass:true,
                            responsive:{
                                0:{
                                    items:1,
                                    nav:false
                                },
                                600:{
                                    items:3,
                                    nav:false
                                },
                                1000:{
                                    items:4,
                                    nav:true,
                                    loop:true
                                }
                            },
                        });
                    });
                    </script>';
		}
	}
}

// ============== Show Related Courses =============
if (!function_exists('vifonic_related_courses')) {
	function vifonic_related_courses($ID, $content_template = '')
	{
		$terms = wp_get_post_terms($ID, 'course_category', array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'ids'));
		if ($terms) {
			$args = array(
				'post_type' => 'course',
				'post_status' => 'publish',
				'post__not_in' => array($ID),
				'posts_per_page' => 8,
				'ignore_sticky_posts' => 1,
				'tax_query' => array(
					array(
						'taxonomy' => 'course_category',
						'field'    => 'term_id',
						'terms'    => $terms,
						'operator' => 'IN',
					),
				),
			);
			vifonic_title('KHÓA HỌC LIÊN QUAN');
			query_posts($args);
			if (have_posts()) {
				echo '<div id="related-course" class="owl-carousel owl-theme courses-slider">';
				while (have_posts()) {
					the_post();
					echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 course-item">';
					get_template_part('templates/loop/content', $content_template);
					echo '</div>';
				}
				echo '</div>';
				echo '<script>
                    jQuery(document).ready(function(){
                        jQuery("#related-course").owlCarousel({
                            loop:true,
                            margin:10,
                            autoplay: true,
                            navText: ["<i class=\"fa fa-chevron-left\"></i>", "<i class=\"fa fa-chevron-right\"></i>"],
                            dots: false,
                            autoplayTimeout: 3000,
                            responsiveClass:true,
                            responsive:{
                                0:{
                                    items:1,
                                    nav:false
                                },
                                600:{
                                    items:3,
                                    nav:false
                                },
                                1000:{
                                    items:4,
                                    nav:true,
                                    loop:true
                                }
                            },
                        });
                    });
                    </script>';
			}
			wp_reset_query();
		}
	}
}

// ============== Show Vifonic Slider ============
if (!function_exists('vifonic_slider'))
{
	function vifonic_slider(){
		$args = array(
			'post_type' => 'vifonic-slider',
			'posts_per_page' => -1,
			'post_status' => 'publish',
		);

		$querySlider = new WP_Query($args);
		if ($querySlider->have_posts()){
			echo '<div id="vifonic_slider" class="owl-carousel owl-theme">';
			while ($querySlider->have_posts()) {
				$querySlider->the_post();
				?>
                <div class="slide-item">
					<?php the_post_thumbnail('slider-size'); ?>
                    <div class="caption"><?php the_content(); ?></div>
                </div>
				<?php
			}
			echo '</div>';
			echo '<script>
                    jQuery(document).ready(function(){
                        jQuery(".owl-carousel").owlCarousel({
                            loop:true,
                            margin:10,
                            autoplay: true,
                            autoplayTimeout: 3000,
                            responsiveClass:true,
                            responsive:{
                                0:{
                                    items:1,
                                    nav:false
                                },
                                600:{
                                    items:1,
                                    nav:false
                                },
                                1000:{
                                    items:1,
                                    nav:false,
                                    loop:true
                                }
                            },
                        });
                    });
                    </script>';
		}
	}
}

