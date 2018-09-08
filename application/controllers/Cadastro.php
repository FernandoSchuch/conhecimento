<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cadastro extends MY_Controller {

    public function __construct(){            
        parent::__construct();
        $this->load->model('conhecimentosmodel');
    }
    
    public function getCadastro(){
        $parametros = $this->input->post();
        $dados = array();
        
        if (isset($parametros['nodo'])){
            $dados = $this->conhecimentosmodel->getByIdNodo($parametros['nodo']);
        }
        echo '<div class="container">
                    <form action="<?php echo site_url()?>/Cadastro/salvarConhecimento" id="formCadastro" method="post">                
                        <div class="form-group">
                            <label>Título:</label>
                            <input type="text" class="form-control" name="coh_titulo" id="edTitulo" value="'. $dados['coh_titulo'] .'"/>
                        </div>
                        <div class="form-group">                       
                            <label>Descrição:</label>
                            <textarea rows="5" cols="30" class="form-control" name="coh_descricao" id="edDescricao">'. $dados['coh_descricao'] .'</textarea>
                        </div>
                        <div class="form-group">                    
                            <label>Palavras-chave:</label>
                            <input type="text" class="form-control" name="coh_palavras_chave" id="edPalavrasChave" value="'. $dados['coh_palavras_chave'] .'"/>
                        </div>
                        <div>
                            <input type="submit" name="btnSalvar" id="btnSalvar" value="Salvar"/>
                        </div>
                    </form>
                </div>';
        
    }
    
    public function salvarConhecimento(){        
        $parametros = $this->input->post();        
        $dados      = $parametros['conhecimento'];
        $novoPedido = $parametros['novoPedido'];
        
        $conhecimento = array();
        foreach($dados as $chave => $valor){
            $conhecimento[$valor['name']] = $valor['value'];
        }        
        $valorIni = $this->conhecimentosmodel->getProximoCodigoPk();
        $conhecimento['coh_conhecimento'] = $valorIni;
        
        $msg  = $this->validaConhecimento($conhecimento);
        $erro = 1;
        if ($msg){
            echo $msg;
        } else { 
            preparaArray($conhecimento, $this->getTipoCamposTabela('conhecimentos'));           
            $msg  = '';
            do {
                $pkDuplicada = false; 
                try{               
                    $this->conhecimentosmodel->insere($conhecimento);    
                    $erro = 0;//Só vai dar sucesso quando chegar aqui
                } catch (Exception $ex) {                
                    if (DuplicouPK($ex->getMessage())){                    
                        $valorIni++;
                        $conhecimento['coh_conhecimento'] = $valorIni;
                        $pkDuplicada = true;
                    } else {                    
                        $msg = $ex->getMessage();
                    }                       
                }
            } while ($pkDuplicada);

            header("Content-type: application/json");
            echo json_encode(array("erro" => $erro, "msg" => $msg));
        }
    }
    
    public function validaConhecimento($dados){
        $msg = '';        
        if ($dados['coh_titulo'] == '')
            $msg = "O título deve der informado";
        else if ($dados['coh_descricao'] == '')
            $msg = "A descrição deve ser informada";
        return $msg; 
    }
}
?>