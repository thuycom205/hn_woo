<?php

namespace Mas\Whatsapp\Admin;

class MetaBox
{
    public $post;

    function __construct($post) {
        $this->post = $post;
    }

    public function show_whatsapp_message( ) {
        $message = get_post_meta($this->post->ID, 'whatsapp_message',true);
        ?>
        <div>
            <h2>Message</h2>
            <div> <?php
                echo $message;
                ?></div>
            <button class="button primary"><?php echo __('send','maswa')?></button>
        </div>
            <?php
    }
    function displayCheck($value,$stored) {
        $s= (int) $stored;
        if ($value == $s) {
            echo "checked";
        }
    }
 public  function view() {
        $id = null;
        if ($this->post && is_object($this->post)) {
            $id  =$this->post->ID;
        } else {
            $id = '';
        }
        $country_code = get_post_meta($this->post->ID, 'country_code',true);
        $phone_number = get_post_meta($this->post->ID, 'phone_number',true);
        $agent_name = get_post_meta($this->post->ID, 'agent_name',true);
        $agent_role = get_post_meta($this->post->ID, 'agent_role',true);
        $agent_ava = get_post_meta($this->post->ID, 'agent_ava',true);
     ?>
         <style>
          .maswa-c {
              display: flex;
              flex-direction: column;
          }
          .maswa-c > div {
              display: flex;
              flex-direction: column;
              justify-content: flex-start;
              align-items: flex-start;
              padding: 5px;
          }
          .maswa-c > div > label{
            flex-grow: 2;
              align-self :flex-start;

          }
          .maswa-c > div > div{
              /*flex-basis: 200px;*/
              align-self :flex-start;

            flex-grow: 8;
          }

          .maswa_ava > div  {
              margin: 5px;
          }
          .maswa_ava > div > img {
              width: 70px;
              vertical-align: top;
          }
          .maswa_ava > div > input[type=radio] {
              vertical-align: top;
              margin-top: 25px;
          }
         </style>
     <div class="maswa-c">
         <div class="maswa-r">
             <label><?php echo __('Country code', 'maswa') ?></label>
              <div>
                  <input name="country_code" type="text"  value="<?php echo $country_code ?>"/>
              </div>
         </div>
         <div>
             <label><?php echo __('Phone number', 'maswa') ?></label>
              <div>
                  <input name="phone_number" type="text"  value="<?php echo $phone_number ?>"/>

              </div>
         </div>
         <div>
             <label><?php echo __('Agent name', 'maswa') ?></label>
             <div>
                 <input name="agent_name" type="text"  value="<?php echo $agent_name ?>"/>
             </div>
         </div>
         <div>
             <label><?php echo __('Agent role', 'maswa') ?></label>
             <div>
                 <input name="agent_role" type="text"  value="<?php echo $agent_role ?>"/>

             </div>
         </div>
         <div class="maswa_ava">
             <label><?php echo __('Agent avatar', 'maswa') ?></label>
             <div>
                 <input name="agent_ava" type="radio"  value="1" <?php $this->displayCheck(1,$agent_ava) ?> />
                 <img class="smallImg" src="<?php echo MASWA_URL?>/assets/img/Male-1.png" alt="<?php ?>" />
             </div>
              <div>
                 <input name="agent_ava" type="radio"  value="2" <?php $this->displayCheck(2,$agent_ava) ?> />
                 <img src="<?php echo MASWA_URL?>/assets/img/Male-2.png" alt="<?php ?>" />
             </div>
             <div>
                 <input name="agent_ava" type="radio"  value="3" <?php $this->displayCheck(3,$agent_ava) ?> />
                 <img src="<?php echo MASWA_URL?>/assets/img/Female-1.png" alt="<?php ?>" />
             </div>
             <div>
                 <input  name="agent_ava" type="radio"  value="4" <?php $this->displayCheck(4,$agent_ava) ?> />
                 <img src="<?php echo MASWA_URL?>/assets/img/Female-2.png" alt="<?php ?>" />
             </div>
         </div>
     </div>
<?php

 }
}