<?php
/**
 * Persistencia Universidades
 * @author Fabricio Nogueira <nogsantos@gmail.com>
 * @since 29 AGO 2012
 */
class Application_Model_DbTable_Universidades extends Zend_Db_Table_Abstract {

    protected $_name = 'universidades';
    protected $_dependentTables = array('cursos');
    /**
     * Recuperar Universidade Cadastradas por id
     */
    public function getUniversidade($id) {
        $id = (int) $id;
        $row = $this->fetchRow(' id = ' . $id);
        if (!$row) {
            throw new Exception("Vazio");
        }
        return $row->toArray();
    }
    /**
     * Recuperar todas as Universidades Cadastradas
     */
    public function getAllUniversidades() {
        $row = $this->fetchRow();
        if (!$row) {
            return false;
        }else{
            return true;
        }
    }
    /**
     * Persistir uma nova universidade
     */
    public function novoUniversidade($nome) {
        try {
            $data = array(
                'nome' => $nome,
            );
            $this->insert($data);
        } catch (Zend_Exception $e) {
            Zend_Controller_Plugin_ErrorHandler::EXCEPTION_OTHER;
            throw new Exception(utf8_encode("Este nome já foi utilizado, por favor, escolha outra nome."));
        }
    }
    /**
     * Editar uma universidade
     */
    public function editarUniversidade($id, $nome) {
        $data = array(
            'nome' => $nome,
        );
        $this->update($data, ' id = ' . (int) $id);
    }
    /**
     * Excluir universidade
     */
    public function excluirUniversidade($id) {
        try {
            $this->delete(' id = ' . (int) $id);
        } catch (Zend_Exception $e) {
            Zend_Controller_Plugin_ErrorHandler::EXCEPTION_OTHER;
            throw new Exception(utf8_encode("Esta Universidade está sendo referênciada em um curso."));
        }
    }
    /**
     * Popula select de unidades
     */
     public function getSelectUniversidades(){
        $oUniversidades = new Application_Model_DbTable_Universidades();

        return $oUniversidades->getAdapter()->fetchPairs( 
            $oUniversidades->select()->from( 'universidades', array('id', 'nome') )->order('nome')
        );
    }
}