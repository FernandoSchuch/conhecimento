<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
        public function __construct() {
            parent::__construct ();
            
            //$this->load->helper('url');
            //$this->load->library('tank_auth');
            
            /*if (!$this->tank_auth->is_logged_in()) {
                redirect('/auth/login/');
            }
            $this->load->model('usuarioModel');*/
	}
    
	public function Index(){ 
            
            /*if (!$this->tank_auth->is_logged_in()) {
                redirect('/auth/login/');
            } else {
                $data['user_id']  = $this->tank_auth->get_user_id();
                $data['username'] = $this->tank_auth->get_username();
                $this->load->view('welcome', $data);
            }*/
            
            $titulo['titulo'] = 'Conhecimento';
            $scripts['scripts'] = array('jstree.min.js', 'principal.js');
            $this->load->view('partials/topo', $titulo);
            $this->load->view('home');
            $this->load->view('partials/rodape', $scripts);
	}
        
}
?>
