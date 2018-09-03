<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	/**
     * Carrega a home
     */
	public function Index(){            
            $this->load->model('conhecimentos');
            $reviews = $this->conhecimentos->get(1);
            $data['coh_titulo'] = $reviews['coh_titulo'];            
            $this->load->view('home', $data);
	}
        
}
?>
