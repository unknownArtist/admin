<?php

class Application_Form_FilterEmail extends Zend_Form
{

    public function init()
    {
    	$this->setAction('#');
        $email = new Zend_Form_Element_Text('email');
        $email->setRequired(TRUE)
                  ->setLabel('Email')
                  ->addValidator('EmailAddress')
                 ->setErrorMessages(array('email is Required'))
                 ->addFilter('StripTags')
                 ->addFilter('StringTrim');

       $search = new Zend_Form_Element_Submit('Search');

        $this->addElements(array(
        	$email,
        	$search,
        	
        	));
    }


}

