<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Web Framework 1                                       *
 * BinarySEC (c) (2000-2008) / www.binarysec.com         *
 * Author: Olivier Pascal <op@binarysec.com>             *
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

class admin_users extends wf_agg {

	/** Properties **/

	private $a_core_cacher   = null;
	private $a_core_session  = null;

	private $base_admin_link = '/admin/users';
	private $base_link       = '';
	private $users           = array();
	private $data_valid      = false;


	/** Public methods **/


	/* Aggregator loader */

	public function loader($wf) {
		$this->wf = $wf;
		$this->a_core_cacher = $this->wf->core_cacher();
		$this->a_core_session = $this->wf->core_session();
	}


	/* Renderers (render_*) */

	public function render_list() {
		$this->load_data();

		$tpl = new core_tpl($this->wf);
		$tpl->set('scripts', $this->render_dialogs());
		$tpl->set('users', $this->users);
		return($tpl->fetch('admin/users/list'));
	}


	/* Verifications */

	public function exists_by_email($email) {
		return(!!$this->a_core_session->user_search_by_mail($email));
	}


	/* Actions */

	public function add($email, $password, $name, $perms) {
		$this->a_core_session->user_add(array(
			'email'       => $email,
			'name'        => $name,
			'password'    => $password,
			'permissions' => $this->gen_perms($perms)
		));

		/* invalid cached data */
		$this->data_valid = false;
	}

	public function edit($id, $email, $password, $name, $perms) {
		$this->a_core_session->user_mod(
			$id,
			array(
				'email'       => $email,
				'name'        => $name,
				'password'    => $password,
				'permissions' => $this->gen_perms($perms)
			)
		);

		/* invalid cached data */
		$this->data_valid = false;
	}

	public function delete($id) {
		$this->a_core_session->user_del($id);

		/* invalid cached data */
		$this->data_valid = false;
	}

	public function get($id) {
		return($this->a_core_session->user_info($id));
	}


	/** Private methods **/


	/* Data retriever */

	private function load_data() {
		if($this->data_valid)
			return;

		/* load cache */
		if(($c = $this->a_core_cacher->get('admin_users')) != NULL) {
			$this->users = $c;
			$this->data_valid = true;
			return;
		}

		$users = $this->a_core_session->user_list();
		$this->users = $this->gen_list(&$users);

		/* valid cached data */
		$this->data_valid = true;

		/* store data into the cache */
		$this->a_core_cacher->store('admin_users', $this->cats);
	}


	/* Generators (gen_*) */

	private function gen_list($users) {
		$list = array();
		foreach($users as $user) {
			$perms = unserialize($user['permissions']);
			$list[] = array(
				'id'          => $user['id'],
				'email'       => $user['email'],
				'name'        => $user['name'],
				'create_time' => date('d/m/Y', $user['create_time']),
				'perms'       => ($perms) ? implode(', ', $perms) : '',
				'online'      => (!!$user['session_id']),
			);
		}
		return($list);
	}

	public function gen_perms($data) {
		$perms = array();
		$arr = explode(',', $data);
		foreach($arr as $perm)
			if(($p = trim($perm))) $perms[] = $p;
		return($perms);
	}


	/* Renderers (render_*) */

	private function render_add_form() {
		$tpl = new core_tpl($this->wf);
		return($tpl->fetch('admin/users/form_add'));
	}

	private function render_edit_form() {
		$tpl = new core_tpl($this->wf);
		return($tpl->fetch('admin/users/form_edit'));
	}

	private function render_delete_form() {
		$tpl = new core_tpl($this->wf);
		return($tpl->fetch('admin/users/form_delete'));
	}

	private function render_add_dialog() {
		$dlg = new ajax_dialog($this->wf, 'add_user');
		$dlg->title = 'Ajouter un nouvel utilisateur';
		$dlg->content = $this->render_add_form();
		return($dlg->render());
	}

	private function render_edit_dialog() {
		$dlg = new ajax_dialog($this->wf, 'edit_user');
		$dlg->title = '&Eacute;diter l\'utilisateur';
		$dlg->content = $this->render_edit_form();
		return($dlg->render());
	}

	private function render_delete_dialog() {
		$dlg = new ajax_dialog($this->wf, 'delete_user');
		$dlg->title = 'Supprimer l\'utilisateur';
		$dlg->content = $this->render_delete_form();
		return($dlg->render());
	}

	private function render_dialogs() {
		$buf .= $this->render_add_dialog();
		$buf .= $this->render_edit_dialog();
		$buf .= $this->render_delete_dialog();
		return($buf);
	}

}
