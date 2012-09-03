/**
 * Formulário de exclusão das universidades
 * @author Fabricio Nogueira
 * @since 31 AGO 2012
 */
jQuery(function(){
    /*
     * Instancias
     **/
    var notifier = new Backbone.Notifier(),
        btExcluir = jQuery("#btExcluir");
    /*
     * Bt Confirma Exclusão
     **/
    btExcluir.click(function(){
        notifier.notify({
            message: "Confirma a EXCLUS&Atilde;O do Aluno?",
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
    });
});