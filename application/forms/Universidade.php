<?php
/**
 * Formulário Universidades
 * @author Fabricio Nogueira <nogsantos@gmail.com>
 * @since 29 AGO 2012
 */
class Application_Form_Universidade extends Zend_Form {
    /**
     * 
     */
    public function init() {
        $this->setName('universidade');
        
        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter("Int");
        
        $nome = new Zend_Form_Element_Text('nome');
        $nome->setRequired(true)
             ->addFilter('StripTags')
             ->addFilter('StringTrim')
             ->addValidator('NotEmpty')
             ->setOrder(0);
        $this->addElements(
            array(
                $id,
                $nome,
            )
        );
    }
}