<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed - Conhecimentos');
  
class Basemodel extends CI_Model {

    public function __construct() {
        parent::__construct();            
    }
    
    public function getTipoCamposTabela($tabela) {
        $sql = "SELECT  b.attname AS CAMPO, 
                        UPPER(c.typname) AS TIPO, 
                        (atttypmod-4 - ((atttypmod / 65536) * 65536)) AS DECIMAIS
                FROM    pg_class a
                        JOIN pg_attribute b ON b.attrelid = a.oid AND
                                               b.attnum   > 0     AND
                                               b.attisdropped <> 't'
                        JOIN pg_type      c ON c.oid = b.atttypid
                WHERE   a.relkind = 'r' and
                        a.relname = ?
                ORDER BY b.attnum";
        
        $query  = $this->db->query($sql, array(strtolower($tabela)));
        $campos = $query->result_array();
        $result = array();
        foreach($campos as $key => $campo):
            $result[$campo['campo']] = array('tipo'     => tipoPostgres2PHP($campo['tipo']),
                                             'decimais' => $campo['decimais']);
        endforeach;
        
        return $result;
        
    }
    
    public function getProximoCodigoPK($campo, $tabela){        
        $query = $this->db->query("select coalesce(max(" . $campo . "), 0) + 1 as proximo_codigo from " . $tabela);
        return $query->row_array()['proximo_codigo'];
    }

}
 