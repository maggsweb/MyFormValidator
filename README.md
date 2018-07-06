# MyFormValidator

An easy-to-use PHP Form Validation Class

<hr>

### Table of Contents
**[Initialization](#initialization)**  
**[Validation Methods](#validation)**  
**[Return Methods](#return)**  

<hr>

## Initialization

This class is instantiated after submission of a form.

Fields are registered within the class, so that Validation methods can be performed and arrays of errors/values returned

```php

require_once ('MyFormValidator.php');

/**
 * Instantiate the FormValidator for use
 */
$formVal = new FormValidator();

/**
 * Set METHOD.
 * Default is _GET (in which case this step can be skipped)
 */
$formVal->setMethod('POST');

/**
 * Register all submitted fields into the class
 */
$formVal->registerFields();

```


## Validation Methods

All of these methods can be chained if required.

eg: $formVal->validate('some-field-name')->clean()->isRequired()->isEmail();

```php

/**
 * Sanitise field
 * This should be added to all fields that include any sort of user input/selection
 */
$formVal->validate('some-field-name')->clean();

/**
 * Mandatory field
 * Flag fields as mandatory
 */
$formVal->validate('some-field-name')->isRequired();

/**
 * Validate input value as a valid email address
 */
$formVal->validate('some-field-name')->isEmail();

/**
 * Validate input value as a password, using set rules set
 */
$formVal->validate('some-field-name')->isPassword();

/**
 * Ensure that X number of check-box options have been selected
 */
$formVal->validate('some-checkbox-group-name')->checkboxGroupRequired(2);

```

## Return Methods

The getErrors() and getValues() methods are available to the processing file to return arrays for processing

```php

/**
 * Get an array of error messages in:
 *  $fieldname => $message
 * 
 */
$errors = $formVal->getErrors();


/**
 * Get an array of cleaned form fields in:
 *  $fieldname => $value
 */
$fields = $formVal->getFields();

```

See fully working example in example.php
