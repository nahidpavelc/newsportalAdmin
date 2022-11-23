<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php
class AdminModel extends CI_Model
{

  // $returnmessage can be num_rows, result_array, result
  public function isRowExist($tableName, $data, $returnmessage, $user_id = NULL)
  {

    $this->db->where($data);
    if ($user_id !== NULL) {
      $this->db->where('userId', $user_id);
    }
    if ($returnmessage == 'num_rows') {
      return $this->db->get($tableName)->num_rows();
    } else if ($returnmessage == 'result_array') {
      return $this->db->get($tableName)->result_array();
    } else {
      return $this->db->get($tableName)->result();
    }
  }
  // saveDataInTable table name , array, and return type is null or last inserted ID.
  public function saveDataInTable($tableName, $data, $returnInsertId = 'false')
  {

    $this->db->insert($tableName, $data);
    if ($returnInsertId == 'true') {
      return $this->db->insert_id();
    } else {
      return -1;
    }
  }

  public function check_campaign_ambigus($start_date, $end_date)
  {

    if (date_format(date_create($start_date), "Y-m-d") > date_format(date_create($end_date), "Y-m-d")) {
      return -2;
    }

    $this->db->limit(1);
    $this->db->where('end_date >=', $start_date);
    $this->db->where('available_status', 1);
    $query = $this->db->get('create_campaign')->num_rows();
    if ($query > 0) {
      return -1;
    }
    return 1;
  }

  public function end_date_extends($end_date, $id)
  {

    $this->db->limit(1);
    $this->db->where('start_date >=', $end_date);
    $this->db->where('id', $id);
    $this->db->where('available_status', 1);
    $query = $this->db->get('create_campaign')->num_rows();
    if ($query > 0) {
      return -1;
    }
    $this->db->limit(1);
    $this->db->where('end_date >=', $end_date);
    $this->db->where('id !=', $id);
    $this->db->where('available_status', 1);
    $query2 = $this->db->get('create_campaign')->num_rows();
    if ($query2 > 0) {
      return -1;
    }
    return 1;
  }

