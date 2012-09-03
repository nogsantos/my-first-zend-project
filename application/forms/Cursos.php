<?php
/**
 * Formulário Cursos
 * @author Fabricio Nogueira <nogsantos@gmail.com>
 * @since 29 AGO 2012
 */
class Application_Form_Cursos extends Zend_Form {
    /*
     * 
     */
    public function init() {
        $this->setName('cursos');
        
        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter("Int");
        
        $nome = new Zend_Form_Element_Text('nome');
        $nome->setRequired(true)
             ->addFilter('StripTags')
             ->addFilter('StringTrim')
             ->addValidator('NotEmpty');
        
        $universidadeId = new Zend_Form_Element_Text('universidade_id');
        $universidadeId->addFilter("Int")
                       ->setRequired(true)
                       ->addValidator('NotEmpty');
        $this->addElements(
            array(
                $id,
                $nome,
                $universidadeId,
            )
        );
    }
}