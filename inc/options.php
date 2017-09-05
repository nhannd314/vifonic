<?php
/**
 * Created by PhpStorm.
 * User: nhansay
 * Date: 12/06/2015
 * Time: 16:53
 */

if ( ! class_exists( 'Vifonic_theme_options' ) ) {

    class Vifonic_theme_options {

        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        /* Load Redux Framework */
        public function __construct() {

            if ( ! class_exists( 'ReduxFramework' ) ) {
                return;
            }

            if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                $this->initSettings();
            } else {
                add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
            }

        }

        public function initSettings() {

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                return;
            }

            $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
        }

        /**
        Thiết lập cho method setAgruments
        Method này sẽ chứa các thiết lập cơ bản cho trang Options Framework như tên menu chẳng hạn
         **/
        public function setArguments() {
            $theme = wp_get_theme(); // Lưu các đối tượng trả về bởi hàm wp_get_theme() vào biến $theme để làm một số việc tùy thích.
            $this->args = array(
                // Các thiết lập cho trang Options
                'opt_name'  => 'vifonic_options', // Tên biến trả dữ liệu của từng options, ví dụ: tp_options['field_1']
                'display_name' => $theme->get( 'Name' ), // Thiết lập tên theme hiển thị trong Theme Options
                'menu_type'          => 'menu',
                'allow_sub_menu'     => true,
                'menu_title'         => __('Theme options', 'vifonic'),
                'page_title'         => __('Theme options', 'vifonic'),
                'dev_mode' => false,
                'customizer' => true,
                'menu_icon' => '', // Đường dẫn icon của menu option
                // Chức năng Hint tạo dấu chấm hỏi ở mỗi option để hướng dẫn người dùng */
                'hints'              => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'   => 'light',
                        'shadow'  => true,
                        'rounded' => false,
                        'style'   => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show' => array(
                            'effect'   => 'slide',
                            'duration' => '500',
                            'event'    => 'mouseover',
                        ),
                        'hide' => array(
                            'effect'   => 'slide',
                            'duration' => '500',
                            'event'    => 'click mouseleave',
                        ),
                    ),
                ) // end Hints
            );
        } // end setArguments function

        /**
        Thiết lập khu vực Help để hướng dẫn người dùng
         **/
        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'      => 'redux-help-tab-1',
                'title'   => 'Documentation',
                'content' => '<p>I will write the documentation soon!</p>'
            );

            $this->args['help_tabs'][] = array(
                'id'      => 'redux-help-tab-2',
                'title'   => 'Google Fonts',
                'content' => '<p>To use Google fonts please set up by your code. Thanks so much!</p>'
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = '<p>It is so easy to custom your theme with theme options!</p>';
        } // end setHelpTabs function

        /**
        Thiết lập từng phần trong khu vực Theme Options
        mỗi section được xem như là một phân vùng các tùy chọn
        Trong mỗi section có thể sẽ chứa nhiều field
         **/
        public function setSections() {

            // Section General
            $this->sections[] = array(
                'title'  => __('General', 'vifonic'),
                'desc'   => __('General Settings', 'vifonic'),
                'icon'   => 'el-icon-home',
                'fields' => array(
                    array(
                        'id'       => 'site_favicon',
                        'type'     => 'media',
                        'title'    => 'Site favicon',
                        'desc'     => 'Site favicon',
                        'readonly' => false,
                        'url'      => true,
                        'default'  => array(
                            'url' => get_template_directory_uri().'/img/icon.ico'
                        )
                    ),
                    array(
                        'id'       => 'site_logo',
                        'type'     => 'media',
                        'title'    => 'Site logo',
                        'desc'     => 'Site logo',
                        'readonly' => false,
                        'url'      => true,
                        'default'  => array(
                            'url' => get_template_directory_uri().'/img/logo.png'
                        )
                    )
                )
            ); // end section

	        // Section Header
            $this->sections[] = array(
                'title'  => __('Header', 'vifonic'),
                'desc'   => __('Header Settings', 'vifonic'),
                'icon'   => 'el-icon-website',
                'fields' => array(

	                //Breadcrumb Background
	                array(
		                'id'       => 'breadcrumb-bg',
		                'type'     => 'background',
		                'title'    => __('Breadcrumb Background', 'vifonic'),
		                'desc'     => __('Breadcrumb background with image, color, etc.', 'vifonic'),
		                'background-color' => false,
		                'background-repeat' => false,
		                'background-attachment' => false,
		                'background-clip' => false,
		                'background-origin' => false,
		                'default'  => array(
			                'background-position' => 'center center',
			                'background-size' => 'cover',
		                )
	                )
                )
            ); // end section

	        // Section Footer
            $this->sections[] = array(
                'title'  => __('Footer', 'vifonic'),
                'desc'   => __('Footer Settings', 'vifonic'),
                'icon'   => 'el-icon-website',
                'fields' => array(
                	//Footer Column
	                array(
		                'id'       => 'footer-col',
		                'type'     => 'radio',
		                'title'    => __('Footer Column', 'vifonic'),
		                'desc'     => __('Select the number of column in footer.', 'vifonic'),
		                'options'  => array(
			                '1' => '1 '.__('Column', 'vifonic'),
			                '2' => '2 '.__('Column', 'vifonic'),
			                '3' => '3 '.__('Column', 'vifonic'),
			                '4' => '4 '.__('Column', 'vifonic'),
		                ),
		                'default' => '3',
	                ),

	                //Footer Background
	                array(
		                'id'       => 'footer-bg',
		                'type'     => 'background',
		                'title'    => __('Footer Background', 'vifonic'),
		                'desc'     => __('Footer background with image, color, etc.', 'vifonic'),
		                'background-color' => false,
		                'background-repeat' => false,
		                'background-attachment' => false,
		                'background-clip' => false,
		                'background-origin' => false,
		                'default'  => array(
			                'background-position' => 'center center',
			                'background-size' => 'cover',
		                )
	                )
                )
            ); // end section
	        // Section Social Network
            $this->sections[] = array(
                'title'  => __('Social Network', 'vifonic'),
                'desc'   => __('Social Network Settings', 'vifonic'),
                'icon'   => 'el-icon-network',
                'fields' => array(
                	//Facebook
	                array(
		                'id'       => 'social-fb',
		                'type'     => 'text',
		                'title'    => __('Facebook', 'vifonic'),
		                'validate' => 'url',
		                'msg'      => __('Url ivalid', 'vifonic'),
		                'default'  => 'https://www.facebook.com/'
	                ),

	                //Google+
	                array(
		                'id'       => 'social-gplus',
		                'type'     => 'text',
		                'title'    => __('Google+', 'vifonic'),
		                'validate' => 'url',
		                'msg'      => __('Url ivalid', 'vifonic'),
		                'default'  => 'https://plus.google.com/'
	                ),
	                //Youtube
	                array(
		                'id'       => 'social-ytb',
		                'type'     => 'text',
		                'title'    => __('Youtube', 'vifonic'),
		                'validate' => 'url',
		                'msg'      => __('Url ivalid', 'vifonic'),
		                'default'  => 'https://www.youtube.com/'
	                ),
	                //Zalo
	                array(
		                'id'       => 'social-zalo',
		                'type'     => 'text',
		                'title'    => __('Zalo', 'vifonic'),
		                'validate' => 'url',
		                'msg'      => __('Url ivalid', 'vifonic'),
		                'default'  => 'http://zalo.me/0123456789'
	                ),

                )
            ); // end section

        }

    } // end My_theme_option class

    global $reduxConfig;
    $reduxConfig = new Vifonic_theme_options();

}