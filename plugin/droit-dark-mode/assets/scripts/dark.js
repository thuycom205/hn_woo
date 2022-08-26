
(function($){
    let $html = document.querySelector('html');
    if( $html && dtdr_settings.mode == 'yes' && dtdr_settings.default == 'yes'){
        $html.classList.add('drdt-dark-mode');
        drdt_admin_setCookie("drdt_dark_admin", 'yes', 365);
    }

    // button event
    let $dtdrbutton = document.querySelectorAll('.dark_switch_box');
    if( $dtdrbutton ){
        for( let $i = 0; $i < $dtdrbutton.length; $i++){
            let $self = $dtdrbutton[$i];
            if( !$self ){
                continue;
            }
            if( dtdr_settings.mode == 'yes' && dtdr_settings.default == 'yes'){
                $self.classList.toggle('active');
            }
            $self.addEventListener('click', function( $ev ){
                let $this = (this);
               $html.classList.toggle('drdt-dark-mode');
               $html.classList.toggle(dtdr_settings.colorset);
               $this.classList.toggle('active');

               var getPublic = drdt_admin_getCookie("drdt_dark_admin");

                if(getPublic == 'yes'){
                    drdt_admin_setCookie("drdt_dark_admin", 'no', 365);
                } else {
                    drdt_admin_setCookie("drdt_dark_admin", 'yes', 365);
                }
            });
        }
    }

    // set cookie for droit dark mode
    function drdt_admin_setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }
      
    // get cookie for droit dark mode
    function drdt_admin_getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

})(jQuery);