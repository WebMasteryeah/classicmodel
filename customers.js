
/*
 * The JavaScript for the AJAX'd version of the Customers browser,
 * using XML for data transfers.
 */

(function () {
    'use strict';
    /*jslint browser: true, devel: true, indent: 4, maxlen: 80 */

    var REQUEST_COMPLETE = 4,      // ReadyState of XMLHttpRequest when done
        OK = 200,                  // HTTP response OK code
        customerDetailsXHR = null;  // The XMLHttpRequest object for customer details

    // Called asynchronously as the state of the customerDetailsXHR
    // for the currently select product details XMLHttp request changes.
    function detailsArrived() {
		
        var xml,
            customerDetail = document.getElementById("CustomerDetails"),
            cDetail, detail, idElement, id,
            customerNoElement, customerNo, nameElement, customerName,
            contactLastNameElement, contactLastName, contactFirstNameElement, contactFirstName,
            phoneElement, phone, address1Element, address1, cityElement, city, 
            postalCodeElement, postalCode, countryElement, country,
            stateElement, state, salesRepNoElement, salesRepNo, creditLimitElement, creditLimit;
            
        if (customerDetailsXHR.readyState === REQUEST_COMPLETE &&
                customerDetailsXHR.status === OK && customerDetailsXHR.responseXML !== null) {

            xml = customerDetailsXHR.responseXML;
            
            cDetail = xml.getElementsByTagName("customer");
            detail = cDetail[0];
			
			nameElement = detail.getElementsByTagName("customerName");
			customerName = nameElement[0].childNodes[0].data;
			customerDetail.rows[0].cells[1].innerHTML = customerName;
			
			contactLastNameElement = detail.getElementsByTagName("contactLastName");
			contactLastName = contactLastNameElement[0].childNodes[0].data;
            
            contactFirstNameElement = detail.getElementsByTagName("contactFirstName");
			contactFirstName = contactFirstNameElement[0].childNodes[0].data;
            
			customerDetail.rows[1].cells[1].innerHTML = contactLastName + ' ' + contactFirstName;
			
			phoneElement = detail.getElementsByTagName("phone");
			phone = phoneElement[0].childNodes[0].data;
			customerDetail.rows[2].cells[1].innerHTML = phone;
            
            address1Element = detail.getElementsByTagName("address1");
			address1 = address1Element[0].childNodes[0].data;
			customerDetail.rows[3].cells[1].innerHTML = address1;
            
            cityElement = detail.getElementsByTagName("city");
			city = cityElement[0].childNodes[0].data;
			customerDetail.rows[4].cells[1].innerHTML = city;
            
            countryElement = detail.getElementsByTagName("country");
			country = countryElement[0].childNodes[0].data;
			customerDetail.rows[5].cells[1].innerHTML = country;
            
            creditLimitElement = detail.getElementsByTagName("creditLimit");
			creditLimit = creditLimitElement[0].childNodes[0].data;
			customerDetail.rows[6].cells[1].innerHTML = creditLimit;
			
        }
    }

    function loadCustomerDetails() {
        var customerID = document.getElementById("Customer ID").value,
            resource = "customerDetail.php?customerId=" + customerID;

        customerDetailsXHR = new XMLHttpRequest();
        customerDetailsXHR.onreadystatechange = detailsArrived;
        customerDetailsXHR.open("GET", resource, true);
        customerDetailsXHR.send();
    }

    
    /* Initialisation: bind the event handlers and kick it into life by calling
     * loadCustomerDetails()
     */
    document.getElementById("Customer ID").onchange = loadCustomerDetails;

}());
