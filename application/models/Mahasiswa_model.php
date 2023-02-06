<?php
class Mahasiswa_model extends CI_Model
{

    public function getMahasiswa($id = NULL){
        if ($id== NULL) {
            $this->db->select('mahasiswa.nama,user.username');
            $this->db->from('mahasiswa');
            $this->db->join('user', 'user.id_user = mahasiswa.user_id');
            return $query = $this->db->get()->result_array();
            //return $this->db->get('mahasiswa')->result_array();
        }else {
            return $this->db->get_where('mahasiswa',['id'=>$id])->result_array();
        }
       
    }
    public function deleteMahasiswa($id)
    {
        $this->db->delete('mahasiswa',['id'=>$id]);
        return $this->db->affected_rows();
    }
    public function createMahasiswa($data)
    {
        $this->db->insert('mahasiswa',$data);
        return $this->db->affected_rows();
    }
    public function updateMahasiswa($data,$id)
    {
        $this->db->update('mahasiswa', $data, ['id'=>$id]);
        return $this->db->affected_rows();
    }
}
