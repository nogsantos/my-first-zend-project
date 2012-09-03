/**
 * Formulário de cadastro de um novo aluno
 * @author Fabricio Nogueira
 * @since 31 AGO 2012
 */
jQuery(function(){
    /*
     * Instâncias
     **/
    var notifier             = new Backbone.Notifier(),
        nome                 = jQuery("#nome"),
        inputNome            = jQuery("#inputNome"),
        matricula            = jQuery("#matricula"),
        inputMatricula       = jQuery("#inputMatricula"),
        btCancelar           = jQuery("#btCancelar"),
        btCadastrar          = jQuery("#btCadastrar"),
        universidadeId       = jQuery("#universidadeId"),
        cursoId              = jQuery("#cursoId"),
        selectCursoId        = jQuery("#selectCursoId"),
        ajax                 = jQuery("#ajax"),
        divMensagem          = jQuery("#mensagem"),
        load                 = jQuery("#load");
    /*
     * Bt Confirma Cadastro
     **/
    btCadastrar.click(function(){
        validaCadastro();
    });
    /*
     * Validação do formulário
     **/
    function validaCadastro(){
        var erro = "";
        if(jQuery.trim(nome.val())==""){
            inputNome.addClass("error");
            jQuery("#inputNome .control-label").fadeIn("fast");
            erro += 1;
        }else{
            inputNome.removeClass("error");
            jQuery("#inputNome .control-label").fadeOut("fast");
            erro += "";
        }
        if(jQuery.trim(matricula.val())==""){
            inputMatricula.addClass("error");
            jQuery("#inputMatricula .control-label").fadeIn("fast");
            erro += 1;
        }else{
            inputMatricula.removeClass("error");
            jQuery("#inputMatricula .control-label").fadeOut("fast");
            erro += "";
        }
        if(cursoId.val()=="" || cursoId.val() == null){
            selectCursoId.addClass("error");
            jQuery("#selectCursoId .control-label").fadeIn("fast");
            erro += 1;
        }else{
            selectCursoId.removeClass("error");
            jQuery("#selectCursoId .control-label").fadeOut("fast");
            erro += "";
        }
        if(erro ==""){
            notifier.notify({
                message: "Confirma a CADASTRO do Aluno?",
                'type': "warning",
                buttons: [{
                    'data-role': 'ok', 
                    text: 'Continuar'
                },{
                    'data-role': 'cancel', 
                    text: 'Cancelar', 
                    'class': 'default'
                }],
                modal: true,
                ms: null,
                destroy: false
            }).on('click:ok', function(){
                this.destroy();
                document.form.submit();
            }).on('click:cancel', 'destroy');
            return true;
        }else{
            return false;
        }
    }
    /*
     * Ajax, populando o select de cursos com a unidade setada
     **/
    universidadeId.change(function(){
        var universidade_id = jQuery(this).val(),
            opt = "";
        jQuery.ajax({
            type: "POST",
            url: ajax.val(),
            dataType: "json",
            data: {universidade_id : universidade_id},
            beforeSend: function(){
                cursoId.empty();
                load.show();
            },
            success: function(data) {
                if(data.cursos.length){
                    divMensagem.fadeOut("fast");
                    jQuery.each(data.cursos, function(i,values){
                        opt += '<option value="'+values.id+'">'+ values.id + ' - ' + values.nome+'</option>';
                    });
                }else{
                    divMensagem.fadeIn("fast").html("<h4><strong>Messagem:</strong></h4>N&atilde;o h&aacute; Cursos relacionados a universidade Selecionada.");
                }
                cursoId.append(opt);
            },
            error: function(){
                alert("Erro de processamento.");
            },
            complete: function(){
                load.hide();
            }
        });
    })
});