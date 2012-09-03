<?php
/**
 * Controller Universidades
 * @author Fabricio Nogueira <nogsantos@gmail.com>
 * @since 29 AGO 2012
 */
class UniversidadesController extends Zend_Controller_Action {
    /**
     * 
     */
    public function init() {
        $this->view->assign('classActive', 'universidades');
        $this->view->menssagens = $this->_helper->flashMessenger->getMessages();
    }
    /**
     *
     */
    public function indexAction() {
        $oUniversidades = new Application_Model_DbTable_Universidades();
        if($oUniversidades->getAllUniversidades()){
            $this->view->oUniversidades = $oUniversidades->fetchAll(null,'id');
        }else{
            $this->view->oUniversidades = "";
        }
    }
    /**
     * Cadastro de novas Universidades
     */
    public function novoAction() {
        $form = new Application_Form_Universidade();
        if ($this->getRequest()->isPost()) {
            if ($this->getRequest()->getPost('cancelar') == "") {
                $formData = $this->getRequest()->getPost();
                if ($form->isValid($formData)) {
                    $nome = $form->getValue('nome');
                    $oUniversidades = new Application_Model_DbTable_Universidades();
                    $oUniversidades->novoUniversidade($nome);
                    $this->_helper->flashMessenger->addMessage(utf8_encode('Cadastro realizado com sucesso!'));
                } else {
                    $form->populate($formData);
                }
            }
            $this->_helper->redirector('index');
        }
    }
    /**
     * Editar uma Universidade
     */
    public function editarAction() {
        $form = new Application_Form_Universidade();
        if ($this->getRequest()->isPost()) {
            if ($this->getRequest()->getPost('cancelar') == "") {
                $formData = $this->getRequest()->getPost();
                if ($form->isValid($formData)) {
                    $id = (int) $form->getValue('id');
                    $nome = $form->getValue('nome');
                    $oUniversidades = new Application_Model_DbTable_Universidades();
                    $oUniversidades->editarUniversidade($id, $nome);
                    $this->_helper->flashMessenger->addMessage(utf8_encode('Edição realizada com sucesso!'));
                } else {
                    $form->populate($formData);
                } 
            } 
            $this->_helper->redirector('index');
        } else {
            $id = $this->_getParam('id', 0);
            if ($id > 0) {
                $oUniversidade = new Application_Model_DbTable_Universidades();
                $this->view->oUniversidade = $oUniversidade->getUniversidade($id);
            }
        }
    }
    /**
     * Deletar uma Universidade
     */
    public function excluirAction() {
        if ($this->getRequest()->isPost()) {
            if ($this->getRequest()->getPost('cancelar') == '') {
                $id = $this->getRequest()->getPost('id');
                $oUniversidade = new Application_Model_DbTable_Universidades();
                $result = $oUniversidade->excluirUniversidade($id);
                if($result=="")
                    $this->_helper->flashMessenger->addMessage(utf8_encode('Exclusão realizada com sucesso!'));
                else
                    $this->_helper->flashMessenger->addMessage($result);
            }
            $this->_helper->redirector('index');
        } else {
            $id = $this->_getParam('id', 0);
            $oUniversidade = new Application_Model_DbTable_Universidades();
            $this->view->oUniversidade = $oUniversidade->getUniversidade($id);
        }
    }
    /**
     * Redirecionamento para o grid do controller
     */
    public function gridAction(){
        $this->_helper->redirector('index');
    }
}