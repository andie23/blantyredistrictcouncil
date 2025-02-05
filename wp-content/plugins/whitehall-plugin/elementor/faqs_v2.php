<?php namespace WHITEHALLPLUGIN\Element;

use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Border;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Plugin;

/**
 * Elementor button widget.
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Faqs_V2 extends Widget_Base {

    /**
     * Get widget name.
     * Retrieve button widget name.
     *
     * @since  1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name() {
        return 'whitehall_faqs_v2';
    }

    /**
     * Get widget title.
     * Retrieve button widget title.
     *
     * @since  1.0.0
     * @access public
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('Faqs V2', 'whitehall');
    }

    /**
     * Get widget icon.
     * Retrieve button widget icon.
     *
     * @since  1.0.0
     * @access public
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'fa fa-briefcase';
    }

    /**
     * Get widget categories.
     * Retrieve the list of categories the button widget belongs to.
     * Used to determine where to display the widget in the editor.
     *
     * @since  2.0.0
     * @access public
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'whitehall' ];
    }

    /**
     * Register button widget controls.
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function _register_controls() {
        $this->start_controls_section(
            'general_tab',
            [
                'label' => esc_html__('General', 'whitehall'),
            ]
        );
		$this->add_control(
            'subtitle',
            [
                'label'       => __( 'Sub Title', 'whitehall' ),
                'type'        => Controls_Manager::TEXT,
				'label_block' => true,
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );
        $this->add_control(
            'title',
            [
                'label'       => __( 'Title', 'whitehall' ),
                'type'        => Controls_Manager::TEXTAREA,
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );
		$this->end_controls_section();
		
		//Faqs Sidebar
        $this->start_controls_section(
            'faqs_sidebar_tab',
            [
                'label' => esc_html__('Faqs Sidebar', 'whitehall'),
            ]
        );
		$this->add_control(
            'slides',
            [
                'label'   => esc_html__( 'Features', 'whitehall' ),
                'type' => Controls_Manager::REPEATER,
				'separator' => 'before',
                'default' =>
                    [

                    ],
                'fields' =>
                    [
                        [
                            'name' => 'title',
                            'label' => esc_html__('Title', 'whitehall'),
                            'type' => Controls_Manager::TEXT,
							'label_block' => true,
                        ],
						[
                            'name' => 'icon',
                            'label' => esc_html__('Select Icon', 'whitehall'),
                            'type' => Controls_Manager::SELECT2,
							'label_block' => true,
                            'options' => get_fontawesome_icons(),
                        ],
                        [
                            'name' => 'number',
                            'label' => esc_html__('Number', 'whitehall'),
                            'type' => Controls_Manager::TEXT,
							'label_block' => true,
                        ],
						[
                            'name' => 'text',
                            'label' => esc_html__('Phone Text', 'whitehall'),
                            'type' => Controls_Manager::TEXTAREA,
                        ],
						[
                            'name' => 'btn_title',
                            'label' => esc_html__('Button Title', 'whitehall'),
                            'type' => Controls_Manager::TEXT,
							'label_block' => true,
                        ],
                        [
                            'name' => 'btn_link',
                            'label' => esc_html__('Button Link', 'whitehall'),
                            'type' => Controls_Manager::URL,
                            'placeholder' => __( 'https://your-link.com/', 'whitehall' ),
                            'show_external' => true,
                            'default' => [
                                'url' => '',
                                'is_external' => true,
                                'nofollow' => true,
                            ],
                        ],
                    ],
            ]
        );
        $this->end_controls_section();
		
		//FAQs
		$this->start_controls_section(
            'faqs_tab',
            [
                'label' => esc_html__('Faqs', 'whitehall'),
            ]
        );
        $this->add_control(
            'query_number',
            [
                'label'   => esc_html__('Number of Post', 'whitehall'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 8,
                'min'     => 1,
                'max'     => 100,
                'step'    => 1,
            ]
        );
        $this->add_control(
            'query_orderby',
            [
                'label'   => esc_html__('Order By', 'whitehall'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => array(
                    'date'       => esc_html__('Date', 'whitehall'),
                    'title'      => esc_html__('Title', 'whitehall'),
                    'menu_order' => esc_html__('Menu Order', 'whitehall'),
                    'rand'       => esc_html__('Random', 'whitehall'),
                ),
            ]
        );
        $this->add_control(
            'query_order',
            [
                'label'   => esc_html__('Order', 'whitehall'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'ASC',
                'options' => array(
                    'DESC' => esc_html__('DESC', 'whitehall'),
                    'ASC'  => esc_html__('ASC', 'whitehall'),
                ),
            ]
        );
        $this->add_control(
            'query_category',
            [
                'label' => esc_html__('Category', 'whitehall'),
                'type' => Controls_Manager::SELECT,
                'options' => get_categories_list('faqs_cat')
            ]
        );
        $this->end_controls_section();
		
		//Faqs Form
		$this->start_controls_section(
            'faqs_form',
            [
                'label' => esc_html__( 'Faqs Form', 'whitehall' ),
            ]
        );
		$this->add_control(
            'subtitle1',
            [
                'label'       => __( 'Sub Title', 'whitehall' ),
                'type'        => Controls_Manager::TEXT,
				'label_block' => true,
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );
        $this->add_control(
            'title1',
            [
                'label'       => __( 'Title', 'whitehall' ),
                'type'        => Controls_Manager::TEXTAREA,
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );
		$this->add_control(
            'cf7_shortocde',
            [
                'label' => esc_html__('Select Contact Form 7', 'whitehall'),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'options' => get_contact_form_7_list(),
            ]
        );
        $this->end_controls_section();
    }

    /**
     * Render button widget output on the frontend.
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $allowed_html = wp_kses_allowed_html('post');

        $paged = whitehall_set($_POST, 'paged') ? esc_attr($_POST['paged']) : 1;

        $this->add_render_attribute('wrapper', 'class', 'themerange-whitehall');
        $args = array(
            'post_type'      => 'faqs',
            'posts_per_page' => whitehall_set($settings, 'query_number'),
            'orderby'        => whitehall_set($settings, 'query_orderby'),
            'order'          => whitehall_set($settings, 'query_order'),
            'paged'          => $paged
        );

        if( whitehall_set($settings, 'query_category') ) $args['faqs_cat'] = whitehall_set($settings, 'query_category');
        $query = new \WP_Query($args);

        if($query->have_posts()) { ?>

		<!-- faq-page-section -->
        <section class="faq-page-section faq-section sec-pad">
            <div class="auto-container">
                <div class="sec-title centred">
					<?php if($settings['subtitle']){ ?>
					<h6><i class="flaticon-star"></i><span><?php echo wp_kses( $settings['subtitle'], true ); ?></span><i class="flaticon-star"></i></h6>
					<?php } ?>

					<?php if($settings['title']){ ?>
					<h2><?php echo wp_kses( $settings['title'], true ); ?></h2>
					<div class="title-shape"></div>
					<?php } ?>
                </div>
                <div class="row clearfix">
                    <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
                        <div class="faq-sidebar">
                            <?php foreach($settings['slides'] as $key => $item) { ?>
                            <div class="single-item">
                                <span><?php echo wp_kses( $item['number'], true ); ?></span>
                                <div class="icon-box"><i class="<?php echo esc_attr( $item['icon'] ); ?>"></i></div>
                                <h4><?php echo wp_kses( $item['title'], true ); ?></h4>
                                <p><?php echo wp_kses( $item['text'], true ); ?></p>
								
								
                                <a href="faq.html">View faq’s<i class="flaticon-right-arrow"></i></a>
                            </div>
							<?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12 col-sm-12 content-side">
                        <ul class="accordion-box">
                            <?php $i=1; while ($query->have_posts() ) : $query->the_post(); ?>
							<li class="accordion block <?php if($i == 1) echo 'active-block'; ?>">
                                <div class="acc-btn <?php if($i == 1) echo 'active'; ?>">
                                    <div class="icon-outer"></div>
                                    <h5><span><?php echo wp_kses(sprintf('%02d', $i), true); ?>. </span><?php the_title(); ?></h5>
                                </div>
                                <div class="acc-content <?php if($i == 1) echo 'current'; ?>">
                                    <div class="text">
                                        <?php the_content(); ?>
                                    </div>
                                </div>
                            </li>
							<?php $i++; endwhile; ?>
                        </ul>
                        <div class="form-inner">
                            <div class="text">
                                <h3><?php echo wp_kses( $settings['subtitle1'], true ); ?></h3>
                                <p><?php echo wp_kses( $settings['title1'], true ); ?></p>
                            </div>
							
							<?php if($settings['cf7_shortocde']){ ?>
                            <div class="question-form">
								<?php echo do_shortcode('[contact-form-7 id="'.esc_attr($settings['cf7_shortocde']).'"]'); ?>
                            </div>
							<?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- faq-page-section end -->

        <?php }

        wp_reset_postdata();
    }
}
