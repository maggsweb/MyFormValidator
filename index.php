<?php


$formVal = new FormValidator();
$formVal->setMethod('POST');
$formVal->registerFields();

$formVal->validate('firstname')->clean()->isRequired();
$formVal->validate('surname')->clean()->isRequired();
$formVal->validate('emailadd')->clean()->isRequired()->isEmail();
$formVal->validate('password')->clean()->isRequired()->isPassword();
$formVal->validate('department')->isRequired();
$formVal->validate('interests')->checkboxGroupRequired(2);

$errors = $formVal->getErrors();
$fields = $formVal->getFields();

