<?php
namespace AppartCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;



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
class Appart_screens_features extends Widget_Base {

    public function get_name() {
        return 'appart-screens-features';
    }

    public function get_title() {
        return __( 'Screens Features', 'appart-hero' );
    }

    public function get_icon() {
        return ' eicon-posts-group';
    }

    public function get_categories() {
        return [ 'appart-elements' ];
    }

    protected function _register_controls() {

        // ------------------------------  Title Section ------------------------------
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
                'default' => 'Data Analytics'
            ]
        );
        $this->end_controls_section(); // End title section

        // ------------------------------  Featured image ------------------------------
        $this->start_controls_section(
            'images_sec', [
                'label' => __( 'Featured images', 'appart-core' ),
            ]
        );
        $this->add_control(
            'images', [
                'label' => __( 'Images', 'appart-core' ),
                'type' => Controls_Manager::REPEATER,
                'title_field' => '{{{ title }}}',
                'fields' => [
                    [
                        'name' => 'title',
                        'label' => __( 'Image title', 'appart-core' ),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => true
                    ],
                    [
                        'name' => 'image',
                        'label' => __( 'Image', 'appart-core' ),
                        'type' => Controls_Manager::MEDIA,
                    ],
                    [
                        'name' => 'animation',
                        'label' => __( 'Animation', 'appart-core' ),
                        'type' => Controls_Manager::ANIMATION,
                        'default' => 'fadeInLeft'
                    ],
                    [
                        'name' => 'animation_duration',
                        'label' => __( 'Animation duration', 'appart-core' ),
                        'description' => __( 'Animation duration in second', 'appart-core' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => '0.3'
                    ],
                ]
            ]
        );
        $this->end_controls_section(); // End title section


        // ------------------------------ Feature list ------------------------------
        $this->start_controls_section(
            'feature_list', [
                'label' => __( 'Feature list', 'appart-core' ),
            ]
        );
        $this->add_control(
            'features', [
                'label' => __( 'Features list', 'appart-core' ),
                'type' => Controls_Manager::REPEATER,
                'title_field' => '{{{ title }}}',
                'fields' => [
                    [
                        'name' => 'title',
                        'label' => __( 'Feature title', 'appart-core' ),
                        'description' => __( 'Wrap up text with span tag (<span>Bold Text</span>) for bold text.', 'appart-core' ),
                        'type' => Controls_Manager::TEXTAREA,
                        'label_block' => true,
                        'default' => '<span>Beautiful design</span> to customize your storefront and showcase your products'
                    ],
                    [
                        'name' => 'icon_type',
                        'label' => __( 'Icon type', 'appart-core' ),
                        'type' => Controls_Manager::SELECT,
                        'options' => [
                            'ti_icon' => __( 'Thimify icon', 'appart-core' ),
                            'fontawesome_icon' => __( 'Font-awesome icon', 'appart-core' ),
                            'image_icon' => __( 'Image icon', 'appart-core' ),
                        ],
                        'default' => 'ti_icon',
                    ],
                    [
                        'name' => 'ti_icon',
                        'label' => __( 'Thimify icon', 'appart-core' ),
                        'type' => Controls_Manager::ICON,
                        'options' => appart_thimify_icons(),
                        'include' => appart_thimify_include_icons(),
                        'default' => 'ti-pie-chart',
                        'condition' => [
                            'icon_type' => 'ti_icon'
                        ]
                    ],
                    [
                        'name' => 'fontawesome_icon',
                        'label' => __( 'Social icon', 'appart-core' ),
                        'type' => Controls_Manager::ICON,
                        'include' => appart_font_awesome_icons_include(),
                        'default' => 'fa fa-check',
                        'condition' => [
                            'icon_type' => 'fontawesome_icon'
                        ]
                    ],
                    [
                        'name' => 'image_icon',
                        'label' => __( 'Image icon', 'appart-core' ),
                        'type' => Controls_Manager::MEDIA,
                        'condition' => [
                            'icon_type' => 'image_icon'
                        ]
                    ],
                ],
            ]
        );
        $this->end_controls_section();


        // ------------------------------Buttons -------------------------
        $this->start_controls_section(
            'buttons_sec', [
                'label' => __( 'Buttons', 'appart-core' ),
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'label' => __( 'Button font properties', 'appart-core' ),
                'name' => 'typography_buttons',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .promo-button .banner_btn, {{WRAPPER}} .promo-button .learn-btn',
            ]
        );
        $this->add_control(
            'buttons', [
                'label' => __( 'Create buttons', 'appart-core' ),
                'type' => Controls_Manager::REPEATER,
                'title_field' => '{{{ label }}}',
                'fields' => [
                    [
                        'name' => 'label',
                        'label' => __( 'Button name', 'appart-core' ),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => true,
                        'default' => 'Get app now'
                    ],
                    [
                        'name' => 'url',
                        'label' => __( 'Button URL', 'appart-core' ),
                        'type' => Controls_Manager::URL,
                        'default' => [
                            'url' => '#'
                        ]
                    ],
                    [
                        'name' => 'btn_style',
                        'label' => __( 'Button style', 'appart-core' ),
                        'type' => Controls_Manager::SELECT,
                        'default' => 'white',
                        'options' => [
                            'white' => 'White button',
                            'outline' => 'Outline button',
                            'custom' => 'Custom styled button',
                        ]
                    ],
                    [
                        'name' => 'bg_color',
                        'label' => __( 'Button background color', 'appart-core' ),
                        'type' => Controls_Manager::COLOR,
                        'default' => '#ffffff',
                        'condition' => [
                            'btn_style' => 'custom'
                        ]
                    ],
                    [
                        'name' => 'bg_hover_color',
                        'label' => __( 'Button background hover color', 'appart-core' ),
                        'type' => Controls_Manager::COLOR,
                        'default' => 'rgba(255,255,255,0)',
                        'condition' => [
                            'btn_style' => 'custom'
                        ]
                    ],
                    [
                        'name' => 'font_color',
                        'label' => __( 'Button font color', 'appart-core' ),
                        'type' => Controls_Manager::COLOR,
                        'default' => '#414141',
                        'condition' => [
                            'btn_style' => ['custom', 'outline']
                        ]
                    ],
                    [
                        'name' => 'font_hover_color',
                        'label' => __( 'Button font hover color', 'appart-core' ),
                        'type' => Controls_Manager::COLOR,
                        'default' => '#ffffff',
                        'condition' => [
                            'btn_style' => 'custom'
                        ]
                    ],
                    [
                        'name' => 'border_color',
                        'label' => __( 'Button border color', 'appart-core' ),
                        'type' => Controls_Manager::COLOR,
                        'default' => '#ffffff',
                        'condition' => [
                            'btn_style' => 'custom'
                        ]
                    ],
                    [
                        'name' => 'border_hover_color',
                        'label' => __( 'Button border hover color', 'appart-core' ),
                        'type' => Controls_Manager::COLOR,
                        'default' => '#ffffff',
                        'condition' => [
                            'btn_style' => 'custom'
                        ]
                    ],

                ],
            ]
        );
        $this->end_controls_section(); // End Buttons


        /**
         * Style Tab
         * ------------------------------ Style Title ------------------------------
         *
         */
        $this->start_controls_section(
            'style_title', [
                'label' => __( 'Style section title', 'appart-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'color_prefix', [
                'label' => __( 'Text Color', 'appart-core' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .app-promo-content h2' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .app-promo-content-two h2' => 'color: {{VALUE}};',
                ],
                'default' => '#1a264a'
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'typography_prefix',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .app-promo-content h2, {{WRAPPER}} .app-promo-content-two h2',
            ]
        );
        $this->end_controls_section();


        //----------------------------------- Style Feature List
        $this->start_controls_section(
            'style_feature_list', [
                'label' => __( 'Style Feature List', 'appart-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'color_feature_title', [
                'label' => __( 'Color', 'appart-core' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .app-promo-content .promo-item, {{WRAPPER}} .app-promo-content .promo-item i' => 'color: {{VALUE}};',
                ],
                'default' => '#fff'
            ]
        );
        $this->add_control(
            'color_feature_item_icon', [
                'label' => __( 'Icon border color', 'appart-core' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .app-promo-content .promo-item i' => 'border-color: {{VALUE}};',
                ],
                'default' => '#fff'
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'label' => 'Typography',
                'name' => 'typography_feature_item',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .app-promo-content .promo-item',
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
            'is_revers_column', [
                'label' => __( 'Reverse column', 'appart-core' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'appart-core' ),
                'label_off' => __( 'No', 'appart-core' ),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'style', [
                'label' => __( 'Style', 'appart-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'style_01' => 'Style one',
                    'style_02' => 'Style two',
                ],
                'default' => 'style_01'
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings();
        $features = isset($settings['features']) ? $settings['features'] : '';
        $images = isset($settings['images']) ? $settings['images'] : '';
        $buttons = isset($settings['buttons']) ? $settings['buttons'] : '';
        ?>

        <?php
        if($settings['style']=='style_01') {
            ?>
            <div class="container screens_features screens_features1">
                <div class="row <?php echo ($settings['is_revers_column'] == 'yes') ? 'reverse_column' : ''; ?>">
                    <div class="col-lg-5 col-md-6">
                        <div class="app-promo-content">
                            <?php if (!empty($settings['title_text'])) : ?>
                                <h2> <?php echo esc_html($settings['title_text']); ?></h2>
                            <?php endif; ?>
                            <?php
                            if ($features) {
                            foreach ($features as $feature) {
                                ?>
                                <div class="promo-item">
                                    <?php
                                    if ($feature['icon_type'] == 'ti_icon') {
                                        echo "<i class='{$feature['ti_icon']}'></i>";
                                    } elseif ($feature['icon_type'] == 'fontawesome_icon') {
                                        echo "<i class='{$feature['fontawesome_icon']}'></i>";
                                    } elseif ($feature['icon_type'] == 'image_icon') {
                                        echo "<img src='{$feature['image_icon']['url']}' alt='{$feature['title']}'>";
                                    }
                                    echo $feature['title'];
                                    ?>
                                </div>
                                <?php
                            }}
                            ?>
                            <div class="promo-button">
                                <?php
                                if (is_array($buttons)) {
                                $i = 1;
                                foreach ($buttons as $button) {
                                    if ($button['btn_style'] == 'white') {
                                        echo '<a class="banner_btn btn-white" href="' . esc_url($button['url']['url']) . '">' . esc_html($button['label']) . '</a>';
                                    } elseif ($button['btn_style'] == 'outline') {
                                        echo '<a class="learn-btn" style="color:' . $button["font_color"] . ';" href="' . esc_url($button['url']['url']) . '">' . esc_html($button['label']) . '</a>';
                                    } else {
                                        ?>
                                        <style>
                                            .sf_btn<?php echo $i; ?>:hover {
                                                color: <?php echo $button['font_hover_color']; ?> !important;
                                                background-color: <?php echo $button['bg_hover_color']; ?> !important;
                                                border-color: <?php echo $button['border_hover_color']; ?> !important;
                                            }
                                        </style>
                                        <a class="sf_btn<?php echo $i; ?> banner_btn"
                                           href="<?php echo esc_url($button['url']['url']); ?>"
                                           style="background: <?php echo $button['bg_color']; ?>; color: <?php echo $button['font_color']; ?>; border-color: <?php echo $button['border_color']; ?>;">
                                            <?php echo esc_html($button['label']) ?>
                                        </a>
                                        <?php
                                        ++$i;
                                    }
                                }}
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 offset-lg-1 col-md-6">
                        <div class="app-promo-img">
                            <?php
                            if (is_array($images)) {
                            $image_i = 1;
                            foreach ($images as $image) { ?>
                                <img src="<?php echo $image['image']['url'] ?>"
                                     class="promo-img img<?php echo $image_i; ?> wow <?php echo $image['animation'] ?>"
                                     data-wow-delay="<?php echo $image['animation_duration'] ?>s" alt="img">
                                <?php
                                ++$image_i;
                            }}
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }

        elseif($settings['style']=='style_02') {
            ?>
            <section class="powerfull_features" id="features2">
                <div class="container">
                    <div class="row <?php echo ($settings['is_revers_column'] == 'yes') ? 'reverse_column' : ''; ?>">
                        <div class="col-lg-7 col-md-5">
                            <div class="row m0">
                                <?php
                                if (is_array($images)) {
                                    $image_i = 1;
                                    foreach ($images as $image) { ?>
                                        <div class="col-sm-6 power-img">
                                            <img src="<?php echo $image['image']['url'] ?>" alt="">
                                        </div>
                                        <?php
                                        ++$image_i;
                                    }}
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-7">
                            <div class="app-promo-content app-promo-content-two">
                                <?php if (!empty($settings['title_text'])) : ?>
                                    <h2> <?php echo esc_html($settings['title_text']); ?></h2>
                                <?php endif; ?>
                                <?php
                                if ($features) {
                                    foreach ($features as $feature) {
                                        ?>
                                        <div class="promo-item">
                                            <?php
                                            if ($feature['icon_type'] == 'ti_icon') {
                                                echo "<i class='{$feature['ti_icon']}'></i>";
                                            } elseif ($feature['icon_type'] == 'fontawesome_icon') {
                                                echo "<i class='{$feature['fontawesome_icon']}'></i>";
                                            } elseif ($feature['icon_type'] == 'image_icon') {
                                                echo "<img src='{$feature['image_icon']['url']}' alt='{$feature['title']}'>";
                                            }
                                            echo $feature['title'];
                                            ?>
                                        </div>
                                        <?php
                                    }}
                                ?>
                                <div class="promo-button">
                                    <?php
                                    if (is_array($buttons)) {
                                        $i = 1;
                                        foreach ($buttons as $button) {
                                            if ($button['btn_style'] == 'white') {
                                                echo '<a class="banner_btn btn-white" href="' . esc_url($button['url']['url']) . '">' . esc_html($button['label']) . '</a>';
                                            } elseif ($button['btn_style'] == 'outline') {
                                                echo '<a class="learn-btn" style="color:' . $button["font_color"] . ';" href="' . esc_url($button['url']['url']) . '">' . esc_html($button['label']) . '</a>';
                                            } else {
                                                ?>
                                                <style>
                                                    .banner_btn<?php echo $i; ?>:hover {
                                                        color: <?php echo $button['font_hover_color']; ?> !important;
                                                        background-color: <?php echo $button['bg_hover_color']; ?> !important;
                                                        border-color: <?php echo $button['border_hover_color']; ?> !important;
                                                    }
                                                </style>
                                                <a class="banner_btn<?php echo $i; ?> banner_btn"
                                                   href="<?php echo esc_url($button['url']['url']); ?>"
                                                   style="background: <?php echo $button['bg_color']; ?>; color: <?php echo $button['font_color']; ?>; border-color: <?php echo $button['border_color']; ?>;">
                                                    <?php echo esc_html($button['label']) ?>
                                                </a>
                                                <?php
                                                ++$i;
                                            }
                                        }}
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php
        }
    }

}