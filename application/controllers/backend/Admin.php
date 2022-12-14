<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

  function __construct()
  {

    parent::__construct();

    $this->lang->load('content', $_SESSION['lang']);

    if (!isset($_SESSION['user_auth']) || $_SESSION['user_auth'] != true) {
      redirect('login', 'refresh');
    }
    if ($_SESSION['userType'] != 'admin')
      redirect('login', 'refresh');
    //Model Loading
    $this->load->model('AdminModel');
    $this->load->model('AccountsModel');
    $this->load->library("pagination");
    $this->load->helper("url");
    $this->load->helper("text");

    date_default_timezone_set("Asia/Dhaka");
  }

  public function index()
  {
    $data['title']      = 'Admin Panel • HRSOFTBD News Portal Admin Panel';
    $data['page']       = 'backEnd/dashboard_view';
    $data['activeMenu'] = 'dashboard_view';

    $this->load->view('backEnd/master_page', $data);
  }

  //Theme setting
  public function theme_setting($param1 = '', $param2 = '', $param3 = '')
  {
    $theme_data_temp    = $this->db->get('tbl_backend_theme')->result();
    $data['theme_data'] = array();
    foreach ($theme_data_temp as $value) {
      $data['theme_data'][$value->name]  = $value->value;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $long_title = $this->input->post('long_title', true);
      $this->AdminModel->theme_text_update('long_title', $long_title);

      $short_title = $this->input->post('short_title', true);
      $this->AdminModel->theme_text_update('short_title', $short_title);

      $tagline = $this->input->post('tagline', true);
      $this->AdminModel->theme_text_update('tagline', $tagline);

      $share_title = $this->input->post('share_title', true);
      $this->AdminModel->theme_text_update('share_title', $share_title);

      $share_title = $this->input->post('version', true);
      $this->AdminModel->theme_text_update('version', $share_title);

      $share_title = $this->input->post('organization', true);
      $this->AdminModel->theme_text_update('organization', $share_title);


      if (!empty($_FILES['logo']['name'])) {

        $path_parts                 = pathinfo($_FILES["logo"]['name']);
        $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
        $dir                        = date("YmdHis", time());
        $config_c['file_name']      = $newFile_name . '_' . $dir;
        $config_c['remove_spaces']  = TRUE;
        $config_c['upload_path']    = 'assets/themeLogo/';
        $config_c['max_size']       = '20000'; //  less than 20 MB
        $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

        $this->load->library('upload', $config_c);
        $this->upload->initialize($config_c);
        if (!$this->upload->do_upload('logo')) {
        } else {

          $upload_c = $this->upload->data();
          $logo['logo'] = $config_c['upload_path'] . $upload_c['file_name'];
          $this->image_size_fix($logo['logo'], 300, 300);
        }
        $this->AdminModel->theme_text_update('logo', $logo['logo']);
      }



      if (!empty($_FILES['share_banner']['name'])) {

        $path_parts                 = pathinfo($_FILES["share_banner"]['name']);
        $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
        $dir                        = date("YmdHis", time());
        $config['file_name']        = $newFile_name . '_' . $dir;
        $config['remove_spaces']    = TRUE;
        $config['upload_path']      = 'assets/themeBanner/';
        $config['max_size']         = '20000'; //  less than 20 MB
        $config['allowed_types']    = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('share_banner')) {
        } else {

          $upload = $this->upload->data();
          $share_banner['share_banner'] = $config['upload_path'] . $upload['file_name'];
          $this->image_size_fix($share_banner['share_banner'], 600, 315);
        }
        $this->AdminModel->theme_text_update('share_banner', $share_banner['share_banner']);
      }



      $this->session->set_flashData('message', 'Theme Info Updated Successfully!');
      redirect('admin/theme-setting', 'refresh');
    }

    $data['page']       = 'backEnd/admin/theme_setting';
    $data['activeMenu'] = 'theme_setting';

    $this->load->view('backEnd/master_page', $data);
  }
  //Manage Cubicle
  public function cubicle($param1 = 'add', $param2 = '', $param3 = '')
  {
    if ($param1 == 'add') {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        foreach ($this->input->post('building_name', true) as $key => $value) {

          $insert_cubicle['building_name'] = $value;
          $insert_cubicle['priority']         = $this->input->post('priority', true)[$key];
          $insert_cubicle['insert_by']        = $_SESSION['userid'];
          $insert_cubicle['insert_time']      = date('Y-m-d H:i:s');

          $insert_cubicle_list = $this->db->insert('tbl_cubicle_building', $insert_cubicle);
        }

        if ($insert_cubicle_list) {
          $this->session->set_flashData('message', "Cubicle Added Successfully.");
          redirect('admin/cubicle/', 'refresh');
        } else {
          $this->session->set_flashData('message', "Cubicle Add Failed.");
          redirect('admin/cubicle/', 'refresh');
        }
      }
    } elseif ($param1   == 'edit'   && $param2 > 0) {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $update_cubicle['building_name']    = $this->input->post('building_name', true);
        $update_cubicle['priority']         = $this->input->post('priority', true);
        $update_cubicle['insert_by']        = $_SESSION['userid'];
        $update_cubicle['insert_time']      = date('Y-m-d H:i:s');

        if ($this->AdminModel->cubicle_update($update_cubicle, $param2)) {
          $this->session-> set_flashData('message', "Cubicle Update Successfully.");
          redirect('admin/cubicle', 'refresh');
        } else {
          $this->session-> set_flashData('message', "Cubicle Update Failed.");
          redirect('admin/cubicle', 'refresh');
        }
      }

      $data['cubicle_info'] = $this->db->get_where('tbl_cubicle_building', array('id' => $param2));
      if ($data['cubicle_info']->num_rows() > 0) {

        $data['cubicle_info']      = $data['cubicle_info']->row();
        $data['cubicle_id']        = $param2;
      } else {

        $this->session->set_flashData('message', "Wrong Attempt!");
        redirect('admin/cubicle', 'refresh');
      }
    } elseif ($param1   == 'delete' && $param2 > 0) {
      if ($this->AdminModel->cubicle_delete($param2)) {

        $this->session->set_flashData('message', "Data Deleted Successfully.");
        redirect('admin/cubicle', 'refresh');
      } else {
        $this->session->set_flashData('message', "Data Delete Failed.");
        redirect('admin/cubicle', 'refresh');
      }
    }
    $data['title']             = 'Cubicle';
    $data['activeMenu']        = 'cubicle';
    $data['page']              = 'backEnd/admin/cubicle';
    $data['cubicle_list']  = $this->db->order_by('priority', 'asc')->get('tbl_cubicle_building')->result();

    $this->load->view('backEnd/master_page', $data);
  }

  // Manage Wallpaper
  public function wall_paper($param1 = 'add', $param2 = '', $param3 = '')
  {
    if ($param1 == 'add') {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_wallpaper['weblink']          = $this->input->post('weblink', true);
        $insert_wallpaper['priority']         = $this->input->post('priority', true);
        $insert_wallpaper['insert_by']        = $_SESSION['userid'];
        $insert_wallpaper['insert_time']      = date('Y-m-d H:i:s');

        if (!empty($_FILES['photo']['name'])) {
          $path_parts                 = pathinfo($_FILES["photo"]['name']);
          $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newFile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/logo/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          // $dst_img = imagecreatetruecolor($insert_manage_logo['photo'], 1280, 720);
          // $transparent = imagecolorallocatealpha($dst_img, 0, 255, 0, 127);
          // imagefill($dst_img, 0, 0, $transparent);
          // $config_c($dst_img, 0, 0, $this->x_axis, $this->y_axis);
          // imageAlphaBlending($dst_img, false);
          // imageSaveAlpha($dst_img, true);

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('photo')) {
          } else {

            $upload_c = $this->upload->data();
            $insert_wallpaper['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($insert_wallpaper['photo'], 1280, 720);
          }
        }

        $photo_wallpaper = $this->db->insert('tbl_wallpaper', $insert_wallpaper);

        if ($photo_wallpaper) {
          $this->session->set_flashData('message', "Cove Photo Added Successfully.");
          redirect('admin/wall_paper/', 'refresh');
        } else {
          $this->session->set_flashData('message', "Cover Photo Add Failed.");
          redirect('admin/wall_paper/', 'refresh');
        }
      }
    } elseif ($param1   == 'edit'   && $param2 > 0) {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $update_wallpaper['weblink']          = $this->input->post('weblink', true);
        $update_wallpaper['priority']         = $this->input->post('priority', true);
        $update_wallpaper['insert_by']        = $_SESSION['userid'];
        $update_wallpaper['insert_time']      = date('Y-m-d H:i:s');
        if (!empty($_FILES['photo']['name'])) {
          $path_parts                 = pathinfo($_FILES["photo"]['name']);
          $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newFile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/logo/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);

          if (!$this->upload->do_upload('photo')) {
          } else {
            $upload_c = $this->upload->data();
            $update_wa['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($update_wallpaper['photo'], 400, 400);
          }
        }

        if ($this->AdminModel->logo_update($update_wallpaper, $param2)) {
          $this->session->set_flashData('message', "Photo Updated Successfully.");
          redirect('admin/wall_paper', 'refresh');
        } else {
          $this->session->set_flashData('message', "Photo Update Failed.");
          redirect('admin/wall_paper', 'refresh');
        }
      }

      $data['wallpaper_info'] = $this->db->get_where('tbl_wallpaper', array('id' => $param2));

      if ($data['wallpaper_info']->num_rows() > 0) {

        $data['wallpaper_info']      = $data['wallpaper_info']->row();
        $data['wallpaper_id']        = $param2;
      } else {

        $this->session->set_flashData('message', "Wrong Attempt!");
        redirect('admin/top-slider', 'refresh');
      }
    } elseif ($param1   == 'delete' && $param2 > 0) {
      if ($this->AdminModel->logo_delete($param2)) {

        $this->session->set_flashData('message', "Data Deleted Successfully.");
        redirect('admin/wall_paper', 'refresh');
      } else {
        $this->session->set_flashData('message', "Data Delete Failed.");
        redirect('admin/wall_paper', 'refresh');
      }
    }
    $data['title']             = 'Manage Logo';
    $data['activeMenu']        = 'wall_paper';
    $data['page']              = 'backEnd/admin/wall_paper';
    $data['wallpaper_list']  = $this->db->order_by('priority', 'asc')->get('tbl_wallpaper')->result();

    $this->load->view('backEnd/master_page', $data);
  }

  // Manage logo
  public function manage_logo($param1 = 'add', $param2 = '', $param3 = '')
  {
    if ($param1 == 'add') {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_manage_logo['weblink']          = $this->input->post('weblink', true);
        $insert_manage_logo['priority']         = $this->input->post('priority', true);
        $insert_manage_logo['insert_by']        = $_SESSION['userid'];
        $insert_manage_logo['insert_time']      = date('Y-m-d H:i:s');

        if (!empty($_FILES['photo']['name'])) {
          $path_parts                 = pathinfo($_FILES["photo"]['name']);
          $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newFile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/logo/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          // $dst_img = imagecreatetruecolor($insert_manage_logo['photo'], 1280, 720);
          // $transparent = imagecolorallocatealpha($dst_img, 0, 255, 0, 127);
          // imagefill($dst_img, 0, 0, $transparent);
          // $config_c($dst_img, 0, 0, $this->x_axis, $this->y_axis);
          // imageAlphaBlending($dst_img, false);
          // imageSaveAlpha($dst_img, true);

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('photo')) {
          } else {

            $upload_c = $this->upload->data();
            $insert_manage_logo['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($insert_manage_logo['photo'], 1280, 720);
          }
        }

        $photo_manage_logo = $this->db->insert('tbl_logo', $insert_manage_logo);

        if ($photo_manage_logo) {
          $this->session->set_flashData('message', "Cove Photo Added Successfully.");
          redirect('admin/manage_logo/', 'refresh');
        } else {
          $this->session->set_flashData('message', "Cover Photo Add Failed.");
          redirect('admin/manage_logo/', 'refresh');
        }
      }
    } elseif ($param1   == 'edit'   && $param2 > 0) {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $update_manage_logo['weblink']          = $this->input->post('weblink', true);
        $update_manage_logo['priority']         = $this->input->post('priority', true);
        $update_manage_logo['insert_by']        = $_SESSION['userid'];
        $update_manage_logo['insert_time']      = date('Y-m-d H:i:s');
        if (!empty($_FILES['photo']['name'])) {
          $path_parts                 = pathinfo($_FILES["photo"]['name']);
          $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newFile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/logo/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);

          if (!$this->upload->do_upload('photo')) {
          } else {
            $upload_c = $this->upload->data();
            $update_manage_logo['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($update_manage_logo['photo'], 400, 400);
          }
        }

        if ($this->AdminModel->logo_update($update_manage_logo, $param2)) {
          $this->session->set_flashData('message', "Photo Updated Successfully.");
          redirect('admin/manage_logo', 'refresh');
        } else {
          $this->session->set_flashData('message', "Photo Update Failed.");
          redirect('admin/manage_logo', 'refresh');
        }
      }

      $data['manage_logo_info'] = $this->db->get_where('tbl_logo', array('id' => $param2));

      if ($data['manage_logo_info']->num_rows() > 0) {

        $data['manage_logo_info']      = $data['manage_logo_info']->row();
        $data['manage_logo_id']        = $param2;
      } else {

        $this->session->set_flashData('message', "Wrong Attempt!");
        redirect('admin/top-slider', 'refresh');
      }
    } elseif ($param1   == 'delete' && $param2 > 0) {
      if ($this->AdminModel->logo_delete($param2)) {

        $this->session->set_flashData('message', "Data Deleted Successfully.");
        redirect('admin/manage_logo', 'refresh');
      } else {
        $this->session->set_flashData('message', "Data Delete Failed.");
        redirect('admin/manage_logo', 'refresh');
      }
    }
    $data['title']             = 'Manage Logo';
    $data['activeMenu']        = 'manage_logo';
    $data['page']              = 'backEnd/admin/manage_logo';
    $data['manage_logo_list']  = $this->db->order_by('priority', 'asc')->get('tbl_logo')->result();

    $this->load->view('backEnd/master_page', $data);
  }

  // Cover_photo
  public function cover_photo($param1 = 'add', $param2 = '', $param3 = '')
  {
    if ($param1 == 'add') {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_cover_photo['weblink']          = $this->input->post('weblink', true);
        $insert_cover_photo['priority']         = $this->input->post('priority', true);
        $insert_cover_photo['insert_by']        = $_SESSION['userid'];
        $insert_cover_photo['insert_time']      = date('Y-m-d H:i:s');

        if (!empty($_FILES['photo']['name'])) {
          $path_parts                 = pathinfo($_FILES["photo"]['name']);
          $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newFile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/coverPhoto/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('photo')) {
          } else {

            $upload_c = $this->upload->data();
            $insert_cover_photo['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($insert_cover_photo['photo'], 1920, 1080);
          }
        }

        $photo_cover_photo = $this->db->insert('tbl_cover_photo', $insert_cover_photo);

        if ($photo_cover_photo) {
          $this->session->set_flashData('message', "Cove Photo Added Successfully.");
          redirect('admin/cover_photo/', 'refresh');
        } else {
          $this->session->set_flashData('message', "Cover Photo Add Failed.");
          redirect('admin/cover_photo/', 'refresh');
        }
      }
    } elseif ($param1   == 'edit'   && $param2 > 0) {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $update_cover_photo['weblink']         = $this->input->post('weblink', true);
        $update_cover_photo['priority']         = $this->input->post('priority', true);

        if (!empty($_FILES['photo']['name'])) {
          $path_parts                 = pathinfo($_FILES["photo"]['name']);
          $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newFile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/coverPhoto/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('photo')) {
          } else {
            $upload_c = $this->upload->data();
            $update_cover_photo['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($update_cover_photo['photo'], 1920, 1080);
          }
        }
        if ($this->AdminModel->cover_photo_update($update_cover_photo, $param2)) {
          $this->session->set_flashData('message', "Photo Updated Successfully.");
          redirect('admin/cover_photo', 'refresh');
        } else {
          $this->session->set_flashData('message', "Photo Update Failed.");
          redirect('admin/cover_photo', 'refresh');
        }
      }

      $data['cover_photo_info'] = $this->db->get_where('tbl_cover_photo', array('id' => $param2));
      if ($data['cover_photo_info']->num_rows() > 0) {

        $data['cover_photo_info']      = $data['cover_photo_info']->row();
        $data['cover_photo_id']        = $param2;
      } else {

        $this->session->set_flashData('message', "Wrong Attempt!");
        redirect('admin/top-slider', 'refresh');
      }
    } elseif ($param1   == 'delete' && $param2 > 0) {
      if ($this->AdminModel->cover_photo_delete($param2)) {

        $this->session->set_flashData('message', "Data Deleted Successfully.");
        redirect('admin/cover_photo', 'refresh');
      } else {
        $this->session->set_flashData('message', "Data Delete Failed.");
        redirect('admin/cover_photo', 'refresh');
      }
    }
    $data['title']             = 'Cover Photo';
    $data['activeMenu']        = 'cover_photo';
    $data['page']              = 'backEnd/admin/cover_photo';
    $data['cover_photo_list']  = $this->db->order_by('priority', 'asc')->get('tbl_cover_photo')->result();

    $this->load->view('backEnd/master_page', $data);
  }

  // Manage Top_Slider
  public function top_slider($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_top_slider['weblink']         = $this->input->post('weblink', true);
        $insert_top_slider['priority']         = $this->input->post('priority', true);
        $insert_top_slider['insert_by']        = $_SESSION['userid'];
        $insert_top_slider['insert_time']      = date('Y-m-d H:i:s');

        if (!empty($_FILES['photo']['name'])) {
          $path_parts                 = pathinfo($_FILES["photo"]['name']);
          $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newFile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/topSlider/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('photo')) {
          } else {

            $upload_c = $this->upload->data();
            $insert_top_slider['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($insert_top_slider['photo'], 1920, 1080);
          }
        }

        $photo_top_slider = $this->db->insert('tbl_top_slider', $insert_top_slider);

        if ($photo_top_slider) {
          $this->session->set_flashData('message', "Data Added Successfully.");
          redirect('admin/top-slider/', 'refresh');
        } else {
          $this->session->set_flashData('message', "Data Add Failed.");
          redirect('admin/top-slider/', 'refresh');
        }
      }
    } else if ($param1  == 'edit' && $param2 > 0) {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $update_top_slider['weblink']         = $this->input->post('weblink', true);
        $update_top_slider['priority']         = $this->input->post('priority', true);

        if (!empty($_FILES['photo']['name'])) {
          $path_parts                 = pathinfo($_FILES["photo"]['name']);
          $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newFile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/topSlider/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('photo')) {
          } else {

            $upload_c = $this->upload->data();
            $update_top_slider['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($update_top_slider['photo'], 1920, 1080);
          }
        }


        if ($this->AdminModel->top_slider_update($update_top_slider, $param2)) {

          $this->session->set_flashData('message', "Data Updated Successfully.");
          redirect('admin/top-slider', 'refresh');
        } else {

          $this->session->set_flashData('message', "Data Update Failed.");
          redirect('admin/top-slider', 'refresh');
        }
      }

      $data['top_slider_info'] = $this->db->get_where('tbl_top_slider', array('id' => $param2));

      if ($data['top_slider_info']->num_rows() > 0) {

        $data['top_slider_info']    = $data['top_slider_info']->row();
        $data['top_slider_id']        = $param2;
      } else {

        $this->session->set_flashData('message', "Wrong Attempt !");
        redirect('admin/top-slider', 'refresh');
      }
    } elseif ($param1   == 'delete' && $param2 > 0) {

      if ($this->AdminModel->top_slider_delete($param2)) {

        $this->session->set_flashData('message', "Data Deleted Successfully.");
        redirect('admin/top-slider', 'refresh');
      } else {
        $this->session->set_flashData('message', "Data Delete Failed.");
        redirect('admin/top-slider', 'refresh');
      }
    }

    $data['title']      = 'Top Slider';
    $data['activeMenu'] = 'top_slider';
    $data['page']       = 'backEnd/admin/top_slider';
    $data['top_slider_list'] = $this->db->order_by('priority', 'asc')->get('tbl_top_slider')->result();

    $this->load->view('backEnd/master_page', $data);
  }
  // Manage Question
  public function question($param1 = 'add', $param2 = '', $param3 = '')
  {
    if ($param1 == 'add') {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_question['exam_id']        = $this->input->post('exam_id', true);
        $insert_question['question_title'] =  $this->input->post('question_title', true);
        $insert_question['status']         =  $this->input->post('status', true);
        $insert_question['insert_time']    =  date('Y-m-d H:i:s');
        $insert_question['insert_by']      =  $_SESSION['userid'];

        if (!empty($_FILES['question_photo']['name'])) {
          $path_parts                 = pathinfo($_FILES["question_photo"]['name']);
          $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newFile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/quePhoto/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('question_photo')) {
          } else {
            $upload_c = $this->upload->data();
            $insert_question['question_photo'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($insert_question['question_photo'], 400, 400);
          }
        }

        $add_question = $this->db->insert('tbl_question', $insert_question);

        if ($add_question) {
          $this->session->set_flashData('message', 'Question Added Successfully!');
          redirect('admin/question/list', 'refresh');
        } else {
          $this->session->set_flashData('message', 'Question Add Failed!');
        }
      }
      $data['question_list'] = $this->db->order_by('id', 'desc')->get('tbl_question')->result();
      $data['title']         = 'Add Question';
      $data['activeMenu']    = 'add_question';
      $data['page']          = 'backend/admin/question_add';
    } elseif ($param1 == 'list') {
      $data['question_list'] = $this->db->order_by('id', 'desc')->get('tbl_question')->result();
      $data['title']        = 'Question List';
      $data['activeMenu']   = 'question_list';
      $data['page']         = 'backEnd/admin/question_list';
    } elseif ($param1 == 'edit' && $param2 > 0) {
      $data['edit_info']      = $this->db->get_where('tbl_question', array('id' => $param2));

      if ($data['edit_info']->num_rows() > 0) {
        $data['edit_info']    =   $data['edit_info']->row();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          $update_question['exam_id']          = $this->input->post('exam_id', true);
          $update_question['question_title']   = $this->input->post('question_title', true);
          $update_question['status']           = $this->input->post('status', true);
          $insert_question['insert_time']      =  date('Y-m-d H:i:s');
          $insert_question['insert_by']        =  $_SESSION['userid'];

          if (!empty($_FILES['question_photo']['name'])) {
            $path_parts                 = pathinfo($_FILES["question_photo"]['name']);
            $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
            $dir                        = date("YmdHis", time());
            $config_c['file_name']      = $newFile_name . '_' . $dir;
            $config_c['remove_spaces']  = TRUE;
            $config_c['upload_path']    = 'assets/quePhoto/';
            $config_c['max_size']       = '20000'; //  less than 20 MB
            $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

            $this->load->library('upload', $config_c);
            $this->upload->initialize($config_c);
            if (!$this->upload->do_upload('question_photo')) {
            } else {
              $upload_c = $this->upload->data();

              $update_question['question_photo'] = $config_c['upload_path'] . $upload_c['file_name'];
              $this->image_size_fix($update_question['question_photo'], 400, 400);
            }
          }

          if ($this->AdminModel->update_question($update_question, $param2)) {

            $this->session->set_flashData('message', 'Two Updated Successfully!');
            redirect('admin/question/list', 'refresh');
          } else {

            $this->session->set_flashData('message', 'Two Update Failed!');
            redirect('admin/question/list', 'refresh');
          }
        }
      } else {

        $this->session->set_flashData('message', 'Wrong Attempt!');
        redirect('admin/question/list', 'refresh');
      }
      $data['title']      = 'Question Edit';
      $data['activeMenu'] = 'question_edit';
      $data['page']       = 'backEnd/admin/question_edit';
    } elseif ($param1 == 'delete' && $param2 > 0) {
      if ($this->AdminModel->delete_question($param2)) {
        $this->session->set_flashData('message', 'Question Successfully Deleted!');
        redirect('admin/question/list', 'refresh');
      } else {
        $this->session->set_flashData('message', 'Question Deleted Failed');
        redirect('admin/question/list', 'refresh');
      }
    } else {
      $this->session->set_flashData('message', 'Wrong Attempt!');
      redirect('admin/question/list', 'refresh');
    }
    $this->load->view('backEnd/master_page', $data);
  }
  // Manage Question-Option
  public function que_option($param1 = 'add', $param2 = '', $param3 = '')
  {
    if ($param1 == 'add') {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_option['question_id']     =  $this->input->post('question_id', true);
        $insert_option['option_type']     =  $this->input->post('option_type', true);
        $insert_option['option_1']        =  $this->input->post('option_1', true);
        $insert_option['option_2']        =  $this->input->post('option_2', true);
        $insert_option['option_3']        =  $this->input->post('option_3', true);
        $insert_option['option_4']        =  $this->input->post('option_4', true);
        $insert_option['correct_option']  =  $this->input->post('correct_option', true);

        $insert_option['insert_by']       =  $_SESSION['userid'];
        $insert_option['insert_time']     =  date('Y-m-d H:i:s');

        $add_qu_option = $this->db->insert('tbl_question_options', $insert_option);

        if ($add_qu_option) {
          $this->session->set_flashData('message', 'All Question Option  Added Successfully!');
          redirect('admin/que_option/list', 'refresh');
        } else {
          $this->session->set_flashData('message', 'Question Option Add Failed!');
        }
      }

      $data['question_list'] = $this->db->order_by('id', 'desc')->get('tbl_question')->result();

      $data['title']         = 'Que Option Add';
      $data['activeMenu']    = 'que_option_add';
      $data['page']          = 'backend/admin/que_option_add';
    } elseif ($param1 == 'list') {

      $data['que_option_list'] = $this->db->order_by('id', 'desc')->get('tbl_question_options')->result();
      $data['title']        = 'Que Option List';
      $data['activeMenu']   = 'que_option_list';
      $data['page']         = 'backEnd/admin/que_option_list';
    } elseif ($param1 == 'edit' && $param2 > 0) {

      $data['edit_info']      = $this->db->get_where('tbl_question_options', array('id' => $param2));

      if ($data['edit_info']->num_rows() > 0) {
        $data['edit_info']    =   $data['edit_info']->row();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          $update_question['option_type']        = $this->input->post('option_type', true);
          $update_question['question_id']        = $this->input->post('question_id', true);
          $update_question['option_1']           = $this->input->post('option_1', true);
          $update_question['option_2']           = $this->input->post('option_2', true);
          $update_question['option_3']           = $this->input->post('option_3', true);
          $update_question['option_4']           = $this->input->post('option_4', true);
          $update_question['correct_option']     = $this->input->post('correct_option', true);

          $insert_question['insert_time']        = date('Y-m-d H:i:s');
          $insert_question['insert_by']          = $_SESSION['userid'];

          if ($this->AdminModel->update_que_options($update_question, $param2)) {

            $this->session->set_flashData('message', 'Question Options Updated Successfully!');
            redirect('admin/que-option/list', 'refresh');
          } else {

            $this->session->set_flashData('message', 'Question Options Update Failed!');
            redirect('admin/que-option/list', 'refresh');
          }
        }
      } else {

        $this->session->set_flashData('message', 'Wrong Attempt!');
        redirect('admin/que-option/list', 'refresh');
      }
      $data['title']      = 'Que Option Edit';
      $data['activeMenu'] = 'que_option_edit';
      $data['page']       = 'backEnd/admin/que_option_edit';
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->delete_que_options($param2)) {
        $this->session->set_flashData('message', 'Question option Deleted Successfully!');
        redirect('admin/que-option/list', 'refresh');
      } else {
        $this->session->set_flashData('message', 'Question option Deleted Failed');
        redirect('admin/que-option/list', 'refresh');
      }
    } else {
      $this->session->set_flashData('message', 'Wrong Attempt!');
      redirect('admin/que-option/list', 'refresh');
    }
    $this->load->view('backEnd/master_page', $data);
  }

  //Photo Album 2....
  public function photo_album_2($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1         == 'add') {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_photo_album_2['album_title']      = $this->input->post('album_title', true);
        $insert_photo_album_2['priority']         = $this->input->post('priority', true);
        $insert_photo_album_2['insert_time']      = date('Y-m-d H:i:s');
        $insert_photo_album_2['insert_by']        = $_SESSION['userid'];

        $photo_album_add = $this->db->insert('tbl_photo_album_2', $insert_photo_album_2);

        if ($photo_album_add) {
          $this->session->set_flashData('message', "Data Added Successfully.");
          redirect('admin/photo-album_2/', 'refresh');
        } else {
          $this->session->set_flashData('message', "Data Add Failed.");
          redirect('admin/photo-album_2/', 'refresh');
        }
      }
    } else if ($param1  == 'edit' && $param2 > 0) {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $update_photo_album_2['album_title']      = $this->input->post('album_title', true);
        $update_photo_album_2['priority']         = $this->input->post('priority', true);
        $insert_photo_album_2['insert_time']      = date('Y-m-d H:i:s');
        $insert_photo_album_2['insert_by']        = $_SESSION['userid'];


        if ($this->AdminModel->photo_album_update($update_photo_album_2, $param2)) {

          $this->session->set_flashData('message', "Data Updated Successfully.");
          redirect('admin/photo-album_2', 'refresh');
        } else {

          $this->session->set_flashData('message', "Data Update Failed.");
          redirect('admin/photo-album_2', 'refresh');
        }
      }

      $data['photo_album_info_2'] = $this->db->get_where('tbl_photo_album_2', array('id' => $param2));

      if ($data['photo_album_info_2']->num_rows() > 0) {

        $data['photo_album_info_2']    = $data['photo_album_info_2']->row();
        $data['photo_album_id']        = $param2;
      } else {

        $this->session->set_flashData('message', "Wrong Attempt !");
        redirect('admin/photo-album_2', 'refresh');
      }
    } elseif ($param1   == 'delete' && $param2 > 0) {

      if ($this->AdminModel->delete_photo_album_2($param2)) {

        $this->session->set_flashData('message', "Data Deleted Successfully.");
        redirect('admin/photo-album_2', 'refresh');
      } else {
        $this->session->set_flashData('message', "Data Delete Failed.");
        redirect('admin/photo-album_2', 'refresh');
      }
    }

    $data['title']      = 'photo Album 2';
    $data['activeMenu'] = 'photo_album_2';
    $data['page']       = 'backEnd/admin/photo_album_2';
    $data['photo_album_list_2'] = $this->db->order_by('priority', 'desc')->get('tbl_photo_album_2')->result();

    $this->load->view('backEnd/master_page', $data);
  }

  //Photo Gal.. 2
  public function photo_gal($param1 = 'add', $param2 = '', $param3 = '')
  {
    if ($param1 == 'add') {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $insert_photo_gal['photo_album_id']    = $this->input->post('photo_album_id', true);
        $insert_photo_gal['title']             = $this->input->post('title', true);
        $insert_photo_gal['insert_by']         = $_SESSION['userid'];
        $insert_photo_gal['insert_time']       = date('Y-m-d H:i:s');

        if (!empty($_FILES['photo_file']['name'])) {
          $path_parts                 = pathinfo($_FILES["photo_file"]['name']);
          $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newFile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/photoGallery2/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('photo_file')) {
          } else {

            $upload_c = $this->upload->data();
            $insert_photo_gal['photo_file'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($insert_photo_gal['photo_file'], 400, 400);
          }
        }

        $add_photo_gal = $this->db->insert('tbl_photo_gallery_2', $insert_photo_gal);

        if ($add_photo_gal) {

          $this->session->set_flashData('message', 'Data Created Successfully!');
          redirect('admin/photo-gal/list', 'refresh');
        } else {

          $this->session->set_flashData('message', 'Data Created Failed!');
          redirect('admin/photo-gal', 'refresh');
        }
      }

      $data['photo_album_list_2'] = $this->db->order_by('id', 'desc')->get('tbl_photo_album_2')->result();
      $data['title']         = 'Photo Gal Add';
      $data['page']          = 'backEnd/admin/photo_gal_add';
      $data['activeMenu']    = 'photo_gal_add';
    } elseif ($param1 == 'edit' && (int) $param2 > 0) {

      $check_table_row = $this->db->where('id', $param2)->get('tbl_photo_gallery_2');

      if ($check_table_row->num_rows() > 0) {
        $data['photo_gal_info'] = $check_table_row->row();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $update_photo_gal['photo_album_id']    = $this->input->post('photo_album_id', true);
          $update_photo_gal['title']             = $this->input->post('title', true);

          if (!empty($_FILES['photo_file']['name'])) {
            $path_parts                 = pathinfo($_FILES["photo_file"]['name']);
            $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
            $dir                        = date("YmdHis", time());
            $config_c['file_name']      = $newFile_name . '_' . $dir;
            $config_c['remove_spaces']  = TRUE;
            $config_c['upload_path']    = 'assets/photoGallery2/';
            $config_c['max_size']       = '20000'; //  less than 20 MB
            $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

            $this->load->library('upload', $config_c);
            $this->upload->initialize($config_c);
            if (!$this->upload->do_upload('photo_file')) {
            } else {

              $upload_c = $this->upload->data();
              $update_photo_gal['photo_file'] = $config_c['upload_path'] . $upload_c['file_name'];
              $this->image_size_fix($update_photo_gal['photo_file'], 400, 400);
            }
          }


          if ($this->AdminModel->photo_gal_update($update_photo_gal, $param2)) {

            $this->session->set_flashData('message', 'Data Updated Successfully!');
            redirect('admin/photo-gal/list', 'refresh');
          } else {

            $this->session->set_flashData('message', 'Data Update Failed!');
            redirect('admin/photo-gal/list', 'refresh');
          }

          $this->session->set_flashData('message', 'Data Updated Successfully');
          redirect('admin/photo-gal/list', 'refresh');
        }
      }

      $data['photo_album_list_2']  = $this->db->order_by('id', 'desc')->get('tbl_photo_album_2')->result();

      $data['title']         = 'Photo Gallery Update';
      $data['page']          = 'backEnd/admin/photo_gal_edit';
      $data['activeMenu']    = 'photo_gal_edit';
    } elseif ($param1 == 'list') {

      $config = array();
      $config["base_url"] = base_url("admin/photo-gal/list");
      $config["total_rows"] = $this->db->get(' tbl_photo_gallery_2')->num_rows();
      $config["per_page"] = 10;
      $config["uri_segment"] = 4;

      //custom
      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';

      $config['first_link'] = "First";
      $config['last_link'] = "Last";

      $config['first_tag_open'] = '<li>';
      $config['first_tag_close'] = '</li>';

      $config['prev_link'] = '«';
      $config['prev_tag_open'] = '<li class="prev">';
      $config['prev_tag_close'] = '</li>';

      $config['next_link'] = '»';
      $config['next_tag_open'] = '<li>';
      $config['next_tag_close'] = '</li>';

      $config['last_tag_open'] = '<li>';
      $config['last_tag_close'] = '</li>';

      $config['cur_tag_open'] = '<li class="active"><a href="#">';
      $config['cur_tag_close'] = '</a></li>';
      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';

      $this->pagination->initialize($config);

      $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

      $data["links"] = $this->pagination->create_links();

      $data['photo_gal_list'] = $this->AdminModel->get_photo_gal_list($config["per_page"], $page);

      $data['new_serial'] = $page;

      $data['title']      = 'Photo Gallery List';
      $data['page']       = 'backEnd/admin/photo_gal_list';
      $data['activeMenu'] = 'photo_gal_list';
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->photo_gal_delete($param2)) {

        $this->session->set_flashData('message', 'Data Deleted Successfully!');
        redirect('admin/photo-gal/list', 'refresh');
      } else {
        $this->session->set_flashData('message', 'Data Deleted Failed!');
        redirect('admin/photo-gal/list', 'refresh');
      }
    } else {

      $this->session->set_flashData('message', 'Wrong Attempt!');
      redirect('admin/photo-gallery/list', 'refresh');
    }
    $this->load->view('backEnd/master_page', $data);
  }

  // Manage_College
  public function college($param1 = 'add', $param2 = '', $param3 = '')
  {
    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_data['name']             = $this->input->post('name', true);
        $insert_data['short_name']       = $this->input->post('short_name', true);
        $insert_data['priority']         = $this->input->post('priority', true);
        $insert_data['insert_by']        = $_SESSION['userid'];
        $insert_data['insert_time']      = date('Y-m-d H:i:s');

        $add_college = $this->db->insert('tbl_medical_collage_list_2', $insert_data);

        if ($add_college) {

          $this->session->set_flashData('message', 'college Added Successfully!');
          redirect('admin/college/list', 'refresh');
        } else {

          $this->session->set_flashData('message', 'college Add Failed!');
          redirect('admin/college/list', 'refresh');
        }
      }

      $data['title']             = 'Add College';
      $data['activeMenu']        = 'add_college';
      $data['page']              = 'backEnd/admin/college_add';
    } elseif ($param1 == 'list') {

      $data['authors_list'] = $this->db->order_by('id', 'desc')->get('tbl_medical_collage_list_2')->result();

      $data['title']        = 'College List';
      $data['activeMenu']   = 'college_list';
      $data['page']         = 'backEnd/admin/college_list';
    } elseif ($param1 == 'edit' && $param2 > 0) {

      $data['edit_info']   = $this->db->get_where('tbl_medical_collage_list_2', array('id' => $param2));

      if ($data['edit_info']->num_rows() > 0) {
        $data['edit_info']    = $data['edit_info']->row();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          $update_data['name']        = $this->input->post('name', true);
          $update_data['short_name']  = $this->input->post('short_name', true);
          $update_data['priority']    = $this->input->post('priority', true);

          $update_data['insert_by']   = $this->input->post('insert_by', true);
          $update_data['insert_time'] = $this->input->post('insert_time', true);


          if ($this->AdminModel->update_data($update_data, $param2)) {

            $this->session->set_flashData('message', 'Medical College Updated Successfully!');
            redirect('admin/college/list', 'refresh');
          } else {

            $this->session->set_flashData('message', 'Medical College Update Failed!');
            redirect('admin/college/list', 'refresh');
          }
        }
      } else {

        $this->session->set_flashData('message', 'Wrong Attempt!');
        redirect('admin/college/list', 'refresh');
      }
      $data['title']      = 'College Edit';
      $data['activeMenu'] = 'college_edit';
      $data['page']       = 'backEnd/admin/college_edit';
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->delete_data($param2)) {
        $this->session->set_flashData('message', 'Medical College Deleted Successfully!');
        redirect('admin/college/list', 'refresh');
      } else {
        $this->session->set_flashData('message', 'Medical College Deleted Failed!');
        redirect('admin/college/list', 'refresh');
      }
    } else {
      $this->session->set_flashData('message', 'Wrong Attempt!');
      redirect('admin/college/list', 'refresh');
    }
    $this->load->view('backEnd/master_page', $data);
  }

  // Manage_One
  public function one($param1 = 'add', $param2 = '', $param3 = '')
  {
    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_one['name']             = $this->input->post('name', true);
        $insert_one['email']            = $this->input->post('email', true);
        $insert_one['phone']            = $this->input->post('phone', true);
        $insert_one['status']           = $this->input->post('status', true);
        $insert_one['insert_time']      = date('Y-m-d H:i:s');
        // $update_one['insert_time']      = $this->input->post('insert_time', true);

        if (!empty($_FILES['photo']['name'])) {
          $path_parts                 = pathinfo($_FILES["photo"]['name']);
          $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newFile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/onePhoto/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('photo')) {
          } else {
            $upload_c = $this->upload->data();
            $insert_one['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($insert_one['photo'], 400, 400);
          }
        }
        $add_one = $this->db->insert('tbl_test_1', $insert_one);

        if ($add_one) {
          $this->session->set_flashData('message', 'One Added Successfully!');
          redirect('admin/one/list', 'refresh');
        } else {
          $this->session->set_flashData('message', 'One Add Failed!');
          redirect('admin/one/list', 'refresh');
        }
      }
      $data['title']             = 'One Add';
      $data['activeMenu']        = 'one_add';
      $data['page']              = 'backEnd/admin/one_add';
    } elseif ($param1 == 'list') {

      $data['one_list']     = $this->db->order_by('id', 'desc')->get('tbl_test_1')->result();
      $data['title']        = 'One List';
      $data['activeMenu']   = 'one_list';
      $data['page']         = 'backEnd/admin/one_list';
    } elseif ($param1 == 'edit' && $param2 > 0) {

      $data['edit_info']      = $this->db->get_where('tbl_test_1', array('id' => $param2));

      if ($data['edit_info']->num_rows() > 0) {
        $data['edit_info']    =   $data['edit_info']->row();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          $update_one['name']        = $this->input->post('name', true);
          $update_one['email']       = $this->input->post('email', true);
          $update_one['phone']       = $this->input->post('phone', true);
          $update_one['status']      = $this->input->post('status', true);
          $update_one['insert_time'] = $this->input->post('insert_time', true);

          if (!empty($_FILES['photo']['name'])) {

            $path_parts                 = pathinfo($_FILES["photo"]['name']);
            $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
            $dir                        = date("YmdHis", time());
            $config_c['file_name']      = $newFile_name . '_' . $dir;
            $config_c['remove_spaces']  = TRUE;
            $config_c['upload_path']    = 'assets/onePhoto/';
            $config_c['max_size']       = '20000'; //  less than 20 MB
            $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

            $this->load->library('upload', $config_c);
            $this->upload->initialize($config_c);
            if (!$this->upload->do_upload('photo')) {
            } else {

              $upload_c = $this->upload->data();
              $update_one['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
              $this->image_size_fix($update_one['photo'], 400, 500);
            }
          }

          if ($this->AdminModel->update_one_data($update_one, $param2)) {

            $this->session->set_flashData('message', 'One Updated Successfully!');
            redirect('admin/one/list', 'refresh');
          } else {

            $this->session->set_flashData('message', 'One Update Failed!');
            redirect('admin/one/list', 'refresh');
          }
        }
      } else {

        $this->session->set_flashData('message', 'Wrong Attempt!');
        redirect('admin/one/list', 'refresh');
      }
      $data['title']      = 'One Edit';
      $data['activeMenu'] = 'one_edit';
      $data['page']       = 'backEnd/admin/one_edit';
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->delete_one_data($param2)) {
        $this->session->set_flashData('message', 'One Deleted Successfully!');
        redirect('admin/one/list', 'refresh');
      } else {
        $this->session->set_flashData('message', 'One Deleted Failed!');
        redirect('admin/one/list', 'refresh');
      }
    } else {
      $this->session->set_flashData('message', 'Wrong Attempt!');
      redirect('admin/one/list', 'refresh');
    }
    $this->load->view('backEnd/master_page', $data);
  }

  // Manage_TWO
  public function two($param1 = 'add', $param2 = '', $param3 = '')
  {
    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_two['name']             = $this->input->post('name', true);
        $insert_two['user_id']          = $this->input->post('user_id', true);
        $insert_two['phone']            = $this->input->post('phone', true);
        $insert_two['description']      = $this->input->post('description', true);
        $insert_two['insert_time']      = date('Y-m-d H:i:s');

        // if (!empty($_FILES['photo']['name'])) {
        //   $path_parts                 = pathinfo($_FILES["photo"]['name']);
        //   $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
        //   $dir                        = date("YmdHis", time());
        //   $config_c['file_name']      = $newFile_name . '_' . $dir;
        //   $config_c['remove_spaces']  = TRUE;
        //   $config_c['upload_path']    = 'assets/twoPhoto/';
        //   $config_c['max_size']       = '20000'; //  less than 20 MB
        //   $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

        //   $this->load->library('upload', $config_c);
        //   $this->upload->initialize($config_c);
        //   if (!$this->upload->do_upload('photo')) {
        //   } else {
        //     $upload_c = $this->upload->data();
        //     $insert_two['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
        //     $this->image_size_fix($insert_two['photo'], 400, 400);
        //   }
        // }

        $add_two = $this->db->insert('tbl_test_2', $insert_two);

        if ($add_two) {
          $this->session->set_flashData('message', 'Two Added Successfully!');
          redirect('admin/two/list', 'refresh');
        } else {
          $this->session->set_flashData('message', 'two Add Failed!');
          redirect('admin/two/list', 'refresh');
        }
      }

      $data['test1_list'] = $this->db->order_by('id', 'desc')->get('tbl_test_1')->result();
      $data['title']             = 'Two Add';
      $data['activeMenu']        = 'two_add';
      $data['page']              = 'backEnd/admin/two_add';
    } elseif ($param1 == 'list') {

      $data['two_list']     = $this->db->select('tbl_test_2.*,tbl_test_1.name as test1_name')
        ->join('tbl_test_1', 'tbl_test_1.id = tbl_test_2.user_id', 'left')->order_by('id', 'desc')->get('tbl_test_2')->result();

      $data['title']        = 'Two List';
      $data['activeMenu']   = 'two_list';
      $data['page']         = 'backEnd/admin/two_list';
    } elseif ($param1 == 'edit' && $param2 > 0) {

      $data['edit_info']      = $this->db->get_where('tbl_test_2', array('id' => $param2));

      if ($data['edit_info']->num_rows() > 0) {
        $data['edit_info']    =   $data['edit_info']->row();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          $update_two['name']        = $this->input->post('name', true);
          $update_two['user_id']       = $this->input->post('user_id', true);
          $update_two['phone']       = $this->input->post('phone', true);
          $update_two['description']      = $this->input->post('description', true);
          $update_two['insert_time'] = $this->input->post('insert_time', true);

          // if (!empty($_FILES['photo']['name'])) {

          //   $path_parts                 = pathinfo($_FILES["photo"]['name']);
          //   $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          //   $dir                        = date("YmdHis", time());
          //   $config_c['file_name']      = $newFile_name . '_' . $dir;
          //   $config_c['remove_spaces']  = TRUE;
          //   $config_c['upload_path']    = 'assets/twoPhoto/';
          //   $config_c['max_size']       = '20000'; //  less than 20 MB
          //   $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          //   $this->load->library('upload', $config_c);
          //   $this->upload->initialize($config_c);
          //   if (!$this->upload->do_upload('photo')) {
          //   } else {

          //     $upload_c = $this->upload->data();
          //     $update_two['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
          //     $this->image_size_fix($update_two['photo'], 400, 500);
          //   }
          // }

          if ($this->AdminModel->update_two_data($update_two, $param2)) {

            $this->session->set_flashData('message', 'Two Updated Successfully!');
            redirect('admin/two/list', 'refresh');
          } else {

            $this->session->set_flashData('message', 'Two Update Failed!');
            redirect('admin/two/list', 'refresh');
          }
        }
      } else {

        $this->session->set_flashData('message', 'Wrong Attempt!');
        redirect('admin/two/list', 'refresh');
      }
      $data['title']      = 'Two Edit';
      $data['activeMenu'] = 'two_edit';
      $data['page']       = 'backEnd/admin/two_edit';
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->delete_two_data($param2)) {
        $this->session->set_flashData('message', 'Two Deleted Successfully!');
        redirect('admin/two/list', 'refresh');
      } else {
        $this->session->set_flashData('message', 'Two Deleted Failed!');
        redirect('admin/two/list', 'refresh');
      }
    } else {
      $this->session->set_flashData('message', 'Wrong Attempt!');
      redirect('admin/two/list', 'refresh');
    }
    $this->load->view('backEnd/master_page', $data);
  }

  // Manage_Three
  public function three($param1 = 'add', $param2 = '', $param3 = '')
  {
    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_three['name']             = $this->input->post('name', true);
        $insert_three['email']            = $this->input->post('email', true);
        $insert_three['phone']            = $this->input->post('phone', true);
        $insert_three['status']           = $this->input->post('status', true);
        $insert_three['insert_time']      = date('Y-m-d H:i:s');
        // $update_one['insert_time']      = $this->input->post('insert_time', true);

        if (!empty($_FILES['photo']['name'])) {
          $path_parts                 = pathinfo($_FILES["photo"]['name']);
          $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newFile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/threePhoto/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('photo')) {
          } else {
            $upload_c = $this->upload->data();
            $insert_three['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($insert_three['photo'], 400, 400);
          }
        }
        $add_three = $this->db->insert('tbl_test_2', $insert_three);

        if ($add_three) {
          $this->session->set_flashData('message', 'Three Added Successfully!');
          redirect('admin/one/list', 'refresh');
        } else {
          $this->session->set_flashData('message', 'Three Add Failed!');
          redirect('admin/one/list', 'refresh');
        }
      }
      $data['title']             = 'Three Add';
      $data['activeMenu']        = 'three_add';
      $data['page']              = 'backEnd/admin/three_add';
    } elseif ($param1 == 'list') {

      $data['three_list']     = $this->db->order_by('id', 'desc')->get('tbl_test_3')->result();
      $data['title']        = 'Three List';
      $data['activeMenu']   = 'three_list';
      $data['page']         = 'backEnd/admin/three_list';
    } elseif ($param1 == 'edit' && $param2 > 0) {

      $data['edit_info']      = $this->db->get_where('tbl_test_3', array('id' => $param2));

      if ($data['edit_info']->num_rows() > 0) {
        $data['edit_info']    =   $data['edit_info']->row();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          $update_three['name']        = $this->input->post('name', true);
          $update_three['email']       = $this->input->post('email', true);
          $update_three['phone']       = $this->input->post('phone', true);
          $update_three['status']      = $this->input->post('status', true);
          $update_three['insert_time'] = $this->input->post('insert_time', true);

          if (!empty($_FILES['photo']['name'])) {

            $path_parts                 = pathinfo($_FILES["photo"]['name']);
            $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
            $dir                        = date("YmdHis", time());
            $config_c['file_name']      = $newFile_name . '_' . $dir;
            $config_c['remove_spaces']  = TRUE;
            $config_c['upload_path']    = 'assets/threePhoto/';
            $config_c['max_size']       = '20000'; //  less than 20 MB
            $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

            $this->load->library('upload', $config_c);
            $this->upload->initialize($config_c);
            if (!$this->upload->do_upload('photo')) {
            } else {

              $upload_c = $this->upload->data();
              $update_three['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
              $this->image_size_fix($update_three['photo'], 400, 500);
            }
          }

          if ($this->AdminModel->update_three_data($update_three, $param2)) {

            $this->session->set_flashData('message', 'Three Updated Successfully!');
            redirect('admin/three/list', 'refresh');
          } else {

            $this->session->set_flashData('message', 'Three Update Failed!');
            redirect('admin/three/list', 'refresh');
          }
        }
      } else {

        $this->session->set_flashData('message', 'Wrong Attempt!');
        redirect('admin/three/list', 'refresh');
      }
      $data['title']      = 'Three Edit';
      $data['activeMenu'] = 'three_edit';
      $data['page']       = 'backEnd/admin/three_edit';
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->delete_two_data($param2)) {
        $this->session->set_flashData('message', 'Three Deleted Successfully!');
        redirect('admin/three/list', 'refresh');
      } else {
        $this->session->set_flashData('message', 'Three Deleted Failed!');
        redirect('admin/three/list', 'refresh');
      }
    } else {
      $this->session->set_flashData('message', 'Wrong Attempt!');
      redirect('admin/three/list', 'refresh');
    }
    $this->load->view('backEnd/master_page', $data);
  }

  // Manage_Student
  public function student($param1 = 'add', $param2 = '', $param3 = '')
  {
    // Add Data
    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_student['first_name']     = $this->input->post('first_name', true);
        $insert_student['last_name']      = $this->input->post('last_name', true);
        $insert_student['email']          = $this->input->post('email', true);
        $insert_student['phone']          = $this->input->post('phone', true);
        $insert_student['address']        = $this->input->post('address', true);
        $insert_student['description']    = $this->input->post('description', true);

        if (!empty($_FILES['photo_1']['name'])) {

          $path_parts                 = pathinfo($_FILES["photo_1"]['name']);
          $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newFile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/studentPhoto/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('photo_1')) {
          } else {

            $upload_c = $this->upload->data();
            $insert_student['photo_1'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($insert_student['photo_1'], 400, 500);
          }
        }
        if (!empty($_FILES['photo_2']['name'])) {

          $path_parts                 = pathinfo($_FILES["photo_2"]['name']);
          $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newFile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/studentPhoto/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('photo_2')) {
          } else {

            $upload_c = $this->upload->data();
            $insert_student['photo_2'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($insert_student['photo_2'], 400, 500);
          }
        }
        if (!empty($_FILES['photo_3']['name'])) {

          $path_parts                 = pathinfo($_FILES["photo_3"]['name']);
          $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newFile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/studentPhoto/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('photo_3')) {
          } else {

            $upload_c = $this->upload->data();
            $insert_student['photo_3'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($insert_student['photo_3'], 400, 500);
          }
        }
        if (!empty($_FILES['photo_4']['name'])) {

          $path_parts                 = pathinfo($_FILES["photo_4"]['name']);
          $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newFile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/studentPhoto/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('photo_4')) {
          } else {

            $upload_c = $this->upload->data();
            $insert_student['photo_4'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($insert_student['photo_4'], 400, 500);
          }
        }


        $add_student = $this->db->insert('tbl_test', $insert_student);

        if ($add_student) {

          $this->session->set_flashData('message', 'Student Added Successfully!');
          redirect('admin/student/list', 'refresh');
        } else {

          $this->session->set_flashData('message', 'Student Add Failed!');
          redirect('admin/student/list', 'refresh');
        }
      }

      $data['title']             = 'Student Add';
      $data['activeMenu']        = 'add_student';
      $data['page']              = 'backEnd/admin/student_add';
    } elseif ($param1 == 'list') {

      $data['authors_list'] = $this->db->order_by('id', 'desc')->get('tbl_test')->result();

      $data['title']        = 'Student List';
      $data['activeMenu']   = 'student_list';
      $data['page']         = 'backEnd/admin/student_list';
    } elseif ($param1 == 'edit' && $param2 > 0) {

      $data['edit_info']   = $this->db->get_where('tbl_test', array('id' => $param2));
      if ($data['edit_info']->num_rows() > 0) {

        $data['edit_info']    = $data['edit_info']->row();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          $update_student['first_name']    = $this->input->post('first_name', true);
          $update_student['last_name']     = $this->input->post('last_name', true);
          $update_student['email']         = $this->input->post('email', true);
          $update_student['phone']         = $this->input->post('phone', true);
          $update_student['address']       = $this->input->post('address', true);
          $update_student['description']   = $this->input->post('description', true);

          if (!empty($_FILES['photo_1']['name'])) {

            $path_parts                 = pathinfo($_FILES["photo_1"]['name']);
            $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
            $dir                        = date("YmdHis", time());
            $config_c['file_name']      = $newFile_name . '_' . $dir;
            $config_c['remove_spaces']  = TRUE;
            $config_c['upload_path']    = 'assets/studentPhoto/';
            $config_c['max_size']       = '20000'; //  less than 20 MB
            $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

            $this->load->library('upload', $config_c);
            $this->upload->initialize($config_c);
            if (!$this->upload->do_upload('photo_1')) {
            } else {

              $upload_c = $this->upload->data();
              $saveData['photo_1'] = $config_c['upload_path'] . $upload_c['file_name'];
              $this->image_size_fix($saveData['photo_1'], 400, 400);
            }
          }

          if ($this->AdminModel->update_student($update_student, $param2)) {

            $this->session->set_flashData('message', 'Student Updated Successfully!');
            redirect('admin/student/list', 'refresh');
          } else {

            $this->session->set_flashData('message', 'Student Update Failed!');
            redirect('admin/student/list', 'refresh');
          }
        }
      } else {

        $this->session->set_flashData('message', 'Wrong Attempt!');
        redirect('admin/student/list', 'refresh');
      }

      $data['title']      = 'Student Edit';
      $data['activeMenu'] = 'student_edit';
      $data['page']       = 'backEnd/admin/student_edit';
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->delete_student($param2)) {

        $this->session->set_flashData('message', 'Student Deleted Successfully!');
        redirect('admin/student/list', 'refresh');
      } else {

        $this->session->set_flashData('message', 'Student Deleted Failed!');
        redirect('admin/student/list', 'refresh');
      }
    } else {

      $this->session->set_flashData('message', 'Wrong Attempt!');
      redirect('admin/student/list', 'refresh');
    }

    $this->load->view('backEnd/master_page', $data);
  }

  // Add User
  public function add_user($param1 = '')
  {
    $messagePage['divisions'] = $this->db->get('tbl_division')->result_array();
    $messagePage['userType']   = $this->db->get('user_type')->result();

    $messagePage['title']      = 'Add User Admin Panel • HRSOFTBD News Portal Admin Panel';
    $messagePage['page']       = 'backEnd/admin/add_user';
    $messagePage['activeMenu'] = 'add_user';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $saveData['firstname'] = $this->input->post('first_name', true);
      $saveData['lastname']  = $this->input->post('last_name', true);
      $saveData['username']  = $this->input->post('user_name', true);
      $saveData['email']     = $this->input->post('email', true);
      $saveData['phone']     = $this->input->post('phone', true);
      $saveData['password']  = sha1($this->input->post('password', true));
      $saveData['address']   = $this->input->post('address', true);
      $saveData['roadHouse'] = $this->input->post('road_house', true);
      $saveData['userType']  = $this->input->post('user_type', true);
      $saveData['photo']     = 'assets/userPhoto/defaultUser.jpg';

      if (!empty($_FILES['photo']['name'])) {

        $path_parts                 = pathinfo($_FILES["photo"]['name']);
        $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
        $dir                        = date("YmdHis", time());
        $config_c['file_name']      = $newFile_name . '_' . $dir;
        $config_c['remove_spaces']  = TRUE;
        $config_c['upload_path']    = 'assets/userPhoto/';
        $config_c['max_size']       = '20000'; //  less than 20 MB
        $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

        $this->load->library('upload', $config_c);
        $this->upload->initialize($config_c);
        if (!$this->upload->do_upload('photo')) {
        } else {

          $upload_c = $this->upload->data();
          $saveData['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
          $this->image_size_fix($saveData['photo'], 400, 400);
        }
      }

      //This will returns as third parameter num_rows, result_array, result
      $username_check = $this->AdminModel->isRowExist('user', array('username' => $saveData['username']), 'num_rows');
      $email_check = $this->AdminModel->isRowExist('user', array('email' => $saveData['email']), 'num_rows');

      if ($username_check > 0 || $email_check > 0) {
        //Invalid message
        $messagePage['page'] = 'backEnd/admin/insertFailed';
        $messagePage['noteMessage'] = "<hr> UserName: " . $saveData['username'] . " can not be create.";
        if ($username_check > 0) {

          $messagePage['noteMessage'] .= '<br> Cause this username is already exist.';
        } else if ($email_check > 0) {

          $messagePage['noteMessage'] .= '<br> Cause this email is already exist.';
        }
      } else {
        //success
        $insertId = $this->AdminModel->saveDataInTable('user', $saveData, 'true');

        $messagePage['page'] = 'backEnd/admin/insertSuccessfull';
        $messagePage['noteMessage'] = "<hr> UserName: " . $saveData['username'] . " has been created successfully.";

        // Category allocate for users
        if (!empty($this->input->post('selectCategory', true))) {

          foreach ($this->input->post('selectCategory', true) as $cat_value) {

            $this->db->insert('category_user', array('userId' => $insertId, 'categoryId' => $cat_value));
          }
        }
      }
    }


    $this->load->view('backEnd/master_page', $messagePage);
  }

  // Edit User
  public function edit_user($param1 = '')
  {
    // Update using post method 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      if (strlen($this->input->post('password', true)) > 3) {
        $saveData['password']  = sha1($this->input->post('password', true));
      }

      $saveData['firstname'] = $this->input->post('first_name', true);
      $saveData['lastname']  = $this->input->post('last_name', true);
      $saveData['phone']     = $this->input->post('phone', true);
      $saveData['address']   = $this->input->post('address', true);
      $saveData['roadHouse'] = $this->input->post('road_house', true);
      $saveData['userType']  = $this->input->post('user_type', true);
      $user_id               = $param1;

      if (!empty($_FILES['photo']['name'])) {

        $path_parts                 = pathinfo($_FILES["photo"]['name']);
        $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
        $dir                        = date("YmdHis", time());
        $config_c['file_name']      = $newFile_name . '_' . $dir;
        $config_c['remove_spaces']  = TRUE;
        $config_c['upload_path']    = 'assets/userPhoto/';
        $config_c['max_size']       = '20000'; //  less than 20 MB
        $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

        $this->load->library('upload', $config_c);
        $this->upload->initialize($config_c);
        if (!$this->upload->do_upload('photo')) {
        } else {

          $upload_c = $this->upload->data();
          $saveData['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
          $this->image_size_fix($saveData['photo'], 400, 400);
        }
      }

      if (isset($saveData['photo']) && file_exists($saveData['photo'])) {

        $result = $this->db->select('photo')->from('user')->where('id', $user_id)->get()->row()->photo;

        if (file_exists($result)) {
          unlink($result);
        }
      }

      $this->db->where('id', $user_id);
      $this->db->update('user', $saveData);

      $data['page']        = 'backEnd/admin/insertSuccessfull';
      $data['noteMessage'] = "<hr> Data has been Updated successfully.";
    } else if ($this->AdminModel->isRowExist('user', array('id' => $param1), 'num_rows') > 0) {

      $data['userDetails']   = $this->AdminModel->isRowExist('user', array('id' => $param1), 'result_array');

      $myupozilla_id         = $this->db->get_where('tbl_upozilla', array("id" => $data['userDetails'][0]['address']))->row();

      $data['myzilla_id']    = $myupozilla_id->zilla_id;
      $data['mydivision_id'] = $myupozilla_id->division_id;

      $data['divissions']    = $this->db->get('tbl_divission')->result();

      $data['distrcts']      = $this->db->get_where('tbl_zilla', array('divission_id' => $data['mydivision_id']))->result();
      $data['upozilla']      = $this->db->get_where('tbl_upozilla', array('zilla_id' => $data['myzilla_id']))->result();

      $data['userType'] = $this->db->get('user_type')->result_array();
      $data['user_id']  = $param1;
      $data['page']     = 'backEnd/admin/edit_user';
    } else {

      $data['page']        = 'errors/invalidInformationPage';
      $data['noteMessage'] = $this->lang->line('wrong_info_search');
    }

    $data['user_type']   = $this->db->select('id, value, name')->get('user_type')->result();
    $data['title']      = 'Users List Admin Panel • HRSOFTBD News Portal Admin Panel';
    $data['activeMenu'] = 'user_list';
    $this->load->view('backEnd/master_page', $data);
  }

  //Suspend User
  public function suspend_user($id, $setvalue)
  {
    $this->db->where('id', $id);
    $this->db->update('user', array('status' => $setvalue));
    $this->session->set_flashData('message', 'Data Saved Successfully.');

    redirect('admin/user_list', 'refresh');
  }

  //Delete User
  public function delete_user($id)
  {
    $old_image_url = $this->db->where('id', $id)->get('user')->row();
    $this->db->where('id', $id)->delete('user');
    if (isset($old_image_url->photo)) {
      unlink($old_image_url->photo);
    }

    $this->session->set_flashData('message', 'Data Deleted.');
    redirect('admin/user_list', 'refresh');
  }

  //User List
  public function user_list()
  {
    $this->db->where('userType !=', 'admin');
    $data['myUsers']    = $this->db->get('user')->result_array();
    $data['title']      = 'Users List Admin Panel • HRSOFTBD News Portal Admin Panel';
    $data['page']       = 'backEnd/admin/user_list';
    $data['activeMenu'] = 'user_list';
    $this->load->view('backEnd/master_page', $data);
  }
  // Image Size Fix 
  public function image_size_fix($filename, $width = 600, $height = 400, $destination = '')
  {

    // Content type
    // header('Content-Type: image/jpeg');
    // Get new dimensions
    list($width_orig, $height_orig) = getimagesize($filename);

    // Output 20 May, 2018 updated below part
    if ($destination == '' || $destination == null)
      $destination = $filename;

    $extention = pathinfo($destination, PATHINFO_EXTENSION);
    if ($extention != "png" && $extention != "PNG" && $extention != "JPEG" && $extention != "jpeg" && $extention != "jpg" && $extention != "JPG") {

      return true;
    }
    // Resample
    $image_p = imagecreatetruecolor($width, $height);
    $image   = imagecreatefromstring(file_get_contents($filename));
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);



    if ($extention == "png" || $extention == "PNG") {
      imagepng($image_p, $destination, 9);
    } else if ($extention == "jpg" || $extention == "JPG" || $extention == "jpeg" || $extention == "JPEG") {
      imagejpeg($image_p, $destination, 70);
    } else {
      imagepng($image_p, $destination);
    }
    return true;
  }
  //Get Division
  public function get_division()
  {

    $result = $this->db->select('id, name')->get('tbl_divission')->result();
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
  }
  //Get Zilla from Division
  public function get_zilla_from_division($division_id = 1)
  {

    $result = $this->db->select('id, name')->where('divission_id', $division_id)->get('tbl_zilla')->result();
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
  }
  //Get Upzilla from Division
  public function get_upozilla_from_division_zilla($zilla_id = 1)
  {

    $result = $this->db->select('id, name')->where('zilla_id', $zilla_id)->get('tbl_upozilla')->result();
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
  }
  //Get download file
  public function download_file($file_name = '', $fullpath = '')
  {

    $this->load->helper('download');

    $filePath = $file_name;

    if ($file_name == 'full' && ($fullpath != '' || $fullpath != null)) $filePath = $fullpath;

    if ($_GET['file_path']) $filePath = $_GET['file_path'];

    if (file_exists($filePath)) {

      force_download($filePath, NULL);
    } else {

      die('The provided file path is not valid.');
    }
  }
  // Profile
  public function profile($param1 = '')
  {

    $user_id            = $this->session->userdata('userid');
    $data['user_info']  = $this->AdminModel->get_user($user_id);


    $myzilla_id         = $data['user_info']->zilla_id;
    $mydivision_id      = $data['user_info']->division_id;

    $data['divissions'] = $this->db->get('tbl_divission')->result();

    $data['distrcts']   = $this->db->get_where('tbl_zilla', array('divission_id' => $mydivision_id))->result();
    $data['upozilla']   = $this->db->get_where('tbl_upozilla', array('zilla_id'  => $myzilla_id))->result();

    if ($param1 == 'update_photo') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {


        //exta work
        $path_parts               = pathinfo($_FILES["photo"]['name']);
        $newFile_name             = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
        $dir                      = date("YmdHis", time());
        $config['file_name']      = $newFile_name . '_' . $dir;
        $config['remove_spaces']  = TRUE;
        //exta work
        $config['upload_path']    = 'assets/userPhoto/';
        $config['max_size']       = '20000'; //  less than 20 MB
        $config['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('photo')) {

          // case - failure
          $upload_error = array('error' => $this->upload->display_errors());
          $this->session->set_flashData('message', "Failed to update image.");
        } else {

          $upload                 = $this->upload->data();
          $newphotoadd['photo']   = $config['upload_path'] . $upload['file_name'];

          $old_photo              = $this->db->where('id', $user_id)->get('user')->row()->photo;

          if (file_exists($old_photo)) unlink($old_photo);

          $this->image_size_fix($newphotoadd['photo'], 200, 200);

          $this->db->where('id', $user_id)->update('user', $newphotoadd);

          $this->session->set_userdata('userPhoto', $newphotoadd['photo']);
          $this->session->set_flashData('message', 'User Photo Updated Successfully!');

          redirect('admin/profile', 'refresh');
        }
      }
    } else if ($param1 == 'update_pass') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $old_pass    = sha1($this->input->post('old_pass', true));
        $new_pass    = sha1($this->input->post('new_pass', true));
        $user_id     = $this->session->userdata('userid');

        $get_user    = $this->db->get_where('user', array('id' => $user_id, 'password' => $old_pass));
        $user_exist  = $get_user->row();

        if ($user_exist) {

          $this->db->where('id', $user_id)
            ->update('user', array('password' => $new_pass));
          $this->session->set_flashData('message', 'Password Updated Successfully');
          redirect('admin/profile', 'refresh');
        } else {

          $this->session->set_flashData('message', 'Password Update Failed');
          redirect('admin/profile', 'refresh');
        }
      }
    } else if ($param1 == 'update_info') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $update_data['firstname']   = $this->input->post('firstname', true);
        $update_data['lastname']    = $this->input->post('lastname', true);
        $update_data['roadHouse']   = $this->input->post('roadHouse', true);
        $update_data['address']     = $this->input->post('address', true);


        $db_email     = $this->db->where('id!=', $user_id)->where('email', $this->input->post('email', true))->get('user')->num_rows();
        $db_username  = $this->db->where('id!=', $user_id)->where('username', $this->input->post('username', true))->get('user')->num_rows();


        if ($db_username == 0) {

          $update_data['username']    = $this->input->post('username', true);
        }
        if ($db_email == 0) {

          $update_data['email']       = $this->input->post('email', true);
        }


        $current_password = sha1($this->input->post('password', true));

        $db_password      = $data['user_info']->password;

        if ($current_password == $db_password) {

          if ($this->AdminModel->update_pro_info($update_data, $user_id)) {

            $this->session->set_userdata('username_first', $update_data['firstname']);
            $this->session->set_userdata('username_last', $update_data['lastname']);
            $this->session->set_userdata('username', $update_data['username']);

            $this->session->set_flashData('message', 'Information Updated Successfully!');
            redirect('admin/profile', 'refresh');
          } else {

            $this->session->set_flashData('message', 'Information Update Failed!');
            redirect('admin/profile', 'refresh');
          }
        } else {

          $this->session->set_flashData('message', 'Current Password Does Not Match!');
          redirect('admin/profile', 'refresh');
        }
      }
    }

    $data['title']      = 'Profile Admin Panel • HRSOFTBD News Portal Admin Panel';
    $data['activeMenu'] = 'Profile';
    $data['page']       = 'backEnd/admin/profile';

    $this->load->view('backEnd/master_page', $data);
  }

  //Journal
  public function journal($param1 = 'add', $param2 = '', $param3 = '')
  {
    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_journals['title']              = $this->input->post('title', true);
        if ($this->input->post('published_date', true)) {

          $insert_journals['published_date']         = date('Y-m-d', strtotime($this->input->post('published_date', true)));
        }
        $insert_journals['journal_introduction']    = $this->input->post('journal_introduction', true);
        $insert_journals['journal_volume']       = $this->input->post('journal_volume', true);
        $insert_journals['location']            = $this->input->post('location', true);
        $insert_journals['published_organization']  = $this->input->post('published_organization', true);
        $insert_journals['online_reading_link']     = $this->input->post('online_reading_link', true);
        $insert_journals['contact_with_name']        = $this->input->post('contact_with_name', true);
        $insert_journals['contact_with_phone']      = $this->input->post('contact_with_phone', true);
        $insert_journals['contact_with_pemail']     = $this->input->post('contact_with_pemail', true);
        $insert_journals['public_private']        = $this->input->post('public_private', true);
        $insert_journals['journal_type']          = $this->input->post('journal_type', true);
        $insert_journals['paid_type']              = $this->input->post('paid_type', true);
        $insert_journals['total_read']          = $this->input->post('total_read', true);
        $insert_journals['insert_by']            = $_SESSION['userid'];
        $insert_journals['insert_time']          = date('Y-m-d H:i:s');

        if (!empty($_FILES['journal_pdf']['name'])) {

          $path_parts                 = pathinfo($_FILES["journal_pdf"]['name']);
          $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newFile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/journalsPhoto/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'pdf|PDF';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('journal_pdf')) {
          } else {

            $upload_c = $this->upload->data();
            $insert_journals['journal_pdf'] = $config_c['journal_pdf'] . $upload_c['file_name'];
          }
        }

        if (!empty($_FILES['journal_cover_photo']['name'])) {

          $path_parts                 = pathinfo($_FILES["journal_cover_photo"]['name']);
          $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newFile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/journalsPhoto/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('journal_cover_photo')) {
          } else {

            $upload_c = $this->upload->data();
            $insert_journals['journal_cover_photo'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($insert_journals['journal_cover_photo'], 600, 800);
          }
        }

        $add_journals = $this->db->insert('tbl_journals', $insert_journals);

        $new_journal_id = $this->db->insert_id();
        $author_data['journal_id'] = $new_journal_id;
        $author_data['insert_time'] = date('Y-m-d H:i');
        $author_data['insert_by']     = $_SESSION['userid'];


        foreach ($this->input->post('author_id', true) as $key => $value) {

          if ($value == '') continue;

          $author_data['author_id'] = $this->input->post('author_id', true)[$key];
          $author_data['contribution_level']  = $this->input->post('contribution_level', true)[$key];
          $author_data['contribution_text']  = $this->input->post('contribution_text', true)[$key];

          $this->db->insert('tbl_journal_authors', $author_data);
        }

        if ($add_journals) {

          $this->session->set_flashData('message', 'Journals Added Successfully!');
          redirect('admin/journal/list', 'refresh');
        } else {

          $this->session->set_flashData('message', 'Journals Add Failed!');
          redirect('admin/journal/list', 'refresh');
        }
      }

      $data['author_list']    = $this->db->get('tbl_authors')->result();

      $data['title']             = 'Journals Add';
      $data['activeMenu']        = 'add_journal';
      $data['page']              = 'backEnd/admin/journal_add';
    } elseif ($param1 == 'list') {

      $data = array();
      $data['search']['published_date']  = '';
      $data['search']['title']           = '';
      $data['search']['author_id']       = '';

      $data['new_sl'] = 1;

      $data["links"] = '';

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if ($this->input->post('published_date', true)) {

          $data['search']['published_date']     = date('Y-m-d', strtotime($this->input->post('published_date', true)));
        }

        if ($this->input->post('title', true)) {

          $data['search']['title']     = $this->input->post('title', true);
        }

        if ($this->input->post('author_id', true)) {

          $data['search']['author_id']     = $this->input->post('author_id', true);
        }

        $data['journals_list'] = $this->AdminModel->get_journal_list($config["per_page"] = 1000, $page = 0, $data['search']);
      } else {

        $config = array();
        $config["base_url"] = base_url("admin/journal/list");
        $config["total_rows"] = $this->db->count_all('tbl_journals');
        $config["per_page"] = 10;
        $config["uri_segment"] = 4;

        //custom

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = "First";
        $config['last_link'] = "Last";

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['prev_link'] = '«';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';

        $config['next_link'] = '»';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';


        $this->pagination->initialize($config);

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $data['new_sl'] = $page;

        $data["links"] = $this->pagination->create_links();

        $data['journals_list'] = $this->AdminModel->get_journal_list($config["per_page"], $page, $data['search']);
      }



      $data['author_list'] = $this->db->order_by('id', 'desc')->get('tbl_authors')->result();

      $data['title']        = 'Journals List';
      $data['activeMenu']   = 'journal_list';
      $data['page']         = 'backEnd/admin/journal_list';
    } elseif ($param1 == 'edit' && $param2 > 0) {

      $data['edit_info']   = $this->db->get_where('tbl_journals', array('id' => $param2));

      if ($data['edit_info']->num_rows() > 0) {

        $data['edit_info']    = $data['edit_info']->row();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          $update_journals['title']              = $this->input->post('title', true);
          $update_journals['published_date']         = date('Y-m-d', strtotime($this->input->post('published_date', true)));

          $update_journals['journal_introduction']    = $this->input->post('journal_introduction', true);
          $update_journals['journal_volume']       = $this->input->post('journal_volume', true);
          $update_journals['location']            = $this->input->post('location', true);
          $update_journals['published_organization']  = $this->input->post('published_organization', true);
          $update_journals['online_reading_link']     = $this->input->post('online_reading_link', true);
          $update_journals['contact_with_name']        = $this->input->post('contact_with_name', true);
          $update_journals['contact_with_phone']      = $this->input->post('contact_with_phone', true);
          $update_journals['contact_with_pemail']     = $this->input->post('contact_with_pemail', true);
          $update_journals['public_private']        = $this->input->post('public_private', true);
          $update_journals['journal_type']          = $this->input->post('journal_type', true);
          $update_journals['paid_type']              = $this->input->post('paid_type', true);
          $update_journals['total_read']          = $this->input->post('total_read', true);

          if (!empty($_FILES['journal_pdf']['name'])) {

            $path_parts                 = pathinfo($_FILES["journal_pdf"]['name']);
            $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
            $dir                        = date("YmdHis", time());
            $config_c['file_name']      = $newFile_name . '_' . $dir;
            $config_c['remove_spaces']  = TRUE;
            $config_c['upload_path']    = 'assets/journalsPhoto/';
            $config_c['max_size']       = '20000'; //  less than 20 MB
            $config_c['allowed_types']  = 'pdf|PDF';

            $this->load->library('upload', $config_c);
            $this->upload->initialize($config_c);
            if (!$this->upload->do_upload('journal_pdf')) {
            } else {

              $upload_c = $this->upload->data();
              $update_journals['journal_pdf'] = $config_c['upload_path'] . $upload_c['file_name'];
            }
          }

          if (!empty($_FILES['journal_cover_photo']['name'])) {

            $path_parts                 = pathinfo($_FILES["journal_cover_photo"]['name']);
            $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
            $dir                        = date("YmdHis", time());
            $config_c['file_name']      = $newFile_name . '_' . $dir;
            $config_c['remove_spaces']  = TRUE;
            $config_c['upload_path']    = 'assets/journalsPhoto/';
            $config_c['max_size']       = '20000'; //  less than 20 MB
            $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

            $this->load->library('upload', $config_c);
            $this->upload->initialize($config_c);
            if (!$this->upload->do_upload('journal_cover_photo')) {
            } else {

              $upload_c = $this->upload->data();
              $update_journals['journal_cover_photo'] = $config_c['upload_path'] . $upload_c['file_name'];
              $this->image_size_fix($update_journals['journal_cover_photo'], 600, 800);
            }
          }

          if ($this->AdminModel->update_journals($update_journals, $param2)) {


            foreach ($this->input->post('author_id', true) as $key => $value) {

              if ($value == '') continue;

              $author_data['journal_id']       = $param2;
              $author_data['author_id']       = $this->input->post('author_id', true)[$key];
              $author_data['contribution_level']  = $this->input->post('contribution_level', true)[$key];
              $author_data['contribution_text']  = $this->input->post('contribution_text', true)[$key];
              $author_data['insert_time']     = date('Y-m-d H:i');
              $author_data['insert_by']         = $_SESSION['userid'];

              if (!empty($_FILES['contribution_pdf']['name'][$key])) {

                $path_parts                 = pathinfo($_FILES["contribution_pdf"]['name'])[$key];
                $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename'])[$key];
                $dir                        = date("YmdHis", time())[$key];
                $config_c['file_name']      = $newFile_name . '_' . $dir[$key];
                $config_c['remove_spaces']  = TRUE;
                $config_c['upload_path']    = 'assets/journalsPhoto/';
                $config_c['max_size']       = '20000'; //  less than 20 MB
                $config_c['allowed_types']  = 'pdf|PDF';

                $this->load->library('upload', $config_c)[$key];
                $this->upload->initialize($config_c)[$key];
                if (!$this->upload->do_upload('contribution_pdf')) {
                } else {

                  $upload_c = $this->upload->data();
                  $author_data['contribution_pdf'] = $config_c['upload_path'] . $upload_c['file_name'][$key];
                }
              }


              $this->db->insert('tbl_journal_authors', $author_data);
            }

            $this->session->set_flashData('message', 'Journals Updated Successfully!');
            redirect('admin/journal/edit/' . $param2, 'refresh');
          } else {

            $this->session->set_flashData('message', 'Journals Update Failed!');
            redirect('admin/journal/edit/' . $param2, 'refresh');
          }
        }
      } else {

        $this->session->set_flashData('message', 'Wrong Attempt!');
        redirect('admin/journal/list', 'refresh');
      }

      $data['author_info'] = $this->AdminModel->get_author_data($param2);


      $data['author_list']    = $this->db->get('tbl_authors')->result();

      $data['title']      = 'Journals Edit';
      $data['activeMenu'] = 'journal_edit';
      $data['page']       = 'backEnd/admin/journal_edit';
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->delete_journals($param2)) {

        $this->db->where('journal_id', $param2)->delete('tbl_journal_authors');

        $this->session->set_flashData('message', 'Journals  Deleted Successfully!');
        redirect('admin/journal/list', 'refresh');
      } else {

        $this->session->set_flashData('message', 'Journals Deleted Failed!');
        redirect('admin/journal/list', 'refresh');
      }
    } elseif ($param1 == 'delete-author' && $param2 > 0) {

      if ($this->db->where('id', $param2)->delete('tbl_journal_authors')) {

        $this->session->set_flashData('message', 'Author Info Deleted Successfully!');
        redirect('admin/journal/list', 'refresh');
      } else {

        $this->session->set_flashData('message', 'Author Info Deleted Failed!');
        redirect('admin/journal/list', 'refresh');
      }
    } else {

      $this->session->set_flashData('message', 'Wrong Attempt!');
      redirect('admin/journal/list', 'refresh');
    }

    $this->load->view('backEnd/master_page', $data);
  }

  public function journal_authors($id = 0)
  {

    $data['author_info']   = $this->db->get_where('tbl_journal_authors', array('id' => $id));

    if ($data['author_info']->num_rows() > 0) {

      $data['author_info'] = $data['author_info']->row();

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $update_journal_authors['author_id']               = $this->input->post('author_id', true);
        $update_journal_authors['contribution_level']      = $this->input->post('contribution_level', true);
        $update_journal_authors['contribution_text']       = $this->input->post('contribution_text', true);

        $this->db->where('id', $id)->update('tbl_journal_authors', $update_journal_authors);

        $this->session->set_flashData('message', 'Update Completed.');
        redirect('admin/journal-authors/' . $id, 'refresh');
      }
    } else {
      $this->session->set_flashData('message', 'Wrong Attempt!');
      redirect('admin/journal-authors/' . $id, 'refresh');
    }



    $data['author_list']    = $this->db->get('tbl_authors')->result();

    $data['title']      = 'Journals Authors Edit';
    $data['activeMenu'] = 'journal_authors_edit';
    $data['page']       = 'backEnd/admin/journal_authors_edit';

    $this->load->view('backEnd/master_page', $data);
  }

  //Author
  public function author($param1 = 'add', $param2 = '', $param3 = '')
  {
    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_authors['author_name']      = $this->input->post('author_name', true);
        $insert_authors['author_phone']     = $this->input->post('author_phone', true);
        $insert_authors['email']            = $this->input->post('email', true);
        $insert_authors['institute_name']   = $this->input->post('institute_name', true);
        $insert_authors['designation']      = $this->input->post('designation', true);
        $insert_authors['insert_by']        = $_SESSION['userid'];
        $insert_authors['insert_time']      = date('Y-m-d H:i:s');

        if (!empty($_FILES['author_photo']['name'])) {

          $path_parts                 = pathinfo($_FILES["author_photo"]['name']);
          $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newFile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/authorsPhoto/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('author_photo')) {
          } else {

            $upload_c = $this->upload->data();
            $insert_authors['author_photo'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($insert_authors['author_photo'], 400, 500);
          }
        }

        $add_authors = $this->db->insert('tbl_authors', $insert_authors);

        if ($add_authors) {

          $this->session->set_flashData('message', 'Author Added Successfully!');
          redirect('admin/author/list', 'refresh');
        } else {

          $this->session->set_flashData('message', 'Author Add Failed!');
          redirect('admin/author/list', 'refresh');
        }
      }

      $data['title']             = 'Author Add';
      $data['activeMenu']        = 'add_author';
      $data['page']              = 'backEnd/admin/author_add';
    } elseif ($param1 == 'list') {

      $data['authors_list'] = $this->db->order_by('id', 'desc')->get('tbl_authors')->result();

      $data['title']        = 'Author List';
      $data['activeMenu']   = 'author_list';
      $data['page']         = 'backEnd/admin/author_list';
    } elseif ($param1 == 'edit' && $param2 > 0) {

      $data['edit_info']   = $this->db->get_where('tbl_authors', array('id' => $param2));

      if ($data['edit_info']->num_rows() > 0) {

        $data['edit_info']    = $data['edit_info']->row();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          $update_authors['author_name']      = $this->input->post('author_name', true);
          $update_authors['author_phone']     = $this->input->post('author_phone', true);
          $update_authors['email']            = $this->input->post('email', true);
          $update_authors['institute_name']   = $this->input->post('institute_name', true);
          $update_authors['designation']      = $this->input->post('designation', true);

          if (!empty($_FILES['author_photo']['name'])) {

            $path_parts                 = pathinfo($_FILES["author_photo"]['name']);
            $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
            $dir                        = date("YmdHis", time());
            $config_c['file_name']      = $newFile_name . '_' . $dir;
            $config_c['remove_spaces']  = TRUE;
            $config_c['upload_path']    = 'assets/authorsPhoto/';
            $config_c['max_size']       = '20000'; //  less than 20 MB
            $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

            $this->load->library('upload', $config_c);
            $this->upload->initialize($config_c);
            if (!$this->upload->do_upload('author_photo')) {
            } else {

              $upload_c = $this->upload->data();
              $update_authors['author_photo'] = $config_c['upload_path'] . $upload_c['file_name'];
              $this->image_size_fix($update_authors['author_photo'], 400, 500);
            }
          }

          if ($this->AdminModel->update_authors($update_authors, $param2)) {

            $this->session->set_flashData('message', 'Author Updated Successfully!');
            redirect('admin/author/list', 'refresh');
          } else {

            $this->session->set_flashData('message', 'Author Update Failed!');
            redirect('admin/author/list', 'refresh');
          }
        }
      } else {

        $this->session->set_flashData('message', 'Wrong Attempt!');
        redirect('admin/author/list', 'refresh');
      }

      $data['title']      = 'Author Edit';
      $data['activeMenu'] = 'author_edit';
      $data['page']       = 'backEnd/admin/author_edit';
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->delete_authors($param2)) {

        $this->session->set_flashData('message', 'Author Deleted Successfully!');
        redirect('admin/author/list', 'refresh');
      } else {

        $this->session->set_flashData('message', 'Author Deleted Failed!');
        redirect('admin/author/list', 'refresh');
      }
    } else {

      $this->session->set_flashData('message', 'Wrong Attempt!');
      redirect('admin/author/list', 'refresh');
    }

    $this->load->view('backEnd/master_page', $data);
  }

  //Division
  public function division($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_division['name']            = $this->input->post('name', true);
        $insert_division['name_en']         = $this->input->post('name_en', true);



        $division_add = $this->db->insert('tbl_divission', $insert_division);

        if ($division_add) {

          $this->session->set_flashData('message', "Data Added Successfully.");
          redirect('admin/division/', 'refresh');
        } else {

          $this->session->set_flashData('message', "Data Add Failed.");
          redirect('admin/division/', 'refresh');
        }
      }
    } else if ($param1 == 'edit' && $param2 > 0) {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $update_division['name']            = $this->input->post('name', true);
        $update_division['name_en']         = $this->input->post('name_en', true);


        if ($this->AdminModel->division_update($update_division, $param2)) {

          $this->session->set_flashData('message', "Data Updated Successfully.");
          redirect('admin/division', 'refresh');
        } else {

          $this->session->set_flashData('message', "Data Update Failed.");
          redirect('admin/division', 'refresh');
        }
      }

      $data['division_info'] = $this->db->get_where('tbl_divission', array('id' => $param2));

      if ($data['division_info']->num_rows() > 0) {

        $data['division_info']    = $data['division_info']->row();
        $data['division_id'] = $param2;
      } else {

        $this->session->set_flashData('message', "Wrong Attempt !");
        redirect('admin/division', 'refresh');
      }
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->delete_division($param2)) {

        $this->session->set_flashData('message', "Data Deleted Successfully.");
        redirect('admin/division', 'refresh');
      } else {

        $this->session->set_flashData('message', "Data Delete Failed.");
        redirect('admin/division', 'refresh');
      }
    }

    $data['title']      = 'Division';
    $data['activeMenu'] = 'division';
    $data['page']       = 'backEnd/admin/division';
    $data['division_list'] = $this->db->order_by('id', 'desc')->get('tbl_divission')->result();

    $this->load->view('backEnd/master_page', $data);
  }

  //Zilla
  public function zilla($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_zilla['divission_id']   = $this->input->post('divission_id', true);
        $insert_zilla['name']           = $this->input->post('name', true);
        $insert_zilla['name_en']        = $this->input->post('name_en', true);


        $add_zilla = $this->db->insert('tbl_zilla', $insert_zilla);

        if ($add_zilla) {

          $this->session->set_flashData('message', 'Data Created Successfully!');
          redirect('admin/zilla/list', 'refresh');
        } else {

          $this->session->set_flashData('message', 'Data Created Failed!');
          redirect('admin/zilla', 'refresh');
        }
      }

      $data['division_list']  = $this->db->order_by('id', 'desc')->get('tbl_divission')->result();

      $data['title']         = 'Zilla Add';
      $data['page']          = 'backEnd/admin/zilla_add';
      $data['activeMenu']    = 'zilla_add';
    } elseif ($param1 == 'edit' && (int) $param2 > 0) {

      $check_table_row = $this->db->where('id', $param2)->get('tbl_zilla');

      if ($check_table_row->num_rows() > 0) {

        $data['zilla_info'] = $check_table_row->row();


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          $update_zilla['divission_id']   = $this->input->post('divission_id', true);
          $update_zilla['name']           = $this->input->post('name', true);
          $update_zilla['name_en']        = $this->input->post('name_en', true);




          if ($this->AdminModel->get_zilla_update($update_zilla, $param2)) {

            $this->session->set_flashData('message', 'Data Updated Successfully!');
            redirect('admin/zilla/list', 'refresh');
          } else {

            $this->session->set_flashData('message', 'Data Update Failed!');
            redirect('admin/zilla/list', 'refresh');
          }

          $this->session->set_flashData('message', 'Data Updated Successfully');
          redirect('admin/zilla/list', 'refresh');
        }
      }

      $data['division_list']  = $this->db->order_by('id', 'desc')->get('tbl_divission')->result();

      $data['title']         = 'Zilla Update';
      $data['page']          = 'backEnd/admin/zilla_edit';
      $data['activeMenu']    = 'zilla_edit';
    } elseif ($param1 == 'list') {

      $config = array();
      $config["base_url"] = base_url("admin/zilla/list");
      $config["total_rows"] = $this->db->get(' tbl_zilla')->num_rows();
      $config["per_page"] = 10;
      $config["uri_segment"] = 4;

      //custom
      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';

      $config['first_link'] = "First";
      $config['last_link'] = "Last";

      $config['first_tag_open'] = '<li>';
      $config['first_tag_close'] = '</li>';

      $config['prev_link'] = '«';
      $config['prev_tag_open'] = '<li class="prev">';
      $config['prev_tag_close'] = '</li>';

      $config['next_link'] = '»';
      $config['next_tag_open'] = '<li>';
      $config['next_tag_close'] = '</li>';

      $config['last_tag_open'] = '<li>';
      $config['last_tag_close'] = '</li>';

      $config['cur_tag_open'] = '<li class="active"><a href="#">';
      $config['cur_tag_close'] = '</a></li>';
      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';

      $this->pagination->initialize($config);

      $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

      $data["links"] = $this->pagination->create_links();

      $data['zilla_list'] = $this->AdminModel->get_zilla_list($config["per_page"], $page);

      $data['new_serial'] = $page;

      $data['title']      = 'Zilla List';
      $data['page']       = 'backEnd/admin/zilla_list';
      $data['activeMenu'] = 'zilla_list';
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->zilla_delete($param2)) {

        $this->session->set_flashData('message', 'Data Deleted Successfully!');
        redirect('admin/zilla/list', 'refresh');
      } else {

        $this->session->set_flashData('message', 'Data Deleted Failed!');
        redirect('admin/zilla/list', 'refresh');
      }
    } else {

      $this->session->set_flashData('message', 'Wrong Attempt!');
      redirect('admin/zilla/list', 'refresh');
    }


    $this->load->view('backEnd/master_page', $data);
  }

  //Upazila
  public function upazila($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_upazila['division_id']    = $this->input->post('division_id', true);
        $insert_upazila['zilla_id']       = $this->input->post('zilla_id', true);
        $insert_upazila['name']           = $this->input->post('name', true);
        $insert_upazila['name_en']        = $this->input->post('name_en', true);


        $add_upazila = $this->db->insert('tbl_upozilla', $insert_upazila);

        if ($add_upazila) {

          $this->session->set_flashData('message', 'Data Created Successfully!');
          redirect('admin/upazila/list', 'refresh');
        } else {

          $this->session->set_flashData('message', 'Data Created Failed!');
          redirect('admin/upazila', 'refresh');
        }
      }

      $data['division_list']  = $this->db->order_by('id', 'desc')->get('tbl_divission')->result();
      $data['zilla_list']  = $this->db->order_by('id', 'desc')->get('tbl_zilla')->result();

      $data['title']         = 'upazila Add';
      $data['page']          = 'backEnd/admin/upazila_add';
      $data['activeMenu']    = 'upazila_add';
    } elseif ($param1 == 'edit' && (int) $param2 > 0) {

      $check_table_row = $this->db->where('id', $param2)->get('tbl_upozilla');

      if ($check_table_row->num_rows() > 0) {

        $data['upzila_info'] = $check_table_row->row();


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          $update_upazila['division_id']    = $this->input->post('division_id', true);
          $update_upazila['zilla_id']       = $this->input->post('zilla_id', true);
          $update_upazila['name']           = $this->input->post('name', true);
          $update_upazila['name_en']        = $this->input->post('name_en', true);




          if ($this->AdminModel->get_upazila_update($update_upazila, $param2)) {

            $this->session->set_flashData('message', 'Data Updated Successfully!');
            redirect('admin/upazila/list', 'refresh');
          } else {

            $this->session->set_flashData('message', 'Data Update Failed!');
            redirect('admin/upazila/list', 'refresh');
          }

          $this->session->set_flashData('message', 'Data Updated Successfully');
          redirect('admin/upazila/list', 'refresh');
        }
      }

      $data['division_list']  = $this->db->order_by('id', 'desc')->get('tbl_divission')->result();
      $data['zilla_list']  = $this->db->order_by('id', 'desc')->get('tbl_zilla')->result();

      $data['title']         = 'Upazila Update';
      $data['page']          = 'backEnd/admin/upazila_edit';
      $data['activeMenu']    = 'upazila_edit';
    } elseif ($param1 == 'list') {

      $config = array();
      $config["base_url"] = base_url("admin/upazila/list");
      $config["total_rows"] = $this->db->get(' tbl_upozilla')->num_rows();
      $config["per_page"] = 10;
      $config["uri_segment"] = 4;

      //custom
      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';

      $config['first_link'] = "First";
      $config['last_link'] = "Last";

      $config['first_tag_open'] = '<li>';
      $config['first_tag_close'] = '</li>';

      $config['prev_link'] = '«';
      $config['prev_tag_open'] = '<li class="prev">';
      $config['prev_tag_close'] = '</li>';

      $config['next_link'] = '»';
      $config['next_tag_open'] = '<li>';
      $config['next_tag_close'] = '</li>';

      $config['last_tag_open'] = '<li>';
      $config['last_tag_close'] = '</li>';

      $config['cur_tag_open'] = '<li class="active"><a href="#">';
      $config['cur_tag_close'] = '</a></li>';
      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';

      $this->pagination->initialize($config);

      $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

      $data["links"] = $this->pagination->create_links();

      $data['upazila_list'] = $this->AdminModel->get_upazila_list($config["per_page"], $page);

      $data['new_serial'] = $page;

      $data['title']      = 'Upazila List';
      $data['page']       = 'backEnd/admin/upazila_list';
      $data['activeMenu'] = 'upazila_list';
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->upazila_delete($param2)) {

        $this->session->set_flashData('message', 'Data Deleted Successfully!');
        redirect('admin/upazila/list', 'refresh');
      } else {

        $this->session->set_flashData('message', 'Data Deleted Failed!');
        redirect('admin/upazila/list', 'refresh');
      }
    } else {

      $this->session->set_flashData('message', 'Wrong Attempt!');
      redirect('admin/upazila/list', 'refresh');
    }


    $this->load->view('backEnd/master_page', $data);
  }

  //video album
  public function video_album($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_video_album['album_title']      = $this->input->post('album_title', true);
        $insert_video_album['priority']         = $this->input->post('priority', true);
        $insert_video_album['insert_time']      = $_SESSION['userid'];
        $insert_video_album['insert_by']         = date('Y-m-d H:i:s');


        $video_album_add = $this->db->insert('tbl_video_album', $insert_video_album);

        if ($video_album_add) {

          $this->session->set_flashData('message', "Data Added Successfully.");
          redirect('admin/video-album/', 'refresh');
        } else {

          $this->session->set_flashData('message', "Data Add Failed.");
          redirect('admin/video-album/', 'refresh');
        }
      }
    } else if ($param1 == 'edit' && $param2 > 0) {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $update_video_album['album_title']      = $this->input->post('album_title', true);
        $update_video_album['priority']         = $this->input->post('priority', true);


        if ($this->AdminModel->video_album_update($update_video_album, $param2)) {

          $this->session->set_flashData('message', "Data Updated Successfully.");
          redirect('admin/video-album', 'refresh');
        } else {

          $this->session->set_flashData('message', "Data Update Failed.");
          redirect('admin/video-album', 'refresh');
        }
      }

      $data['video_album_info'] = $this->db->get_where('tbl_video_album', array('id' => $param2));

      if ($data['video_album_info']->num_rows() > 0) {

        $data['video_album_info']    = $data['video_album_info']->row();
        $data['video_album_id'] = $param2;
      } else {

        $this->session->set_flashData('message', "Wrong Attempt !");
        redirect('admin/video-album', 'refresh');
      }
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->delete_video_album($param2)) {

        $this->session->set_flashData('message', "Data Deleted Successfully.");
        redirect('admin/video-album', 'refresh');
      } else {

        $this->session->set_flashData('message', "Data Delete Failed.");
        redirect('admin/video-album', 'refresh');
      }
    }

    $data['title']      = 'Video Album';
    $data['activeMenu'] = 'video_album';
    $data['page']       = 'backEnd/admin/video_album';
    $data['video_album_list'] = $this->db->order_by('priority', 'desc')->get('tbl_video_album')->result();

    $this->load->view('backEnd/master_page', $data);
  }

  //Session year
  public function session_year($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_session_year['session_year']     = $this->input->post('session_year', true);
        $insert_session_year['insert_time']      = $_SESSION['userid'];
        $insert_session_year['insert_by']         = date('Y-m-d H:i:s');


        $session_year_add = $this->db->insert('tbl_session_year', $insert_session_year);

        if ($session_year_add) {

          $this->session->set_flashData('message', "Data Added Successfully.");
          redirect('admin/session-year/', 'refresh');
        } else {

          $this->session->set_flashData('message', "Data Add Failed.");
          redirect('admin/session-year/', 'refresh');
        }
      }
    } else if ($param1 == 'edit' && $param2 > 0) {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $update_session_year['session_year']     = $this->input->post('session_year', true);



        if ($this->AccountsModel->session_year_update($update_session_year, $param2)) {

          $this->session->set_flashData('message', "Data Updated Successfully.");
          redirect('admin/session_year', 'refresh');
        } else {

          $this->session->set_flashData('message', "Data Update Failed.");
          redirect('admin/session_year', 'refresh');
        }
      }

      $data['session_year_info'] = $this->db->get_where('tbl_session_year', array('id' => $param2));

      if ($data['session_year_info']->num_rows() > 0) {

        $data['session_year_info']    = $data['session_year_info']->row();
        $data['session_year_id'] = $param2;
      } else {

        $this->session->set_flashData('message', "Wrong Attempt !");
        redirect('admin/session_year', 'refresh');
      }
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AccountsModel->delete_session_year($param2)) {

        $this->session->set_flashData('message', "Data Deleted Successfully.");
        redirect('admin/session_year', 'refresh');
      } else {

        $this->session->set_flashData('message', "Data Delete Failed.");
        redirect('admin/session_year', 'refresh');
      }
    }

    $data['title']      = 'Session Year';
    $data['activeMenu'] = 'session_year';
    $data['page']       = 'backEnd/admin/session_year';
    $data['session_year_list'] = $this->db->order_by('id', 'desc')->get('tbl_session_year')->result();

    $this->load->view('backEnd/master_page', $data);
  }

  //Income Invoice
  public function income_invoice($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if ($this->input->post('invoice_date', true)) {

          $insert_income_invoice['invoice_date']       = date('Y-m-d', strtotime($this->input->post('invoice_date', true)));
        }

        $insert_income_invoice['membership_number']  = $this->input->post('membership_number', true);
        $insert_income_invoice['total_amount']       = $this->input->post('total_amount', true);
        $insert_income_invoice['approve_status']     = $this->input->post('approve_status', true);
        $insert_income_invoice['insert_by']          = $_SESSION['userid'];
        $insert_income_invoice['insert_time']      = date('Y-m-d H:i:s');

        $add_income_invoice = $this->db->insert('tbl_income_invoice', $insert_income_invoice);

        if ($add_income_invoice) {

          $this->session->set_flashData('message', 'Data Created Successfully!');
          redirect('admin/income-invoice/list', 'refresh');
        } else {

          $this->session->set_flashData('message', 'Data Created Failed!');
          redirect('admin/income-invoice', 'refresh');
        }
      }


      $data['title']         = 'Income Invoice Add';
      $data['page']          = 'backEnd/admin/income_invoice';
      $data['activeMenu']    = 'income_invoice';
    } elseif ($param1 == 'edit' && (int) $param2 > 0) {

      $check_table_row = $this->db->where('id', $param2)->get('tbl_income_invoice');

      if ($check_table_row->num_rows() > 0) {

        $data['income_invoice_info'] = $check_table_row->row();


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          if ($this->input->post('invoice_date', true)) {

            $update_income_invoice['invoice_date']       = date('Y-m-d', strtotime($this->input->post('invoice_date', true)));
          }

          $update_income_invoice['membership_number']  = $this->input->post('membership_number', true);
          $update_income_invoice['total_amount']       = $this->input->post('total_amount', true);
          $update_income_invoice['approve_status']     = $this->input->post('approve_status', true);




          if ($this->AccountsModel->get_income_invoice_update($update_income_invoice, $param2)) {

            $this->session->set_flashData('message', 'Data Updated Successfully!');
            redirect('admin/income-invoice/list', 'refresh');
          } else {

            $this->session->set_flashData('message', 'Data Update Failed!');
            redirect('admin/income-invoice/list', 'refresh');
          }

          $this->session->set_flashData('message', 'Data Updated Successfully');
          redirect('admin/income-invoice/list', 'refresh');
        }
      }


      $data['title']         = 'Income Invoice Update';
      $data['page']          = 'backEnd/admin/income_invoice';
      $data['activeMenu']    = 'income_invoice';
    } elseif ($param1 == 'list') {

      $config = array();
      $config["base_url"] = base_url("admin/income-invoice/list");
      $config["total_rows"] = $this->db->get(' tbl_income_invoice')->num_rows();
      $config["per_page"] = 10;
      $config["uri_segment"] = 4;

      //custom
      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';

      $config['first_link'] = "First";
      $config['last_link'] = "Last";

      $config['first_tag_open'] = '<li>';
      $config['first_tag_close'] = '</li>';

      $config['prev_link'] = '«';
      $config['prev_tag_open'] = '<li class="prev">';
      $config['prev_tag_close'] = '</li>';

      $config['next_link'] = '»';
      $config['next_tag_open'] = '<li>';
      $config['next_tag_close'] = '</li>';

      $config['last_tag_open'] = '<li>';
      $config['last_tag_close'] = '</li>';

      $config['cur_tag_open'] = '<li class="active"><a href="#">';
      $config['cur_tag_close'] = '</a></li>';
      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';

      $this->pagination->initialize($config);

      $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

      $data["links"] = $this->pagination->create_links();

      $data['income_invoice_list'] = $this->AccountsModel->get_income_invoice_list($config["per_page"], $page);

      $data['new_serial'] = $page;

      $data['title']      = 'Income Invoice List';
      $data['page']       = 'backEnd/admin/income_invoice';
      $data['activeMenu'] = 'income_invoice';
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AccountsModel->income_invoice_delete($param2)) {

        $this->session->set_flashData('message', 'Data Deleted Successfully!');
        redirect('admin/income-invoice/list', 'refresh');
      } else {

        $this->session->set_flashData('message', 'Data Deleted Failed!');
        redirect('admin/income-invoice/list', 'refresh');
      }
    } else {

      $this->session->set_flashData('message', 'Wrong Attempt!');
      redirect('admin/income-invoice/list', 'refresh');
    }


    $this->load->view('backEnd/master_page', $data);
  }

  //Income Category
  public function income_category($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_income_category['category_name']      = $this->input->post('category_name', true);
        $insert_income_category['fee_amount']         = $this->input->post('fee_amount', true);
        $insert_income_category['priority']           = $this->input->post('priority', true);
        $insert_income_category['insert_by']           = $_SESSION['userid'];
        $insert_income_category['insert_time']       = date('Y-m-d H:i:s');

        if (!empty($_FILES['icon']['name'])) {

          $path_parts                 = pathinfo($_FILES["icon"]['name']);
          $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newFile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/incomeCategory/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('icon')) {
          } else {

            $upload_c = $this->upload->data();
            $insert_income_category['icon'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($insert_income_category['icon'], 400, 400);
          }
        }

        $income_category = $this->db->insert('tbl_income_category', $insert_income_category);

        if ($income_category) {

          $this->session->set_flashData('message', 'Data Created Successfully!');
          redirect('admin/income_category/list', 'refresh');
        } else {

          $this->session->set_flashData('message', 'Data Created Failed!');
          redirect('admin/income_category', 'refresh');
        }
      }


      $data['title']         = 'Income Category Add';
      $data['page']          = 'backEnd/admin/income_category';
      $data['activeMenu']    = 'income_category';
    } elseif ($param1 == 'edit' && (int) $param2 > 0) {

      $check_table_row = $this->db->where('id', $param2)->get('tbl_income_category');

      if ($check_table_row->num_rows() > 0) {

        $data['income_category_info'] = $check_table_row->row();


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          $update_income_category['category_name']      = $this->input->post('category_name', true);
          $update_income_category['fee_amount']         = $this->input->post('fee_amount', true);
          $update_income_category['priority']           = $this->input->post('priority', true);

          if (!empty($_FILES['icon']['name'])) {

            $path_parts                 = pathinfo($_FILES["icon"]['name']);
            $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
            $dir                        = date("YmdHis", time());
            $config_c['file_name']      = $newFile_name . '_' . $dir;
            $config_c['remove_spaces']  = TRUE;
            $config_c['upload_path']    = 'assets/incomeCategory/';
            $config_c['max_size']       = '20000'; //  less than 20 MB
            $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

            $this->load->library('upload', $config_c);
            $this->upload->initialize($config_c);
            if (!$this->upload->do_upload('icon')) {
            } else {

              $upload_c = $this->upload->data();
              $update_income_category['icon'] = $config_c['upload_path'] . $upload_c['file_name'];
              $this->image_size_fix($update_income_category['icon'], 400, 400);
            }
          }


          if ($this->AccountsModel->get_income_category_update($update_income_category, $param2)) {

            $this->session->set_flashData('message', 'Data Updated Successfully!');
            redirect('admin/income-category/list', 'refresh');
          } else {

            $this->session->set_flashData('message', 'Data Update Failed!');
            redirect('admin/income-category/list', 'refresh');
          }

          $this->session->set_flashData('message', 'Data Updated Successfully');
          redirect('admin/income-category/list', 'refresh');
        }
      }


      $data['title']         = 'Video Gallery Update';
      $data['page']          = 'backEnd/admin/video_gallery_edit';
      $data['activeMenu']    = 'video_gallery_edit';
    } elseif ($param1 == 'list') {

      $config = array();
      $config["base_url"] = base_url("admin/income-category/list");
      $config["total_rows"] = $this->db->get('tbl_income_category')->num_rows();
      $config["per_page"] = 10;
      $config["uri_segment"] = 4;

      //custom
      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';

      $config['first_link'] = "First";
      $config['last_link'] = "Last";

      $config['first_tag_open'] = '<li>';
      $config['first_tag_close'] = '</li>';

      $config['prev_link'] = '«';
      $config['prev_tag_open'] = '<li class="prev">';
      $config['prev_tag_close'] = '</li>';

      $config['next_link'] = '»';
      $config['next_tag_open'] = '<li>';
      $config['next_tag_close'] = '</li>';

      $config['last_tag_open'] = '<li>';
      $config['last_tag_close'] = '</li>';

      $config['cur_tag_open'] = '<li class="active"><a href="#">';
      $config['cur_tag_close'] = '</a></li>';
      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';

      $this->pagination->initialize($config);

      $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

      $data["links"] = $this->pagination->create_links();

      $data['income_category_list'] = $this->AccountsModel->get_income_category_list($config["per_page"], $page);

      $data['new_serial'] = $page;

      $data['title']      = 'Income Category List';
      $data['page']       = 'backEnd/admin/income_category';
      $data['activeMenu'] = 'income_category';
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AccountsModel->income_category_delete($param2)) {

        $this->session->set_flashData('message', 'Data Deleted Successfully!');
        redirect('admin/income-category/list', 'refresh');
      } else {

        $this->session->set_flashData('message', 'Data Deleted Failed!');
        redirect('admin/income-category/list', 'refresh');
      }
    } else {

      $this->session->set_flashData('message', 'Wrong Attempt!');
      redirect('admin/income-category/list', 'refresh');
    }


    $this->load->view('backEnd/master_page', $data);
  }

  //video gallery
  public function video_gallery($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_video_gallery['video_album_id']       = $this->input->post('video_album_id', true);
        $insert_video_gallery['youtube_video_link']   = $this->input->post('youtube_video_link', true);
        $insert_video_gallery['title']                = $this->input->post('title', true);
        $insert_video_gallery['insert_by']            = $_SESSION['userid'];
        $insert_video_gallery['insert_time']          = date('Y-m-d H:i:s');

        $add_video_gallery = $this->db->insert('tbl_video_gallery', $insert_video_gallery);

        if ($add_video_gallery) {

          $this->session->set_flashData('message', 'Data Created Successfully!');
          redirect('admin/video-gallery/list', 'refresh');
        } else {

          $this->session->set_flashData('message', 'Data Created Failed!');
          redirect('admin/video-gallery', 'refresh');
        }
      }

      $data['video_album_list']  = $this->db->order_by('priority', 'desc')->get('tbl_video_album')->result();

      $data['title']         = 'Video Gallery Add';
      $data['page']          = 'backEnd/admin/video_gallery_add';
      $data['activeMenu']    = 'video_gallery_add';
    } elseif ($param1 == 'edit' && (int) $param2 > 0) {

      $check_table_row = $this->db->where('id', $param2)->get('tbl_video_gallery');

      if ($check_table_row->num_rows() > 0) {

        $data['video_gallery_info'] = $check_table_row->row();


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          $update_video_gallery['video_album_id']         = $this->input->post('video_album_id', true);
          $update_video_gallery['youtube_video_link']     = $this->input->post('youtube_video_link', true);
          $update_video_gallery['title']                  = $this->input->post('title', true);




          if ($this->AdminModel->get_video_gallery_update($update_video_gallery, $param2)) {

            $this->session->set_flashData('message', 'Data Updated Successfully!');
            redirect('admin/video-gallery/list', 'refresh');
          } else {

            $this->session->set_flashData('message', 'Data Update Failed!');
            redirect('admin/video-gallery/list', 'refresh');
          }

          $this->session->set_flashData('message', 'Data Updated Successfully');
          redirect('admin/video-gallery/list', 'refresh');
        }
      }

      $data['video_album_list']  = $this->db->order_by('priority', 'desc')->get('tbl_video_album')->result();

      $data['title']         = 'Video Gallery Update';
      $data['page']          = 'backEnd/admin/video_gallery_edit';
      $data['activeMenu']    = 'video_gallery_edit';
    } elseif ($param1 == 'list') {

      $config = array();
      $config["base_url"] = base_url("admin/video-gallery/list");
      $config["total_rows"] = $this->db->get(' tbl_video_gallery')->num_rows();
      $config["per_page"] = 10;
      $config["uri_segment"] = 4;

      //custom
      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';

      $config['first_link'] = "First";
      $config['last_link'] = "Last";

      $config['first_tag_open'] = '<li>';
      $config['first_tag_close'] = '</li>';

      $config['prev_link'] = '«';
      $config['prev_tag_open'] = '<li class="prev">';
      $config['prev_tag_close'] = '</li>';

      $config['next_link'] = '»';
      $config['next_tag_open'] = '<li>';
      $config['next_tag_close'] = '</li>';

      $config['last_tag_open'] = '<li>';
      $config['last_tag_close'] = '</li>';

      $config['cur_tag_open'] = '<li class="active"><a href="#">';
      $config['cur_tag_close'] = '</a></li>';
      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';

      $this->pagination->initialize($config);

      $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

      $data["links"] = $this->pagination->create_links();

      $data['video_gallery_list'] = $this->AdminModel->get_video_gallery_list($config["per_page"], $page);

      $data['new_serial'] = $page;

      $data['title']      = 'Video Gallery List';
      $data['page']       = 'backEnd/admin/video_gallery_list';
      $data['activeMenu'] = 'video_gallery_list';
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->video_gallery_delete($param2)) {

        $this->session->set_flashData('message', 'Data Deleted Successfully!');
        redirect('admin/video-gallery/list', 'refresh');
      } else {

        $this->session->set_flashData('message', 'Data Deleted Failed!');
        redirect('admin/video-gallery/list', 'refresh');
      }
    } else {

      $this->session->set_flashData('message', 'Wrong Attempt!');
      redirect('admin/video-gallery/list', 'refresh');
    }


    $this->load->view('backEnd/master_page', $data);
  }

  //File Labrary
  public function file_library($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_file_library['title']         = $this->input->post('title', true);
        $insert_file_library['insert_by']     = $_SESSION['userid'];
        $insert_file_library['insert_time']   = date('Y-m-d H:i:s');

        if (!empty($_FILES['file_path']['name'])) {

          $path_parts                 = pathinfo($_FILES["file_path"]['name']);
          $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newFile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/fileLibrary/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('file_path')) {
          } else {

            $upload_c = $this->upload->data();
            $insert_file_library['file_path'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($insert_file_library['file_path'], 600, 800);
          }
        }

        $add_file_path = $this->db->insert('tbl_file_library', $insert_file_library);

        if ($add_file_path) {

          $this->session->set_flashData('message', 'Data Created Successfully!');
          redirect('admin/file-library/list', 'refresh');
        } else {

          $this->session->set_flashData('message', 'Data Created Failed!');
          redirect('admin/file-library', 'refresh');
        }
      }


      $data['title']         = 'File Library Add';
      $data['page']          = 'backEnd/admin/file_library_add';
      $data['activeMenu']    = 'file_library_add';
    } elseif ($param1 == 'edit' && (int) $param2 > 0) {

      $check_table_row = $this->db->where('id', $param2)->get('tbl_file_library');

      if ($check_table_row->num_rows() > 0) {

        $data['file_library_info'] = $check_table_row->row();


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          $update_file_library['title']         = $this->input->post('title', true);

          if (!empty($_FILES['file_path']['name'])) {

            $path_parts                 = pathinfo($_FILES["file_path"]['name']);
            $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
            $dir                        = date("YmdHis", time());
            $config_c['file_name']      = $newFile_name . '_' . $dir;
            $config_c['remove_spaces']  = TRUE;
            $config_c['upload_path']    = 'assets/fileLibrary/';
            $config_c['max_size']       = '20000'; //  less than 20 MB
            $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

            $this->load->library('upload', $config_c);
            $this->upload->initialize($config_c);
            if (!$this->upload->do_upload('file_path')) {
            } else {

              $upload_c = $this->upload->data();
              $update_file_library['file_path'] = $config_c['upload_path'] . $upload_c['file_name'];
              $this->image_size_fix($update_file_library['file_path'], 600, 800);
            }
          }



          if ($this->AdminModel->get_file_library_update($update_file_library, $param2)) {

            $this->session->set_flashData('message', 'Data Updated Successfully!');
            redirect('admin/file-library/list', 'refresh');
          } else {

            $this->session->set_flashData('message', 'Data Update Failed!');
            redirect('admin/file-library/list', 'refresh');
          }

          $this->session->set_flashData('message', 'Data Updated Successfully');
          redirect('admin/file-library/list', 'refresh');
        }
      }

      $data['title']         = 'File Library Update';
      $data['page']          = 'backEnd/admin/file_library_edit';
      $data['activeMenu']    = 'file_library_edit';
    } elseif ($param1 == 'list') {

      $config = array();
      $config["base_url"] = base_url("admin/file-library/list");
      $config["total_rows"] = $this->db->get(' tbl_file_library')->num_rows();
      $config["per_page"] = 10;
      $config["uri_segment"] = 4;

      //custom
      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';

      $config['first_link'] = "First";
      $config['last_link'] = "Last";

      $config['first_tag_open'] = '<li>';
      $config['first_tag_close'] = '</li>';

      $config['prev_link'] = '«';
      $config['prev_tag_open'] = '<li class="prev">';
      $config['prev_tag_close'] = '</li>';

      $config['next_link'] = '»';
      $config['next_tag_open'] = '<li>';
      $config['next_tag_close'] = '</li>';

      $config['last_tag_open'] = '<li>';
      $config['last_tag_close'] = '</li>';

      $config['cur_tag_open'] = '<li class="active"><a href="#">';
      $config['cur_tag_close'] = '</a></li>';
      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';

      $this->pagination->initialize($config);

      $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

      $data["links"] = $this->pagination->create_links();

      $data['file_library_list'] = $this->AdminModel->get_file_library_list($config["per_page"], $page);

      $data['new_serial'] = $page;

      $data['title']      = 'File Libray List';
      $data['page']       = 'backEnd/admin/file_library_list';
      $data['activeMenu'] = 'file_library_list';
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->file_library_delete($param2)) {

        $this->session->set_flashData('message', 'Data Deleted Successfully!');
        redirect('admin/file-library/list', 'refresh');
      } else {

        $this->session->set_flashData('message', 'Data Deleted Failed!');
        redirect('admin/file-library/list', 'refresh');
      }
    } else {

      $this->session->set_flashData('message', 'Wrong Attempt!');
      redirect('admin/file-library/list', 'refresh');
    }


    $this->load->view('backEnd/master_page', $data);
  }

  //Photo Album
  public function photo_album($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_photo_album['album_title']      = $this->input->post('album_title', true);
        $insert_photo_album['priority']         = $this->input->post('priority', true);
        $insert_photo_album['insert_time']      = $_SESSION['userid'];
        $insert_photo_album['insert_by']         = date('Y-m-d H:i:s');


        $video_album_add = $this->db->insert('tbl_photo_album', $insert_photo_album);

        if ($video_album_add) {

          $this->session->set_flashData('message', "Data Added Successfully.");
          redirect('admin/photo-album/', 'refresh');
        } else {

          $this->session->set_flashData('message', "Data Add Failed.");
          redirect('admin/photo-album/', 'refresh');
        }
      }
    } else if ($param1 == 'edit' && $param2 > 0) {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $update_photo_album['album_title']      = $this->input->post('album_title', true);
        $update_photo_album['priority']         = $this->input->post('priority', true);


        if ($this->AdminModel->photo_album_update($update_photo_album, $param2)) {

          $this->session->set_flashData('message', "Data Updated Successfully.");
          redirect('admin/photo-album', 'refresh');
        } else {

          $this->session->set_flashData('message', "Data Update Failed.");
          redirect('admin/photo-album', 'refresh');
        }
      }

      $data['photo_album_info'] = $this->db->get_where('tbl_photo_album', array('id' => $param2));

      if ($data['photo_album_info']->num_rows() > 0) {

        $data['photo_album_info']    = $data['photo_album_info']->row();
        $data['photo_album_id'] = $param2;
      } else {

        $this->session->set_flashData('message', "Wrong Attempt !");
        redirect('admin/photo-album', 'refresh');
      }
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->delete_photo_album($param2)) {

        $this->session->set_flashData('message', "Data Deleted Successfully.");
        redirect('admin/photo-album', 'refresh');
      } else {

        $this->session->set_flashData('message', "Data Delete Failed.");
        redirect('admin/photo-album', 'refresh');
      }
    }

    $data['title']            = 'photo Album';
    $data['activeMenu']       = 'photo_album';
    $data['page']             = 'backEnd/admin/photo_album';
    $data['photo_album_list'] = $this->db->order_by('priority', 'desc')->get('tbl_photo_album')->result();

    $this->load->view('backEnd/master_page', $data);
  }

  //Photo Gallery
  public function photo_gallery($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_photo_gallery['photo_album_id']    = $this->input->post('photo_album_id', true);
        $insert_photo_gallery['title']            = $this->input->post('title', true);
        $insert_photo_gallery['insert_by']          = $_SESSION['userid'];
        $insert_photo_gallery['insert_time']      = date('Y-m-d H:i:s');

        if (!empty($_FILES['photo_file']['name'])) {

          $path_parts                 = pathinfo($_FILES["photo_file"]['name']);
          $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newFile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/photoGallery/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('photo_file')) {
          } else {

            $upload_c = $this->upload->data();
            $insert_photo_gallery['photo_file'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($insert_photo_gallery['photo_file'], 400, 400);
          }
        }



        $add_photo_gallery = $this->db->insert('tbl_photo_gallery', $insert_photo_gallery);

        if ($add_photo_gallery) {

          $this->session->set_flashData('message', 'Data Created Successfully!');
          redirect('admin/photo-gallery/list', 'refresh');
        } else {

          $this->session->set_flashData('message', 'Data Created Failed!');
          redirect('admin/photo-gallery', 'refresh');
        }
      }

      $data['photo_album_list']  = $this->db->order_by('id', 'desc')->get('tbl_photo_album')->result();

      $data['title']         = 'Photo Gallery Add';
      $data['page']          = 'backEnd/admin/photo_gallery_add';
      $data['activeMenu']    = 'photo_gallery_add';
    } elseif ($param1 == 'edit' && (int) $param2 > 0) {

      $check_table_row = $this->db->where('id', $param2)->get('tbl_photo_gallery');

      if ($check_table_row->num_rows() > 0) {

        $data['photo_gallery_info'] = $check_table_row->row();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          $update_photo_gallery['photo_album_id']    = $this->input->post('photo_album_id', true);
          $update_photo_gallery['title']            = $this->input->post('title', true);

          if (!empty($_FILES['photo_file']['name'])) {

            $path_parts                 = pathinfo($_FILES["photo_file"]['name']);
            $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
            $dir                        = date("YmdHis", time());
            $config_c['file_name']      = $newFile_name . '_' . $dir;
            $config_c['remove_spaces']  = TRUE;
            $config_c['upload_path']    = 'assets/photoGallery/';
            $config_c['max_size']       = '20000'; //  less than 20 MB
            $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

            $this->load->library('upload', $config_c);
            $this->upload->initialize($config_c);

            if (!$this->upload->do_upload('photo_file')) {
            } else {

              $upload_c = $this->upload->data();
              $update_photo_gallery['photo_file'] = $config_c['upload_path'] . $upload_c['file_name'];
              $this->image_size_fix($update_photo_gallery['photo_file'], 400, 400);
            }
          }


          if ($this->AdminModel->photo_gallery_update($update_photo_gallery, $param2)) {

            $this->session->set_flashData('message', 'Data Updated Successfully!');
            redirect('admin/photo-gallery/list', 'refresh');
          } else {

            $this->session->set_flashData('message', 'Data Update Failed!');
            redirect('admin/photo-gallery/list', 'refresh');
          }

          $this->session->set_flashData('message', 'Data Updated Successfully');
          redirect('admin/photo-gallery/list', 'refresh');
        }
      }

      $data['photo_album_list']  = $this->db->order_by('id', 'desc')->get('tbl_photo_album')->result();

      $data['title']         = 'Photo Gallery Update';
      $data['page']          = 'backEnd/admin/photo_gallery_edit';
      $data['activeMenu']    = 'photo_gallery_edit';
    } elseif ($param1 == 'list') {

      $config = array();
      $config["base_url"] = base_url("admin/photo-gallery/list");
      $config["total_rows"] = $this->db->get(' tbl_photo_gallery')->num_rows();
      $config["per_page"] = 10;
      $config["uri_segment"] = 4;

      //custom
      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';

      $config['first_link'] = "First";
      $config['last_link'] = "Last";

      $config['first_tag_open'] = '<li>';
      $config['first_tag_close'] = '</li>';

      $config['prev_link'] = '«';
      $config['prev_tag_open'] = '<li class="prev">';
      $config['prev_tag_close'] = '</li>';

      $config['next_link'] = '»';
      $config['next_tag_open'] = '<li>';
      $config['next_tag_close'] = '</li>';

      $config['last_tag_open'] = '<li>';
      $config['last_tag_close'] = '</li>';

      $config['cur_tag_open'] = '<li class="active"><a href="#">';
      $config['cur_tag_close'] = '</a></li>';
      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';

      $this->pagination->initialize($config);

      $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

      $data["links"] = $this->pagination->create_links();

      $data['photo_gallery_list'] = $this->AdminModel->get_photo_gallery_list($config["per_page"], $page);

      $data['new_serial'] = $page;

      $data['title']      = 'Photo Gallery List';
      $data['page']       = 'backEnd/admin/photo_gallery_list';
      $data['activeMenu'] = 'photo_gallery_list';
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->photo_gallery_delete($param2)) {

        $this->session->set_flashData('message', 'Data Deleted Successfully!');
        redirect('admin/photo-gallery/list', 'refresh');
      } else {

        $this->session->set_flashData('message', 'Data Deleted Failed!');
        redirect('admin/photo-gallery/list', 'refresh');
      }
    } else {

      $this->session->set_flashData('message', 'Wrong Attempt!');
      redirect('admin/photo-gallery/list', 'refresh');
    }


    $this->load->view('backEnd/master_page', $data);
  }

  public function page_settings($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $page_settings_data['name']           = $this->input->post('name', true);
        $page_settings_data['title']          = $this->input->post('title', true);
        $page_settings_data['body']           = $this->input->post('body');
        $page_settings_data['is_menu']        = $this->input->post('is_menu', true);
        $page_settings_data['priority']       = $this->input->post('priority', true);
        $page_settings_data['parent_page_id'] = $this->input->post('parent_page_id', true);

        if (!empty($_FILES["attatched"]['name'])) {

          //exta work
          $path_parts                 = pathinfo($_FILES["attatched"]['name']);
          $newFile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config['file_name']      = $newFile_name . '_' . $dir;
          $config['remove_spaces']  = TRUE;
          $config['upload_path']    = 'assets/pageSettings/';
          $config['max_size']       = '20000'; //  less than 20 MB
          $config['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG|pdf|docx';

          $this->load->library('upload', $config);
          $this->upload->initialize($config);
          if (!$this->upload->do_upload('attatched')) {
          } else {

            $upload = $this->upload->data();
            $page_settings_data['attatched']   = $config['upload_path'] . $upload['file_name'];

            $file_parts = pathinfo($page_settings_data['attatched']);
            if ($file_parts['extension'] != "pdf") {
              $this->image_size_fix($page_settings_data['attatched'], $width = 440, $height = 320);
            }
          }
        }

        $check_name_exist = $this->db->where('name', $page_settings_data['name'])->get('tbl_common_pages');
        if ($check_name_exist->num_rows() > 0) {

          $this->session->set_flashData('message', 'This Page Already Exists!');
          redirect('admin/page_settings', 'refresh');
        } else {

          $page_settings = $this->db->insert('tbl_common_pages', $page_settings_data);

          if ($page_settings) {

            $this->session->set_flashData('message', 'Page Created Successfully!');
            redirect('admin/page_settings', 'refresh');
          } else {

            $this->session->set_flashData('message', 'Page Create Failed!');
            redirect('admin/page_settings', 'refresh');
          }
        }
      }

      $data['title']         = 'Page Setting Add';
      $data['page']          = 'backEnd/admin/page_settings_add';
      $data['activeMenu']    = 'page_settings_add';
      $data['page_settings'] = $this->db->select('id, name')->get('tbl_common_pages')->result();
    } elseif ($param1 == 'edit' && (int) $param2 > 0) {

      $data['table_info']    = $this->db->where('id', $param2)->get('tbl_common_pages')->row();
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //exta work
        $path_parts                   = pathinfo($_FILES["attatched"]['name']);
        $newFile_name                 = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
        $dir                          = date("YmdHis", time());
        $config['file_name']          = $newFile_name . '_' . $dir;
        $config['remove_spaces']      = TRUE;
        $config['max_size']           = '20000'; //  less than 20 MB
        $config['allowed_types']      = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG|pdf|docx';
        $config['upload_path']        = 'assets/pageSettings';

        $old_file_url                   = $data['table_info'];
        $update_data['title']           = $this->input->post('title', true);
        $update_data['body']            = $this->input->post('body');
        $update_data['is_menu']         = $this->input->post('is_menu', true);
        $update_data['priority']        = $this->input->post('priority', true);
        $update_data['parent_page_id']  = $this->input->post('parent_page_id', true);

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('attatched')) {

          $this->session->set_flashData('message', 'Data Updated Successfully');
          $this->db->where('id', $param2)->update('tbl_common_pages', $update_data);

          redirect('admin/page_settings/list', 'refresh');
        } else {

          $upload = $this->upload->data();

          $update_data['attatched'] = $config['upload_path'] . '/' . $upload['file_name'];
          $this->db->where('id', $param2)->update('tbl_common_pages', $update_data);
          $file_parts = pathinfo($update_data['attatched']);
          if ($file_parts['extension'] != "pdf") {
            $this->image_size_fix($update_data['attatched'], $width = 440, $height = 320);
          }
          if (file_exists($old_file_url->attatched)) unlink($old_file_url->attatched);
          $this->session->set_flashData('message', 'Data Updated Successfully');
          redirect('admin/page_settings/list', 'refresh');
        }
      }



      $data['page_settings'] = $this->db->select('id, name')->where('id !=', $param2)->get('tbl_common_pages')->result();



      $data['title']         = 'Page Setting Update';
      $data['page']          = 'backEnd/admin/page_settings_edit';
      $data['activeMenu']    = 'page_settings_edit';
    } elseif ($param1 == 'list') {

      $data['title']      = 'Page Setting List';
      $data['page']       = 'backEnd/admin/page_settings_list';
      $data['activeMenu'] = 'page_settings_list';
      $data['table_info'] = $this->db->get('tbl_common_pages')->result_array();
    } elseif ($param1 == 'delete' && (int) $param2 > 0) {

      $attatched = $this->db->where('id', $param2)->get('tbl_common_pages')->row()->attatched;

      if (file_exists($attatched)) {

        unlink($attatched);
      }

      $page_settings_delete = $this->db->where('id', $param2)->delete('tbl_common_pages');



      if ($page_settings_delete) {

        $this->session->set_flashData('message', 'Page Deleted Successfully!');
        redirect('admin/page_settings/list', 'refresh');
      } else {

        $this->session->set_flashData('message', 'Page Delete Failed!');
        redirect('admin/page_settings/list', 'refresh');
      }
    } else {

      $this->session->set_flashData('message', 'Wrong Attempt!');
      redirect('admin/page_settings/list', 'refresh');
    }

    $this->load->view('backEnd/master_page', $data);
  }

  public function sms_send($param1 = 'list', $param2 = '', $param3 = '')
  {
    if ($param1 == 'list') {

      $data['title']         = 'SMS Send';
      $data['activeMenu']    = 'sms_send';
      $data['page']          = 'backEnd/admin/sms_send_list';
      //$data['sms_send_list'] = $this->db->order_by('send_date_time','desc')->get('tbl_sms_send_list')->result();


    } elseif ($param1 == 'setting') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $setting_data['username'] = $this->input->post('username', true);
        $setting_data['password'] = $this->input->post('password', true);

        $update_setting = $this->db->where('id', 1)->update('tbl_sms_send_setting', $setting_data);

        if ($update_setting) {

          $this->session->set_flashData('message', 'SMS Setting Updated Successfully!');
          redirect('admin/sms_send/setting', 'refresh');
        } else {

          $this->session->set_flashData('message', 'SMS Setting Update Failed!');
          redirect('admin/sms_send/setting', 'refresh');
        }
      }

      $data['title']        = 'SMS Send';
      $data['activeMenu']   = 'sms_send';
      $data['page']         = 'backEnd/admin/sms_send_setting';
      //$data['setting_info'] = $this->db->where('id',1)->get('tbl_sms_send_setting')->row();

    } elseif ($param1 == 'new_sms') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $sms_send_data['send_date_time']   = date('Y-m-d H:i:s');
        $sms_send_data['message']          = $this->input->post('message', true);
        $sms_send_data['receiver_numbers'] = $this->input->post('receiver_numbers', true);
        $sms_send_data['insert_by']        = $_SESSION['userid'];

        $sms_send_add = $this->db->insert('tbl_sms_send_list', $sms_send_data);

        if ($sms_send_add) {

          $this->session->set_flashData('message', 'Message Send Successfully!');
          redirect('admin/sms_send/new_sms', 'refresh');
        } else {

          $this->session->set_flashData('message', 'Message Send Failed!');
          redirect('admin/sms_send/new_sms', 'refresh');
        }
      }

      $data['title']         = 'SMS Send';
      $data['activeMenu']    = 'sms_send';
      $data['page']          = 'backEnd/admin/sms_send_new';
    } else {

      $this->session->set_flashData('message', 'Wrong Attempt!');
      redirect('admin/sms_send/list', 'refresh');
    }

    $this->load->view('backEnd/master_page', $data);
  }

  public function get_sms_number($sms_to)
  {
    if ($sms_to == 1) {

      $result = $this->db->select('mobile')->get('tbl_members')->result();

      $mobile = '';

      foreach ($result as $key => $value) {

        if ($mobile != '') if ($value->mobile != '') $mobile .= ',';
        $mobile .= $value->mobile;
      }

      echo json_encode($mobile, JSON_UNESCAPED_UNICODE);
    } else {

      $result = $this->db->select('phone as mobile')->get('tbl_committee')->result();

      $mobile = '';

      foreach ($result as $key => $value) {

        if ($mobile != '') if ($value->mobile != '') $mobile .= ',';
        $mobile .= $value->mobile;
      }
      echo json_encode($mobile, JSON_UNESCAPED_UNICODE);
    }
  }

  public function mail_setting()
  {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      foreach ($this->input->post('mail_setting_id', true) as $key => $id_value) {

        $id    = $id_value;
        $value = $this->input->post('value', true)[$key];

        $this->db->where('id', $id)->update('tbl_mail_send_setting', array('value' => $value));
      }

      $this->session->set_flashData('message', 'Mail Send Setting Updated Successfully!');
      redirect('admin/mail_setting', 'refresh');
    }

    $data['title']             = 'Mail Setting';
    $data['activeMenu']        = 'mail_setting';
    $data['page']              = 'backEnd/admin/mail_setting';
    $data['mail_setting_info'] = $this->db->get('tbl_mail_send_setting')->result();
    $this->load->view('backEnd/master_page', $data);
  }
}
