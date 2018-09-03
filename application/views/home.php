<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Conhecimento</title>
        <link rel="stylesheet" href="assests/dist/themes/default/style.min.css">
    </head>
    <body>
        <div id="Container">
            <form action="busca" id="formBuscaNodos">
                <div id="Pesquisar">                
                    Expressao
                    <input type="text" name="texto" id="texto" />                    
                    <input type="submit" name="btnPesquisar" id="btnPesquisar" value="Pesquisar" />                        
                </div>
            </form>
            <div>
                <input type="button" name="btnRenomear" id="btnRenomear" value="Renomear" />
            </div>                
            <hr/>
 
            <h2>Resultados da pesquisa:</h2>
            <div id="Resultado"></div>
            
            
        </div>
        <!-- 3 setup a container element -->
        <div id="jstree"></div>  
        

        <!--<script type="text/javascript" src="assests/dist/jquery.min.js" ></script>        
        <script type="text/javascript" src="assests/dist/jstree.min.js"></script>-->
        <script type="text/javascript" src="<?php base_url() ?>/assests/js/busca.js"></script>        
    </body>
</html>
