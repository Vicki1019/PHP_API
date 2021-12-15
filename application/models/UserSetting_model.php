<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserSetting_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * 確認使用者
     *
     * @var string $sql 查詢使用者資料
     *
     * @param string $email 信箱
     *
     * @return object
     */
    public function userCheck($email){
        $sql = "SELECT member_nickname, email, profile_picture, group_cn
                FROM member_info 
                LEFT JOIN group_code ON group_code.member_no = member_info.member_no
                WHERE email=? AND member_info.locate_code = group_code.group_no";
        $query = $this->db->query($sql, $email);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * 取得使用者位置
     *
     * @var string $sql 
     *
     * @return object
     */
    public function get_user_locate($email)
    {
        $sql = "SELECT locate_code FROM member_info WHERE email=?";
        $query = $this->db->query($sql,$email);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    /**
     * 更新使用者暱稱與頭貼
     *
     * @param object $params
     * @param string $params->email 信箱
     * @param string $params->newname 新的暱稱
     * @param string $params->newphoto 新的頭貼
     *
     * @var string $sql 更新使用者暱稱
     *
     * @return bool
     */
    public function updateinfo($params)
    {
        $sql = "UPDATE member_info SET member_nickname=? , profile_picture=? WHERE email=?";
        $query = $this->db->query($sql, [
            $params->newName,
            $params->newphoto,
            $params->email
        ]);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }

        /*// 先查找使用者的新暱稱是否與原先相同
        $sql = "SELECT member_nickname as oldNickname FROM member_info WHERE email=?";
        $query = $this->db->query($sql, $params->email);
        $row = $query->row_array();

        //相同則直接回傳成功
        $newNickname = $params->nickname;
        if($newNickname == $row['oldNickname'])
        {
            return true;
        } else {
            $sql = "UPDATE member_info SET member_nickname=? WHERE email=?";
            $query = $this->db->query($sql, [
                $newNickname,
                $params->email
            ]);
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }*/
    }

    /**
     * 更新使用者密碼
     *
     * @param object $params
     * @param string $params->email 信箱
     * @param string $params->passwd 舊密碼
     * @param string $params->newpasswd 新密碼
     *
     * @var string $sql 更新使用者密碼
     *
     * @return bool|string
     */
    public function updatepass($params)
    {
        $sql = "UPDATE member_info SET passwd=? WHERE email=? AND passwd=?";
        $query = $this->db->query($sql, [
            $params->newpasswd,
            $params->email,
            $params->passwd
        ]);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

/**
     * 更新冰箱名稱
     *
     * @param object $params
     * @param string $params->email 信箱
     * @param string $params->refname 冰箱名稱
     * @var string $sql 更新冰箱名稱
     *
     * @return bool|string
     */
    public function update_refname($params)
    {
        $sql = "UPDATE group_code SET group_cn=? WHERE group_no=? AND group_cn=(SELECT group_cn FROM group_code WHERE group_no=? AND member_no=?)";
        $query = $this->db->query($sql, [
            $params->refname,
            $params->group_no,
            $params->group_no,
            $params->member_no
        ]);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 取得使用者編號
     *
     * @param object $params
     * @param string $params->email 信箱
     *
     * @var string $sql 取得使用者編號
     *
     * @return bool|string
     */
    public function getmemberno($email)
    {
        $sql = "SELECT member_no FROM member_info WHERE email=?";
        $query = $this->db->query($sql, $email);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    /**
     * 取得群組編號
     *
     * @param object $params
     * @param string $params->email 信箱
     *
     * @var string $sql 取得群組編號
     *
     * @return bool|string
     */
    public function getgroupno($email)
    {
        $sql = "SELECT group_no FROM member_info WHERE email=?";
        $query = $this->db->query($sql, $email);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }


    /**
     * 檢查分類是否重複
     *
     * @param object $params
     * @param string $params->memberno 使用者編號
     * @param string $params->newkind 新分類
     *
     * @var string $sql 檢查分類是否重複
     *
     * @return bool|string
     */
    public function kindcheck($params)
    {
        $sql = "SELECT member_no, kind_cn FROM food_kind_code WHERE member_no=? AND kind_cn=? ";
        $query = $this->db->query($sql, [
            $params->memberno,
            $params->newkind
        ]);
        if ($this->db->affected_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 新增分類項目
     *
     * @param object $params
     * @param string $params->newkind 新分類
     * @param string $params->memberno 使用者編號
     * @param string $params->groupno 群組編號
     *
     * @var string $sql 新增分類項目
     *
     * @return bool|string
     */
    public function addkind($params)
    {
        $sql = "INSERT INTO food_kind_code (kind_cn, member_no, group_no) VALUE (?,?,?)";
        $query = $this->db->query($sql, [
            $params->newkind,
            $params->memberno,
            $params->groupno
        ]);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 刪除分類項目
     *
     * @param object $params
     * @param string $params->deletekind 欲刪除分類
     *
     * @var string $sql 刪除分類項目
     *
     * @return bool|string
     */
    public function deletekind($params)
    {
        $sql = "DELETE FROM food_kind_code WHERE member_no=? AND kind_cn=?";
        $query = $this->db->query($sql, [
           $params->memberno,
           $params->deletekind
        ]);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

   /**
     * 儲存使用者LINE NOtify Token
     *
     * @param object $params
     * @param string $params->LINE Token 
     *
     * @var string $sql 儲存使用者LINE NOtify Token
     *
     * @return bool|string
     */
    public function savetoken($params)
    {
      $sql = "UPDATE member_info SET line_token=? WHERE email=?";
      $this->db->query($sql, [
      $params->token,
      $params->email
      ]);
      if ($this->db->affected_rows() > 0) {
          return true;
      } else {
          return false;
      }
    }

    /**
     * 刪除LINE NOtify Token
     *
     * @param object $params
     *
     * @var string $sql 刪除LINE NOtify Token
     *
     * @return bool|string
     */
    public function delete_line_token($email)
    {
        $sql = "UPDATE member_info SET line_token=NULL WHERE email=?";
        $this->db->query($sql, $email);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

   /**
     * 取得使用者LINE Token
     *
     * @param object $params
     * @param string $params->email 信箱
     *
     * @var string $sql 取得使用者LINE Token
     *
     * @return bool|string
     */
    public function get_line_token($email)
    {
        $sql = "SELECT line_token FROM member_info WHERE email=?";
        $query = $this->db->query($sql, $email);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * 取得推播設定時間
     *
     * @param object $params
     * @param string $params->email 信箱
     *
     * @var string $sql 取得推播設定時間
     *
     * @return bool|string
     */
    public function get_send_hint($email)
    {
        $sql = "SELECT send_hint FROM member_info WHERE email=?";
        $query = $this->db->query($sql, $email);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * 更新預設推播時間
     *
     * @param object $params
     *
     * @var string $sql 更新預設推播時間
     *
     * @return bool|string
     */
    public function update_notify_time($params)
    {
        $sql = "UPDATE member_info SET send_hint=? WHERE email=?";
        $this->db->query($sql, [
            $params->new_time,
            $params->email
            ]);
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
    }

    /**
     * 取得冰箱清單之推播時間
     *
     * @param object $params
     * @param string $params->member_no 使用者編號
     *
     * @var string $sql 取得冰箱清單之推播時間
     *
     * @return bool|string
     */
    public function get_reflist_alert($member_no)
    {
        $sql = "SELECT refre_list_no, alert_date FROM refre_list WHERE member_no=?";
        $query = $this->db->query($sql, $member_no);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * 更新冰箱清單推播時間
     *
     * @param object $params
     *
     * @var string $sql 更新冰箱清單推播時間
     *
     * @return bool|string
     */
    public function update_reflist_notify($params)
    {
        $sql = "UPDATE refre_list SET alert_date=? WHERE member_no=? AND refre_list_no=?";
        $this->db->query($sql, [
            $params->new_ref_alert,
            $params->member_no,
            $params->food_no
            ]);
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
    }

    /**
     * 取得購物清單之推播時間
     *
     * @param object $params
     * @param string $params->member_no 使用者編號
     *
     * @var string $sql 取得購物清單之推播時間
     *
     * @return bool|string
     */
    public function get_shoplist_alert($member_no)
    {
        $sql = "SELECT shopping_list_no, hint_datetime FROM shopping_list WHERE member_no=?";
        $query = $this->db->query($sql, $member_no);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * 更新購物清單推播時間
     *
     * @param object $params
     *
     * @var string $sql 更新購物清單推播時間
     *
     * @return bool|string
     */
    public function update_shoplist_notify($params)
    {
        $sql = "UPDATE shopping_list SET hint_datetime=? WHERE member_no=? AND shopping_list_no=?";
        $this->db->query($sql, [
            $params->new_shop_alert,
            $params->member_no,
            $params->shoplist_no
            ]);
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
    }
    public function add_kind_photo(){
        
    }
}