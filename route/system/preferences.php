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
 
class wfr_admin_system_preferences extends wf_route_request {
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
	public function show_groups() {
		$this->a_admin_html->set_title(
			$this->lang->ts("Gestionnaire des préférences")
		);
		$this->a_admin_html->set_subtitle(
			$this->lang->ts("Gestionnaire des préférences")
		);
		
		/* get all groups */
		$list = array();
		$groups = $this->a_core_pref->group_find();
		foreach($groups as &$group) {
			$link = $this->wf->linker(
				"/admin/system/preferences/vars/show/$group[name]"
			);
			$list[] = array(
				$o = $this->a_core_pref->register_group($group["name"]),
				$link
			);
		}
		
		/* Create the side bar */
		$tpl = new core_tpl($this->wf);
		$tpl->set('groups', &$list);
		$this->a_admin_html->add_sidebar(
			$this->lang->ts("Fast group access"), 
			$tpl->fetch('admin/system/preferences/sb_groups_access')
		);
		
		/* create en render the page */
		$tpl = new core_tpl($this->wf);
		$tpl->set('groups', &$list);
		$this->a_admin_html->rendering(
			$tpl->fetch('admin/system/preferences/list_groups')
		);
		exit(0);
	}
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 *
	 * Show all vars 
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	public function show_vars() {
		/* get all groups */
		$list = array();
		$list_key = array();
		$groups = $this->a_core_pref->group_find();
		foreach($groups as &$group) {
			$link = $this->wf->linker(
				"/admin/system/preferences/vars/show/$group[name]"
			);
			$list_key[$group["name"]] = array(
				$o = $this->a_core_pref->register_group($group["name"]),
				$link
			);
			$list[] = &$list_key[$group["name"]];
		}
		
		/* get name */
		$name = $this->wf->core_request()->get_ghost();
		$name[0] = " ";
		$name = trim($name);
		
		/* get the object */
		if(!$list_key[$name]) {
			$this->wf->core_request()->set_header(
				"Location",
				$this->wf->linker("/")
			);
			$this->wf->core_request()->send_headers();
			exit(0);
		}
		
		/* get all variables */
		$vars = $list_key[$name][0]->get_all();

		/* decode description */
		foreach($vars as &$var) {
			$var["edit_url"] = $this->wf->linker(
				"/admin/system/preferences/vars/edit/$name/".
				$var["variable"]
			);
			$var["description"] = base64_decode($var["description"]);
		}
		
		/* Create the side bar */
		$tpl = new core_tpl($this->wf);
		$tpl->set('groups', &$list);
		$tpl->set('show_return', TRUE);
		$this->a_admin_html->add_sidebar(
			$this->lang->ts("Fast group access"), 
			$tpl->fetch('admin/system/preferences/sb_groups_access')
		);
		
		/* set titles */
		$this->a_admin_html->set_title(
			$this->lang->ts(array(
				"Edition des préférences: %s", 
				$list_key[$name][0]->description
			))
		);
		$this->a_admin_html->set_subtitle(
			$this->lang->ts(array(
				"Edition des préférences de %s", 
				$list_key[$name][0]->name
			))
		);

		$tpl = new core_tpl($this->wf);
		$tpl->set('vars', &$vars);
		$tpl->set('dialogs', $this->render_edit_dialogs());
		$this->a_admin_html->rendering(
			$tpl->fetch('admin/system/preferences/list_vars')
		);
		exit(0);
		
	}
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 *
	 * Render the simple edit form used for NUM/VARCHAR
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	private function render_edit_simple() {
		$dlg = new ajax_dialog($this->wf, 'edit_var_simple');
		$dlg->title = $this->lang->ts('Editer la variable');
		$tpl = new core_tpl($this->wf);
		$dlg->content = $tpl->fetch(
			'admin/system/preferences/list_vars_edit_simple'
		);
		return($dlg->render());
	}
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 *
	 * Render all forms/dialogs
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	private function render_edit_dialogs() {
		return(
			$this->render_edit_simple()
		);
	}
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 *
	 * Function used to receive a var modification form
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	public function edit_var() {
		/* get the  */
		$name = $this->wf->core_request()->get_ghost();
		$t = explode('/', $name);
		$i_group = &$t[1];
		$i_variable = &$t[2];
		
		/* get all groups */
		$list_key = array();
		$groups = $this->a_core_pref->group_find();
		foreach($groups as $group)
			$list_key[$group["name"]] = $this->a_core_pref->register_group(
				$group["name"]
			);
		
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
		
		
		/* get the input */
		$data = $this->wf->get_var("var");
	
		/* set input */
		$list_key[$i_group]->set_value(&$i_variable, &$data["value"]);

		/* return to the good page */
		$this->wf->core_request()->set_header(
			"Location",
			$this->wf->linker("/admin/system/preferences/vars/show/$i_group")
		);
		$this->wf->core_request()->send_headers();
		exit(0);
	}
	
}

