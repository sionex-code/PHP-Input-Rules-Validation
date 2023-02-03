PHP Input Rules Validation lib
=================================

This is a PHP script that provides a simple way to validate user inputs. It defines a class InputRules with several methods to check inputs. The methods include checking if the input is an integer, a valid email address, and a required field.

The input validation rules are specified using an array, with the field name as the key and a string of method names separated by '|' as the value. The methods are called on the input data in the checkpost method of the InputRules class. The results of the validation checks are stored in the Err property, which is an array.

The script then creates an instance of the InputRules class, adds validation rules, and calls the checkpost method. If all the validation checks pass, it continues with the next steps. Otherwise, it loops through the Err array and displays the errors.

The script also contains an HTML form for testing the validation rules.
