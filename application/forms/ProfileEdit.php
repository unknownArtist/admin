<?php

class Application_Form_ProfileEdit extends Zend_Form
{

     public function init()
    {

        $selectCountry = array( 
            '1'   =>  'America',
            '0'   =>  'Canada'
            
            );
        
        $Kindof = array(
            'Male'     =>  'Male',
            'Female'   =>  'Female',
            
        );
        
       $SexOptions     = array(
             'Dog'    =>  'Dog',
             'Cat'    =>  'Cat',
             'Other'  =>  'Other'
        );
       
       $profileType = array(
            '0'   =>  'For mating',
            '1'   =>  'For sale',
            '2'   =>  'Adoption',
            '3'   =>  'Showcase'
       );
       
       $nego    = array(
           
            '1'   =>  'Yes',
            '0'   =>  'No',
       );
       
       $Selectpurebred = array(
           
            '1'   =>  'Yes',
            '0'    =>  'No'
       );
       
       $Selecthavepapers = array(
           
          '1'   =>  'Yes',
          '0'    =>  'No'
       );
       $statesofamerica = Zend_Registry::get('states');
        
/////////////////////////////////////////////////////////////////////////////////  
       ///////////////////////////////////////////////////////////////
        
        
        $this->setMethod('post');
        $this->setAction('#');
        $this->setName('profile');
        
        $Accessiblename = new Zend_Form_Element_Text('name');
        
        $Accessiblename->setLabel('Accessible name')
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
        
        $Country        = new Zend_Form_Element_Select('country');
        $Country->setLabel('Select Country')
                       ->addFilter('StripTags')
                        ->addFilter('StringTrim')
                        ->addValidator('NotEmpty')
                       ->addMultiOptions($selectCountry);
        
        
        $state        = new Zend_Form_Element_Select('state');
        $state->setLabel('Select State')
                        ->addFilter('StripTags')
                        ->addFilter('StringTrim')
                        ->addValidator('NotEmpty')
                        ->addMultiOptions($statesofamerica);
        
        $city = new Zend_Form_Element_Text('city');
        $city->setLabel('City')
                       ->addFilter('StripTags')
                       ->setRequired(true)
                        ->addFilter('StringTrim')
                        ->addValidator('NotEmpty')
                        ->addValidator('regex', true, 
                                 array(
                                       'pattern'=>'/^[(a-zA-Z ]+$/', 
                                       'messages'=>array(
                                       'regexNotMatch'=>'Kindly Enter only Alphabets'
                                      )
                       ));
        
        $zip = new Zend_Form_Element_Text('zipcode');
        $zip->setLabel('Zip')
                       ->addFilter('StripTags')
                       ->setRequired(true)
                        ->addFilter('StringTrim')
                        ->addValidator('NotEmpty')
                        ->addErrorMessage('Only digits')
                        ->addValidator('Digits');
        
        $kind        = new Zend_Form_Element_Select('kind');
        $kind->setLabel('Kind')
                       ->addFilter('StripTags')
                        ->addFilter('StringTrim')
                        ->addValidator('NotEmpty')
                       ->addMultiOptions($Kindof);
        
        $race        = new Zend_Form_Element_Text('race');
        $race->setLabel('Race')
                        ->addFilter('StripTags')
                        ->setRequired(true)
                        ->addFilter('StringTrim')
                        ->addValidator('NotEmpty')
                        ->addValidator('regex', true, 
                                 array(
                                       'pattern'=>'/^[(a-zA-Z ]+$/', 
                                       'messages'=>array(
                                       'regexNotMatch'=>'Kindly Enter only Alphabets'
                                      )
                       ));
                       
        
        $sex        = new Zend_Form_Element_Select('sex');
        $sex->setLabel('Sex')
                       ->addFilter('StripTags')
                       ->setRequired(true)
                        ->addFilter('StringTrim')
                        ->addValidator('NotEmpty')
                       ->addMultiOptions($SexOptions);
        
        $purebred   = new Zend_Form_Element_Select('pure_bread');
        $purebred->setLabel('Pure bred')
                 ->addFilter('StripTags')
                 ->setRequired(true)
                 ->addFilter('StringTrim')
                 ->addValidator('NotEmpty')
                 ->addMultiOptions($Selectpurebred);
                 
                 
        
        $havepapers   = new Zend_Form_Element_Select('papers');
        $havepapers->setLabel('Have papers')
                   ->addFilter('StripTags')
                   ->setRequired(true)
                   ->addFilter('StringTrim')
                   ->addValidator('NotEmpty')
                   ->addMultiOptions($Selecthavepapers);
                   
        
        $profiletype        = new Zend_Form_Element_Select('type');
        $profiletype->setLabel('Profile Type')
                       ->addFilter('StripTags')
                       ->setRequired(true)
                       ->addFilter('StringTrim')
                       ->addValidator('NotEmpty')
                       ->addMultiOptions($profileType);
        
        $Amount = new Zend_Form_Element_Text('amount');
        $Amount->setLabel('Amount')
                       ->addFilter('StripTags')
                       ->setRequired(true)
                       ->addErrorMessage('Amount is required field')
                       ->addFilter('StringTrim')
                       ->addValidator('NotEmpty')
                       ->addValidator('regex', true, 
                                 array(
                                       'pattern'=>'/^[(0-9$]+/', 
                                       'messages'=>array(
                                       'regexNotMatch'=>'Kindly Enter only Digits'
                                      )
                       ));
        
        $Negotiable       = new Zend_Form_Element_Select('negotiable');
        $Negotiable->setLabel('Negotiable')
                       ->addFilter('StripTags')
                       ->setRequired(true)
                       ->addFilter('StringTrim')
                       ->addValidator('NotEmpty')
                       ->addMultiOptions($nego);
        
        $picupload        = new Zend_Form_Element_File('pic_upload');
         $picupload->setLabel('Select the file to upload:')
                      ->setDestination(APPLICATION_PATH.'/../public/images')
                      ->addValidator('Count', false, 1) // ensure only 1 file
                      ->addValidator('Size', false, 8097152) // limit to 6MB
                      ->addValidator('Extension', false, 'jpg,jpeg,png,gif');
                   
        $picuploadSec     = new Zend_Form_Element_File('pic_uploadSec');
         $picuploadSec->setLabel('Select the file to upload:')
                      ->setDestination(APPLICATION_PATH.'/../public/images')
                      ->addValidator('Count', false, 1) // ensure only 1 file
                      ->addValidator('Size', false, 8097152) // limit to 6MB
                      ->addValidator('Extension', false, 'jpg,jpeg,png,gif');
        
        $picuploadThird        = new Zend_Form_Element_File('pic_uploadThird');
         $picuploadThird->setLabel('Select the file to upload:')
                      ->setDestination(APPLICATION_PATH.'/../public/images')
                      ->addValidator('Count', false, 1) // ensure only 1 file
                      ->addValidator('Size', false, 8097152) // limit to 6MB
                      ->addValidator('Extension', false, 'jpg,jpeg,png,gif');

        $picuploadFourth  = new Zend_Form_Element_File('pic_uploadFourth');
         $picuploadFourth->setLabel('Select the file to upload:')
                      ->setDestination(APPLICATION_PATH.'/../public/images')
                      ->addValidator('Count', false, 1) // ensure only 1 file
                      ->addValidator('Size', false, 8097152) // limit to 6MB
                      ->addValidator('Extension', false, 'jpg,jpeg,png,gif');


        $description = new Zend_Form_Element_Textarea('details');
        $description->setLabel('Description')
                    ->addFilter('StripTags')
                    ->addErrorMessage('Please Write some Details About your Pet')
                    ->addFilter('StringTrim')
                    ->setAttrib('cols',40) 
                    ->setAttrib('rows',12)
                    ->addValidator('NotEmpty');
        
        $email        = new Zend_Form_Element_Text('email');
        $email->setLabel('Email')
                       ->addFilter('StripTags')
                       ->setRequired(true)
                       ->addFilter('StringTrim')
                       ->addValidator('EmailAddress')
                       ->addErrorMessage('Valid Email is required')
                       ->addValidator('NotEmpty')
                       ->addValidator('EmailAddress');
        
        $phone        = new Zend_Form_Element_Text('phone');
        $phone->setLabel('Phone')
                        ->addFilter('StripTags')
                        ->setRequired(true)
                        ->addFilter('StringTrim')
                        ->addErrorMessage('Valid phone number is required')
                        ->addValidator('NotEmpty')
                        ->addValidator('Digits');
  /*
        $lat        = new Zend_Form_Element_Hidden('latitude');
                    
                    $lat->addFilter('StripTags')
                        ->setAttrib('id', 'geo_latitude')
                        ->setRequired(true)
                        ->addFilter('StringTrim')
                        
                        ->addValidator('NotEmpty');

        $long        = new Zend_Form_Element_Hidden('longitude');
                  
                   $long->addFilter('StripTags')
                        ->setAttrib('id', 'geo_longitude')
                        ->setRequired(true)
                        ->addFilter('StringTrim')
                        
                        ->addValidator('NotEmpty');
        
        $address = new Zend_Form_Element_Text('address');
        $address->setLabel('Type you complete Address')
                        ->addFilter('StripTags')
                        ->setRequired(true)
                        ->addFilter('StringTrim')
                        ->setAttrib('id','address')
                        ->addErrorMessage('This Field is Required')
                        ->addValidator('NotEmpty');
        */         
        
        $submit = new Zend_Form_Element_Submit('submit');
        

        //$getAddress = new Zend_Form_Element_Submit('getAddress','submit');
        //$getAddress->setAttrib('onclick','findAddress(document.getElementById("address").value);');
        

        
        $this->addElements(array(
            
            $Accessiblename,
            $Country,
            $state,
            $city,
            $zip,
            $kind,
            $sex,
            $race,
            $purebred,
            $havepapers,
            $profiletype,
            $Amount,
            $Negotiable,
            $picupload,
            $picuploadSec,
            $picuploadThird,
            $picuploadFourth,
            $description,
            $email,
            $phone,
            //$lat,
            //$long,
            $submit,
            
        ));
        
        
    }

}

