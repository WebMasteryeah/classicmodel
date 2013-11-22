/*
 * The JavaScript for the AJAX'd version of the NW Product Browser,
 * using XML for data transfers.
 */

(function () {
    'use strict';
    /*jslint browser: true, devel: true, indent: 4, maxlen: 80 */

    var REQUEST_COMPLETE = 4,      // ReadyState of XMLHttpRequest when done
        OK = 200,                  // HTTP response OK code
        customerListXHR = null,
        customerDetailXHR = null,
        orderDetailsXHR = null,
        moreDetailListXHR, 
        moreDetailsXHR;
        
    // Adds a (text, value) option to a select element
    function addOption(selectbox, text, value) {
        var option = document.createElement("option");
        option.text = text;
        option.value = value;
        selectbox.options.add(option);
    }

    // Called asynchronously as the state of the productDetailsXHR
    // for the currently select product details XMLHttp request changes.
    function detailsArrived() {
		
        var xml_o, orderDetail, oDetail, 
            orderNumberElement, orderNumber, orderNumberElement, 
            shippedDateElement, shippedDate, statusElement, status,
            commentsElement, comments,
            customerDetail = document.getElementById("CustomerDetails"), orderNumber,
            orderDateElement, orderDate;
            
        if (orderDetailsXHR.readyState === REQUEST_COMPLETE &&
                orderDetailsXHR.status === OK && orderDetailsXHR.responseXML !== null) {

            xml_o = orderDetailsXHR.responseXML;
            
            orderDetail = xml_o.getElementsByTagName("order");
            oDetail = orderDetail[0];
            
            orderNumberElement = oDetail.getElementsByTagName("orderNumber");
			orderNumber = orderNumberElement[0].childNodes[0].data;
			customerDetail.rows[1].cells[1].innerHTML = orderNumber;
            
            orderDateElement = oDetail.getElementsByTagName("orderDate");
			orderDate = orderDateElement[0].childNodes[0].data;
			customerDetail.rows[2].cells[1].innerHTML = orderDate;
            
            shippedDateElement = oDetail.getElementsByTagName("shippedDate");
			shippedDate = shippedDateElement[0].childNodes[0].data;
			customerDetail.rows[3].cells[1].innerHTML = shippedDate;
            
            statusElement = oDetail.getElementsByTagName("status");
			status = statusElement[0].childNodes[0].data;
			customerDetail.rows[4].cells[1].innerHTML = status;
			
        }
    }
    
    function customerDetailsArrived() {
		
        var customerDetail = document.getElementById("CustomerDetails"),
            customerNameElement, customerName, contactLElement, customerName,
            contactLElement, contactL, contactFElement, contactF, phoneElement, phone,
            creaditLimitElement, creaditLimit,
            xml_c, orderDetail, oDetail, orderNumberElement, orderNumber;
            
        if (customerDetailXHR.readyState === REQUEST_COMPLETE &&
                customerDetailXHR.status === OK && customerDetailXHR.responseXML !== null) {

            xml_c = customerDetailXHR.responseXML;
            
            orderDetail = xml_c.getElementsByTagName("customer");
            oDetail = orderDetail[0];
            
            customerNameElement = oDetail.getElementsByTagName("customerName");
			customerName = customerNameElement[0].childNodes[0].data;
			customerDetail.rows[0].cells[1].innerHTML = customerName;
        }
    }
    
    function newDetailListArrived(){
        
        var orderCombo, orderList, order, i;
        if (moreDetailListXHR.readyState  === REQUEST_COMPLETE && 
        moreDetailListXHR.status  === OK && moreDetailListXHR.responseXML !== null) {
            
            xml = moreDetailListXHR.responseXML;
            orderCombo = document.getElementById("OrderedProduct");
            orderList = xml.getElementsByTagName("moreDetail");
            
            while (orderCombo.options.length > 0) {
                orderCombo.remove(0);
            }
            
            for (i = 0; i < orderList.length; i += 1) {
                product = orderList[i];
                idElement = product.getElementsByTagName("id");
                id = idElement[0].childNodes[0].data;
                nameElement = product.getElementsByTagName("name");
                name = nameElement[0].childNodes[0].data;
                addOption(productCombo, name, id);
            }
            productCombo.selectedIndex = 0;
            moreDetailChanged();
        }
    }
    
    function orderChanged(){
        var orderID = document.getElementById("OrderNumber").value,
            resource = "ordersDetail.php?orderId=" + orderID;
            dResource = "ordersDetail.php?orderId=" + orderID;

        orderDetailsXHR = new XMLHttpRequest();
        orderDetailsXHR.onreadystatechange = newDetailListArrived;
        orderDetailsXHR.open("GET", resource, true);
        orderDetailsXHR.send();
        
        
        
    }
    
    function newOrderListArrived(){
        
        var xml, productCombo, productList, product, i, id, idElement,
            nameElement, name;
        if (customerListXHR.readyState === REQUEST_COMPLETE &&
                customerListXHR.status === OK &&
                customerListXHR.responseXML !== null) {

            xml = customerListXHR.responseXML;
            productCombo = document.getElementById("OrderNumber");
            productList = xml.getElementsByTagName("order");
            
            while (productCombo.options.length > 0) {
                productCombo.remove(0);
            }
            
            for (i = 0; i < productList.length; i += 1) {
                product = productList[i];
                idElement = product.getElementsByTagName("id");
                id = idElement[0].childNodes[0].data;
                nameElement = product.getElementsByTagName("name");
                name = nameElement[0].childNodes[0].data;
                addOption(productCombo, name, id);
            }
            productCombo.selectedIndex = 0;
            orderChanged();
        }
    }
    
    function customerChanged(){
        var customerID = document.getElementById("CustomerName").value,
            resource = "orderList.php?orderId=" + customerID,
            //detailResource = "customerDetail.php?customerId=" + customerID;

        customerListXHR = new XMLHttpRequest();
        customerListXHR.onreadystatechange = newOrderListArrived;
        customerListXHR.open("GET", resource, true);
        customerListXHR.send();
        
        //customerDetailXHR = new XMLHttpRequest();
        //customerDetailXHR.onreadystatechange = customerDetailsArrived;
        //customerDetailXHR.open("GET", detailResource, true);
        //customerDetailXHR.send();
            
    }

    
    /* Initialisation: bind the event handlers and kick it into life by calling
     */
    window.onload = function(){
        document.getElementById('CustomerName').onchange = customerChanged;
        document.getElementById('OrderNumber').onchange = orderChanged;
        document.getElementById('OrderedProduct').onchange = loadMoreDetails;
        customerChanged();
    }

}());
