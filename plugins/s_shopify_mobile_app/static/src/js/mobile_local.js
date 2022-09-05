if (window.location.href.indexOf('?mobile=1') !== -1) {
    var xhttp = new XMLHttpRequest();
    var shop_origin = ''
    typeof window.Shopify.shop != "undefined" ? shop_origin = window.Shopify.shop : false
    if (shop_origin != undefined && shop_origin.length > 0) {
        xhttp.open("GET", 'https://odooteam1.izysync.com/mobile_apps/' + shop_origin, true);
        // xhttp.setRequestHeader('Content-type', 'application/json');
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                var response = JSON.parse(this.responseText);
                var script = document.createElement("script");
                script.type = "text/javascript";
                script.innerHTML = response.custom_js;
                document.getElementsByTagName("head")[0].appendChild(script);

                var link = document.createElement("link");
                link.type = "rel/stylesheet";
                link.innerHTML = response.custom_css;
                document.getElementsByTagName("head")[0].appendChild(link);
            }
        };
        // Send request
        xhttp.send();
    }
}

