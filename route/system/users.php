<?php

class wfr_admin_system_users extends wf_route_request {
	private $a_admin_html;
	private $a_core_session;
	
	public function __construct($wf) {
		$this->wf = $wf;
		$this->a_admin_html = $this->wf->admin_html();
		$this->a_core_session = $this->wf->core_session();
	}

	public function show() {
		$this->a_admin_html->set_title("Administration");
		$this->a_admin_html->set_subtitle("Gestionnaire d'utilisateur");
		$this->a_admin_html->rendering($this->render_list());
	}
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 *
	 * Rail function used to add a user
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	public function add() {
		$ok = true;

		/* no email */
		if(!$_POST['email']) {
// 			$this->a_admin_html->add_error(
// 				'L\'adresse email de l\'utilisateur n\'a pas
// 				&eacute;t&eacute; sp&eacute;cifi&eacute;e.'
// 			);
			$ok = false;
		}
		else {
			/* FATAL: email already exists */
			if($this->a_core_session->user_search_by_mail($_POST['email'])) {
// 				$this->a_admin_html->add_error(
// 					'Un utilisateur poss&eacute;dant cette adresse email
// 					(<strong>'.htmlentities($_POST['email']).'</strong>)
// 					existe d&eacute;j&agrave; dans la base de donn&eacute;es.'
// 				);
				$this->show();
				return;
			}
			/* email invalid */
			if(!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
// 				$this->a_admin_html->add_error(
// 					'L\'adresse email de l\'utilisateur est malform&eacute;e.'
// 				);
				$ok = false;
			}
		}

		/* no password */
		if(!$_POST['password']) {
// 			$this->a_admin_html->add_error(
// 				'Le mot de passe de l\'utilisateur n\'a pas
// 				&eacute;t&eacute; sp&eacute;cifi&eacute;.'
// 			);
			$ok = false;
		}
		/* no password confirmation */
		if($_POST['password'] && !$_POST['password_confirm']) {
// 			$this->a_admin_html->add_error(
// 				'Le mot de passe de l\'utilisateur n\'a pas
// 				&eacute;t&eacute; confirm&eacute;.'
// 			);
			$ok = false;
		}
		/* passwords mismatch */
		if($_POST['password'] && $_POST['password_confirm']
		&& $_POST['password'] != $_POST['password_confirm']) {
// 			$this->a_admin_html->add_error(
// 				'Les deux mots de passe fournis ne correspondent pas.'
// 			);
			$ok = false;
		}

		if($ok) {
			$perms  = array();
			$values = array();

			$t = explode("\n", $_POST['perms']);
			foreach($t as $perm) {
				$perm = trim($perm, " \r\n");
				if($perm) {
					$ret = preg_match('/^(.*)\([^\)]*\)$/', $perm, $res);
					if($ret) {
						$perms[]  = $res[1];
						$values[] = $res[2];
					}
					else {
						$perms[]  = $perm;
						$values[] = NULL;
					}
				}
			}

			$this->a_core_session->user_add(array(
				"email"       => $_POST['email'],
				"password"    => $_POST['password'],
				"name"        => $_POST['name'],
				"permissions" => &$perms,
				"values"      => &$values
			));
		}

		$this->wf->core_request()->set_header(
			'Location',
			$this->wf->linker('/admin/system/users/list')
		);
		$this->wf->core_request()->send_headers();
		exit(0);
	}

	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 *
	 * Rail function used to edit a user
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	public function edit() {
		$ok = true;

		/* FATAL: no id */
		if(!$_POST['id']) {
// 			$this->a_admin_html->add_error(
// 				'L\'identifiant de l\'utilisateur &agrave; &eacute;diter
// 				n\'a pas &eacute;t&eacute; sp&eacute;cifi&eacute;.'
// 			);
			$this->show();
			return;
		}

		/* get user infos */
		$user_infos = $this->a_core_session->user_info($_POST['id']);

		/* FATAL: id doesn't exist */
		if(!$user_infos) {
// 			$this->a_admin_html->add_error(
// 				'L\'utilisateur &agrave; supprimer n\'existe
// 				 pas dans la base de donn&eacute;es.'
// 			);
			$this->show();
			return;
		}

		/* no email */
		if(!$_POST['email']) {
// 			$this->a_admin_html->add_error(
// 				'L\'adresse email de l\'utilisateur n\'a pas
// 				&eacute;t&eacute; sp&eacute;cifi&eacute;e.'
// 			);
			$ok = false;
		}
		else {
			/* FATAL: email has changed and already exists */
			if($_POST['email'] != $user_infos['email']
			&& $this->a_core_session->user_search_by_mail($_POST['email'])) {
// 				$this->a_admin_html->add_error(
// 					'Un utilisateur poss&eacute;dant cette adresse email
// 					(<strong>'.htmlentities($_POST['email']).'</strong>)
// 					existe d&eacute;j&agrave; dans la base de donn&eacute;es.'
// 				);
				$this->show();
				return;
			}
			/* email invalid */
			if(!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
// 				$this->a_admin_html->add_error(
// 					'L\'adresse email de l\'utilisateur est malform&eacute;e.'
// 				);
				$ok = false;
			}
		}

		/* no password confirmation */
// 		if($_POST['password'] && !$_POST['password_confirm']) {
// 			$this->a_admin_html->add_error(
// 				'Le mot de passe de l\'utilisateur n\'a pas
// 				&eacute;t&eacute; confirm&eacute;.'
// 			);
// 			$ok = false;
// 		}
		/* passwords mismatch */
		if($_POST['password'] && $_POST['password_confirm']
		&& $_POST['password'] != $_POST['password_confirm']) {
// 			$this->a_admin_html->add_error(
// 				'Les deux mots de passe fournis ne correspondent pas.'
// 			);
			$ok = false;
		}

		if($ok) {
			$perms  = array();
			$values = array();

			$t = explode("\n", $_POST['perms']);
			foreach($t as $perm) {
				$perm = trim($perm, " \r\n");
				if($perm) {
					$ret = preg_match('/^(.*)\(([^\)]*)\)$/', $perm, $res);
					if($ret) {
						$perms[]  = $res[1];
						$values[] = $res[2];
					}
					else {
						$perms[]  = $perm;
						$values[] = NULL;
					}
				}
			}

			$data = array(
				"email"       => $_POST['email'],
				"name"        => $_POST['name'],
				"permissions" => &$perms,
				"values"      => &$values
			);

			if($_POST['password'] == $_POST['password_confirm']) {
				$data['password'] = $_POST['password'];
			}

			$this->a_core_session->user_mod(
				$_POST['id'],
				$data
			);
		}

		$this->wf->core_request()->set_header(
			'Location',
			$this->wf->linker('/admin/system/users/list')
		);
		$this->wf->core_request()->send_headers();
		exit(0);
	}

	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 *
	 * Rail function used to delete a user
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	public function delete() {
		$this->a_core_session->user_del($_POST['id']);

		$this->wf->core_request()->set_header(
			'Location',
			$this->wf->linker('/admin/system/users/list')
		);
		$this->wf->core_request()->send_headers();
		exit(0);
	}

	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 *
	 * Rendering user list
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	private function render_list() {
		/* fetch user list */
		$users = $this->a_core_session->user_list();
		$list = array();
		foreach($users as $user) {
			$from = $user['remote_address'];
			if($user['remote_address'])
				$from .= " (".
					$user['remote_hostname'].
					")";

			$perms = array();
			$perm_list = $this->a_core_session->user_get_permissions($user['id']);
			foreach($perm_list as $perm => $value) {
				if($value !== TRUE) {
					$perm .= '('.$value.')';
				}
				$perms[] = $perm;
			}

			$online = time() - $user['session_time'] <= $this->a_core_session->get_timeout();

			$list[] = array(
				'id'          => $user['id'],
				'email'       => $user['email'],
				'name'        => htmlentities($user['name'], HTML_ENTITIES, 'UTF-8'),
				'_name'       => utf8_decode($user['name']),
				'create_time' => date('d/m/Y', $user['create_time']),
				'from'        => $from,
				'online'      => $online,
				'perms'       => $perms
			);
		}
		
		$tpl = new core_tpl($this->wf);
		$tpl->set('scripts', $this->render_dialogs());
		$tpl->set('users', &$list);
		
		return($tpl->fetch('admin/system/users/list'));
	}
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 *
	 * All function to render form etc...
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	private function render_add_form() {
		$tpl = new core_tpl($this->wf);
		return($tpl->fetch('admin/system/users/form_add'));
	}

	private function render_edit_form() {
		$tpl = new core_tpl($this->wf);
		return($tpl->fetch('admin/system/users/form_edit'));
	}

	private function render_delete_form() {
		$tpl = new core_tpl($this->wf);
		return($tpl->fetch('admin/system/users/form_delete'));
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
