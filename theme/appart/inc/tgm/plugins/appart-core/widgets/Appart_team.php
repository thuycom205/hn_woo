<?php
namespace AppartCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use WP_Query;



// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}



/**
 * Text Typing Effect
 *
 * Elementor widget for text typing effect.
 *
 * @since 1.7.0
 */
class Appart_team extends Widget_Base {

    public function get_name() {
        return 'appart_team';
    }

    public function get_title() {
        return __( 'Team', 'appart-core' );
    }

    public function get_icon() {
        return ' eicon-person';
    }

    public function get_categories() {
        return [ 'appart-elements' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'title_sec', [
                'label' => __( 'Title section', 'appart-core' ),
            ]
        );
        $this->add_control(
            'title_text', [
                'label' => esc_html__( 'Title text', 'appart-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Our Team'
            ]
        );
        $this->add_control(
            'color_title', [
                'label' => __( 'Text Color', 'appart-core' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .title-four h2' => 'color: {{VALUE}};',
                ],
                'default' => '#1a264a'
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'typography_title',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .title-four h2',
            ]
        );
        $this->end_controls_section();

        /**-------------------------------- Subtitle ------------------------------------  */
        $this->start_controls_section(
            'subtitle_sec', [
                'label' => __( 'Subtitle section', 'appart-core' ),
            ]
        );
        $this->add_control(
            'subtitle_text', [
                'label' => esc_html__( 'Subtitle text', 'appart-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default' => 'Explore Our team'
            ]
        );
        $this->add_control(
            'color_subtitle', [
                'label' => __( 'Text Color', 'appart-core' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .title-four p' => 'color: {{VALUE}};',
                ],
                'default' => '#585e68'
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'typography_subtitle',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .title-four p',
            ]
        );
        $this->end_controls_section();


        // ------------------------------ Team Members ------------------------------
        $this->start_controls_section(
            'team', [
                'label' => __( 'Team', 'appart-core' ),
            ]
        );
        $this->add_control(
            'members', [
                'label' => __( 'Team Members', 'appart-core' ),
                'type' => Controls_Manager::REPEATER,
                'title_field' => '{{{ name }}}',
                'fields' => [
                    [
                        'name' => 'name',
                        'label' => esc_html__('Member Name', 'appart-core'),
                        'type' => Controls_Manager::TEXT,
                        'default' => 'Eh Jewel',
                    ],
                    [
                        'name' => 'profile_pic',
                        'type' =>  Controls_Manager::MEDIA,
                        'label' => esc_html__('Profile picture', 'appart-core'),
                    ],
                    [
                        'name' => 'designation',
                        'type' => Controls_Manager::TEXT,
                        'label' => esc_html__('Designation', 'appart-core'),
                        'default' => 'CTO @ DroitLab'
                    ],
                    [
                        'name' => 'about',
                        'type' => Controls_Manager::TEXTAREA,
                        'label' => esc_html__('About text', 'appart-core'),
                        'default' => 'Nullam dictum sapien vitae lorem ultr varius. Nulla volutpat nisl augue Proin vehicula mauris.'
                    ],
                    [
                        'name' => 'fb',
                        'type' => Controls_Manager::URL,
                        'label' => esc_html__('Facebook URL', 'appart-core'),
                        'default' => [
                            'url' => '#'
                        ]
                    ],
                    [
                        'name' => 'twitter',
                        'type' => Controls_Manager::URL,
                        'label' => esc_html__('Twitter URL', 'appart-core'),
                        'default' => [
                            'url' => '#'
                        ]
                    ],
                    [
                        'name' => 'linkedin',
                        'type' => Controls_Manager::URL,
                        'label' => esc_html__('Linkedin URL', 'appart-core'),
                        'default' => [
                            'url' => '#'
                        ]
                    ],
                    [
                        'name' => 'pinterest',
                        'type' => Controls_Manager::URL,
                        'label' => esc_html__('Pinterest URL', 'appart-core'),
                        'default' => [
                            'url' => '#'
                        ]
                    ],
                ],
            ]
        );
        $this->end_controls_section();

        //------------------------------ Style Section ------------------------------
        $this->start_controls_section(
            'style_section', [
                'label' => __( 'Style section', 'appart-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'column', [
                'label' => __( 'Columns', 'appart-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => '4',
                'options' => [
                    '2' => 'Six',
                    '4' => 'Three',
                    '3' => 'Four',
                    '6' => 'Two'
                ]
            ]
        );
        $this->add_control(
            'sec_padding', [
                'label' => __( 'Section padding', 'appart-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .team_area_solid' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '120',
                    'right' => '0',
                    'bottom' => '120',
                    'left' => '0',
                    'unit' => 'px', // The selected CSS Unit. 'px', '%', 'em',
                    'isLinked' => false,
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings();
        $members = !empty($settings['members']) ? $settings['members'] : '';
        ?>
        <section class="team_area_solid feature-bg">
            <div class="container">
                <div class="title-four text-center">
                    <?php if(!empty($settings['title_text'])) : ?>
                        <h2> <?php echo $settings['title_text'] ?> </h2>
                    <?php endif; ?>
                    <?php if(!empty($settings['subtitle_text'])) : ?>
                        <p> <?php echo $settings['subtitle_text']; ?> </p>
                    <?php endif; ?>
                </div>
                <div class="row">
                    <?php
                    if(is_array($members)) {
                    foreach ($members as $member) {
                        ?>
                        <div class="col-md-<?php echo $settings['column'] ?> col-sm-6">
                            <div class="team_member">
                                <?php if(!empty($member['profile_pic']['url'])): ?>
                                <img src="<?php echo $member['profile_pic']['url'] ?>" alt="<?php echo $member['name'] ?>">
                                <?php endif; ?>
                                <div class="content">
                                    <?php if(!empty($member['name'])) : ?>
                                        <h2><?php echo $member['name'] ?></h2>
                                    <?php endif; ?>
                                    <?php if(!empty($member['designation'])) : ?>
                                        <h6><?php echo $member['designation'] ?></h6>
                                    <?php endif; ?>
                                    <p> <?php echo $member['about'] ?> </p>
                                    <div class="social">
                                        <?php if(!empty($member['fb'])) : ?>
                                            <a href="<?php echo esc_url($member['fb']['url']) ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                        <?php endif; ?>
                                        <?php if(!empty($member['twitter'])) : ?>
                                            <a href="<?php echo esc_url($member['twitter']['url']) ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                        <?php endif; ?>
                                        <?php if(!empty($member['linkedin'])) : ?>
                                            <a href="<?php echo esc_url($member['linkedin']['url']) ?>"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                                        <?php endif; ?>
                                        <?php if(!empty($member['pinterest'])) : ?>
                                            <a href="<?php echo $member['pinterest']['url'] ?>"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }}
                    ?>
                </div>
            </div>
        </section>
        <?php
    }
}