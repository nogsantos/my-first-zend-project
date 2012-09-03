<?php
/**
 * Formulário Alunos
 * @author Fabricio Nogueira <nogsantos@gmail.com>
 * @since 31 AGO 2012
 */
class Application_Form_Alunos extends Zend_Form {
    /*
     * 
     */
    public function init() {
        $this->setName('alunos');
        
        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter("Int");
        
        $nome = new Zend_Form_Element_Text('nome');
        $nome->setRequired(true)
             ->addFilter('StripTags')
             ->addFilter('StringTrim')
             ->addValidator('NotEmpty');
        
        $matricula = new Zend_Form_Element_Text('matricula');
        $matricula->setRequired(true)
                  ->addFilter('StripTags')
                  ->addFilter('StringTrim')
                  ->addValidator('NotEmpty');
        
        $cursoId = new Zend_Form_Element_Text('curso_id');
        $cursoId->addFilter("Int")
                ->setRequired(true)
                ->addValidator('NotEmpty');
        $this->addElements(
            array(
                $id,
                $nome,
                $matricula,
                $cursoId,
            )
        );
    }
}