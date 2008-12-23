<?php

class wfr_admin_system_profiles extends wf_route_request {
	private $a_admin;
	private $a_session;
	private $a_profile;
	private $a_lang;

	public function __construct($wf) {
		$this->wf = $wf;

		$this->a_admin   = $this->wf->admin_html();
		$this->a_session = $this->wf->core_session();
		$this->a_profile = $this->wf->core_profile();
		$this->lang      = $this->wf->core_lang()->get_context('admin/system/profiles');

		$p = $this->a_profile->register_profile(
			'core_session_extend',
			'Informations &eacute;tendues sur l\'utilisateur'
		);
		$p->register('sex', 'Sexe', CORE_PROFILE_BOOL, false);

		$p = $this->a_profile->register_profile(
			'forum',
			'Forum'
		);
		$p->register('nickname', 'Pseudo', CORE_PROFILE_VARCHAR, false);
	}

	public function edit() {
		$ghost = trim($this->wf->core_request()->get_ghost(), '/');
		$arr   = explode('/', $ghost);
		$uid   = $arr[0];
		$pid   = $arr[1];

		/* valid user and profile */
		$user    = $this->a_session->user_info($uid);
		$profile = $this->a_profile->group_find(NULL, $pid);
		if(!$user || !$profile) {
			$this->wf->core_request()->set_header(
				'Location',
				$this->wf->linker('/admin/system/users/list')
			);
			$this->wf->core_request()->send_headers();
			exit(0);
		}

		$form_fields = $this->wf->get_var('profile');
		$profile_ctx = $this->a_profile->register_profile($profile[0]['name']);
		foreach($form_fields as $var => $value) {
			$profile_ctx->set_value($var, $uid, $value);
		}

		$this->wf->core_request()->set_header(
			'Location',
			$this->wf->linker('/admin/system/profiles/show/'.$uid.'/'.$profile[0]['id'])
		);
		$this->wf->core_request()->send_headers();
		exit(0);
	}

	public function show() {
		$ghost = trim($this->wf->core_request()->get_ghost(), '/');
		$arr   = explode('/', $ghost);
		$uid   = $arr[0];
		$pid   = $arr[1];

		/* invalid user */
		$user = $this->a_session->user_info($uid);
		if(!$user) {
			$this->wf->core_request()->set_header(
				'Location',
				$this->wf->linker('/admin/system/users/list')
			);
			$this->wf->core_request()->send_headers();
			exit(0);
		}

		$acc_items = array();

		/* get profiles */
		$profiles = $this->a_profile->group_find();
		foreach($profiles as $profile) {
			/* create form */
			$form = new core_form($this->wf, 'form_edit_profile'.$profile['id']);
			$form->action = $this->wf->linker('/admin/system/profiles/edit/'.$uid.'/'.$profile['id']);
			$form->method = 'post';

			/* get fields */
			$p = $this->a_profile->register_profile($profile['name']);
			$fields = $p->get_all_fields();

			/* add fields */
			foreach($fields as $field) {
				$field_id    = 'field'.$field['id'];
				$field_value = $p->get_value($field['field'], $uid);

				switch($field['type']) {
					case CORE_PROFILE_NUM:
						$elt = new core_form_text($field_id);
						$elt->value = $field_value;
						break;
						
					case CORE_PROFILE_BOOL:
						$elt = new core_form_radio($field_id);
						$elt->orientation = 'horizontal';
						$elt->options  = array(TRUE => 'Oui', FALSE => 'Non');
						$elt->selected = $field_value;
						break;
						
					case CORE_PROFILE_VARCHAR:
						$elt = new core_form_text($field_id);
						$elt->value = $field_value;
						break;
					
					case CORE_PROFILE_DATA:
						$elt = new core_form_textarea($field_id);
						$elt->value = $field_value;
						break;
					
					default:
						$elt = new core_form_text($field_id);
						$elt->value = $field_value;
						break;
				}
				$elt->name  = 'profile['.$field['field'].']';
				$elt->label = base64_decode($field['description']);
				$form->add_element($elt);
			}

			/* add submit button */
			$elt = new core_form_submit($form_name.'_submit');
			$elt->value = 'Enregistrer';
			$form->add_element($elt);

			/* construct accordion item with the form */
			$title =
				'<h2 class="accordiontitle">'.
				'<img src="'.$this->wf->linker('/data/icons/22x22/expand.png').'" alt="" /> '.
				base64_decode($profile['description']).
				'</h2>';
			$acc_items[$title] = $form->render('/admin/system/profiles/form');
		}

		$this->a_admin->set_title($this->lang->ts('Profil avancé de l\'utilisateur'));
		$this->a_admin->set_subtitle($this->lang->ts('Profil avancé de l\'utilisateur'));

		$acc = new ajax_accordion($this->wf, 'profiles');
		$acc->selected = $pid ? $pid : 1;
		$acc->items = $acc_items;

		$tpl = new core_tpl($this->wf);
		$tpl->set('forms', $acc->render());
		$this->a_admin->rendering($tpl->fetch('/admin/system/profiles/edit'));
	}

}
