<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
       
    }

    public function indexAction()
    {
        $form = new Application_Form_Admin();
        $this->view->AdminSignIn = $form;

             
        $authAdapter = $this->getAuthAdapter();
           
        if ($this->getRequest()->isPost()) 
            {
            
            $formData = $this->getRequest()->getPost();
            
            

            if ($form->isValid($formData)) 
                {
                    $admin    = $form->getValue('admin');
                    $password = $form->getValue('password');
                    
                         $authAdapter->setIdentity($admin)
                                     ->setCredential($password);
                
                    $auth = Zend_Auth::getInstance();
                    $result = $auth->authenticate($authAdapter);
	     
        
             if($result->isValid())
               {
                    $auth->getStorage()->write(
                         $authAdapter->getResultRowObject(array('adminid', 'admin_username', 'role'))
                        );

            
                    $this->_redirect('index/home');
               }
               else
                    {
                        $form->populate($formData);
                        $this->view->SignUpError = "Invalid Username or Password";
                    }
                
                 } 
            
            else            
                {
                    $form->populate($formData);
                }
        }   
    }

    private function getAuthAdapter()
    {
        $auth = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        $auth->setTableName('adminlogin')
             ->setIdentityColumn('admin_username')
             ->setCredentialColumn('admin_password');
        
        return $auth;
    }

    public function homeAction()
    {
    	echo "how are you adil"; 
    }

    public function profilesAction()
    {
    	//$form = new Application_Form_FilterEmail();
    	//$this->view->form = $form;

        $getConnect = Zend_Db_Table::getDefaultAdapter();
        $getDbTable = new Zend_Db_Select($getConnect);

        if(isset($_POST['email']))
        {
         	$email = $_POST["email"];

        	$where = "email = '$email'";
        	$getAllProfiles = $getDbTable->from('profiles')->where($where);
        }
        else 
        {
     	   $getAllProfiles = $getDbTable->from('profiles');
    	}

        $getResult = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($getAllProfiles));

        $Paginatedresult = $getResult->setItemCountPerPage(10)
                                     ->setCurrentPageNumber($this->_getParam('page',1));
        $this->view->listProfiles = $Paginatedresult;
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('index');
    }

    public function editAction()
    {
        if(Zend_Auth::getInstance()->hasIdentity())
        {
        $form = new Application_Form_ProfileEdit();
        $this->view->form = $form;

        if($this->getRequest()->isPost())
        {
            $formData = $this->getRequest()->getPost();
                 if ($form->isValid($formData)) 
                {
                  
                  $getStates = new Application_Model_State();
                  $state = $form->getValue('state');
                  $stateResult = $getStates->fetchAll("state_abbr = '$state'")->toArray();
                  foreach ($stateResult as $value) 
                  {
                      $stateRow = $value['state_id']; 
                  }
                  
        $data = array(

                    'name'               =>  $form->getValue('name'), 
                    'country'            =>  $form->getValue('country'),
                    
                    'state'              =>  $stateRow,
                    'city'               =>  $form->getValue('city'),
                    
                    'zipcode'            =>  $form->getValue('zipcode'),
                    'sex'                =>  $form->getValue('kind'),
                    
                    'race'               =>  $form->getValue('race'),
                    'kind'               =>  $form->getValue('sex'),
              
                    'pure_bread'         =>  $form->getValue('pure_bread'),
                    'papers'             =>  $form->getValue('papers'),
                    
                    'type'               =>  $form->getValue('type'),
                    'amount'             =>  $form->getValue('amount'),
                    
                    'negotiable'         =>  $form->getValue('negotiable'),
                    'details'            =>  $form->getValue('details'),
                     
                    'email'              =>  $form->getValue('email'),
                    'phone'              =>  $form->getValue('phone'),

                    'user_id'            =>  $this->_request->getParam('id'),
                    
                
                     );

            
                 $InsertProfileData = new Application_Model_Profile();
                 $id = $this->_request->getParam('id');
                 $where = "user_id = '$id'";
                 
                 $checkIfData = $InsertProfileData->fetchRow($where);
                 if($checkIfData)
                 {
                    $InsertProfileData->update($data ,$where);
                 }
                 else
                 {
                 	$InsertProfileData->insert($data);
                 }
                 

             //  $InsertProfileData->fetchRow($where)->toArray();
                
/////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////// PIC upload Section////////////////////////////////////////
                $uploadPics = new Application_Model_UserPics();
                      
                 if($form->pic_upload->receive())
                {
                    $picData = array (
                    
                    'profile_id'            => $id,
                    'picture'               => $form->getValue('pic_upload'),
                    //'date'                  => date('Y,m,d')
                   );
                    
                               

                }
                
                $uploadPics->insert($picData);

                if($form->pic_uploadSec->receive())
                {
                    $picDataSec = array (
                    
                    'profile_id'            => $id,
                    'picture'               => $form->getValue('pic_uploadSec'),
                    //'date'              => date('Y,m,d')
                   );
                    
                    

                }
                
                $uploadPics->insert($picDataSec);

                if($form->pic_uploadThird->receive())
                {
                    $picDataThird = array (
                    
                    'profile_id'       => $id,
                    'picture'          => $form->getValue('pic_uploadThird'),
                    //'date'                  => date('Y,m,d')
                   );
                    
                    

                }
                
                $uploadPics->insert($picDataThird);

                if($form->pic_uploadFourth->receive())
                {
                    $picDataFourth = array (
                    
                    'profile_id'            => $id,
                    'picture'      => $form->getValue('pic_uploadFourth'),
                    //'date'              => date('Y,m,d')
                   );
                    
               
                   

                }
                
                $uploadPics->insert($picDataFourth);
/////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////// PIC upload Section End////////////////////////////////////////
                }
                 else
               {
                $form->populate($formData);
               }
           }
           
           else
           {  
             $identity = $this->_request->getParam('id'); 
             if($identity > 0)

             {
                $getProfileData = new Application_Model_Profile();
                $whereIF = "user_id = ".$identity;

                if($getProfileData->fetchRow($whereIF))
                {
                $profileData = $getProfileData->fetchRow($whereIF)->toArray();
                $form->populate($profileData);
                }
                else
                {
                    $this->view->form = $form;
                }
             }               
           }
   
        }
        else 
            {
               $this->_redirect('index');
            
    
    }
}

    public function resetPasswordAction()
    {
        $form = new Application_Form_ChangePassword();
        $this->view->form = $form;

       $CurrentLoggedInUserID = $this->_request->getParam('id');
      
      

       if($this->getRequest()->isPost())
       {
           $formData = $this->getRequest()->getPost();


           if($form->isValid($formData))
           {
               $UpdateformData = array(

                    'password' =>   $form->getValue('password'),
                  );

              
            $updateFormData = new Application_Model_ResetPassword();
            $response = $updateFormData->update($UpdateformData,'id = '.$CurrentLoggedInUserID);
            if($response)
                echo "updated";
            else
                echo "not updated";
            }
           else
            {
             	$form->populate($formData);
            }
        }
        
}

    public function addTemplateAction() 
    {
        $form = new Application_Form_Template();
        $tempObj = new Application_Model_Templates();
        $from1 = $tempObj->fetchAll();
        $this->view->form1 = $from1; 
        $this->view->form = $form;


        if ($this->getRequest()->isPost()) 
            {
            
            $formData = $this->getRequest()->getPost();
          
            if ($form->isValid($formData)) 
                {
                                 
                $data = array( 
                  'template' => $_POST['template'],
                  'subject'  => $_POST['subject'],
                  ); 


                 
                $tempObj = new Application_Model_Templates();
                    
                    if($tempObj->insert($data)) 
                        {
                            $this->view->success = "Template saved";
                            $this->_redirect('index/add-template');
                        }
                    else
                        {
                            $this->view->failure = "Template not saved";
                        }
                }
            else            
                {
                    $form->populate($formData);
                }
            }
    }

        public function editTemplateAction()
        {

         $form = new Application_Form_Template();
         $this->view->form = $form;
         $this->_request->getParam('sno');

          if ($this->getRequest()->isPost()) 
            {
            
            $formData = $this->getRequest()->getPost();
          
            if ($form->isValid($formData)) 
                {
                                 
                $data = array(

                 'template' => $_POST['template'],
                 'subject'  => $_POST['subject'],

                 ); 
                 
                $tempObj = new Application_Model_Templates();
                    $where = "sno = ".$this->_request->getParam('sno'); 
                    if($tempObj->update($data,$where)) 
                        {
                            $this->view->success = "Template saved";
                            $this->_redirect('index/add-template/');
                        }
                    else
                        {
                            $this->view->failure = "Template not saved";
                        }
                }
            else            
                {
                    $form->populate($formData);
                }
            }
            else
            {
                $identity = $this->_request->getParam('sno'); 
             if($identity > 0)

             {
                $getProfileData = new Application_Model_Templates();
                $whereIF = "sno = ".$identity;

                if($getProfileData->fetchRow($whereIF))
                {
                $profileData = $getProfileData->fetchRow($whereIF)->toArray();

                $form->populate($profileData);
                }
                else
                {
                    $this->view->form = $form;
                }
              }       
            }

        }

        public function getEmailsAction()
        {
            //first get all emails to 
            //get Emails
            $identity = $this->_request->getParam('sno');
            $getTemps      = new Application_Model_Templates();
            $getUserEmails = new Application_Model_Users();
            $setEmails     = new Application_Model_SendEmail();

            $emails = $getUserEmails->fetchAll()->toArray();
            $where = "sno = '$identity'";
            $subject = $getTemps->fetchRow($where)->toArray();
            $sub = $subject['subject'];
            
            foreach ($emails as $row) 
           {
                  
                  $data = array(
                    'sendEmail'     =>   $row['email'],
                    'temp_id'       =>   $identity,
                    'subject'      =>    $sub,
                    );
                 
 
                  $setEmails->insert($data);
            }

        }

        private function sendmailto()
         {

          $setEmails     = new Application_Model_SendEmail();

          $limitedEmails = $setEmails->fetchAll($where = NULL,$order = NULL, 20)->toArray();
          $getTemplate = new Application_Model_Templates();

          $getTemplaTe = $getTemplate->fetchRow("sno = ".$limitedEmails[0]['temp_id'])->toArray();
          
          
          foreach ($limitedEmails as $Emailz) 

          {
       
            require_once "Swift/lib/swift_required.php";
            $transport = Swift_SmtpTransport::newInstance()
                        ->setHost('mail.petmatchup.com')
                        ->setEncryption('ssl')
                        ->setPort(465)
                        ->setUsername('petmatchup@petmatchup.com')
                        ->setPassword('petpet321');
 
                        //Create mailer
                        $mailer = Swift_Mailer::newInstance($transport);
                        
                           
                        
                        //Create the message
                        $message = Swift_Message::newInstance()
                            ->setSubject($Emailz['subject'])
                            ->setFrom(array('petmatchup@petmatchup.com' => 'Petmatchup'))
                            ->setTo($Emailz['sendEmail'])
                            ->setBody($getTemplaTe['template'], 'text/html');
                        
                        
                          
                        //Send the message
                        $mailer->send($message);
                        $where = "id = ".$Emailz['id'];
                  $setEmails->delete($where);
                        
                    }
         }

         public function newsLetterAction()
         {
            $this->sendmailto();
         }

         public function deleteTemplateAction()
         {
            $identity = $this->_request->getParam('sno');
            $getTemps = new Application_Model_Templates();
            $whereIF = "sno = ".$identity;

            if($getTemps->delete($whereIF))
            {
                
                $this->_redirect('index/add-template');
            }
            else
            {
                echo "<script>alert(Template coud'nt Deleted);</script>";
            }

          }

        public function inviteFriendAction()
        {
          $form = new Application_Form_inviteFriend();
          $this->view->invitefrnd = $form;

         if($this->getRequest()->isPost())
         {
            $formData = $this->getRequest()->getPost();

            if($form->isValid($formData))
            {
              $emailTo = $form->getValue('email');
              $messageData = $form->getValue('Message');

            require_once "Swift/lib/swift_required.php";
            $transport = Swift_SmtpTransport::newInstance()
                        ->setHost('mail.petmatchup.com')
                        ->setEncryption('ssl')
                        ->setPort(465)
                        ->setUsername('petmatchup@petmatchup.com')
                        ->setPassword('petpet321');
 
                        //Create mailer
                        $mailer = Swift_Mailer::newInstance($transport);
                              
                        //Create the message
                        $message = Swift_Message::newInstance()
                            ->setSubject('Petmatchup')
                            ->setFrom(array('petmatchup@petmatchup.com' => 'Petmatchup'))
                            ->setTo($emailTo)
                            ->setBody($messageData, 'text/html');

                        //Send the message
                        $mailer->send($message);

                        echo "Message sent successfully........";
///////////////////////////////////////////////////////////////////////////////////////////////
                            // $smtpServer = 'mail.petmatchup.com';
                            // $username = 'petmatchup@petmatchup.com';
                            // $Password = 'petpet321';
                            // $config = array(
                            //                 'ssl' => 'ssl',
                            //                 'auth' => 'login',
                            //                 'username' => $username,
                            //                 'password' => $Password,
                            //                 'port' => 465
                            //                 );
                            // $transport = new Zend_Mail_Transport_Smtp($smtpServer, $config);
                            // Zend_Mail::setDefaultTransport($transport);
                            // $message = '

                            //         '.$messageData.'
                                    
                            //         http://www.petchmatchup.com

                            //         ';
                            // $mail = new Zend_Mail();
                            // $mail->addTo($emailTo, 'Admin');
                            // $mail->setSubject('You have been invited to petmatchup!');
                            // $mail->setBodyText($message);
                            // $mail->setFrom('petmatchup@petmatchup.com', 'petmatchup');
                            // $mail->send($transport);  
                            // echo "Message sent successfully........";

                      }
                    }
            }

        public function membersAction()
        {

          // if($this->_request->getParam('id')==1)
          // {
          
          $tmp = new Application_Model_Users();
          $where = "activate = ".$this->_request->getParam('id');
          $data = $tmp->fetchAll($where)->toArray();
          //$this->view->activeMembers = $data;

          //-------Pagination------------
          $page=$this->_getParam('page',1);
          $paginator = Zend_Paginator::factory($data);
          $paginator->setItemCountPerPage(8);
          $paginator->setCurrentPageNumber($page);
          $this->view->activeMembers=$paginator;
          //-------end of pagination-------


        }

          public function activateAction()
          {
             $data = array(
                        'activate'     => '1'               
                );

            $tmp = new Application_Model_Users();
            $where = "id = ".$this->_request->getParam('id');

            $tmp->update($data,$where);
                    
            $this->view->msg = "profile updated";
            $this->_redirect('index/members/id/0');


            //$data = $tmp->fetchRow($where)->toArray();


          }

          public function deactivateAction()
          {
             $data = array(
                        'activate'     => '0'               
                );

            $tmp = new Application_Model_Users();
            $where = "id = ".$this->_request->getParam('id');

            $tmp->update($data,$where);
                    
            $this->view->msg = "profile updated";
            $this->_redirect('index/members/id/1');


            //$data = $tmp->fetchRow($where)->toArray();


          }

          

        


          


        

 }
