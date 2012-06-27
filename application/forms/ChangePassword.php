<?php

class Application_Form_ChangePassword extends Zend_Form
{

    public function init()
    {
        $this->setAction('');
        $this->setMethod('post');


         $password = new Zend_Form_Element_Password('password');
         $password->setRequired(TRUE)
                  ->setLabel('Password')
                  ->addFilter('StripTags')
                  ->addFilter('StringTrim');

         $ConfirmPassword = new Zend_Form_Element_Password('confirmPassword');
         $ConfirmPassword->setRequired(TRUE)
                 ->setLabel('Confirm Password')
                  ->addFilter('StripTags')
                  ->addValidator(new Zend_Validate_Identical('password'))
                  ->setErrorMessages(array('pass' => 'Password does not match'))
                  ->addFilter('StringTrim');

         $submit = new Zend_Form_Element_Submit('submit', 'Update');


        $this->addElements(array(

        	$password,
        	$ConfirmPassword,
        	$submit

	        ));
    }

}

