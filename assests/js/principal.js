$(document).ready( function() {        
    
    /*$("#jstree").on('rename_node.jstree', function (e, data) {                
        data.node.text = data.node.text + " [ " + data.node.ocorrencias + " ]";       
    });*/		
    
    $("#formBuscaNodos").submit(function (event){        
        
        event.preventDefault(); // Evita que o action padrão seja disparado (Busca/getNodos)       
        url = $(this).attr('action'); // Captura o action do form para enviar via Ajax
        var texto = $("#texto").val();
        
        // Dispara Busca/getNodos que vai chamar
        $.post(url,
              {texto: texto})
        .done(function( dados ) {            
            $("#jstree").jstree("destroy");
            $("#jstree").jstree({                
                'core' : {                        
                    'check_callback' : function (op, node, par, pos, more) {					
                        //Impede de arrastar nodos para dentro de conhecimentos
                        //Ver isso - Da erro quando arrasta para o nodo raiz
                        if(more && op === 'move_node' && par.data.conhecimento == "S")
                            return false;
                        return true;
                    },
                    'data' : JSON.parse(dados)
                },
                'plugins' : ["dnd", "wholerow", "contextmenu"],
                'contextmenu': {items: customMenu}
            });
       });
    });
    
    $("#formCadastro").submit(function (e){        
        e.preventDefault();
        var vUrl = $(this).attr('action');
        var vConhecimento = $("#formCadastro").serializeArray();        
        $.ajax({
            type : "post",
            url  : vUrl,
            data : {conhecimento: vConhecimento},
            //beforeSend: abrir modal de carregando
            success: function(retorno){                 
                if (retorno['erro'] == 1)
                    alert(retorno['msg']);
                else
                    alert('Salvou');
            }
        });
        return false;
    });
	
    $("#jstree").bind("dblclick.jstree", function (event) {
        var tree = $(this).jstree();
        var node = tree.get_node(event.target);
        alert(node.data.conhecimento);
        if (node.data.conhecimento > 0){     
            $.post($("#cadastro").attr('livesite'), {nodo: node.data.conhecimento})               
                .done(function(data){                    
                    $("#cadastro").empty().append(data);
                });
        }
    });

    function customMenu(node) {		
        var items;
        if (node.data.conhecimento == "N"){
            items = {			
                renameItem: { // The "rename" menu item
                    label: "Renomear",
                    action: function () {alert("Renomear");}
                }			
            };
        }
        return items;
    }
});