<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
    class Conhecimentos extends CI_Model {
        
        public function __construct() {
            parent::__construct();
            $this->load->database();
        }        
        
        public function get($id) {
            if($id != FALSE) {
                $query = $this->db->get_where('conhecimentos', array('coh_conhecimento' => $id));
                return $query->row_array();
            }
            else {
                return FALSE;
            }
        }
        
        public function getByTermo($texto, $nodoPai){
            $from = "fc_arvore('$texto'";
            if (($nodo))
                $from .= ", " . $nodo . ")";
            else
                $from .= ", 0)";
            
            $this->db->select('*');
            $this->db->from($from);
            $this->db->get();
                        
            if ( $query->num_rows() > 0 ){
                $row = $query->row_array();
                return $row;
            }
            
        }
    }
?>
