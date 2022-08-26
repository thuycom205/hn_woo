"use strict";
(function($){
    let $html = document.querySelector('html');
    // button event
    var droitDarkMOde = {
        init: function(){
            // click switch button 
            droitDarkMOde.drdtSwitchButton();
            // background Disable
            droitDarkMOde.drdtBackgroundDisable();

            droitDarkMOde.hardCodeExl();
            droitDarkMOde.drdtHandleExcludes();
            droitDarkMOde.drdtHandleIncludes();

            window.addEventListener("DroitDarkModeInit", droitDarkMOde.checkDarkMode);

            droitDarkMOde.drdtImageReplace();
            
            // OS Based Dark Mode.
            droitDarkMOde.DrdtcheckOsMode();

        },

        drdtBackgroundDisable : function(){
            document.querySelectorAll("header, footer, div, section").forEach(function (e) {
                if(e){
                    var t = window.getComputedStyle(e, !1).backgroundImage;
                    var n = e.getAttribute("data-jarallax-original-styles");
                    if("none" !== t || n){
                        e.classList.add("drdt-ignore-dark");
                        e.querySelectorAll("*").forEach(function (el) {
                            return el.classList.add("drdt-ignore-dark");
                        });
                    }
                }
            });
        },
        // enable disable switch butotn
        drdtSwitchButton : function(){
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
        
                        var getPublic = drdt_getCookie("drdt_dark_public");
        
                        if(getPublic == 'yes'){
                            drdt_setCookie("drdt_dark_public", 'no', 365);
                        } else {
                            drdt_setCookie("drdt_dark_public", 'yes', 365);
                        }
                        droitDarkMOde.drdtImageReplace();
                    });
                }
            }
        },

        DrdtcheckOsMode: function () {
            if (dtdr_settings.os_based == 'yes') {
                var e = window.matchMedia("(prefers-color-scheme: dark)");
                try {
                    e.addEventListener("change", function (e) {
                        "dark" == (e.matches ? "dark" : "light") ? document.querySelector("html").classList.add("drdt-dark-mode") : document.querySelector("html").classList.remove("drdt-dark-mode"),
                            window.dispatchEvent(new Event("DroitDarkModeInit"));
                    });
                } catch (t) {
                    try {
                        e.addListener(function (e) {
                            "dark" == (e.matches ? "dark" : "light") ? document.querySelector("html").classList.add("drdt-dark-mode") : document.querySelector("html").classList.remove("drdt-dark-mode"),
                                window.dispatchEvent(new Event("DroitDarkModeInit"));
                        });
                    } catch (e) {
                        console.error(e);
                    }
                }
                window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches && (document.querySelector("html").classList.add("drdt-dark-mode"), window.dispatchEvent(new Event("DroitDarkModeInit")));
            }
        },

        checkDarkMode : function(){
            let $this = (this);
            // $html.classList.toggle('drdt-dark-mode');
            $html.classList.toggle(dtdr_settings.colorset);
            var $dtdrbutton = document.querySelectorAll('.dark_switch_box');
            for( let $i = 0; $i < $dtdrbutton.length; $i++){
                let $self = $dtdrbutton[$i];
                if( ! $self ){
                    continue;
                }
                $self.classList.toggle('active');
            }

            var getPublic = drdt_getCookie("drdt_dark_public");

            if(getPublic == 'yes'){
                drdt_setCookie("drdt_dark_public", 'no', 365);
            } else {
                drdt_setCookie("drdt_dark_public", 'yes', 365);
            }
            droitDarkMOde.drdtImageReplace();
        },

        drdtHandleExcludes: function () {
            if(dtdr_settings.excludes != ''){
                document.querySelectorAll(dtdr_settings.excludes).forEach(function (e) {
                    if(e){
                        e.classList.add("drdt-ignore-dark");
                        e.querySelectorAll("*").forEach(function (e1) {
                            e1.classList.add("drdt-ignore-dark");
                        });
                    }
                });
            }   
        },

        drdtHandleIncludes: function () {
            if(dtdr_settings.includes != ''){
                document.querySelectorAll(dtdr_settings.includes).forEach(function (e) {
                    if(e){
                        e.classList.remove("drdt-ignore-dark");
                        e.querySelectorAll("*").forEach(function (e1) {
                            e1.classList.remove("drdt-ignore-dark");
                        });
                    }
                });
            }  
        },
        drdtImageReplace: function(){
            var $replace = JSON.parse( dtdr_settings.replace );
            var getPublic = drdt_getCookie("drdt_dark_public");
            if( $replace.length > 0){
                $replace.forEach(function($k){
                    var $normal = ($k['normal']) ? $k['normal'] : '';
                    var $dark = ($k['dark']) ? $k['dark'] : '';
                    
                    if(getPublic == 'yes'){
                        var $find = $normal;
                        var $rep = $dark;
                    } else {
                        var $find = $dark;
                        var $rep = $normal;
                    }
                    if( $rep !== ''){
                        var $image = document.querySelectorAll('img[src*="'+$find+'"]');
                        if( $image ){
                            $image.forEach(function($m){
                                $m.setAttribute('src', $rep);
                                $m.setAttribute('srcset', $rep);
                            });
                        }
                    }
                });
            }
        },
        hardCodeExl: function(){
            // hard code css
            var $exClass = document.querySelectorAll('.drdt-ignore-dark');
            if( $exClass ){
                $exClass.forEach(function (e) {
                    if(e){
                        e.querySelectorAll(":not(.drdt-ignore-dark)").forEach(function (e1) {
                            e1.classList.add("drdt-ignore-dark");
                        });
                    }
                });
            }
        }

    };

    
    if( $html && dtdr_settings.mode == 'yes' && dtdr_settings.default == 'yes'){
        $html.classList.add('drdt-dark-mode');
        $html.classList.add(dtdr_settings.colorset);
        // set
        drdt_setCookie("drdt_dark_public", 'yes', 365);
        droitDarkMOde.drdtImageReplace();
    }

    if( dtdr_settings.mode == 'yes' && dtdr_settings.default == 'remove'){
        drdt_setCookie("drdt_dark_public", 'no', 365);
    }

    // set cookie for droit dark mode
    function drdt_setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }
      
    // get cookie for droit dark mode
    function drdt_getCookie(cname) {
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

    document.addEventListener("DOMContentLoaded", droitDarkMOde.init);

})(jQuery);
