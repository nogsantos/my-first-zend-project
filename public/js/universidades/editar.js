/**
 * Formul�rio de edi��o de uma universidade
 * @author Fabricio Nogueira
 * @since 29 AGO 2012
 */
jQuery(function(){
    /*
     * Inst�ncias
     **/
    var notifier   = new Backbone.Notifier(),
        nome       = jQuery("#nome"),
        btCancelar = jQuery("#btCancelar"),
        inputNome  = jQuery("#inputNome"),
        btSalvar   = jQuery("#btSalvar");
    /*
     * Bt Confirma Edi��o
     **/
    btSalvar.click(function(){
        validaEdicao();
    });
    /*
     * Valida��o do formul�rio
     **/
    function validaEdicao(){
        if(jQuery.trim(nome.val())==""){
            inputNome.addClass("error");
            nome.focus();
            jQuery(".help-inline").fadeIn("fast");
            jQuery(".control-label").fadeIn("fast");
            return false;
        }else{
            notifier.notify({
            message: "Confirma a EDI&Ccedil;&Atilde;O da Universidade?",
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
        }
    }
});