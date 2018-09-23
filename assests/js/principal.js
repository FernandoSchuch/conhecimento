$(document).ready( function() {	
    
    $("#formBuscaNodos").submit(function (event){        
        event.preventDefault(); // Evita que o action padrão seja disparado (Busca/getNodos)        
        var texto = $("#texto").val();
        document.getElementById("ultimaConsulta").setAttribute("value", texto);        
        atualizarArvore(texto);
    });       
    
    $("#btnNovo").click(function (e) {
        var nodo = $("#jstree").jstree('get_selected', true)[0].id;
        if (nodo > 0 || nodo == '#'){            
            $.post($("#cadastro").attr('livesite'), {nodoOrigem: nodo})
                .done(function(data){
                    $("#cadastro").empty().append(data);
                });
        } else {
            alert("Você deve selecionar um grupo ou conhecimento antes de inserir um novo");
        }
           
    });
    
    $("#btnOkModal").click(function (e){
        e.preventDefault();        
        var nodo   = $("#jstree").jstree('get_selected', true)[0].id;
        var titulo = $("#edNovoNodo").val();        
        if (nodo > 0 || nodo == '#'){            
            $.post($("#btnOkModal").attr('livesite'), {nodoOrigem: nodo,
                                                       nodoTitulo: titulo})
                .done(function(data){
                    if (data['erro'] == 1)
                        alert(data['msg']);
                    else
                        atualizarArvore('');
                });
        } else {
            alert("Você deve selecionar um grupo ou conhecimento antes de inserir um novo");
        }
           
    });
    
    $("#btnOkExcluir").click(function (e){
       e.preventDefault();       
       var nodo = $("#jstree").jstree('get_selected', true)[0].id;
       if (nodo > 0 || nodo == '#'){
           $.post($("#btnOkExcluir").attr("livesite"), {nodoExcluir: nodo})
                .done(function (data){
                    if (data['erro'] == 1)
                         alert(data['msg']);
                    else {
                        alert('Nodo excluído com sucesso.');
                        atualizarArvore(null);
                    }
                     
                });
       }
    });
    
    $("#btnOkRenomear").click(function (e){
       e.preventDefault();       
       $("#jstree").jstree('save_state');
       var nodo = $("#jstree").jstree('get_selected', true)[0].id;       
       $.post($("#btnOkRenomear").attr("livesite"), {nodoRenomear: nodo, nomeNovo: $("#edNovoNome").val()})
            .done(function (data){
                if (data['erro'] == 1)
                     alert(data['msg']);
                else {
                     alert('Nodo renomeado com sucesso.');
                     atualizarArvore(null);//Se deu para renomear, atualiza a árvore
                 }                
             });        
    });
    
    $(document).on('submit', '#formCadastro', function (event){        
        event.preventDefault();        
        var vUrl = $('#formCadastro').attr('action');        
        var vConhecimento = $("#formCadastro").serializeArray();
        $.ajax({
            type : "post",
            url  : vUrl,
            data : {conhecimento: vConhecimento},
            //beforeSend: abrir modal de carregando
            success: function (retorno) {                
                if (retorno['erro'] == 1)
                    alert(retorno['msg']);
                else
                    alert('Conhecimento salvo com sucesso');
            }
        });
        return false;
    });
    
    function atualizarArvore(filtro){
        var s = filtro;
        if (filtro == null)
            s = $("#ultimaConsulta").val();            
        // Dispara Busca/getNodos        
        $.post($("#formBuscaNodos").attr('action'),
              {texto: s})
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
                'plugins' : ["dnd", "wholerow", "state"]
            });
            
            $("#jstree").bind("dblclick.jstree", function (event) {
                var node = $(this).jstree().get_node(event.target);//Pega o nodo que disparou o dblclick        
                if (node.data.conhecimento > 0){
                    $.post($("#cadastro").attr('livesite'), {nodo: node.data.conhecimento})
                        .done(function(data){                    
                            $("#cadastro").empty().append(data);
                        });
                }
            });
            
            if (texto != null) //Quando clicar no pesquisar, limpa o estado da árvore. Nos outros casos, abre a árvore como estava
                $("#jstree").jstree('clear_state');
       });       
    }
});