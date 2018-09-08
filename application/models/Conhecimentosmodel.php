<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed - Conhecimentos');
  
    class Conhecimentosmodel extends Basemodel {
        
        public function __construct() {
            parent::__construct();            
        }        
        
        public function getByIdNodo($id) {
            if($id != FALSE) {
                $query = $this->db->get_where('conhecimentos', array('coh_conhecimento' => $id));
                return $query->row_array();
            }
            else {
                return FALSE;
            }
        }
        
        public function getByTexto($texto){
            $query = $this->db->query("select * from fc_arvore('$texto')");            
                        
            if ($query->num_rows() > 0)                
                return $query->result_array();
            else
		return array();
        }
        
        public function getProximoCodigoPk(){
            $query = $this->db->query("select coalesce(max(coh_conhecimento), 0) + 1 as proximo_codigo from conhecimentos");
            return $query->row_array()['proximo_codigo'];
        }
        
        public function insere($conhecimento){
            if (!$this->db->insert('conhecimentos', $conhecimento))
                throw new Exception ($this->db->error()['message']);                
        }
    }
?>