  public function fetch_data_pageination($limit, $start, $table, $search = NULL, $approveStatus = NULL, $user_id = NULL)
  {

    $this->db->limit($limit, $start);

    if ($approveStatus !== NULL) {
      $this->db->where('approveStatus', $approveStatus);
    }

    if ($user_id !== NULL) {
      $this->db->where('userId', $user_id);
    }

    if ($search !== NULL) {
      $this->db->like('title', $search);
      $this->db->or_like('body', $search);
      $this->db->or_like('date', $search);
    }

    $this->db->order_by('date', 'desc');
    $query = $this->db->get($table);

    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $data[] = $row;
      }
      return $data;
    }
    return false;
  }
  public function fetch_images($limit = 18, $start = 0, $table, $search = NULL, $where_data = NULL)
  {

    $this->db->limit($limit, $start);

    if ($search !== NULL) {
      $this->db->like('date', $search);
      $this->db->or_like('photoCaption', $search);
    }
    if ($where_data !== NULL) {
      $this->db->where($where_data);
    }
    $this->db->group_by('photo');
    $this->db->order_by('date', 'desc');
    $query = $this->db->get($table);

    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $data[] = $row;
      }
      return $data;
    }
    return false;
  }

  public function usersCategory($userId)
  {

    $this->db->select('category.*');
    $this->db->join('category', 'category_user.categoryId = category.id', 'left');
    $this->db->where('category_user.userId', $userId);
    return $this->db->get('category_user')->result_array();
  }


  public function get_user($user_id)
  {
    $query = $this->db->select('user.*,tbl_upozilla.*')
      ->where('user.id', $user_id)
      ->from('user')
      ->join('tbl_upozilla', 'user.address = tbl_upozilla.id', 'left')
      ->get();

    return $query->row();
  }

  public function update_pro_info($update_data, $user_id)
  {
    return $this->db->where('id', $user_id)->update('user', $update_data);
  }

  public function update_testimonials($update_testimonials, $param2)
  {
    if (isset($update_testimonials['photo']) && file_exists($update_testimonials['photo'])) {

      $result = $this->db->select('photo')
        ->from('tbl_testimonial')
        ->where('id', $param2)
        ->get()
        ->row()->photo;

      if (file_exists($result)) {
        unlink($result);
      }
    }

    return $this->db->where('id', $param2)->update('tbl_testimonial', $update_testimonials);
  }
  public function delete_testimonials($param2)
  {
    $result = $this->db->select('photo')
      ->from('tbl_testimonial')
      ->where('id', $param2)
      ->get()
      ->row()->photo;

    if (file_exists($result)) {
      unlink($result);
    }

    return $this->db->where('id', $param2)->delete('tbl_testimonial');
  }

  public function theme_text_update($name_index, $value)
  {

    if ($name_index == 'logo') {
      $result = $this->db->select('value')->where(array('id' => 6))->get('tbl_backend_theme')->row()->value;

      if (file_exists($result)) {
        unlink($result);
      }
    } elseif ($name_index == 'share_banner') {
      $result = $this->db->select('value')->where(array('id' => 7))->get('tbl_backend_theme')->row()->value;

      if (file_exists($result)) {
        unlink($result);
      }
    }

    $update_theme['value'] = $value;
    $this->db->where('name', $name_index)->update('tbl_backend_theme', $update_theme);
    return true;
  }

  // Get One Data 
  public function get_one_($id)
  {
    $this->db->select('tbl_test_1.*, tbl_test_1.name')
      ->from('tbl_test_1');

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->result();
    } else {
      return array();
    }
  }
  //One Update 
  public function update_one_data($update_data, $param2)
  {
    return $this->db->where('id', $param2)->update('tbl_test_1', $update_data);
  }
  // One Delete 
  public function delete_one_data($param2)
  {
    return $this->db->where('id', $param2)->delete('tbl_test_1');
  }

    // Get Two Data 
    public function get_two_($id)
    {
      $this->db->select('tbl_test_2.*, tbl_test_2.name')
        ->from('tbl_test_2');
  
      $result = $this->db->get();
  
      if ($result->num_rows() > 0) {
        return $result->result();
      } else {
        return array();
      }
    }
    //Two Update 
    public function update_two_data($update_data, $param2)
    {
      return $this->db->where('id', $param2)->update('tbl_test_2', $update_data);
    }
    //Two Delete 
    public function delete_two_data($param2)
    {
      return $this->db->where('id', $param2)->delete('tbl_test_2');
    }


  // Get Student Data 
  public function get_student_($id)
  {
    $this->db->select('tbl_test.*, tbl_test.name')
      ->from('tbl_journal_authors');

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->result();
    } else {
      return array();
    }
  }
  //Student Update
  public function update_student($update_authors, $param2)
  {
    if (isset($update_student['photo_1']) | isset($update_student['photo_2']) | isset($update_student['photo_3']) | isset($update_student['photo_4']) && file_exists($update_authors['photo_1'])) {

      $result = $this->db->select('photo_1')
        ->from('tbl_test')
        ->where('id', $param2)
        ->get()
        ->row()->photo_1;

      if (file_exists($result)) {
        unlink($result);
      }
    }

    return $this->db->where('id', $param2)->update('tbl_test', $update_authors);
  }
  //Student Delete
  public function delete_student($param2)
  {
    // $result = $this->db->select('name')
    //   ->from('tbl_test')
    //   ->where('id', $param2)
    //   ->get()
    //   ->row()->author_photo;

    // if (file_exists($result)) {
    //   unlink($result);
    // }
    return $this->db->where('id', $param2)->delete('tbl_test');
  }

  //College Update 
  public function update_data($update_data, $param2)
  {
    return $this->db->where('id', $param2)->update('tbl_medical_collage_list_2', $update_data);
  }
  // College Delete 
  public function delete_data($param2)
  {
    return $this->db->where('id', $param2)->delete('tbl_medical_collage_list_2');
  }

  //Journal Update
  public function update_journals($update_journals, $param2)
  {
    if (isset($update_journals['journal_cover_photo']) && file_exists($update_journals['journal_cover_photo'])) {

      $result = $this->db->select('journal_cover_photo')->from('tbl_journals')->where('id', $param2)->get()->row()->journal_cover_photo;

      if (file_exists($result)) {
        unlink($result);
      }
    }

    if (isset($update_journals['journal_pdf']) && file_exists($update_journals['journal_pdf'])) {

      $result = $this->db->select('journal_pdf')->from('tbl_journals')->where('id', $param2)->get()->row()->journal_pdf;

      if (file_exists($result)) {
        unlink($result);
      }
    }

    return $this->db->where('id', $param2)->update('tbl_journals', $update_journals);
  }
  //Jounal List
  public function get_journal_list($limit, $start, $data)
  {
    $this->db->select('tbl_journals.*, tbl_journal_authors.author_id')
      ->from('tbl_journals')
      ->join('tbl_journal_authors', 'tbl_journal_authors.journal_id = tbl_journals.id', 'left')
      ->order_by('tbl_journals.published_date', 'desc')
      ->group_by('tbl_journals.id')
      ->limit($limit, $start);

    if (($data['published_date']) != '') {

      $this->db->where('tbl_journals.published_date', $data['published_date']);
    }

    if (($data['title']) != '') {

      $this->db->like('tbl_journals.title', $data['title']);
    }

    if (($data['author_id']) != '') {

      $this->db->where('tbl_journal_authors.author_id', $data['author_id']);
    }

    $result = $this->db->get();

    if ($result->num_rows() > 0) {

      return $result->result();
    } else {

      return array();
    }
  }
  //Journal Delete
  public function delete_journals($param2)
  {

    $journal_pdf = $this->db->select('journal_pdf')->from('tbl_journals')->where('id', $param2)->get()->row()->journal_pdf;

    if (file_exists($journal_pdf)) {
      unlink($journal_pdf);
    }

    $journal_cover_photo = $this->db->select('journal_cover_photo')->from('tbl_journals')->where('id', $param2)->get()->row()->journal_cover_photo;

    if (file_exists($journal_cover_photo)) {
      unlink($journal_cover_photo);
    }

    return $this->db->where('id', $param2)->delete('tbl_journals');
  }

  // Get Author Data 
  public function get_author_data($id)
  {
    $this->db->select('tbl_journal_authors.*, tbl_authors.author_name')
      ->from('tbl_journal_authors')
      ->join('tbl_authors', 'tbl_authors.id = tbl_journal_authors.author_id', 'left')
      ->where('tbl_journal_authors.journal_id', $id)
      ->order_by('tbl_journal_authors.contribution_level', 'asc')
      ->group_by('tbl_journal_authors.id');

    $result = $this->db->get();

    if ($result->num_rows() > 0) {

      return $result->result();
    } else {

      return array();
    }
  }
  //Author Update
  public function update_authors($update_authors, $param2)
  {
    if (isset($update_authors['author_photo']) && file_exists($update_authors['author_photo'])) {

      $result = $this->db->select('author_photo')
        ->from('tbl_authors')
        ->where('id', $param2)
        ->get()
        ->row()->author_photo;

      if (file_exists($result)) {
        unlink($result);
      }
    }

    return $this->db->where('id', $param2)->update('tbl_authors', $update_authors);
  }
  //Author Delete
  public function delete_authors($param2)
  {
    $result = $this->db->select('author_photo')
      ->from('tbl_authors')
      ->where('id', $param2)
      ->get()
      ->row()->author_photo;

    if (file_exists($result)) {
      unlink($result);
    }

    return $this->db->where('id', $param2)->delete('tbl_authors');
  }

  // video album Update
  public function video_album_update($update_video_album, $param2)
  {
    return $this->db->where('id', $param2)->update('tbl_video_album', $update_video_album);
  }
  //video album Delete
  public function delete_video_album($param2)
  {
    return $this->db->where('id', $param2)->delete('tbl_video_album');
  }

  // video gallery Update
  public function video_gallery_update($update_video_galley, $param2)
  {
    return $this->db->where('id', $param2)->update('tbl_video_gallery', $update_video_galley);
  }
  //video gallery Delete
  public function delete_video_gallery($param2)
  {
    return $this->db->where('id', $param2)->delete('tbl_video_gallery');
  }

  //Photo Album Delete
  public function photo_album_delete($param2)
  {
    return $this->db->where('id', $param2)->delete('tbl_photo_album');
  }
  //Photo Album list
  public function get_photo_album_list($limit = 10, $start = 0)
  {
    $results = array();

    $this->db->select('tbl_photo_album.id,tbl_photo_album.album_title,tbl_photo_album.priority');
    $this->db->limit($limit, $start);
    $this->db->order_by('priority', 'desc');
    $results = $this->db->get('tbl_photo_album')->result();

    return $results;
  }

  //Photo Gallery Update
  public function photo_gallery_update($update_photo_gallery, $param2)
  {
    if (isset($update_photo_gallery['photo_file']) && file_exists($update_photo_gallery['photo_file'])) {

      $result = $this->db->select('photo_file')
        ->from('tbl_photo_gallery')
        ->where('id', $param2)
        ->get()
        ->row()->photo_file;

      if (file_exists($result)) {
        unlink($result);
      }
    }

    return $this->db->where('id', $param2)->update('tbl_photo_gallery', $update_photo_gallery);
  }
  //Photo gallery List
  public function get_photo_gallery_list($limit = 10, $start = 0)
  {
    $results = array();

    $this->db->select('tbl_photo_gallery.id,tbl_photo_gallery.photo_file,tbl_photo_gallery.title,tbl_photo_album.album_title as album_name');
    $this->db->join('tbl_photo_album', 'tbl_photo_album.id  = tbl_photo_gallery.photo_album_id', 'left');

    $this->db->limit($limit, $start);
    $this->db->order_by('id', 'desc');
    $results = $this->db->get('tbl_photo_gallery')->result();

    return $results;
  }
  //Photo Gallery Delete
  public function photo_gallery_delete($param2)
  {

    $result = $this->db->select('photo_file')
      ->from('tbl_photo_gallery')
      ->where('id', $param2)
      ->get()
      ->row()->photo_file;

    if (file_exists($result)) {
      unlink($result);
    }

    return $this->db->where('id', $param2)->delete('tbl_photo_gallery');
  }

  // Photo album Update
  public function photo_album_update($update_photo_album, $param2)
  {
    return $this->db->where('id', $param2)->update('tbl_photo_album', $update_photo_album);
  }
  //Photo album Delete
  public function delete_photo_album($param2)
  {
    return $this->db->where('id', $param2)->delete('tbl_photo_album');
  }

  //Video Gallery Update
  public function get_video_gallery_update($update_video_gallery, $param2)
  {
    return $this->db->where('id', $param2)->update('tbl_video_gallery', $update_video_gallery);
  }
  //Video gallery List
  public function get_video_gallery_list($limit = 10, $start = 0)
  {
    $results = array();

    $this->db->select('tbl_video_gallery.id,tbl_video_gallery.title,tbl_video_album.album_title as album_name');
    $this->db->join('tbl_video_album', 'tbl_video_album.id  = tbl_video_gallery.video_album_id', 'left');

    $this->db->limit($limit, $start);
    $this->db->order_by('id', 'desc');
    $results = $this->db->get('tbl_video_gallery')->result();

    return $results;
  }
  //Video Gallery Delete
  public function video_gallery_delete($param2)
  {
    return $this->db->where('id', $param2)->delete(' tbl_video_gallery');
  }

  //Division Update
  public function division_update($update_division, $param2)
  {
    return  $this->db->where('id', $param2)->update('tbl_divission', $update_division);
  }

  //Division Delete
  public function delete_division($param2)
  {

    return $this->db->where('id', $param2)->delete('tbl_divission');
  }

  //Zilla Update
  public function get_zilla_update($update_zilla, $param2)
  {

    return  $this->db->where('id', $param2)->update('tbl_zilla', $update_zilla);
  }
  //Zilla List
  public function get_zilla_list($limit = 10, $start = 0)
  {

    $this->db->select('tbl_zilla.id,tbl_zilla.name,tbl_zilla.name_en,tbl_divission.name as division_name');
    $this->db->join('tbl_divission', 'tbl_divission.id = tbl_zilla.divission_id', 'left');
    $this->db->limit($limit, $start);
    $this->db->order_by('id', 'desc');
    $results = $this->db->get('tbl_zilla')->result();

    return $results;
  }
  //Zilla Delete
  public function zilla_delete($param2)
  {

    return $this->db->where('id', $param2)->delete('tbl_zilla');
  }

  //Upazila Update
  public function get_upazila_update($update_upazila, $param2)
  {

    return $this->db->where('id', $param2)->update('tbl_upozilla', $update_upazila);
  }

  //Upazila list
  public function get_upazila_list($limit = 10, $start = 0)
  {

    $this->db->select('tbl_upozilla.id,tbl_upozilla.name,tbl_upozilla.name_en,tbl_divission.name as division_name,tbl_zilla.name as zilla_name');
    $this->db->join('tbl_divission', 'tbl_divission.id = tbl_upozilla.division_id', 'left');
    $this->db->join('tbl_zilla', 'tbl_zilla.id = tbl_upozilla.zilla_id', 'left');
    $this->db->limit($limit, $start);
    $this->db->order_by('id', 'desc');
    $result = $this->db->get('tbl_upozilla')->result();

    return $result;
  }

  //Upazila Delete
  public function upazila_delete($param2)
  {

    return $this->db->where('id', $param2)->delete('tbl_upozilla');
  }

  //File Library Update
  public function get_file_library_update($update_file_library, $param2)
  {

    if (isset($update_file_library['file_path']) && file_exists($update_file_library['file_path'])) {

      $result = $this->db->select('file_path')
        ->from('tbl_file_library')
        ->where('id', $param2)
        ->get()
        ->row()->file_path;

      if (file_exists($result)) {
        unlink($result);
      }
    }

    return $this->db->where('id', $param2)->update('tbl_file_library', $update_file_library);
  }

  //File Libary List
  public function get_file_library_list($limit = 10, $start = 0)
  {

    $this->db->select('id ,title,file_path');
    $this->db->limit($limit, $start);
    $this->db->order_by('id', 'desc');
    $result = $this->db->get('tbl_file_library')->result();

    return $result;
  }

  //File Libary Delete
  public function file_library_delete($param2)
  {

    $result = $this->db->select('file_path')
      ->from('tbl_file_library')
      ->where('id', $param2)
      ->get()
      ->row()->file_path;

    if (file_exists($result)) {
      unlink($result);
    }

    return $this->db->where('id', $param2)->delete('tbl_file_library');
  }
}

?>

