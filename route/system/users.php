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
	 * Rail function used to produce user edition
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	public function list_edit() {

		$id = (int)$this->wf->core_request()->get_argv(0);
		$user = $this->a_core_session->user_info($id);
		$perms = $this->a_core_session->user_get_permissions($id);
		$tpl = new core_tpl($this->wf);
		
		/* construction de la perm list */
		$perms_list = NULL;
		foreach($perms as $k => $v)
			$perms_list .= !$perms_list ? "$k" : ", $k";
		
		$tpl->set("id", $user["id"]);
		$tpl->set("email", $user["email"]);
		$tpl->set("name", $user["name"]);
		$tpl->set("perms", $perms_list);
		
		echo $tpl->fetch('admin/system/users/list_form_edit');
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
// 		/* fetch user list */
// 		$users = $this->a_core_session->user_list();
// 		$list = array();
// 		foreach($users as $user) {
// 			$from = $user['remote_address'];
// 			if($user['remote_address'])
// 				$from .= " (".
// 					$user['remote_hostname'].
// 					")";
// 
// 			$perms = array();
// 			$perm_list = $this->a_core_session->user_get_permissions($user['id']);
// 			if($perm_list) {
// 				foreach($perm_list as $perm => $value) {
// 					if($value !== TRUE) {
// 						$perm .= '('.$value.')';
// 					}
// 					$perms[] = $perm;
// 				}
// 			}
// 
// 			$online = time() - $user['session_time'] <= $this->a_core_session->get_timeout();
// 
// 			$list[] = array(
// 				'id'          => $user['id'],
// 				'email'       => $user['email'],
// 				'name'        => htmlentities($user['name'], HTML_ENTITIES, 'UTF-8'),
// 				'_name'       => utf8_decode($user['name']),
// 				'createtime'  => $user['create_time'],
// 				'from'        => $from,
// 				'online'      => $online,
// 				'perms'       => $perms,
// 				'lastauth'    => $user['session_time_auth']
// 			);
// 		}
// 		
// 		$tpl = new core_tpl($this->wf);
// 		$tpl->set('scripts', $this->render_dialogs());
// 		$tpl->set('users', &$list);
// 		
// 		return($tpl->fetch('admin/system/users/list'));

		$dsrc  = new core_datasource_db($this->wf, "core_session");
		$dset  = new core_dataset($this->wf, $dsrc);
		
		$filters = array();
		$cols = array(
			'icons' => array(),
			'name' => array(
				'name'      => 'Nom',
				'orderable' => true,
			),
			'email' => array(
				'name'      => 'E-mail',
				'orderable' => true,
			),
			'ip' => array(
				'name'      => 'Adresse IP'
			),
			'login' => array(
				'name'      => 'Login'
			),
			'actions' => array()
			
		);
		
		$dset->set_cols($cols);
		$dset->set_filters($filters);
		
		$dset->set_row_callback(array($this, 'callback_row'));

		/* template utilisateur */
		$tplset = array(
			'scripts' => $this->render_dialogs()
		);
		$dview = new core_dataview($this->wf, $dset);
		$dview_render = $dview->render('admin/system/users/list', $tplset);
		return($dview_render);
	}
	
	public function callback_row($row, $datum) {
	
		/* user online ? */
		$online = time() - $datum['session_time'];
		if($online > $this->a_core_session->get_timeout()) {
			$icon = '<img src="'.
				$this->wf->linker('/data/icons/16x16/offline.png').
				'" alt="[On line]" title="On line" />';
			$ip = '-';
		}
		else if($datum['session_id']) {
			$icon = '<img src="'.
				$this->wf->linker('/data/icons/16x16/online.png').
				'" alt="[On line]" title="On line" />';
			
			$ip = $datum["remote_address"]." (".
				gethostbyaddr($datum["remote_address"]).
				")";
		}
		
		/* adresse IP */
		if($datum['session_time_auth']) {
			$login_date = date('d/m/Y H:i:s', $datum['session_time_auth']);
		}
		else {
			$login_date = '-';
			
		}
		
		/* actions */
		$actions = '<a href="#" onclick="'.
			"set_form_edit_user('".
			$datum['id'].
			"')\">Edit</a>".
			
			" | ".
			
			'<a href="'.
			$this->wf->linker("/admin/system/profiles/show/".$datum['id']).
			"\">Profile</a>".
			
			" | ".
			
			'<a href="#" onclick="'.
			"set_form_delete_user('".
			$datum['id']."', '".
			$datum['email'].
			"')\">Edit</a>"
		;
		
		return(array(
			'icon'    => $icon,
			'email'   => htmlentities($row['email']),
			'name'    => htmlentities($row['name']),
			'ip'      => $ip,
			'login'   => $login_date,
			'actions' => $actions
		));
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
		
		$ar = new ajax_async_req($this->wf, 'user_edition');
		$ar->resp_id = 'user_edition';
		$buf .= $ar->render();

		return($buf);
	}
}
