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
	private $a_core_lang;
	private $a_core_html;
	
	private $lang;
	
	private $page_subtitle;
	private $page_sidebar = array();
	private $page_bottom;
	
	public function loader($wf) {
		$this->wf = $wf;
		$this->a_core_route = $this->wf->core_route();
		$this->a_core_request = $this->wf->core_request();
		$this->a_core_session = $this->wf->core_session();
		$this->a_core_lang = $this->wf->core_lang();
		$this->a_core_html = $this->wf->core_html();
		
		$this->lang = $this->a_core_lang->get_context("admin/html");
		
		$this->generate_route();
	}
	
	public function set_title($title) {
		$this->a_core_html->set_title($title);
	}

	public function set_subtitle($subtitle) {
		$this->page_subtitle = $subtitle;
	}
	
	public function add_sidebar($title, $data) {
		$this->page_sidebar[] = array(
			'title' => $title,
			'data'   => $data
		);
	}
	
	public function add_bottom($data) {
		$this->page_bottom .= " / $data";
	}
	
	private function generate_menu_array(&$nav, $dir, $pos, $title, $link="/") {
		$buf = array();
		foreach($nav as $key => $val) {

			if(
				$val[1][2] == WF_ROUTE_ACTION && 
				$val[1][6] == WF_ROUTE_SHOW
				) {
				$linked = $this->wf->linker(
					$link.$key
				);
				if($dir[$pos] != $key) {
					$buf['label'][] = '<li class="admin_route_list_unselected">'.
						'<a href="'.$linked.'">'.
						$this->lang->ts($val[1][5]).
						"</a></li>\n";
				}
				else {
					$buf['label'][] = '<li class="admin_route_list_selected">'.
						'<a href="'.$linked.'">'.
						$this->lang->ts($val[1][5]).
						"</a></li>\n";
				}
			}
			else if(
				$val[1][2] == WF_ROUTE_REDIRECT && 
				$val[1][5] == WF_ROUTE_SHOW
				) {
				$linked = $this->wf->linker(
					$link.$key
				);
				if($dir[$pos] != $key) {
					$buf .= '<li class="admin_route_list_unselected">'.
						'<a href="'.$linked.'">'.
						$this->lang->ts($val[1][4]).
						"</a></li>\n";
				}
				else {
					$buf .= '<li class="admin_route_list_selected">'.
						'<a href="'.$linked.'">'.
						$this->lang->ts($val[1][4]).
						"</a></li>\n";
						
					$title .= ":: ".$this->lang->ts($val[1][4])." ";
				}
			}
	
			if(is_array($val[0]))
				$buf .= $this->generate_menu_array(
					&$val[0], 
					&$dir, 
					&$title, 
					$link.
					"$key/"
				);
		}
		$buf .= "</ul>";
		return($buf);
	}
	
	public function rendering($body) {
		$tpl = new core_tpl($this->wf);
		$tpl->set('user',          $this->a_core_session->me);
		$tpl->set('page_subtitle', $this->page_subtitle);
		$tpl->set('langs',         $this->a_core_lang->get_list());

		/* check si on doit ajouter le side admin */
		if($this->a_core_request->channel[2][0] == "admin") {
			$this->add_sidebar(
				$this->lang->ts("Administration"),
				$this->page_adm_route
			);
			$tpl->set('page_sidebar',     array_reverse($this->page_sidebar));
		}
		
		/* navigation menu */
		$menu = new ajax_topnav($this->wf, 'admin_menu');
		$menu->menu = $this->page_menu;
		$tpl->set('navigation',       $menu->render());
		
		/* add the bottom */
		$this->add_bottom(
			$this->lang->ts(array(
				"%s SQL requests", 
				$this->wf->db->get_request_counter()
			))
		);
		$tpl->set('bottom',           $this->page_bottom);
		
		/* the body .. */
		$tpl->set('body',             $body);
		
		$this->wf->core_html()->rendering($tpl->fetch('admin/main'));
	}

	private function generate_li(&$nav, $dir, $pos, $title, $arr, $link="/", $use=FALSE) {
		$buf = '';
		foreach($nav as $key => $val) {
			$toadd = FALSE;
			
			if(strncmp("/admin", $link, 6) == 0)
				$use = TRUE;
			if(
				$val[1][2] == WF_ROUTE_ACTION && 
				$val[1][6] == WF_ROUTE_SHOW
				) {
				$linked = $this->wf->linker(
					$link.$key
				);
				
				if($use) {
					if($dir[$pos] != $key) {
						$subclass = "admin_route_list_unselected";
					}
					else {
						$subclass = "admin_route_list_selected";
							
						$title .= ":: ".$this->lang->ts($val[1][5])." ";
					}
					
					$buf .= '<li class="'.$subclass.'">'.
						'<a href="'.$linked.'">'.
						$this->lang->ts($val[1][5]).
						"</a></li>\n";
						
					$this->page_adm_route_c++;
				}
				
				$in = array(
					"label" => $this->lang->ts($val[1][5]),
					"link" => $linked
				);
				$toadd = TRUE;
			}
			else if(
				$val[1][2] == WF_ROUTE_REDIRECT && 
				$val[1][5] == WF_ROUTE_SHOW
				) {
				$linked = $this->wf->linker(
					$link.$key
				);
				
				if($use) {
					if($dir[$pos] != $key) {
						$subclass = "admin_route_list_unselected";
					}
					else {
						$subclass = "admin_route_list_selected";
							
						$title .= ":: ".$this->lang->ts($val[1][5])." ";
					}
					
					$buf .= '<li class="'.$subclass.'">'.
						'<a href="'.$linked.'">'.
						$this->lang->ts($val[1][4]).
						"</a></li>\n";
					
					$this->page_adm_route_c++;
				}
				$in = array(
					"label" => $this->lang->ts($val[1][4]),
					"link" => $linked
				);
				$toadd = TRUE;
			}

			if(is_array($val[0])) {
				$buf .=  '<ul>'
					.$this->generate_li(
						&$val[0], 
						&$dir, 
						$pos+1,
						&$title,
						&$in["children"],
						$link.
						"$key/",
						$use
					)
					.'</ul>';
			}

			if($toadd)
				$arr[] = $in;
			
		}
		return($buf);
	}
	
	private $page_menu = array();
	private $page_adm_route;
	private $page_adm_route_c = 0;
	
	private function generate_route() {
		$dir = explode("/", $_SERVER["PATH_INFO"]);
		$start = 1;
		
		/* checking lang context if available */
		if($this->a_core_lang->check_lang_route($dir[1]))
			$start++;
			
		$title = NULL;
		$buf = '<div class="admin_route_list">'.
			$this->generate_li(
				&$this->a_core_route->routes[0],
				&$dir,
				$start,
				&$title,
				&$this->page_menu
			).
			'</div>';
		
		$this->page_adm_route = $buf;
		
		return(TRUE);
	}

}
