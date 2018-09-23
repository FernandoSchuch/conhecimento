
        <div id="Container" class="full-height">
            <form action="<?php echo site_url()?>/Busca/getNodos" id="formBuscaNodos" method="post">
                <div id="Pesquisar" class="input-group" >                    
                    <div class="col-sm-6 offset-3 div-pesquisa">                        
                        <input type="hidden" name="ultimaConsulta" id="ultimaConsulta" value="" />
                        <input type="search" name="texto" id="texto" class="form-control campo-pesquisa" placeholder="Pesquisar na base de conhecimento"/> 
                        <button type="submit" class="btn-pesquisa"><img src="<?php echo base_url()?>assests/img/search.png"/></button>
                    </div>                
                </div>                
            </form>               
            <button type="button" class="btn btn-primary" name="btnNovo"     id="btnNovo" >Novo Conhec.</button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalNovoNodo" name="btnNovoNodo" id="btnNovoNodo" >Novo nodo</button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEditar"   name="btnEditar"   id="btnEditar" >Editar</button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalExcluir"  name="btnExcluir"  id="btnExcluir" >Excluir</button>
            <hr/> 
            
            <div class="full-height conteudo row">            
                <div id="jstree"   class="col-sm-4 full-height"></div>
                <div id="cadastro" class="col-sm-8 full-height" livesite="<?php echo site_url() ?>/Cadastro/getCadastro"></div>
            </div>
            
            <div class="modal" id="modalNovoNodo">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Informe o título para o novo nodo</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        
                        <div class="modal-body">                            
                            <input type="text" name="edNovoNodo" id="edNovoNodo" />
                        </div>
                        
                        <div class="modal-footer">
                            <button id="btnOkModal" livesite="<?php echo site_url() ?>/Cadastro/insereNodo" type="button" class="btn btn-success" data-dismiss="modal">OK</button>
                        </div>
                    </div>                    
                </div>                
            </div>
            
            <div class="modal" id="modalExcluir">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h5>Deseja excluir este nodo e todos os seus filhos?</h5>
                        </div>
                        <div class="modal-footer">
                            <button id="btnOkExcluir" livesite="<?php echo site_url() ?>/Cadastro/deletaNodo" type="button" class="btn btn-success" data-dismiss="modal">OK</button>
                            <button id="btnCancExcluir" type="button" class="btn" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal" id="modalRenomear">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Informe o novo nome para o nodo:</h5>                            
                        </div>
                        
                        <div class="modal-body">                            
                            <input type="text" name="edNovoNome" id="edNovoNome" />
                        </div>
                        
                        <div class="modal-footer">
                            <button id="btnOkRenomear" livesite="<?php echo site_url() ?>/Cadastro/renomearNodo" type="button" class="btn btn-success" data-dismiss="modal">OK</button>
                            <button type="button" class="btn" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>                    
                </div>                
            </div>
            
        </div>        

