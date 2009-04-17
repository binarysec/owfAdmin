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
	private $page_topbar;
	private $page_subtop;
	
	public $start_route = "/admin";
	
	public function loader($wf) {
		$this->wf = $wf;
		$this->a_core_route   = $this->wf->core_route();
		$this->a_core_request = $this->wf->core_request();
		$this->a_core_session = $this->wf->core_session();
		$this->a_core_lang    = $this->wf->core_lang();
		$this->a_core_html    = $this->wf->core_html();
		
		$this->lang = $this->a_core_lang->get_context("admin/html");
		
		if($this->wf->ini_arr["admin"]["start_route"])
			$this->start_route = $this->wf->ini_arr["admin"]["start_route"];

	}
	
	public function append_subtop($data) {
		$this->page_subtop .= $data;
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
			'data'  => $data
		);
	}

	public function append_topbar($data) {
		$this->page_topbar .= $data;
	}
	
	public function add_bottom($data) {
		$this->page_bottom .= " / $data";
	}
	
	public function rendering($body) {
		$this->generate_route();
		
		$tpl = new core_tpl($this->wf);
		$tpl->set('user',              $this->a_core_session->me);
		$tpl->set('page_subtitle',     $this->page_subtitle);
		$tpl->set('page_topbar',       $this->page_topbar);
		$tpl->set('page_subtop',       $this->page_subtop);
		$tpl->set('langs',             $this->a_core_lang->get_list());
		$tpl->set('current_lang_code', $this->a_core_lang->get_code());

		/* check si on doit ajouter le side admin */
		if($this->a_core_request->channel[2][0] == "admin") {
// 			$this->add_sidebar(
// 				$this->lang->ts("Administration"),
// 				$this->page_adm_route
// 			);
			$tpl->set('page_sidebar', array_reverse($this->page_sidebar));
		}
		
		/* navigation menu */
		$menu = new ajax_topnav($this->wf, 'admin_menu');
		$menu->menu = $this->page_menu;

		$tpl->set('navigation', $menu->render());
		
		/* add the bottom */
		$this->add_bottom(
			$this->lang->ts(array(
				"%s SQL requests", 
				$this->wf->db->get_request_counter()
			))
		);
		
		$this->add_bottom(
			$this->lang->ts(array(
				"on <strong>%s</strong> - %s", 
				php_uname("n"),
				$_SERVER["REMOTE_ADDR"]
			))
		);
		
		/* last */
		$this->add_bottom(
			$this->lang->ts(array(
				"engine took %f ms", 
				microtime(TRUE) - $this->wf->time_start
			))
		);
		
		$tpl->set('bottom',           $this->page_bottom);
		
		/* the body .. */
		$tpl->set('body',             $body);
		
		$this->wf->core_html()->rendering($tpl->fetch('admin/main'));
	}
		
	private function generate_li(&$nav, $dir, $pos, $title, $arr, $link="/", $use=FALSE) {
		$buf = '';
		if(!is_array($nav))
			return(NULL);
			
		foreach($nav as $key => $val) {
			$toadd = FALSE;
			
			if(strncmp($this->start_route, $link, strlen($this->start_route)) == 0)
				$use = TRUE;
			if(
				$val[1][2] == WF_ROUTE_ACTION && 
				$val[1][6] == WF_ROUTE_SHOW
				) {
				$linked = $this->wf->linker(
					$link.$key
				);

				if(!$val[1][7])
					$val[1][7] = array("session:anon");
					
				
				$perm = $this->a_core_session->check_permissions(
					&$val[1][7]
				);
				if($perm) {
					if($use) {
						if($dir[$pos] == $key) {
							$char = "* ";
							$title .= ":: ".$this->lang->ts($val[1][5])." ";
						}
						else
							$char = NULL;
							
						$buf .= '<li class="cat_open">'.
							'<a href="'.$linked.'">'.
							$char.$this->lang->ts($val[1][5]).
							"</a></li>\n";
							
						$this->page_adm_route_c++;
					}
					
					$in = array(
						"label" => $this->lang->ts($val[1][5]),
						"link" => $linked
					);
					$toadd = TRUE;
				}
			}
			else if(
				$val[1][2] == WF_ROUTE_REDIRECT && 
				$val[1][5] == WF_ROUTE_SHOW
				) {
				$linked = $this->wf->linker(
					$link.$key
				);
				
				if(!$val[1][6])
					$val[1][6] = array("session:anon");

				$perm = $this->a_core_session->check_permissions(
					&$val[1][6]
				);
				if($perm) {
					if($use) {
						if($dir[$pos] == $key) {
							$char = "* ";
							$title .= ":: ".$this->lang->ts($val[1][5])." ";
						}
						else
							$char = NULL;
							
						$buf .= '<li class="cat_open">'.
							'<a href="'.$linked.'">'.
							$char.$this->lang->ts($val[1][4]).
							"</a></li>\n";
						
						$this->page_adm_route_c++;
					}
					$in = array(
						"label" => $this->lang->ts($val[1][4]),
						"link" => $linked
					);
					$toadd = TRUE;
				}
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
		
		$tv = new ajax_treeview($this->wf, 'menu_tree');
		$tv->tree_id = 'menu_tree';

		/* trouve la route necessaire */
		$sdir = explode("/", $this->start_route);
		$selected_route = &$this->a_core_route->routes[0];
		$found = TRUE;
		
		for($a=1; $a<count($sdir); $a++) {
			$val = &$sdir[$a];
			if($selected_route[$val]) {
				$selected_route = &$selected_route[$val][0];
			}
			else {
				$found = FALSE;
				break;
			}
		}
		if(!$found) {
			$selected_route = &$this->a_core_route->routes[0];
			$dft_route = $this->start_route;
		}
		else
			$dft_route = $this->start_route."/";

		
// 		if($sdir[1] == "admin") {
// 			$this->page_menu[] = array(
// 				'label' => $this->lang->ts("Admin Dashboard"), 
// 				'link' => $this->wf->linker("/admin")
// 			);
// 		}
			
		/* lance la génération de la liste */
		$buf = '<div id="menu_tree">'.
			$this->generate_li(
				&$selected_route,
				&$dir,
				$start,
				&$title,
				&$this->page_menu,
				$dft_route
			).
			'</div>'.
			$tv->render();
		
		$this->page_adm_route = $buf;
		
		return(TRUE);
	}


}
