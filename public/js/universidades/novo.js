/**
 * Formulário de cadastro de uma universidade
 * @author Fabricio Nogueira
 * @since 29 AGO 2012
 */
jQuery(function(){
    /*
     * Instâncias
     **/
    var notifier    = new Backbone.Notifier(),
        nome        = jQuery("#nome"),
        btCancelar  = jQuery("#btCancelar"),
        inputNome   = jQuery("#inputNome"),
        btCadastrar = jQuery("#btCadastrar");
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
        if(jQuery.trim(nome.val())==""){
                inputNome.addClass("error");
                nome.focus();
                jQuery(".control-label").fadeIn("fast");
            return false;
        }else{
            notifier.notify({
                message: "Confirma a CADASTRO da Universidade?",
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