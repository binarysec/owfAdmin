<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Web Framework 1 *
 * BinarySEC (c) (2000-2008) / www.binarysec.com *
 * Author: Olivier Pascal <op@binarysec.com>     *
 *         Michael Vergoz <mv@binarysec.com>     *
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *
 *Avertissement : ce logiciel est protégé par la *
 *loi du copyright et par les traités internationaux.*
 *Toute personne ne respectant pas ces dispositions*
 *se rendra coupable du délit de contrefaçon et sera *
 *passible des sanctions pénales prévues par la loi. *
 *Il est notamment strictement interdit de décompiler, *
 *désassembler ce logiciel ou de procèder à des*
 *opération de "reverse engineering".*
 * *
 *Warning : this software product is protected by*
 *copyright law and international copyright treaties *
 *as well as other intellectual property laws and*
 *treaties. Is is strictly forbidden to reverse*
 *engineer, decompile or disassemble this software *
 *product. *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

class admin_html extends wf_agg {

	private $a_core_route;
	private $a_core_request;
	private $_session;
	private $a_core_lang;
	private $a_core_html;
	
	private $lang;

	public $start_route = "/";
	private $tpl;
	
	public $template = "admin/main";
	
	public function loader($wf) {
		/* non cachable page */
		$wf->no_cache();
		
		$this->a_core_route = $this->wf->core_route();
		$this->a_core_request = $this->wf->core_request();
		$this->_session = $this->wf->session();
		$this->a_core_lang = $this->wf->core_lang();
		$this->a_core_html = $this->wf->core_html();
		$this->a_core_cipher = $this->wf->core_cipher();
		
		if(isset($this->wf->ini_arr["admin"]["start_route"]))
			$this->start_route = $this->wf->ini_arr["admin"]["start_route"];
		
		$this->tpl = new core_tpl($this->wf);
		
		$this->div_set("data-role", "page");
		$this->no_zoom();
	}
	
	public function no_zoom() {
		$this->a_core_html->set_meta_name(
			"viewport", 
			array(
				"content" => "width=device-width, initial-scale=1"
			)
		);	
	}
	
	public function set($var, $value) {
		$this->tpl->set($var, $value);
	}
	
	public $html_title = null;
	public function set_title($title) {
		$this->a_core_html->set_title($title);
		$this->html_title = $title;
	}
	
	/* Header getter/setter */
	private $setmode_header = false;
	public $html_header = null;
	public function header_append($html) {
		$this->html_header .= $html;
	}
	public function header_set($html) {
		$this->html_header = $html;
		$this->setmode_header = true;
	}
	
	/* Footer getter/setter */
	private $setmode_footer = false;
	public $html_footer = null;
	public function footer_append($html) {
		$this->html_footer .= $html;
	}
	public function footer_set($html) {
		$this->html_footer = $html;
		$this->setmode_footer = true;
	}
	
	/* Backlink */
	public $html_backlink = null;
	public function set_backlink($link, $text="Back", $icon="back") {
		$this->html_backlink = array($link, $text, $icon);
	}

	/* div */
	public $html_div = array();
	public function div_set($var, $val) {
		$this->html_div[$var] = $val;
	}
	public function renderlinks($options=array()) {
		if(array_key_exists("body", $options))
			$body = $options["body"];
		else $body = null;
		
		if(array_key_exists("header", $options))
			$header = $options["header"];
		else $header = true;
		
		if(array_key_exists("footer", $options))
			$footer = $options["footer"];
		else $footer = true;

		if(array_key_exists("template", $options))
			$template = $options["template"];
		else $template = 'admin/routes';
		
		$tpl = new core_tpl($this->wf);

		$this->set_title($this->a_core_request->channel[0][5]);
	
		/* make real url */
		$rurl = '';
		$dir = explode("/", $this->a_core_request->channel[3]);
		$nav = &$this->a_core_route->routes;
		$start = 1;
		
		/* checking lang context if available */
		if($this->a_core_lang->check_lang_route(isset($dir[1]) ? $dir[1] : NULL))
			$start++;
		for($i=$start; $i<count($dir); $i++) {
			if(isset($nav[0][$dir[$i]]))
				$nav = &$nav[0][$dir[$i]];
			else
				break;
			$rurl .= "/".$dir[$i];
		}
// 		var_dump($rurl);
		$sub_channels = $this->a_core_route->get_sub_channel($rurl."/p");
		
		/* check subchannels permission */
		foreach($sub_channels as $k => $chan) {
			/* create channel link */
			$sub_channels[$k]["link"] = $this->wf->linker("$rurl/$chan[key]");
			
			if(!is_array($chan["perm"]))
				unset($sub_channels[$k]);
			else {
				/* check channel permissions */
				$r = $this->check_permission($chan["perm"]);
				if(!$r)
					unset($sub_channels[$k]);
					
				/* check visibility */
				if($chan["visible"] != WF_ROUTE_SHOW)
					unset($sub_channels[$k]);
			}
		}
		
		/* order by name */
		uasort($sub_channels, array($this, 'renderlinks_order'));
		
		$in = array(
			"subchans" => $sub_channels,
			"url" => $rurl,
			"channel" => $this->a_core_request->channel[0],
			"body" => $body
			
		);	 
		$tpl->set_vars($in);
		$this->rendering($tpl->fetch($template));
		exit(0);
	}
	
