<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed - Conhecimentos');
  
    class Nodosmodel extends Basemodel {
        
        public function __construct() {
            parent::__construct();            
        }
        
        public function getProximoCodigoPK(){
            return parent::getProximoCodigoPK('nar_nodo', 'nodos_arvore');
        }
        
        public function getById($id){
            if($id) {
                $query = $this->db->get_where('nodos_arvore', array('nar_nodo' => $id));
                return $query->row_array();
            }
            else {
                return false;
            }            
        }
        
        public function insere($nodo){
            if (!$this->db->insert('nodos_arvore', $nodo))
                throw new Exception ($this->db->error()['message']);                
        }
        
        public function deleta($nodo){            
            if (!$this->db->delete('nodos_arvore', array('nar_nodo' => $nodo)))
                throw new Exception ($this->db->error()['message']);
        }
        
        public function atualiza($nodo){            
            $narNodo = $nodo['nar_nodo'];
            unset($nodo['nar_nodo']);
            
            if (!$this->db->update('nodos_arvore', $nodo, array('nar_nodo' => $narNodo)))
                throw new Exception ($this->db->error()['message']);
        }
        
    }