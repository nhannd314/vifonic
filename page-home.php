<?php
/**
 * Template name: Homepage
 */
get_header();
?>

<main class="main main-page page-home full-width">
	<div class="container-fluid">
		<section class="content" role="main">

			<?php
			if (have_posts()):
				while (have_posts()):
					the_post(); ?>

                    <section id="section_CoursesList" class="vifonic-section" style="background-color: #F3F3F3;">
                        <?php
                        //Call function
                        vifonic_title("KHÓA HỌC NHA KHOA", "Các khóa học Nha Khoa nổi bật");
                        vifonic_show_list_courses_by_category("dao-tao-nha-khoa", 8);
                        vifonic_button('XEM TẤT CẢ');
                        ?>
                    </section>

                    <section id="section_CoursesList" class="vifonic-section">
                        <?php
                        //Call function
                        vifonic_title("KHÓA HỌC NHA KHOA", "Các khóa học Nha Khoa nổi bật");
                        vifonic_show_list_courses_by_category("dao-tao-nha-khoa", 8);
                        vifonic_button('XEM TẤT CẢ', 'center', true);
                        ?>
                    </section>

					<div class="post-content clearfix"><?php the_content() ?></div>
					<?php if (get_field('show_comment') == 1) vifonic_comment_facebook(get_the_permalink()) ?>

				<?php endwhile;
			else:
				get_template_part('content', 'none');
			endif;
			?>

		</section>
	</div>
</main><!--/ main -->

<?php get_footer(); ?>