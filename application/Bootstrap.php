<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initStatesList()
    {
        if (!Zend_Registry::isRegistered('states'))
        {
            $dataFile = '../data/us-states.xml';
            $states = array();
            $data = simplexml_load_file($dataFile);

            foreach ($data->item as $item)
             {
                $states[(string) $item->value] = (string) $item->label;
        	 }
            
            Zend_Registry::set('states', $states);
        }
    }
}