	public function renderlinks_order($a, $b) {
		if ($a['name'] == $b['name']) return(0);
		return ($a['name'] < $b['name']) ? -1 : 1;
	}
	
	/* Rendering */
	public function rendering($body, $header=true, $footer=true) {		
		$tmp = '';

		$this->lang = $this->a_core_lang->get_context($this->template);
		
		$tpl = $this->tpl;

		
// 		/* add the bottom */
// 		$this->add_bottom(
// 			$this->lang->ts(array(
// 				"%s SQL requests", 
// 				$this->wf->db->get_request_counter()
// 			))
// 		);
// 		
// 		$this->add_bottom(
// 			$this->lang->ts(array(
// 				"on <strong>%s</strong> - %s", 
// 				php_uname("n"),
// 				$_SERVER["REMOTE_ADDR"]
// 			))
// 		);
// 		
// 		/* last */
// 		$this->add_bottom(
// 			$this->lang->ts(array(
// 				"engine took %f ms", 
// 				microtime(TRUE) - $this->wf->time_start
// 			))
// 		);
// 		
// 		$tpl->set('bottom', $this->page_bottom);

		/* header rendering */
		if(!$this->setmode_header) {
			if($this->html_backlink) {
				$tmp = '<a href="'.$this->html_backlink[0].
					'" data-icon="'.$this->html_backlink[2].
					'" data-iconpos="notext" data-direction="reverse">'.
					$this->html_backlink[1].
					'</a>';
			}
			$opt_lnk = $this->options_link();
			$opt_text = $this->lang->ts("Options");
			$tmp .= '<h1>'.$this->html_title.'</h1>'.
				'<a href="'.$opt_lnk.'" data-icon="gear" data-transition="pop" class="ui-btn-right">'.$opt_text.'</a>';
			if($this->html_header)
				$tmp = $this->html_header.$tmp;
			$this->html_header = 
				'<div data-role="header" data-theme="a" data-position="fixed">'.
				$tmp.
				'</div>';
		}
		
		/* Footer rendering */
		if(!$this->setmode_footer) {
			$tmp = '<p>&copy; 2012 <a href="http://wiki.owf.re" target="_blank">Open Web Framework</a> 2006-2012</p>';
			if($this->html_footer)
				$tmp = $this->html_footer.$tmp;
			$this->html_footer = $tmp;
		}
		
		/* the body .. */
		$in = array(
			"header_bool" => $header,
			"footer_bool" => $footer,
			"title" => $this->html_title,
			"header" => $this->html_header,
			"body" => $body,
			"footer" => $this->html_footer,
			"divs" => $this->html_div,
			"backlink" => $this->html_backlink,
		);	 
		$tpl->set_vars($in);
	
		$this->wf->core_html()->rendering($tpl->fetch($this->template));
	}
	
	
	public function rendering_options($body, $mode="dialog") {	
		
		/* get theme */
		$theme = $this->a_core_cipher->get_var("theme");
		if($theme)
			$this->div_set("data-theme", $theme);
		else
			$this->div_set("data-theme", "a");
			
		/* build the header */
		$blink = $this->a_core_cipher->get_var('back');
		if(!$blink)
			exit(0);
			
		/* build the header */
		if($mode == "dialog") {
			$this->html_header = 
				'<div data-role="header">'."\n".
				"<h1>".$this->html_title."</h1>\n".
				'</div>'."\n"
				;
			$this->setmode_header = true;
		}
		
		$this->rendering($body, true, false);
		
	}
	
	public function check_options_policy($uid, &$info=null) {
		/* view information of all users */
		if($uid != $this->_session->session_me["id"]) {
			if(!$this->check_permission(array("session:manage")))
				return(false);
		}
		$info = $this->_session->user->get(array("id" => $uid));
		$info = $info[0];
		return(true);
	}
	

	public function check_permission($val) {
		foreach($val as $k => $v) {
			if($v == "session:anon" && $this->wf->ini_arr["session"]["allow_anonymous"]) 
				return(true);
			else if($v == "session:ranon")
				return(true);
		}
		$perm = $this->_session->check_permission(
			$val
		);
		if($perm == true)
			return(true);
		return(false);
	}

	public function options_link($uid=null, $theme=null) {
		$lnk = $this->wf->linker("/admin/options");
		$blink = $this->a_core_cipher->encode($_SERVER["REQUEST_URI"]);
		$r = "$lnk?back=$blink";
		if($uid)
			$r .= '&uid='.$uid;
		if($theme)
			$r .= '&theme='.$this->a_core_cipher->encode($theme);
		return($r);
	}
	
}
