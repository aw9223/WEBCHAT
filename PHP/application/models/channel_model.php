<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Channel_model extends CI_Model 
{
    function __construct() 
    {
        parent::__construct();

        $this->load->database();
    }
    
    function _process($row)
    {
        if ($row == FALSE OR count($row) == 0)
        {
            return FALSE;
        }
	    
        return (object) array( 
        );
    }
    
    function get($id)
    {
        
    }
    
    function list_of_channel($context)
    {
        
    }
}