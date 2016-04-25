<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Model_issue extends CI_Model {

    private $_table = 'issue';

    public $resolveArr = array(
        'disable' => '1', 
        'able' => '0'
    );

    public $statusArr = array(
        'able' => '1',
        'close' => '0',
        'delete' => '-1'
    );

    function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取最新的10条记录
     */
    public function top10() {
        $rows = false;
        $sql = "SELECT * FROM `choc_issue` WHERE `status` = 1 ORDER BY `id` DESC LIMIT 0,10";
        $query = $this->db->query($sql);
        foreach ($query->result_array() as $row)
        {
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * 添加数据
     */
    public function add($data) {
        $feedback = array(
            'status' => false,
            'message' => ''
        );
        $data['add_time'] = time();
        $data['add_user'] = $this->input->cookie('uids');
        $sql = "SELECT `id` FROM `choc_issue` WHERE `issue_name` = '".$data['issue_name']."'";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $feedback['message'] = "此任务已经存在";
            return $feedback;
        }
        $res = $this->db->insert('issue', $data);
        if ($res) {
            $feedback['status'] = true;
            $feedback['message'] = 'success';
        } else {
            $feedback['message'] = $this->db->error();
        }
        return $feedback;
    }

    /**
     * 列表
     */
    public function rows() {
        $rows = false;
        $sql = "SELECT * FROM `choc_issue` ORDER BY `id` DESC";
        $query = $this->db->query($sql);
        foreach ($query->result_array() as $row)
        {
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * 删除
     */
    public function del($id) {
        return $this->db->update('issue', array('last_time' => time(), 'last_user' => $this->input->cookie('uids'), 'status' => '-1'), array('id' => $id));
    }

    /**
     * 关闭
     */
    public function close($id) {
        return $this->db->update('issue', array('last_time' => time(), 'last_user' => $this->input->cookie('uids'), 'status' => '0'), array('id' => $id));
    }

    /**
     * 关闭
     */
    public function open($id) {
        return $this->db->update('issue', array('last_time' => time(), 'last_user' => $this->input->cookie('uids'), 'status' => '1', 'resolve' => '0'), array('id' => $id));
    }

    /**
     * 已解决
     */
    public function resolve($id) {
        return $this->db->update('issue', array('last_time' => time(), 'last_user' => $this->input->cookie('uids'), 'status' => '0', 'resolve' => '1'), array('id' => $id));
    }

    /**
     * 获取指定单条信息
     */
    public function fetchOne($id) {
        $query = $this->db->get_where('issue', array('id' => $id), 1);
        if ($query->num_rows()) {
            $row = $query->row_array();
            return $row;
        } else {
            return false;
        }
    }

    /**
     * 验证任务是否已经解决
     */
    public function checkResolve($id) {
        $row = $this->fetchOne($id);
        if ($row) {
            if ($row['resolve']) {
                return true;
            }
        }
        return false;
    }

    /**
     * 更新信息
     */
    public function update($data) {
        $id = $data['id'];
        unset($data['id']);
        $data['last_time'] = time();
        $data['last_user'] = $this->input->cookie('uids');
        return $this->db->update('issue', $data, array('id' => $id));
    }

    /**
     * 我的任务列表
     */
    public function my($offset = 0, $per_page = 20) {
        $rows = array(
            'total_rows' => 0,
            'data' => false
        );

        //获取总数
        $sql = "SELECT * FROM `choc_issue` WHERE `add_user` = '".$this->input->cookie('uids')."' AND `status` = '1'";
        $query = $this->db->query($sql);
        $rows['total_rows'] = $query->num_rows;

        //获取翻页数据
        $sql = "SELECT * FROM `choc_issue` WHERE `add_user` = '".$this->input->cookie('uids')."' AND `status` = '1' ORDER BY `id` DESC LIMIT ".$offset .", ".$per_page."";
        $query = $this->db->query($sql);
        foreach ($query->result_array() as $row)
        {
            $rows['data'][] = $row;
        }
        return $rows;
    }

    /**
     * 我的任务列表
     */
    public function profile($id, $role, $leftTime, $rightTime, $offset = 0, $per_page = 20) {
        $rows = array(
            'total_rows' => 0,
            'data' => false
        );

        $user = 'add_user';
        $userTime = 'add_time';
        if ($role == 1) {
            $user = 'accept_user';
            $userTime = 'accept_time';
        }
        if ($role == 2) {
            $user = 'add_user';
            $userTime = 'add_time';
        }

        //获取总数
        $sql = "SELECT * FROM `choc_issue` WHERE `".$user."` = '".$id."' AND `".$userTime."` >= '".$leftTime."' AND `".$userTime."` < '".$rightTime."'";
        $query = $this->db->query($sql);
        $rows['total_rows'] = $query->num_rows;

        //获取翻页数据
        $sql = "SELECT * FROM `choc_issue` WHERE `".$user."` = '".$id."' AND `".$userTime."` >= '".$leftTime."' AND `".$userTime."` < '".$rightTime."' ORDER BY `id` DESC LIMIT ".$offset .", ".$per_page."";
        $query = $this->db->query($sql);
        foreach ($query->result_array() as $row)
        {
            $rows['data'][] = $row;
        }
        return $rows;
    }

    /**
     * 我的受理列表
     */
    public function todo($offset = 0, $per_page = 20) {
        $rows = array(
            'total_rows' => 0,
            'data' => false
        );

        //获取总数
        $sql = "SELECT * FROM `choc_issue` WHERE `accept_user` = '".$this->input->cookie('uids')."' AND `status` = '1'";
        $query = $this->db->query($sql);
        $rows['total_rows'] = $query->num_rows;

        //获取翻页数据
        $sql = "SELECT * FROM `choc_issue` WHERE `accept_user` = '".$this->input->cookie('uids')."' AND `status` = '1' ORDER BY `id` DESC LIMIT ".$offset .", ".$per_page."";
        $query = $this->db->query($sql);
        foreach ($query->result_array() as $row)
        {
            $rows['data'][] = $row;
        }
        return $rows;
    }

    /**
     * 任务广场列表
     */
    public function plaza($add_user, $accept_user, $status, $resolve, $issueType, $offset = 0, $per_page = 20) {
        $rows = array(
            'total_rows' => 0,
            'data' => false
        );

        $addUserStr = $acceptUserStr = $issueTypeStr = "";

        if ($add_user == 'my') {
            $addUserStr = "`add_user` = '".$this->input->cookie('uids')."' AND ";
        }
        if ($accept_user == 'my') {
            $acceptUserStr = "`accept_user` = '".$this->input->cookie('uids')."' AND ";
        }

        if ($issueType == 'bug' || $issueType == 'task') {
            $array = array('task' => 1, 'bug' => 2);
            $issueTypeStr = "`type` = '".$array[$issueType]."' AND ";
        }

        //获取总数
        $sql = "SELECT * FROM `choc_issue` WHERE ".$addUserStr.$acceptUserStr.$issueTypeStr."`status` = '".$this->statusArr[$status]."' AND `resolve` = '".$this->resolveArr[$resolve]."'";
        $query = $this->db->query($sql);
        $rows['total_rows'] = $query->num_rows;

        //获取翻页数据
        $sql = "SELECT * FROM `choc_issue` WHERE ".$addUserStr.$acceptUserStr.$issueTypeStr."`status` = '".$this->statusArr[$status]."' AND `resolve` = '".$this->resolveArr[$resolve]."' ORDER BY `id` DESC LIMIT ".$offset .", ".$per_page."";
        $query = $this->db->query($sql);
        foreach ($query->result_array() as $row)
        {
            $rows['data'][] = $row;
        }
        return $rows;
    }

    /**
     * 受理
     */
    public function accept($id) {
        return $this->db->update('issue', array('last_time' => time(), 'last_user' => $this->input->cookie('uids'), 'accept_user' => $this->input->cookie('uids'), 'accept_time' => time()), array('id' => $id));
    }

    /**
     * 更改受理
     */
    public function update_accept($id, $uid) {
        return $this->db->update('issue', array('last_time' => time(), 'last_user' => $uid, 'accept_user' => $uid, 'accept_time' => time()), array('id' => $id));
    }

    /**
     * 验证是否受理
     */
    public function checkAccept($id) {
        $row = $this->fetchOne($id);
        if ($row) {
            if ($row['accept_user']) {
                return $row['accept_user'];
            }
        }
        return false;
    }

    public function stacked($userId = 0, $leftTime, $rightTime) {
        $rows = false;
        $where = 'WHERE `status` >=0';
        if ($userId) {
            $where .= " AND `add_user` = '".$userId."' AND `add_time` >= '".$leftTime."' AND `add_time` < '".$rightTime."'";
        }
        //正常状态的
        $sql = "SELECT FROM_UNIXTIME(`add_time`,'%Y-%m-%d') AS `perday`, SUM(`status` = 1)  AS `count` FROM `choc_issue` ".$where." GROUP BY FROM_UNIXTIME(`add_time`,'%Y-%m-%d')";
        $query = $this->db->query($sql);
        $row1 = $query->result_array();
        //关闭状态
        $sql = "SELECT FROM_UNIXTIME(`add_time`,'%Y-%m-%d') AS `perday`, SUM(`status` = 0)  AS `count` FROM `choc_issue` ".$where." GROUP BY FROM_UNIXTIME(`add_time`,'%Y-%m-%d')";
        $query = $this->db->query($sql);
        $row2 = $query->result_array();
        foreach ($row1 as $key=>$value)
        {
            $rows[$key]['perday'] = $value['perday'];
            $rows[$key]['able'] = $value['count'];
            $rows[$key]['close'] = $row2[$key]['count'];
        }
        return $rows;
    }

    public function stackedByQa($userId = 0, $leftTime, $rightTime) {
        $rows = false;
        $where = 'WHERE `status` >=0';
        if ($userId) {
            $where .= " AND `accept_user` = '".$userId."' AND `accept_time` >= '".$leftTime."' AND `accept_time` < '".$rightTime."'";
        }
        //正常状态的
        $sql = "SELECT FROM_UNIXTIME(`accept_time`,'%Y-%m-%d') AS `perday`, SUM(`status` = 1)  AS `count` FROM `choc_issue` ".$where." GROUP BY FROM_UNIXTIME(`accept_time`,'%Y-%m-%d')";
        $query = $this->db->query($sql);
        $row1 = $query->result_array();
        //关闭状态
        $sql = "SELECT FROM_UNIXTIME(`accept_time`,'%Y-%m-%d') AS `perday`, SUM(`status` = 0)  AS `count` FROM `choc_issue` ".$where." GROUP BY FROM_UNIXTIME(`accept_time`,'%Y-%m-%d')";
        $query = $this->db->query($sql);
        $row2 = $query->result_array();
        foreach ($row1 as $key=>$value)
        {
            $rows[$key]['perday'] = $value['perday'];
            $rows[$key]['able'] = $value['count'];
            $rows[$key]['close'] = $row2[$key]['count'];
        }
        return $rows;
    }

    public function topUser() {
        $sql = "SELECT COUNT(1) AS `num`, `add_user` FROM `choc_issue` WHERE `status` >=0 GROUP BY `add_user` ORDER BY `num` DESC LIMIT 5";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function tongji($uid) {
        $array = array('taskNumByme' => 0);
        //统计他在3月份创建了多少任务
        $sql = "SELECT count(1) as total FROM `choc_issue` WHERE `add_time` >= '1456761600' AND `add_time` < '1459440000' AND `add_user`='".$uid."' AND 'status' >= 0";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $row = $query->row_array();
            $array['taskNumByme'] = $row['total'];
        }
        //
        return $array;
    }

    public function listByPlan($planId, $projectId, $limit = 20, $offset = 0) {
        $row = array();
        $this->db->select('*');
        $this->db->where('plan_id', $planId);
        $this->db->where('project_id', $projectId);
        $this->db->order_by('id,type', 'desc');
        $this->db->limit($limit, $offset);
        $query = $this->db->get($this->_table);
        $row = $query->result_array();
        return $row;
    }
}