<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class master_service extends CI_Controller {
	
	public function index()
	{
		$this->load->view('welcome_message');
	}
	
	public function task()
	{
		$sql ="select * from task_types  order by sort_order asc";
		
		$rows = $this->db->query($sql)->result_array();
		if(count($rows)==0)
		{
			echo "Error: no task in database";
			exit;
		}
		$html = "<data>";
		foreach($rows as $row)
		{
			$html .= "<task_row>";
			$html .= "<task_type_id>".$row["task_type_id"]."</task_type_id>";
			$html .= "<task_type_name>".$row["task_type_name"]."</task_type_name>";
			$html .= "<task_type_sort_order>".$row["sort_order"]."</task_type_sort_order>";
			
			$html .= "</task_row>";
			
		}
		$html .=  "</data>";
		header('Content-type: text/xml');
		echo $html;
		
	}
	
	public function project()
	{
		$sql ="select * from projects where ipad_active=1 order by project_code";
		
		$project_rows = $this->db->query($sql)->result_array();
		if(count($project_rows)==0)
		{
			echo "Error: no project in database";
			exit;
		}
		$html = "";
		//print_r($project_rows);
		
		$html .=  "<data>";
		
		foreach ($project_rows as  $project) {
			$html .="<project_row>";
			$html .="<project_id>".$project["project_id"]."</project_id>";
			$html .="<project_code>".$project["project_code"]."</project_code>";
			$html .="<project_name>".$project["project_name"]."</project_name>";
			$html .="<project_image>".base_url()."upload/projects/project_0000.png</project_image>";
			$html .="<ipad_active>".$project["ipad_active"]."</ipad_active>";
			$html .="<buildings>".$this->_building_tag_row($project["project_id"])."</buildings>";
			/*foreach ($project as $key => $value) {
			
				$html .="<$key>".$value[$key]."</$key>";
			}
			*/
			$html .="</project_row>";
		}
		
		
		$html .=  "</data>";
		
		header('Content-type: text/xml');
		echo $html;
		
	}
	private function _building_tag_row($project_id)
	{
		
		$this->db->where("project_id",$project_id);
		$building_rows = $this->db->get("buildings")->result_array();
		
		$html ="";
		  foreach($building_rows as $row)
		  {
		  	$html .="<building_row>";
		  	$html .= "<building_id>".$row["building_id"]."</building_id>";
		  	$html .= "<building_code>".$row["building_code"]."</building_code>";
		  	$html .= "<building_name>".$row["building_name"]."</building_name>";
		  	$html .=$this->_unit_tag_row($row["building_id"]);
		  	$html .="</building_row>";
		  
		  }
		
		return $html;
	}
	
	
	private function _unit_tag_row($building_id)
	{
		
		$this->db->where("building_id",$building_id);
		$building_rows = $this->db->get("units")->result_array();
		
		$html ="<unit_rows>";
		  foreach($building_rows as $row)
		  {
		  	$html .="<unit_row>";
		  	$html .= "<unit_id>".$row["unit_id"]."</unit_id>";
		  	$html .= "<unit_code>".$row["unit_code"]."</unit_code>";
		  	//$html .= "<layout_image>".$row["building_name"]."</layout_image>";
		  	$html .= "<unit_model>".$row["unit_model"]."</unit_model>";
		  	$html .= "<unit_area>".$row["unit_area"]."</unit_area>";
		  	$html .= "<floor_no>".$row["floor_no"]."</floor_no>";
		  	$html .="</unit_row>";
		  }
		$html .="</unit_rows>";
		return $html;
	}
}
 
