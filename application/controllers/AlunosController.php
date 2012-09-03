<?php
/**
 * Controller Alunos
 * @author Fabricio Nogueira <nogsantos@gmail.com>
 * @since 31 AGO 2012
 */
class AlunosController extends Zend_Controller_Action {
    /*
     * 
     */
    public function init() {
        $this->view->assign('classActive', 'alunos');
        $this->view->menssagens = $this->_helper->flashMessenger->getMessages();
        
         $this->_helper->ajaxContext()
              ->addActionContext('get-ajax-content', 'json')
              ->initContext();
    }
    /*
     * 
     */
    public function indexAction() {
        $oAlunos = new Application_Model_DbTable_Alunos();
        if($oAlunos->getAllAlunos()){
            $this->view->oAlunos = $oAlunos->getAlunosCursosUniversidades();
        }else{
            $this->view->oAlunos = "";
        }
    }
    /**
     * Cadastro de um novo Aluno
     */
    public function novoAction() {
        $form = new Application_Form_Alunos();
        if ($this->getRequest()->isPost()) {
            if ($this->getRequest()->getPost('cancelar') == "") {
                $formData = $this->getRequest()->getPost();
                if ($form->isValid($formData)) {
                    $nome = $form->getValue('nome');
                    $matricula = $form->getValue('matricula');
                    $cursoId = (Int) $form->getValue('curso_id');
                    $oAlunos = new Application_Model_DbTable_Alunos();
                    $oAlunos->novoAluno(
                            $nome,
                            $matricula,
                            $cursoId
                    );
                    $this->_helper->flashMessenger->addMessage(utf8_encode('Cadastro realizado com sucesso!'));
                } else {
                    $form->populate($formData);
                }
            }
            $this->_helper->redirector('index');
        }else{
            $this->alunosPopulaUniversidadeSelectView();
        }
    }
    /**
     * Editar uma Curso
     */
    public function editarAction() {
        $form = new Application_Form_Alunos();
        if ($this->getRequest()->isPost()) {
            if ($this->getRequest()->getPost('cancelar') == "") {
                $formData = $this->getRequest()->getPost();
                if ($form->isValid($formData)) {
                    $id = (int) $form->getValue('id');
                    $nome = $form->getValue('nome');
                    $matricula = $form->getValue('matricula');
                    $cursoId = (Int) $form->getValue('curso_id');
                    $oAlunos = new Application_Model_DbTable_Alunos();
                    $oAlunos->editarAluno(
                            $id, 
                            $nome,
                            $matricula,
                            $cursoId
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
                $oAlunos = new Application_Model_DbTable_Alunos();
                $this->view->oAlunos = $oAlunos->getAlunosCursosUniversidades($id);
                $this->alunosPopulaUniversidadeSelectView();
                $this->alunosCursosUniversidadeSelectView($this->view->oAlunos['universidade_id']);
            }
        }
    }
    /**
     * Deletar um Aluno
     */
    public function excluirAction() {
       if ($this->getRequest()->isPost()) {
            if ($this->getRequest()->getPost('cancelar') == '') {
                $id = $this->getRequest()->getPost('id');
                $oAlunos = new Application_Model_DbTable_Alunos();
                $oAlunos->excluirAluno($id);
                $this->_helper->flashMessenger->addMessage(utf8_encode('Exclusão realizada com sucesso!'));
            }
            $this->_helper->redirector('index');
        } else {
            $id = $this->_getParam('id', 0);
            $oAlunos = new Application_Model_DbTable_Alunos();
            $this->view->oAlunos = $oAlunos->getAlunosCursosUniversidades($id);
            $this->alunosPopulaUniversidadeSelectView();
            $this->alunosCursosUniversidadeSelectView($this->view->oAlunos['universidade_id']);
        }
    }
    /**
     * Redirecionamento para o grid do controller
     */
    public function gridAction(){
        $this->_helper->redirector('index');
    }
   /**
    * Universidades cadastradas.
    */
    private function alunosPopulaUniversidadeSelectView(){
        $oUniversidades = new Application_Model_DbTable_Universidades();
        return $this->view->selectUniversidades = $oUniversidades->getSelectUniversidades();
    }
   /**
    * Cursos cadastrados por universidade.
    */
    private function alunosCursosUniversidadeSelectView($id){
        $oCursos = new Application_Model_DbTable_Cursos();

        return $this->view->selectCursosUniversidades = $oCursos->getAdapter()->fetchPairs( 
             $oCursos->getCursosPorUniversidadeSelect($id)
        );
    }
    /**
     * Chamada ajax para popular o campo de cursos de acordo com a universidade setada
     */
    public function getAjaxContentAction() {
        $oCursos = new Application_Model_DbTable_Cursos();
        $this->view->cursos = $oCursos->getCursosPorUniversidade($this->getRequest()->getPost('universidade_id'));
    }
}