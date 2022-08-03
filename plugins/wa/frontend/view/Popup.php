<?php

namespace Mas\Whatsapp;

class PopUp
{
    public function view()
    {
        //if user is login then show the mask button
        if (is_user_logged_in()) {
?>
            <button id="add_to_cart_mask" class="button" style="    display: inline-block; text-align: center; word-break: break-word; background-color: var(--wp--preset--color--primary); color: #fff; border: 1px solid var(--wp--preset--color--black); padding: 1rem 2rem; margin-top: 1rem; text-decoration: none; font-size: medium; cursor: pointer;"> <?php echo __('Add to cart') ?></button>
        <?php
        }
        ?>


        <div style="display:none">
            <div id="wa-optin" style="display: block;">

                <div class="wa-optin-widget-container wa-optin-widget-z-index">
                    <div class="wa-optin-widget-content-container">
                        <div onclick="maswaClosePopup(this)" class="wa-optin-widget-close-btn"><img class="wa-optin-widget-close-img" src="<?php echo MASWA_URL ?>/assets/img/Vector_4.png"></div>
                        <div class="wa-optin-widget-title-bg-container"></div>
                        <div class="wa-optin-widget-left-sec">
                            <div class="wa-optin-widget-title-container">
                                <p class="wa-optin-widget-title">
                                    <span class="wa-optin-widget-title-text"><?php echo __("Receive updates on", "maswa") ?> </span>
                                    <br>
                                    <span class="wa-optin-widget-title-text"><img class="wa-optin-widget-title-text-logo" src="<?php echo MASWA_URL ?>/assets/img/whatsapp-logo-large.png" alt="whatsapp logo">WhatsApp
                                    </span>
                                </p>
                            </div>
                            <div class="wa-optin-widget-ul-container">
                                <ul class="wa-optin-widget-ul">
                                    <li class="wa-optin-widget-list-items">
                                        <img src="<?php echo MASWA_URL ?>/assets/img/Group_27.png" alt="check icon">
                                        <span> <?php echo  __('Order details', 'maswa') ?></span>
                                    </li>
                                    <li class="wa-optin-widget-list-items">
                                        <img src="<?php echo MASWA_URL ?>/assets/img/Group_27.png" alt="check icon">
                                        <span> <?php echo  __('Order tracking', 'maswa') ?></span>

                                    </li>
                                    <li class="wa-optin-widget-list-items">
                                        <img src="<?php echo MASWA_URL ?>/assets/img/Group_27.png" alt="check icon">
                                        <span> <?php echo  __('Customer support', 'maswa') ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="wa-optin-widget-right-sec">
                            <div class="wa-optin-widget-right-sec-content-container">
                                <div class="wa-optin-widget-input-box"><span class="wa-optin-widget-country-flag" id="wa-splmn-country-flag-logo"></span>
                                    <input class="wa-optin-widget-input input-country-code" placeholder="+XXX" id="wa-optin-country-code" autocomplete="off">
                                    <input class="wa-optin-widget-input input-maswa-phoneno" placeholder="XXXXXXXXX" id="wa-optin-phone-number" autocomplete="off" type="tel">
                                </div>
                                <button onclick="popupWhatsapp(this)" class="wa-optin-widget-confirm-btn" id="wa-optin-widget-confirm-btn"><?php echo __('CONFIRM', 'maswa') ?></button>
                            </div>
                        </div>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
}
