/**
 * Default js
 * @author Fabricio Nogueira
 * @since 29 AGO 2012
 */
jQuery(function(){
    /*
     * Instancia Alerts
     **/
    var notifier = new Backbone.Notifier(),
        divPrincipal = jQuery("#principal");
    /*
     * Botão menu link sobre
     **/
    jQuery("#sobre").click(function(){
        notifier.notify({
            message: "Fabricio Nogueira<br />Fone 62 9119-1686<br />nogsantos@gmail.com",
            'type': "info",
            buttons: [{
                'data-role': 'ok', 
                text: 'Ok'
            }],
            modal: true,
            position: 'center',
            ms: null,
            destroy: false
        }).on('click:ok', function(){
            this.destroy();
        });
    });
    /*
     * Botão Conheça Mais página inicial
     **/
    jQuery("#btConhecaMais").click(function(){
        window.open('http://www.nogsantos.com.br/', '_blank'); 
    });
    jQuery(document).ready(function(){
       divPrincipal.fadeIn(1111);
    });
});