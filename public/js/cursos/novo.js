/**
 * Formulário de cadastro de um novo curso
 * @author Fabricio Nogueira
 * @since 30 AGO 2012
 */
jQuery(function(){
    /*
     * Instâncias
     **/
    var notifier             = new Backbone.Notifier(),
        nome                 = jQuery("#nome"),
        btCancelar           = jQuery("#btCancelar"),
        inputNome            = jQuery("#inputNome"),
        btCadastrar          = jQuery("#btCadastrar"),
        universidadeId       = jQuery("#universidadeId"),
        selectUniversidadeId = jQuery("#selectUniversidadeId");
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
        if(universidadeId.val()==""){
            selectUniversidadeId.addClass("error");
            jQuery("#selectUniversidadeId .control-label").fadeIn("fast");
            erro += 1;
        }else{
            selectUniversidadeId.removeClass("error");
            jQuery("#selectUniversidadeId .control-label").fadeOut("fast");
            erro += "";
        }
        if(erro ==""){
            notifier.notify({
                message: "Confirma a CADASTRO do Curso?",
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
});