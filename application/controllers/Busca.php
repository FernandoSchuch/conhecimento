<?php
if(! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed - busca' );

class Busca extends MY_Controller {	
        
	public function __construct() {
            parent::__construct ();
            $this->load->model('conhecimentosmodel');
	}
	
	public function getNodos(){            
            $parametros = $this->input->post();                            
            $dados     = $this->conhecimentosmodel->getByTexto($parametros['texto']);
            $registros = array();		
            if ($dados){
                foreach($dados as $linha){
                    $id     = $linha["nar_nodo"];
                    $pai    = $linha["nar_pai"];
                    $text   = $linha["nar_nome"];
                    $conhec = $linha["coh_conhecimento"];
                    $ocorr  = $linha["nar_ocorrencias"];
                    if ($conhec == 0)
                        $text .= " [ " . $ocorr . " ]";
                    $data   = array("ocorrencias"  => $ocorr,
                                    "conhecimento" => $conhec);
                    if (!$pai)                        
                        $pai = "#";
                    $registros[] = array( "id"     => $id, 
                                          "parent" => $pai,
                                          "text"   => $text,
                                          "data"   => $data);
                }
                echo json_encode($registros);
            } else {
                echo json_encode(array("id" => "X", "text" => "teste"));
            }
	}               
}	
?>