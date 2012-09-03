<?php
/**
 * Persistencia Cursos
 * @author Fabricio Nogueira <nogsantos@gmail.com>
 * @since 29 AGO 2012
 */
class Application_Model_DbTable_Cursos extends Zend_Db_Table_Abstract {

    protected $_name = 'cursos';
    protected $_dependentTables = array('alunos');
    protected $_refereceMap = array(
        'universidades' => array(
            'columns' => 'id',
            'refTablesClass' => 'cursos',
            'refColumns' => array(
                'id',
            ),
        ),
    );
    /**
     * Recuperar um Curso Cadastrado por id
     */
    public function getCursos($id) {
        $id = (int) $id;
        $row = $this->fetchRow(' id = ' . $id);
        if (!$row) {
            throw new Exception("Vazio");
        }
        return $row->toArray();
    }
    /**
     * Recuperar todos os Cursos Cadastradas
     */
    public function getAllCursos() {
        $row = $this->fetchRow();
        if (!$row) {
            return false;
        }else{
            return true;
        }
    }
    /**
     * Persistir um novo curso
     */
    public function novoCurso($nome,$universidadeId){
        $data = array(
            'nome' => $nome,
            'universidade_id' => $universidadeId,
        );
        $this->insert($data);
    }
    /**
     * Editar um Curso
     */
    public function editarCurso($id, $nome, $universidadeId) {
        $data = array(
            'nome' => $nome,
            'universidade_id' => $universidadeId,
        );
        $this->update($data, ' id = ' . (int) $id);
    }
    /**
     * Excluir um Curso
     */
    public function excluirCurso($id) {
        try {
            $this->delete(' id = ' . (int) $id);
        } catch (Zend_Exception $e) {
            Zend_Controller_Plugin_ErrorHandler::EXCEPTION_OTHER;
            throw new Exception(utf8_encode("Este Curso está sendo referência em um aluno."));
        }
    }
    /**
     * 
     */
    public function getUniversidadesCursos(){
         $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('c'=>'cursos',),
                            array('id', 'nome',)
                        )
                        ->joinLeft(
                            array('u' => 'universidades',),
                            'u.id = c.universidade_id',
                            array('id as universidade_id','nome as universidade',)
                        );
         return $this->fetchAll($select);
    }
    /**
     * Retorna os cursos por universidade. Ajax
     */
    public function getCursosPorUniversidade($id){
         $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('c'=>'cursos',),
                            array('id', 'nome',)
                        )
                        ->join(
                            array('u' => 'universidades',),
                            'u.id = c.universidade_id',
                            array('id as universidade_id','nome as universidade',)
                        )
                        ->where("u.id = ". (Int) $id);
         return $this->fetchAll($select)->toArray();
    }
    /**
     * Retorna os cursos por universidade. Select
     */
    public function getCursosPorUniversidadeSelect($id){
         $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('c'=>'cursos',),
                            array('id', 'nome',)
                        )
                        ->join(
                            array('u' => 'universidades',),
                            'u.id = c.universidade_id'
                        )
                        ->where("u.id = ". (Int) $id);
         return $select;
    }
}