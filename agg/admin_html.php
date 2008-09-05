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
	private $title;
	private $subtitle;

	public function loader($wf) {
		$this->wf = $wf;
		$this->a_core_route = $this->wf->core_route();
	}

	public function set_title($title) {
		$this->title = $title;
	}

	public function set_subtitle($subtitle) {
		$this->subtitle = $subtitle;
	}

	private function get_subroutes($link, $recur = false) {
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
					$b = $base.'/'.$name;
 					$subroutes[$b] = ($infos[2] == WF_ROUTE_ACTION) ? $infos[5] : $infos[4];
				}
				else if($recur)
					$this->list_routes(&$infos, $base.'/'.$name, $recur, &$subroutes);
			}
		}
		return($subroutes);
	}

	public function rendering($body) {
		$tpl = new core_tpl($this->wf);
		$tpl->set('admin_sidemenu', $this->get_subroutes('/admin'));
		$tpl->set('admin_topmenu', '');
		$tpl->set('admin_date', date('M, m Y'));
		$tpl->set('admin_title', $this->title);
		$tpl->set('admin_subtitle', $this->subtitle);
		$tpl->set('admin_body', $body);
		$this->wf->core_html()->rendering($tpl->fetch('admin/main'));
	}

}
