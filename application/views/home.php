
        <div id="Container">
            <form action="<?php echo site_url()?>/Busca/getNodos" id="formBuscaNodos" method="post">
                <div id="Pesquisar">                
                    Expressao
                    <input type="text" name="texto" id="texto" />                    
                    <input type="submit" name="btnPesquisar" id="btnPesquisar" value="Pesquisar" />                        
                </div>
            </form>                        
            <hr/>
            <h2>Resultados da pesquisa:</h2>
            <div id="Resultado"></div>            
            
        </div>        
        <div class="row">
            <div id="jstree" class="col-4"></div>
            <div id="cadastro" livesite="<?php echo site_url() ?>/Cadastro/getCadastro" class="col-8"></div>
        </div>

