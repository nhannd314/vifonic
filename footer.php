<?php
/**
 * The template for displaying the footer.
 */
global $vifonic_options;

$footer_bg_image =  $vifonic_options['footer-bg']['background-image'];
$footer_bg_position =  $vifonic_options['footer-bg']['background-position'];
$footer_bg_size =  $vifonic_options['footer-bg']['background-size'];
?>

<footer id="footer" style="background-image:url('<?php echo $footer_bg_image; ?>');background-position: <?php echo $footer_bg_position; ?>;background-size: <?php echo $footer_bg_size; ?>">
    <div class="footer-wrapper" style="background-color: rgba(0, 0, 0, 0.5);">
        <div class="vifonic_email_subcribe">
            <div class="container">
			    <?php echo do_shortcode('[contact-form-7 id="43" title="Email Subcribe"]'); ?>
            </div>
        </div>
        <div class="footer-1">
            <div class="container">
                <div class="row">
				    <?php
				    $footer_col = $vifonic_options['footer-col'];
				    if ($footer_col == 1){
					    $col_class = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
				    } elseif ($footer_col == 2){
					    $col_class = 'col-xs-12 col-sm-6 col-md-6 col-lg-6';
				    } elseif ($footer_col == 3){
					    $col_class = 'col-xs-12 col-sm-6 col-md-4 col-lg-4';
				    } elseif ($footer_col == 4){
					    $col_class = 'col-xs-12 col-sm-6 col-md-3 col-lg-3';
				    }

				    for ($i = 1; $i <= $footer_col; $i++){
					    echo '<div class="'.$col_class.'">';
					    dynamic_sidebar('sidebar-footer-'.$i);
					    if ($i == 1) {
					        echo do_shortcode('[vifonic_social_follow]');
                        }
					    echo '</div>';
				    }
				    ?>
                </div>
            </div>
        </div>
        <!--. /footer-1 -->
        <div class="footer-2">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 footer-2-left">
                        <p class="copyright text-left">© <?php echo date("Y")." ".get_bloginfo('name'); ?>. All rights reserved</p>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 footer-2-right">

                    </div>
                </div>
            </div>
        </div>
        <!--. /footer-2 -->
        <div class="container copyright text-center" style="display: none;">
            <h2><a style="font-size: 14px; margin: 0" href="https://webdep247.vn/">Thiết kế web giá rẻ, website giá rẻ</a></h2>
            <p>
                <!-- DMCA -->
                <a href="http://www.dmca.com/Protection/Status.aspx?ID=9fccbafc-2c62-4b25-b484-6feb2da59435" title="DMCA.com Protection Status" class="dmca-badge"> <img src="//images.dmca.com/Badges/dmca_protected_sml_120am.png?ID=9fccbafc-2c62-4b25-b484-6feb2da59435" alt="DMCA.com Protection Status"></a> <script src="//images.dmca.com/Badges/DMCABadgeHelper.min.js"> </script>
                <!-- /DMCA -->
            </p>
        </div>
    </div>

</footer>

<div id="up-to-top">
    <i class="fa fa-angle-up"></i>
</div>

<?php //echo $vifonic_options['right-support'] ?>

<!-- facebook sdk -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10&appId=355627444798303";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic&subset=latin,vietnamese' rel='stylesheet' type='text/css'>

<?php wp_footer(); ?>

</body>
</html>
