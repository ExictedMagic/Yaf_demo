<?php
/**
 * Created by PhpStorm.
 * User: songxiyao
 * Date: 13-12-4
 * Time: 下午9:25
 */
class Db extends Zend_Db_Table {
    protected $_table;
    protected $_db;

    public function __construct() {
        parent::__construct();
        $this->_db = $this->getAdapter();
    }

    /*
     * 查询列表数据
     * @param $params array
     * @return array|bool
     * eg: $params = array(
     *       'field' => array('id', 'username'), 查询字段
     *       'where'  => array('username' => 'songxiyao', 'password' => 'xxxxx'), 查询条件
     *       'order'  => 'id desc', 排序
     *       'limit'  => 1, 查询的数量
     *       'offset' => 1, 查询偏移量
     *       'page'   => $page ? $page : 1, 当前页码
     *       'per'    => 1, 每页显示数量
     *     );
     */
    public function getList($params = array()) {
        $query = "";
        $select = $this->_db->select();
        if (isset($params['field']) && is_array($params['field']) && !empty($params['field'])) {
            $query .= $select->from($this->_table, $params['field']);
        } else {
            $query .= $select->from($this->_table);
        }
        if (isset($params['where']) && is_array($params['where']) && !empty($params['where'])) {
            foreach ($params['where'] as $k => $v) {
                $query .= $select->where("{$k} = ?", $v);
            }
        }
        if (isset($params['order']) && !empty($params['order'])) {
            $query .= $select->order("{$params['order']}");
        }
        if (isset($params['limit']) && !empty($params['limit'])) {
            if (empty($params['offset'])) {
                $query .= $select->limit($params['limit']);
            } else {
                $query .= $select->limit($params['limit'], $params['offset']);
            }
        }
        //用于翻页
        if (isset($params['page']) && !empty($params['page']) && isset($params['per']) && !empty($params['per'])) {
            $query .= $select->limitPage($params['page'], $params['per']);
        }
        if ($query) {
            $result = $this->_db->fetchAll($select);
        }
        return isset($result) ? $result : false;
    }

    /*
     * 查询单条数据
     * @param $params array
     * @return array|bool
     */
    public function getOne($params) {
        $params['limit'] = 1;
        $result = $this->getList($params);

        if (!empty($result)) {
            return $result[0];
        } else {
            return false;
        }
    }

    /*
     * 返回数据总数
     * @param $params array
     * @return int
     */
    public function getCount($params) {
        $params['field'] = array("count(id) as cnt");
        if (isset($params['limit'])) {
            unset($params['limit']);
        }
        if (isset($params['offset'])) {
            unset($params['offset']);
        }
        if (isset($params['page'])) {
            unset($params['page']);
        }
        if (isset($params['per'])) {
            unset($params['per']);
        }
        $result = $this->getOne($params);
        return $result ? $result : 0;
    }

    /*
     * 插入数据
     * @param $data array
     * @return int|bool
     */
    public function insertData($data) {
        if (is_array($data) && !empty($data)) {
            return $this->_db->insert($this->_table, $data);
        } else {
            return false;
        }
    }

    /*
     * 更新数据
     */
    public function updateData($data, $where) {
        if (is_array($where) && !empty($where)) {
            $query = array();
            foreach ($where as $k => $v) {
                $query[] = $this->_db->quoteInto("{$k} = ?", $v);
            }
            return $this->_db->update($this->_table, $data, $query);
        } else {
            return false;
        }
    }

    /*
     * 删除数据
     */
    public function delData($where) {
        if (is_array($where) && !empty($where)) {
            $query = array();
            foreach ($where as $k => $v) {
                $query[] = $this->_db->quoteInto("{$k} = ?", $v);
            }
            return $this->_db->delete($this->_table, $query);
        } else {
            return false;
        }
    }
}