<?php
/**
 * Persistencia Cursos
 * @author Fabricio Nogueira <nogsantos@gmail.com>
 * @since 29 AGO 2012
 */
class Application_Model_DbTable_Alunos extends Zend_Db_Table_Abstract {

    protected $_name = 'alunos';
    /**
     * Recuperar um Aluno Cadastrado por id
     */
    public function getAluno($id) {
        $id = (int) $id;
        $row = $this->fetchRow(' id = ' . $id);
        if (!$row) {
            throw new Exception(utf8_encode("O Aluno especificado não foi localizado"));
        }
        return $row->toArray();
    }
    /**
     * Recuperar todos os Alunos Cadastradas
     */
    public function getAllAlunos() {
        $row = $this->fetchRow();
        if (!$row) {
            return false;
        }else{
            return true;
        }
    }
    /**
     * Persistir um novo Aluno
     */
    public function novoAluno($nome, $matricula, $cursoId){
        $data = array(
            'nome' => $nome,
            'matricula' => $matricula,
            'curso_id' => $cursoId,
        );
        $this->insert($data);
    }
    /**
     * Editar um Aluno
     */
    public function editarAluno($id, $nome, $matricula, $cursoId) {
        $data = array(
            'nome' => $nome,
            'matricula' => $matricula,
            'curso_id' => $cursoId,
        );
        $this->update($data, ' id = ' . (int) $id);
    }
    /**
     * Excluir um Aluno
     */
    public function excluirAluno($id) {
        try {
            $this->delete(' id = ' . (int) $id);
        } catch (Zend_Exception $e) {
            Zend_Controller_Plugin_ErrorHandler::EXCEPTION_OTHER;
            throw new Exception(utf8_encode("Erro Indefinido, por favor, tente outra vez."));
        }
    }
    /**
     * Retorna alunos cadastrados
     */
    public function getAlunosCursosUniversidades($id=null){
        $select = $this->select()
                       ->setIntegrityCheck(false)
                       ->from(array('a'=>'alunos',),
                            array('id', 'nome','matricula')
                       )
                       ->joinLeft(
                           array('c' => 'cursos',),
                           'c.id = a.curso_id',
                           array('id as curso_id','nome as curso')
                       )
                       ->joinLeft(
                           array('u' => 'universidades',),
                           'u.id = c.universidade_id',
                           array('id as universidade_id','nome as universidade')
                       ) 
                       ->where($id != null ? "a.id = ". (Int) $id : "1=1");
        return $id != null ? $this->fetchRow($select) : $this->fetchAll($select);
    }
}