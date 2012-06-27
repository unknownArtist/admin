<?php

class Application_Form_Template extends Zend_Form
{
	public function init()
	{
		$this->setAction('');
        $this->setMethod('post');


         $subject = new Zend_Form_Element_Text('subject');
        
         $subject->setLabel('Subject')
                        ->setRequired(true)
                        ->addFilter('StripTags')
                        ->addFilter('StringTrim')
                        ->addValidator('NotEmpty')
                        ->addValidator('regex', true, 
                                 array(
                                       'pattern'=>'/^[(a-zA-Z ]+$/', 
                                       'messages'=>array(
                                       'regexNotMatch'=>'Kindly Enter only Alphabets'
                                      )
                       ));


        $template = new Zend_Form_Element_Textarea('template');
        $template->setLabel('Template')
                    ->addFilter('StripTags')
                    ->setRequired(true)
                    ->addErrorMessage('Please Write some Details About your Pet')
                    ->addFilter('StringTrim')
                    ->setAttrib('cols',40) 
                    ->setAttrib('rows',20)
                    ->addValidator('NotEmpty');


        $submit = new Zend_Form_Element_Submit('Save');


         $this->addElements(array(
            
            $subject,
            $template,
            $submit,
            ));
        
	}
}