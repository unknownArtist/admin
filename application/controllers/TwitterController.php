<?php

class TwitterController extends Zend_Controller_Action
{

    public function init()
    {
       
    }

    public function indexAction()
    {
    	

		
    }

    public function aboutusAction() 
    {
    	$url=$_SERVER['REQUEST_URI'];
		$u = explode('/', $url);
		echo $u[3];
		
		
    }
}