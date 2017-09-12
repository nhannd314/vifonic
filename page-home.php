<?php
/**
 * Template name: Homepage
 */
get_header();

//echo do_shortcode('[rev_slider alias="main-slider"]');
vifonic_slider();
?>

<main class="main main-page page-home full-width">
	<div class="container-fluid">
		<section class="content" role="main">

			<?php
			if (have_posts()):
				while (have_posts()):
					the_post(); ?>

                    <?php

                    ?>
                    <section class="vifonic-section" style="padding-bottom: 0;">
                        <?php
                        //Call function
                        vifonic_title("KHÓA HỌC MUA NHIỀU NHẤT", "Các khóa học bán chạy nhất");
                        vifonic_show_best_selling_course_list('slider');
                        ?>
                    </section>

                    <section class="vifonic-section">
                        <?php
                        //Call function
                        vifonic_title("KHÓA HỌC NHA KHOA", "Các khóa học Nha Khoa nổi bật");
                        vifonic_show_list_courses_by_category("dao-tao-nha-khoa", 8);
                        ?>
                    </section>

                    <section class="vifonic-section">
                        <?php
                        //Call function
                        vifonic_title("KHÓA HỌC ĐA KHOA", "Các khóa học Đa Khoa nổi bật");
                        vifonic_show_list_courses_by_category("dao-tao-nha-khoa", 8);
                        ?>
                    </section>

                    <section class="vifonic-section">
						<?php
						//Call function
						vifonic_title("PHỤC HỒI CHỨC NĂNG", "Các khóa học Phục hồi chức năng nổi bật");
						vifonic_show_list_courses_by_category("dao-tao-nha-khoa", 8);
						?>
                    </section>

                    <section class="vifonic-section">
						<?php
						//Call function
						vifonic_title("KHÓA HỌC Y KHOA MIẾN PHÍ", "Các khóa học Y Khoa miễn phí nổi bật");
						vifonic_show_list_courses_by_category('', 8, true);
						?>
                    </section>

                    <section class="vifonic-section">
						<?php
						//Call function
						vifonic_title("DANH SÁCH GIẢNG VIÊN");
						vifonic_show_list_teacher(8);
						?>
                    </section>

                    <section class="vifonic-section">
                        <div class="container">
                            <div class="row reason_row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 20px;">
                                    <?php vifonic_title("Tại sao chọn chúng tôi"); ?>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2">
                                    <div class="wrap">
                                        <i class="fa fa-wifi" aria-hidden="true"></i>
                                        <h4>Học trực tuyến</h4>
                                        <p>Học mọi lúc mọi nơi, chủ động công việc</p>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2">
                                    <div class="wrap">
                                        <i class="fa fa-dollar" aria-hidden="true"></i>
                                        <h4>Tiết kiệm chi phí</h4>
                                        <p>Quá rẻ so với học Offline tại trung tâm</p>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2">
                                    <div class="wrap">
                                        <i class="fa fa-reply" aria-hidden="true"></i>
                                        <h4>Hoàn tiền</h4>
                                        <p>Nếu cảm thấy không hài lòng về khóa học</p>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2">
                                    <div class="wrap">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                        <h4>Thanh toán một lần</h4>
                                        <p>Thanh toán một lần, học trọn đời</p>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2">
                                    <div class="wrap">
                                        <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                        <h4>Trách nhiệm</h4>
                                        <p>Test kiểm tra năng lực sau khóa học</p>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2">
                                    <div class="wrap">
                                        <i class="fa fa-comments-o" aria-hidden="true"></i>
                                        <h4>Hỗ trợ</h4>
                                        <p>Hỗ trợ và giải đáp trong quá trình học</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

					<div class="post-content clearfix"><?php the_content() ?></div>
					<?php if (get_field('show_comment') == 1) vifonic_comment_facebook(get_the_permalink()) ?>

				<?php endwhile;
			else:
				get_template_part('templates/loop/content', 'none');
			endif;
			?>

		</section>
	</div>
</main><!--/ main -->

<?php get_footer(); ?>