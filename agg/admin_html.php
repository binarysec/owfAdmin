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

	private $page_subtitle    = null;
	private $page_hint        = '&nbsp;';
	private $help_title       = '&nbsp;';
	private $help_text        = '&nbsp;';
	private $sidebar_ext    = null;
	private $sidebar_sections = array();
	private $sidebar_actions  = array();

	public function loader($wf) {
		$this->wf = $wf;
		$this->a_core_route = $this->wf->core_route();
		$this->a_core_request = $this->wf->core_request();
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

	public function add_sidebar_section($title, $url, $type = null) {
		$this->sidebar_sections[] = array(
			'title' => $title,
			'url'   => $url,
			'type'  => $type
		);
	}

	public function add_sidebar_action($title, $url) {
		$this->sidebar_actions[] = array(
			'title' => $title,
			'url'   => $url
		);
	}

	public function get_subroutes($link, $recur = false) {
		$dir = explode("/", rtrim($link, '/'));
		$nav = &$this->a_core_route->routes;
		for($i=1; $i<count($dir); $i++) {
			if(isset($nav[0][$dir[$i]]))
				$nav = &$nav[0][$dir[$i]];
			else
				return(array());
		}
		return($this->list_routes(&$nav[0], $link, $recur));
	}

	private function list_routes($routes, $base = '', $recur = false, $subroutes = array()) {
		foreach($routes as $name => $route) {
			foreach($route as $i => $infos) {
				if(isset($infos[0])) {
					$uri = $base.'/'.$name;
					$name = ($infos[2] == WF_ROUTE_ACTION) ? $infos[5] : $infos[4];
					$selected = (substr($this->a_core_request->channel[3].'/', 0, strlen($uri) + 1) == $uri.'/');
 					$subroutes[] = array(
						'uri'      => $uri,
						'name'     => $name,
						'selected' => $selected,
						'link'     => $this->wf->linker($uri),
						'style'    => 'config'
					);
				}
				else if($recur)
					$this->list_routes(&$infos, $base.'/'.$name, $recur, &$subroutes);
			}
		}
		return($subroutes);
	}

	public function rendering($body) {
		/* add admin index */
		$sections = array(array(
			'uri'      => '/',
			'name'     => 'Panneau d\'administration',
			'selected' => (rtrim($this->a_core_request->channel[3], '/') == '/admin'),
			'link'     => $this->wf->linker('/admin'),
			'style'    => 'users'
		));
		$sections = array_merge($sections, $this->get_subroutes('/admin'));

		$tpl = new core_tpl($this->wf);
		$tpl->set('page_subtitle',    $this->page_subtitle);
		$tpl->set('page_hint',        $this->page_hint);
		$tpl->set('help_title',       $this->help_title);
		$tpl->set('help_text',        $this->help_text);
		$tpl->set('sidebar_sections', $sections);
		$tpl->set('sidebar_ext',      $this->sidebar_ext);
		$tpl->set('sidebar_actions',  $this->sidebar_actions);
		$tpl->set('body',             $body);
		$this->wf->core_html()->rendering($tpl->fetch('admin/main'));
	}

}
