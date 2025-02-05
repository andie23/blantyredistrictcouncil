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
class Blog_V2 extends Widget_Base {

    /**
     * Get widget name.
     * Retrieve button widget name.
     *
     * @since  1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name() {
        return 'whitehall_blog_v2';
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
        return esc_html__( 'Blog V2', 'whitehall' );
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
            'blog_v2',
            [
                'label' => esc_html__( 'Blog V2', 'whitehall' ),
            ]
        );
		$this->add_control(
            'bg_image',
            [
                'label' => __( 'Background Image', 'whitehall' ),
                'type' => Controls_Manager::MEDIA,
                'default' => ['url' => Utils::get_placeholder_image_src(),],
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
        $this->add_control(
            'query_number',
            [
                'label'   => esc_html__( 'Number of post', 'whitehall' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 3,
                'min'     => 1,
                'max'     => 100,
                'step'    => 1,
            ]
        );
        $this->add_control(
            'query_orderby',
            [
                'label'   => esc_html__( 'Order By', 'whitehall' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => array(
                    'date'       => esc_html__( 'Date', 'whitehall' ),
                    'title'      => esc_html__( 'Title', 'whitehall' ),
                    'menu_order' => esc_html__( 'Menu Order', 'whitehall' ),
                    'rand'       => esc_html__( 'Random', 'whitehall' ),
                ),
            ]
        );
        $this->add_control(
            'query_order',
            [
                'label'   => esc_html__( 'Order', 'whitehall' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'ASC',
                'options' => array(
                    'DESC' => esc_html__( 'DESC', 'whitehall' ),
                    'ASC'  => esc_html__( 'ASC', 'whitehall' ),
                ),
            ]
        );
        $this->add_control(
            'query_category',
            [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Category', 'whitehall'),
                'options' => get_categories_list(),
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
        $allowed_tags = wp_kses_allowed_html('post');

        $paged = whitehall_set($_POST, 'paged') ? esc_attr($_POST['paged']) : 1;

        $this->add_render_attribute( 'wrapper', 'class', 'templatepath-whitehall' );
        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => whitehall_set( $settings, 'query_number' ),
            'orderby'        => whitehall_set( $settings, 'query_orderby' ),
            'order'          => whitehall_set( $settings, 'query_order' ),
            'paged'          => $paged
        );

        if( whitehall_set( $settings, 'query_category' ) ) $args['category_name'] = whitehall_set( $settings, 'query_category' );
        $query = new \WP_Query( $args );
        $i=1;
        if ( $query->have_posts() ) { ?>
        
		<!-- news-style-two -->
        <section class="news-style-two sec-pad pb-140">
            <div class="pattern-layer" style="background-image: url(<?php echo wp_get_attachment_url($settings['bg_image']['id']); ?>);"></div>
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
                    <?php while ( $query->have_posts() ) : $query->the_post();
					$term_list = wp_get_post_terms(get_the_id(), 'category', array("fields" => "names")); ?>
                    <div class="col-lg-4 col-md-6 col-sm-12 news-block">
                        <div class="news-block-two wow fadeInUp animated animated" data-wow-delay="400ms" data-wow-duration="1500ms">
                            <div class="inner-box">
                                <figure class="image-box"><?php the_post_thumbnail('whitehall_370x455'); ?></figure>
                                <div class="content-box">
                                    <div class="category"><a href="javascript:;"><i class="flaticon-star"></i><?php echo implode( ', ', (array)$term_list ); ?></a></div>
                                    <div class="text">
                                        <div class="post-date"><h3><?php echo get_the_date('d'); ?><span><?php echo get_the_date('M'); ?>’<?php echo get_the_date('y'); ?></span></h3></div>
                                        <h4><a href="<?php echo esc_url(get_permalink(get_the_id())); ?>"><?php the_title(); ?></a></h4>
                                        <ul class="post-info clearfix">
                                            <li><i class="far fa-user"></i><a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) )); ?>"><?php the_author(); ?></a></li>
                                            <li><i class="far fa-comment"></i><a href="<?php echo esc_url(get_permalink(get_the_id()).'#comments'); ?>"><?php comments_number( '0 Comments', '1 Comment', '% Comments' ); ?></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
        <!-- news-style-two end -->

        <?php }

        wp_reset_postdata();
    }
}


