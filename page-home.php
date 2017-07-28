<?php
/**
 * Template name: Homepage
 */
get_header();

vifonic_slider();
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
                        ?>
                    </section>

                    <section id="section_CoursesList" class="vifonic-section">
                        <?php
                        //Call function
                        vifonic_title("KHÓA HỌC ĐA KHOA", "Các khóa học Đa Khoa nổi bật");
                        vifonic_show_list_courses_by_category("dao-tao-nha-khoa", 8);
                        ?>
                    </section>

                    <section id="section_CoursesList" class="vifonic-section">
						<?php
						//Call function
						vifonic_title("PHỤC HỒI CHỨC NĂNG", "Các khóa học Phục hồi chức năng nổi bật");
						vifonic_show_list_courses_by_category("dao-tao-nha-khoa", 8);
						?>
                    </section>

                    <section id="section_CoursesList" class="vifonic-section">
						<?php
						//Call function
						vifonic_title("KHÓA HỌC Y KHOA MIẾN PHÍ", "Các khóa học Y Khoa miễn phí nổi bật");
						vifonic_show_list_courses_by_category("dao-tao-nha-khoa", 8);
						?>
                    </section>

                    <section class="vifonic-section">
                        <div class="container">
                            <div class="row reason_row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 20px;">
                                    <?php vifonic_title("Tại sao chọn chúng tôi"); ?>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2">
                                    <i class="fa fa-wifi" aria-hidden="true"></i>
                                    <h4>Học trực tuyến</h4>
                                    <p>mọi lức mọi nới</p>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2">
                                    <i class="fa fa-money" aria-hidden="true"></i>
                                    <h4>Tiết kiệm chi phí</h4>
                                    <p>giá quá rẻ so với học offline</p>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2">
                                    <i class="fa fa-undo" aria-hidden="true"></i>
                                    <h4>Hoàn tiền</h4>
                                    <p>nếu không lòng</p>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2">
                                    <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                    <h4>Thanh toán một lần</h4>
                                    <p>học trọn đời</p>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2">
                                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                    <h4>Trách nhiệm</h4>
                                    <p>test kiểm tra năng lực sau khóa học</p>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2">
                                    <i class="fa fa-comments-o" aria-hidden="true"></i>
                                    <h4>Hỗ trợ</h4>
                                    <p>hỗ trợ và giải đáp trong quá trình học</p>
                                </div>
                            </div>
                        </div>
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