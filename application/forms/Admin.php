<?php

class Application_Form_Admin extends Zend_Form
{

    public function init()
    {
        
        $this->setAction('#');
        $this->setMethod('post');
        
        $email = new Zend_Form_Element_Text('admin');
        $email->setRequired(TRUE)
                  ->setLabel('Username')
                  ->setErrorMessages(array('Username is Required'))
                 ->addFilter('StripTags')
                 ->addFilter('StringTrim');
        
        $password = new Zend_Form_Element_Password('password');
        $password->setRequired(TRUE)
                 ->setLabel('Password')
                 ->setErrorMessages(array('Password is Required'))
                 ->setRequired(TRUE)
                 ->addFilter('StripTags')
                 ->addFilter('StringTrim');
        
        
        $submit = new Zend_Form_Element_Submit('Login');
        $submit->class = "register";
        $this->addElements(array(
            
            $email,
            $password,
            $submit
        ));
    }


}

