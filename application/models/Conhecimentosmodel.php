<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed - Conhecimentos');
  
    class Conhecimentosmodel extends Basemodel {
        
        public function __construct() {
            parent::__construct();            
        }        
        
        public function getByIdNodo($id) {
            if($id) {
                $query = $this->db->get_where('conhecimentos', array('coh_conhecimento' => $id));
                return $query->row_array();
            }
            else {
                return false;
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
           return parent::getProximoCodigoPK('coh_conhecimento', 'conhecimentos');            
        }
        
        public function insere($conhecimento){
            if (!$this->db->insert('conhecimentos', $conhecimento))
                throw new Exception ($this->db->error()['message']);                
        }
        
        public function atualiza($conhecimento){
            $cohConhecimento = $conhecimento['coh_conhecimento'];
            unset($conhecimento['coh_conhecimento']);
            
            if (!$this->db->update('conhecimentos', $conhecimento, array('coh_conhecimento' => $cohConhecimento)))
                throw new Exception ($this->db->error()['message']);
        }
        
    }
?>
