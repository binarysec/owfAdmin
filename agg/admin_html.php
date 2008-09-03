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

	var $a_core_route;

	public function loader($wf) {
		$this->wf = $wf;
		$this->a_core_route = $this->wf->core_route();

		echo $this->nav(&$this->a_core_route->routes[0]['admin'], '/admin');
print_r($this->a_core_route->routes[0]['admin']);
		exit(0);
	}

	private function nav($data, $base='') {
		foreach($data as $i => $route) {
			if(isset($route[0])) {
				echo $base.'/'.$route[1].'<br />';
			}
			else {
				$this->nav(&$route, $base);
			}
		}

return;

		if(!$data)
			return(FALSE);
		$this->stack++;

		$set = FALSE;
		
		foreach($data as $k => $v) {
			if(is_string($k) || ($k != 0 && $k != 1 && $k != 2))
				$this->nav(&$v);
			else if($k == 1) {
				if($v[0] == WF_ROUTE_REDIRECT && $v[3] == WF_ROUTE_SHOW) {
					/* vérification si ul necessaire */
					if(!$set && $this->stack > 1)
						$this->buffer_l1 .= "<ul>\n";
					$set = TRUE;
					
					/* construction du lien */
// 					$link = $this->a_core_request->linker(
// 						$v[1]
// 					);
					$link = $v[1];

					/* html */
					$this->buffer_l1 .= "<li><a href=\"$link\">$v[2]</a></li>\n";
				}
				else if($v[0] == WF_ROUTE_ACTION && $v[4] == WF_ROUTE_SHOW) {
					/* vérification si ul necessaire */
					if(!$set && $this->stack > 1)
						$this->buffer_l1 .= "<ul>\n";
					$set = TRUE;
					
					/* construction du lien */
// 					$link = $this->a_core_request->linker(
// 						$v[6]
// 					);
					$link = $v[6];
					
					/* html */
					$this->buffer_l1 .= "<li><a href=\"$link\">$v[3]</a></li>\n";
				}
			}
		}
		
		if($set && $this->stack > 1) {
			$this->buffer_l1 .= "</ul>\n";
		}
			
		$this->stack--;
	}

	public function rendering($body) {
		$tpl = new core_tpl($this->wf);
		$tpl->set('html_body', $body);
		$this->wf->core_html()->rendering($tpl->fetch('admin/main'));
	}

}
