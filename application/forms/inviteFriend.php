<?php

class Application_Form_inviteFriend extends Zend_Form
{
	public function init()
	{
		$this->setAction('#');
        $this->setMethod('post');

        $email = new Zend_Form_Element_Text('email');
        $email->setRequired(TRUE)
                  ->setLabel('Email')
                  ->addValidator('EmailAddress')
                 ->setErrorMessages(array('email is Required'))
                 ->addFilter('StripTags')
                 ->addFilter('StringTrim');



        $Message = new Zend_Form_Element_Textarea('Message');
        $Message->setLabel('Message')
                    ->addFilter('StripTags')
                    ->setRequired(true)
                    ->addErrorMessage('Please Write some Message')
                    ->addFilter('StringTrim')
                    ->setAttrib('cols',40) 
                    ->setAttrib('rows',20)
                    ->addValidator('NotEmpty');


        $submit = new Zend_Form_Element_Submit('Send');


         $this->addElements(array(
            
            $email,
            $Message,
            $submit,
            ));
        
	}
}