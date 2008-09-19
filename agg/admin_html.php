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

class admin_html extends wf_agg {

	private $a_core_route;
	private $a_core_request;
	private $a_core_session;

	private $page_subtitle    = null;
	private $page_hint        = '&nbsp;';
	private $help_title       = '&nbsp;';
	private $help_text        = '&nbsp;';
	private $sidebar_ext      = null;
	private $sidebar_actions  = array();

	private $errors           = array();
	private $sel_section_id   = -1;
	private $sel_section_lvl  = -1;
	private $current_link;

	public function loader($wf) {
		$this->wf = $wf;
		$this->a_core_route = $this->wf->core_route();
		$this->a_core_request = $this->wf->core_request();
		$this->a_core_session = $this->wf->core_session();

		$uri = $this->a_core_request->channel[3];
		$ghost = $this->a_core_request->get_ghost();
		$this->current_link = substr($uri, 0, strlen($uri) - strlen($ghost));
	}

	public function set_page_subtitle($subtitle) {
		$this->page_subtitle = $subtitle;
	}

	public function set_page_hint($hint) {
		$this->page_hint = $hint;
	}

	public function set_help_title($title) {
		$this->help_title = $title;
	}

	public function set_help_text($text) {
		$this->help_text = $text;
	}

	public function set_sidebar_ext($ext) {
		$this->sidebar_ext = $ext;
	}

	public function add_sidebar_action($title, $url) {
		$this->sidebar_actions[] = array(
			'title' => $title,
			'url'   => $url
		);
	}

	public function get_subroutes($link, $recur = false, $l = -1) {
		$dir = explode("/", rtrim($link, '/'));
		$nav = &$this->a_core_route->routes;
		for($i=1; $i<count($dir); $i++) {
			if(isset($nav[0][$dir[$i]]))
				$nav = &$nav[0][$dir[$i]];
			else
				return(array());
		}
		return($this->list_routes(&$nav[0], $link, $recur, $l));
	}

	private function list_routes($routes, $link, $recur = false, $l_limit = -1, $l = 0, $base = '', $subroutes = array()) {
		foreach($routes as $id => $route) {
			foreach($route as $i => $infos) {
				if(isset($infos[0])) {
					/* check if the section is visible */
					$visibility = ($infos[2] == WF_ROUTE_ACTION) ? $infos[6] : $infos[5];
					if($visibility == WF_ROUTE_HIDE)
						break;

					$uri = $link.$base.'/'.$id;

					/* fill section infos */
					$level_diff = ($subroutes) ? $l - $subroutes[count($subroutes) - 1]['level'] + 1 : 1;
					$subroutes[] = array(
						'uri'        => $uri,
						'name'       => ($infos[2] == WF_ROUTE_ACTION) ? $infos[5] : $infos[4],
						'link'       => $this->wf->linker($uri),
						'style'      => null,
						'level'      => $l,
						'level_diff' => $level_diff
					);

					/* check the current section */
					$selected = (substr($this->current_link, 0, strlen($uri)) == $uri);
					if($selected && $l > $this->sel_section_lvl) {
						if($this->sel_section_id >= 0)
							$subroutes[$this->sel_section_id]['selected'] = false;
						$this->sel_section_id = count($subroutes) - 1;
						$this->sel_section_lvl = $l;
						$subroutes[$this->sel_section_id]['selected'] = true;
					}
				}
				else if($recur && ($l < $l_limit || $l_limit < 0))
					$this->list_routes(&$infos, $link, $recur, $l_limit, $l + 1, $base.'/'.$id, &$subroutes);
			}
		}
		return($subroutes);
	}

	public function add_error($error) {
		$this->errors[] = $error;
	}

	public function rendering($body) {
		/* add admin sections */
		$sections = array(array(
			'uri'        => '/',
			'name'       => 'Panneau d\'administration',
			'link'       => $this->wf->linker('/admin'),
			'selected'   => ($this->current_link == '/admin'),
			'style'      => 'home',
			'level'      => 0,
			'level_diff' => 1
		));
		$sections = array_merge($sections, $this->get_subroutes('/admin', true, 1));

		$tpl = new core_tpl($this->wf);
		$tpl->set('user',             $this->a_core_session->me);
		$tpl->set('page_subtitle',    $this->page_subtitle);
		$tpl->set('page_hint',        $this->page_hint);
		$tpl->set('help_title',       $this->help_title);
		$tpl->set('help_text',        $this->help_text);
		$tpl->set('sidebar_sections', $sections);
		$tpl->set('sidebar_ext',      $this->render_routes_tree().$this->sidebar_ext);
		$tpl->set('sidebar_actions',  $this->sidebar_actions);
		$tpl->set('errors',           $this->errors);
		$tpl->set('body',             $body);
		$this->wf->core_html()->rendering($tpl->fetch('admin/main'));
	}

	public function render_routes_tree() {
		$tpl = new core_tpl($this->wf);
		$r = $this->get_subroutes('', true);
		$tpl->set('routes', $r);
		return($tpl->fetch('admin/routes'));
	}

}
