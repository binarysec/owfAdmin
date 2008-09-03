<?php
 
class admin extends wf_module {
	public function __construct($wf) {
		$this->wf = $wf;
	}
	
	public function get_name() { return("admin"); }
	public function get_description()  { return("Admin"); }
	public function get_banner()  { return("Admin/1.0"); }
	public function get_version() { return("1.0"); }
	public function get_authors() { return("Olivier PASCAL"); }
	public function get_depends() { return(NULL); }
	
	public function get_actions() {
		return(array(
			"/admin" => array(
				WF_ROUTE_ACTION,
				"admin",
				"show_admin",
				"Page admin",
				WF_ROUTE_HIDE,
				array("session:anon")
			)
		));
	}
}
