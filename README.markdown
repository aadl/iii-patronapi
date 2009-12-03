## III Patron API PHP Class

III makes available a very primitive patron API, which is actually useful, though did I mention primitive?  This bit of code can be included in any php script and used to get patron data from the API as well as validate a cardnumber/password combo.

### REQUIREMENTS

PHP 4 >= 4.3.0, PHP 5

### INSTRUCTIONS

There are two functions that are pertinent:

    get_patronapi_data($id) - This function can be passed either a library card number 
                              or a patron pnum.  It returns an array of data from the 
			      III server.

    check_validation($id, $pin) - This function takes either a card number or a pnum and
                                  a password/pin.  It will return an array of information
				  as detailed in the III documentation.  Essentially, it
				  will tell you if the combo is good, bad, or if the record
				  does not exist.
