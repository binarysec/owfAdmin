<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Web Framework 1                                       *
 * BinarySEC (c) (2000-2008) / www.binarysec.com         *
 * Author: Michael Vergoz <mv@binarysec.com>             *
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~         *
 *  Avertissement : ce logiciel est protégé par la       *
 *  loi du copyright et par les traités internationaux.  *
 *  Toute personne ne respectant pas ces dispositions    *
 *  se rendra coupable du délit de contrefaçon et sera   *
 *  passible des sanctions pénales prévues par la loi.   *
 *  Il est notamment strictement interdit de décompiler, *
 *  désassembler ce logiciel ou de procèder à des        *
 *  opération de "reverse engineering".                  *
 *                                                       *
 *  Warning : this software product is protected by      *
 *  copyright law and international copyright treaties   *
 *  as well as other intellectual property laws and      *
 *  treaties. Is is strictly forbidden to reverse        *
 *  engineer, decompile or disassemble this software     *
 *  product.                                             *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
 
class wfr_admin_admin_system_preferences extends wf_route_request {
	private $a_admin_html;
	private $a_core_pref;
	private $lang;
	
	public function __construct($wf) {
		$this->wf = $wf;
		$this->a_admin_html = $this->wf->admin_html();
		$this->a_core_pref = $this->wf->core_pref();
		$this->lang = $this->wf->core_lang()->get_context("admin/system/preferences");
	}

	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 *
	 * Show all groups
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	public function show() {
		
		/* get all groups */
		$list = array();
		$groups = $this->a_core_pref->group_find();
		$vars = array();
		foreach($groups as &$group) {
			$o = $this->a_core_pref->register_group($group["name"]);
			$ret = $o->get_all();
			foreach($ret as $k => $v) {
				foreach($v as $k2 => $v2) {
					$vars[$group["name"]][$k][$k2] =
						$k2 == "description" ?
						base64_decode($v2) :
						$v2;
				}
			}		
		}
		
		/* tpl */
		$tpl = new core_tpl($this->wf);
		$tpl->set('groups', $vars);
		
		/* render */
		$this->a_admin_html->set_title(
			$this->lang->ts("Gestionnaire des préférences")
		);
		$this->a_admin_html->rendering(
			$tpl->fetch('admin/system/preferences/list_groups')
		);
		exit(0);
	}
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 *
	 * Function used to receive a var modification form
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	public function edit() {
		/* get the input */
		$i_variable = $_POST["name"];
		$value = $_POST["value"];
		$i_group=$_POST["group"];
		
		/* get all groups */
		$list_key = array();
		$groups = $this->a_core_pref->group_find();
		foreach($groups as $group){
			$list_key[$group["name"]] = $this->a_core_pref->register_group(
				$group["name"]
			);
		}
			
		/* sanatize the group */
		if(!$list_key[$i_group]) {
			$this->wf->core_request()->set_header(
				"Location",
				$this->wf->linker("/")
			);
			$this->wf->core_request()->send_headers();
			exit(0);
		}
		
		/* sanatize the variable */
		$all_vars = $list_key[$i_group]->get_all($i_variable);
		if(!$all_vars[$i_variable]) {
			$this->wf->core_request()->set_header(
				"Location",
				$this->wf->linker("/")
			);
			$this->wf->core_request()->send_headers();
			exit(0);
		}
		/* set input */
		$list_key[$i_group]->set_value($i_variable, $value);

		/* return to the good page */
		$this->wf->core_request()->set_header(
			"Location",
			$this->wf->linker("/admin/system/preferences/")
		);
		$this->wf->core_request()->send_headers();
		exit(0);
	}
	
}
