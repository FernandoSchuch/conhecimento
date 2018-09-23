<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cadastro extends MY_Controller {
    
    private $camposExtras = array('coh_novo_conhecimento', 'coh_nodo_origem');

    public function __construct(){            
        parent::__construct();
        $this->load->model('conhecimentosmodel');
        $this->load->model('nodosmodel');
    }
    
    public function getCadastro(){        
        $parametros = $this->input->post();
        $dados      = array();  
        $novo       = 'N';
        $nodoOrigem = '0';
        if (isset($parametros['nodo'])) {//Quando o nodo já existir            
            $dados = $this->conhecimentosmodel->getByIdNodo($parametros['nodo']);
        } else {//quando for novo
            $nodoOrigem = $parametros['nodoOrigem'];
            $novo       = 'S';
        }
        
        echo '<div class="container">
                    <ul class="nav nav-tabs">
                        <li class="nav-item active">
                            <a class="nav-link active" data-toggle="tab" href="#tabcadastro">Cadastro</a>
                        <li>
                        <li class="nav-item active">
                            <a class="nav-link" data-toggle="tab" href="#tabanexo">Anexos</a>
                        <li>
                    </ul>
                    <form action="' . site_url() . '/Cadastro/salvar" id="formCadastro" method="post">                        
                        <div class="tab-content">
                            <input type="hidden" name="coh_conhecimento" id="coh_conhecimento" value="'. $dados['coh_conhecimento'] .'">
                            <input type="hidden" name="coh_novo_conhecimento" id="coh_novo_conhecimento" value="'. $novo .'">
                            <input type="hidden" name="coh_nodo_origem" id="coh_nodo_origem" value="'. $nodoOrigem .'">
                            <div id="tabcadastro" class="container tab-pane active">
                                <div class="form-group">
                                    <label>Título:</label>
                                    <input type="text" class="form-control" name="coh_titulo" id="coh_titulo" value="'. $dados['coh_titulo'] .'"/>
                                </div>
                                <div class="form-group">                       
                                    <label>Descrição:</label>
                                    <textarea rows="5" cols="30" class="form-control" name="coh_descricao" id="coh_descricao">'. $dados['coh_descricao'] .'</textarea>
                                </div>
                                <div class="form-group">                    
                                    <label>Palavras-chave:</label>
                                    <input type="text" class="form-control" name="coh_palavras_chave" id="coh_palavras_chave" value="'. $dados['coh_palavras_chave'] .'"/>
                                </div>
                            </div>
                            <div id="tabanexo" class="conteiner tab-pane fade">
                                <h2>Aqui vão os anexos</h2>
                            </div>
                        </div>
                        <div>
                            <input type="submit" name="btnSalvar" id="btnSalvar" value="Salvar"/>
                        </div>
                    </form>
                </div>';
    }
    
    public function salvar(){
        header("Content-type: application/json");
        $parametros = $this->input->post();
        $dados      = $parametros['conhecimento'];//Info do conhecimento inserido/alterado        
        
        //Monta o array chave-valor com os dados do conhecimento
        $conhecimento = array();
        foreach($dados as $chave => $valor) {
            $conhecimento[$valor['name']] = $valor['value'];
        }
        $novo = $conhecimento['coh_novo_conhecimento'] == 'S';
        $nodo = $conhecimento['coh_nodo_origem'];
                        
        
        //Valida o conhecimento antes de prosseguir
        $ret = $this->validaConhecimento($conhecimento);     
        if ($ret != '') {
            header("Content-type: application/json");
            echo json_encode(array("erro" => 1, "msg" => $ret));
        } else {
            
            if ($novo) {
                $valorIni = $this->conhecimentosmodel->getProximoCodigoPk();
                $conhecimento['coh_conhecimento'] = $valorIni;
            }
            
            
            preparaArray($conhecimento, $this->getTipoCamposTabela('conhecimentos'));            
            retiraCamposExtras($conhecimento, $this->camposExtras);
            
            $ret = $this->salvarConhecimento($novo, $conhecimento);             
            if ($ret['erro'] == 1){
                header("Content-type: application/json");
                echo json_encode($ret);
            } else if ($novo){                                
                $nodoSelec = $this->nodosmodel->getById($nodo);                
                $novoNodo = array();
                $novoNodo['nar_nodo'] = $this->nodosmodel->getProximoCodigoPk();
                
                if ($nodoSelec['coh_conhecimento']){
                    $novoNodo['nar_pai']   = $nodoSelec['nar_pai'];
                    $novoNodo['nar_ordem'] = $nodoSelec['nar_ordem'] + 1;
                } else {
                    $nodoNovo['nar_pai'] = $nodoSelec['nar_nodo'];
                    //Pegar via trigger (BI) o último código?
                }
                $novoNodo['nar_nome']         = '';
                $novoNodo['coh_conhecimento'] = $ret['pk']; //PK do Conhecimento recém incluído                                               
                
                $ret = $this->salvarNodo($novoNodo);
                
                header("Content-type: application/json");
                echo json_encode($ret);
            } else {
                header("Content-type: application/json");
                echo json_encode(array("erro" => 0));
            }
                
        }
    }
    
    public function salvarConhecimento($novo, $conhecimento){
        $valorIni = $conhecimento['coh_conhecimento'];
        $erro = 1;
        $msg  = '';
        if ($novo){            
            do {
                $pkDuplicada = false; 
                try{
                    if ($novo)
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
        } else {            
            try {
                $this->conhecimentosmodel->atualiza($conhecimento);
                $erro = 0;
            } catch (Exception $ex){
                $msg = $ex->getMessage();
            }
        }                        
        return array("erro" => $erro, "msg" => $msg, "pk" => $valorIni);
    }
    
    public function validaConhecimento($dados) {                
        if ($dados['coh_titulo'] == '')   
            return $msg = "O título deve der informado";        
        else if ($dados['coh_descricao'] == '')       
            return "A descrição deve ser informada";        
                
        return $msg;
    }
    
    public function salvarNodo($nodo){
        $valorIni = $nodo['nar_nodo'];
        $erro = 1;
        $msg  = '';
        do {
            $pkDuplicada = false; 
            try{                
                $this->nodosmodel->insere($nodo);                    
                $erro = 0;//Só vai dar sucesso quando chegar aqui
            } catch (Exception $ex) {                
                if (DuplicouPK($ex->getMessage())){                    
                    $valorIni++;
                    $nodo['nar_nodo'] = $valorIni;
                    $pkDuplicada = true;
                } else {
                    $msg = $ex->getMessage();
                }
            }
        } while ($pkDuplicada);
        
        return array("erro" => $erro, "msg" => $msg);
    }
    
    public function insereNodo(){
        $parametros = $this->input->post();
        $nodoSelec  = $this->nodosmodel->getById($parametros['nodoOrigem']);                
        $novo       = array();
        $novo['nar_nodo'] = $this->nodosmodel->getProximoCodigoPk();
        $novo['nar_nome'] = $parametros['nodoTitulo'];
        if ($nodoSelec['coh_conhecimento']){
            $novo['nar_pai']   = $nodoSelec['nar_pai'];
            $novo['nar_ordem'] = $nodoSelec['nar_ordem'] + 1;
        } else {
            //Vai pegar via trigger a próxima ordem
            $novo['nar_pai'] = $nodoSelec['nar_nodo'];            
        }     
        $ret = $this->salvarNodo($novo);
        
        header("Content-type: application/json");
        echo json_encode($ret);
    }
    
    public function deletaNodo(){
        $parametros = $this->input->post();
        $erro = 1;
        $msg  = '';
        try {
            $this->nodosmodel->deleta($parametros['nodoExcluir']);
            $erro = 0;
        } catch (Exception $ex) {
            $msg = $ex->getMessage();
        }
        header("Content-type: application/json");
        echo json_encode(array("erro" => $erro, "msg" => $msg)); 
    }
    
    public function renomearNodo(){
        $parametros = $this->input->post();
        $nodo = $this->nodosmodel->getById($parametros['nodoRenomear']);
        $nodo['nar_nome'] = $parametros['nomeNovo'];
        $erro = 1;
        $msg  = '';
        try{
            $msg = $this->nodosmodel->atualiza($nodo);        
            $erro = 0;
        } catch (Exception $ex){
            $msg = $ex->getMessage();
        }
        
        header("Content-type: application/json");
        echo json_encode(array("erro" => $erro, "msg" => $msg));
    }
}
?>