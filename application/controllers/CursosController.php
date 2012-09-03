<?php
/**
 * Controller Universidades
 * @author Fabricio Nogueira <nogsantos@gmail.com>
 * @since 29 AGO 2012
 */
class CursosController extends Zend_Controller_Action {
    /*
     * 
     */
    public function init() {
        $this->view->assign('classActive', 'cursos');
        $this->view->menssagens = $this->_helper->flashMessenger->getMessages();
    }
    /*
     * 
     */
    public function indexAction() {
        $oCursos = new Application_Model_DbTable_Cursos();
        if($oCursos->getAllCursos()){
            $this->view->oCursos = $oCursos->getUniversidadesCursos();
        }else{
            $this->view->oCursos = "";
        }
    }
    /**
     * Cadastro de um novo Cursos
     */
    public function novoAction() {
        $form = new Application_Form_Cursos();
        if ($this->getRequest()->isPost()) {
            if ($this->getRequest()->getPost('cancelar') == "") {
                $formData = $this->getRequest()->getPost();
                if ($form->isValid($formData)) {
                    $nome = $form->getValue('nome');
                    $universidadeId = (Int) $form->getValue('universidade_id');
                    $oCursos = new Application_Model_DbTable_Cursos();
                    $oCursos->novoCurso(
                            $nome,
                            $universidadeId
                    );
                    $this->_helper->flashMessenger->addMessage(utf8_encode('Cadastro realizado com sucesso!'));
                } else {
                    $form->populate($formData);
                }
            }
            $this->_helper->redirector('index');
        }else{
            $this->cursosPopulaUniversidadeSelectView();
        }
    }
    /**
     * Editar uma Curso
     */
    public function editarAction() {
        $form = new Application_Form_Cursos();
        if ($this->getRequest()->isPost()) {
            if ($this->getRequest()->getPost('cancelar') == "") {
                $formData = $this->getRequest()->getPost();
                if ($form->isValid($formData)) {
                    $id = (int) $form->getValue('id');
                    $nome = $form->getValue('nome');
                    $universidadeId = (int) $form->getValue('universidade_id');
                    $oCursos = new Application_Model_DbTable_Cursos();
                    $oCursos->editarCurso(
                            $id, 
                            $nome,
                            $universidadeId
                    );
                    $this->_helper->flashMessenger->addMessage(utf8_encode('Edição realizada com sucesso!'));
                } else {
                    $form->populate($formData);
                }
            }
            $this->_helper->redirector('index');
        } else {
            $id = $this->_getParam('id', 0);
            if ($id > 0) {
                $oCursos = new Application_Model_DbTable_Cursos();
                $this->view->oCursos = $oCursos->getCursos($id);
                $this->cursosPopulaUniversidadeSelectView();
            }
        }
    }
    /**
     * Deletar um Curso
     */
    public function excluirAction() {
        if ($this->getRequest()->isPost()) {
            if ($this->getRequest()->getPost('cancelar') == '') {
                $id = $this->getRequest()->getPost('id');
                $oCursos = new Application_Model_DbTable_Cursos();
                $oCursos->excluirCurso($id);
                $this->_helper->flashMessenger->addMessage(utf8_encode('Exclusão realizada com sucesso!'));
            }
            $this->_helper->redirector('index');
        } else {
            $id = $this->_getParam('id', 0);
            $oCursos = new Application_Model_DbTable_Cursos();
            $this->view->oCursos = $oCursos->getCursos($id);
            $this->cursosPopulaUniversidadeSelectView();
        }
    }
    /**
     * Redirecionamento para o grid do controller
     */
    public function gridAction(){
        $this->_helper->redirector('index');
    }
   /**
    * Populando o select com as universidades cadastradas.
    */
    private function cursosPopulaUniversidadeSelectView(){
        $oUniversidades = new Application_Model_DbTable_Universidades();
       return $this->view->selectUniversidades = $oUniversidades->getSelectUniversidades();
    }
}