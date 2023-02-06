<?php
class User_model extends CI_Model
{
	public function getUser($id = NULL){
        if ($id== NULL) {
            return $this->db->get('user')->result_array();
        }else {
            
            //get_where('user',['id_user'=>$id])->result_array();
            
            return $this->db->get_where('user', ['id_user' => $id])->result_array();
        }
       
    }
    public function createUser($data)
    {
        $this->db->insert('user', $data);
        return $this->db->affected_rows();
    }

    public function deleteUser($id)
    {
        $this->db->delete('user', ['id_user' => $id]);
        return $this->db->affected_rows();
    }
    public function updateUser($data, $id)
    {
        $this->db->update('user', $data, ['id_user' => $id]);
        return $this->db->affected_rows();
    }
}