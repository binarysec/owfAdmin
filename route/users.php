<?php

class wfr_admin_users extends wf_route_request {

	private $a_admin_html;
	private $a_admin_users;

	public function __construct($wf) {
		$this->wf = $wf;
		$this->a_admin_html = $this->wf->admin_html();
		$this->a_admin_users = $this->wf->admin_users();
	}

	public function show() {
		$this->a_admin_html->set_subtitle("Gestionnaire d'utilisateur");


		$this->a_admin_html->rendering($this->a_admin_users->render_list());
	}

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
			if($this->a_admin_users->exists_by_email($_POST['email'])) {
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
			$this->a_admin_users->add(
				$_POST['email'],
				$_POST['password'],
				$_POST['name'],
				$_POST['perms']
			);
		}

		$this->show();
	}

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
		$user_infos = $this->a_admin_users->get($_POST['id']);

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
			&& $this->a_admin_users->exists_by_email($_POST['email'])) {
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
			$this->a_admin_users->edit(
				$_POST['id'],
				$_POST['email'],
				$_POST['password'],
				$_POST['name'],
				$_POST['perms']
			);
		}

		$this->show();
	}

	public function delete() {
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

		/* FATAL: id doesn't exist */
		if(!$this->a_admin_users->get($_POST['id'])) {
// 			$this->a_admin_html->add_error(
// 				'L\'utilisateur &agrave; supprimer n\'existe
// 				 pas dans la base de donn&eacute;es.'
// 			);
			$this->show();
			return;
		}

		if($ok) {
			$this->a_admin_users->delete($_POST['id']);
		}

		$this->show();
	}

}
