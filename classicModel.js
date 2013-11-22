/**
 * JavaScript for nwproductbrowser2.php
 */

(function () {
    'use strict';
    /*jslint browser: true, devel: true, indent: 4, maxlen: 80 */

    function bindHandlers() {
        var productCombo = document.getElementById('Product'),
            categoryCombo = document.getElementById('ProductLine'),
            whatChange = document.getElementById('whatChanged');

        productCombo.onchange = function () {
            document.getElementById('whatChanged').value = 'Product';
            document.getElementById('browser-form').submit();
        };

        categoryCombo.onchange = function () {
            document.getElementById('whatChanged').value = 'ProductLine';
            document.getElementById('browser-form').submit();
        };
        
        if(whatChange == 'ProductLine'){
			document.getElementById('whatChanged').value = 'Product';
            document.getElementById('browser-form').submit();
		}
    }
    bindHandlers();

// End of the anonymous function
}());

