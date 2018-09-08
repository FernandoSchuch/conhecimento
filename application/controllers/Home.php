<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	/**
     * Carrega a home
     */
	public function Index(){ 
            $titulo['titulo'] = 'Conhecimento';
            $scripts['scripts'] = array('jstree.min.js', 'principal.js');
            $this->load->view('partials/topo', $titulo);
            $this->load->view('home');
            $this->load->view('partials/rodape', $scripts);
	}
        
}
?>
