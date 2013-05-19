<?php
class Blogmodel extends CI_Model {

    

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_all()
    {
        $query = $this->db->get('project');
        return $query->result();
    }

    function insert_entry($values)
    {
        
		$this->db->insert('projects', $values);
    }

    function update_entry($values)
    {
       

        $this->db->update('entries', $values));
    }

}