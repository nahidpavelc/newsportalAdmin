<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
	class AccountsModel extends CI_Model{

        //Update Session Year
        public function session_year_update($update_session_year, $param2)
		{
			return $this->db->where('id',$param2)->update('tbl_session_year',$update_session_year);
		}

        //Delete Session year
        public function delete_session_year($param2)
		{
			return $this->db->where('id',$param2)->delete('tbl_session_year');
		}

        //Income Invoice Update
        public function get_income_invoice_update($update_income_invoice, $param2){

            return $this->db->where('id', $param2)->update('tbl_income_invoice', $update_income_invoice);
        }

        //Income Invoice List
        public function get_income_invoice_list($limit = 10, $start = 0){

            $results = array();

            $this->db->select('id,invoice_date,membership_number,total_amount,approve_status');
            $this->db->limit($limit, $start);
            $this->db->order_by('id', 'desc');
            $results = $this->db->get('tbl_income_invoice')->result();

            return $results;
            
        }

        //Income Invoice Delete
        public function income_invoice_delete($param2){

            return $this->db->where('id',$param2)->delete('tbl_income_invoice');
        }

        //Income Category Update
        public function get_income_category_update($update_income_category, $param2){

            if (isset($update_income_category['icon']) && file_exists($update_income_category['icon'])) {

				$result = $this->db->select('icon')
					->from('tbl_income_category')
					->where('id',$param2)
					->get()
					->row()->icon;

				if (file_exists($result)) {
					unlink($result);
				}
			}

			return $this->db->where('id',$param2)->update('tbl_income_category',$update_income_category);
        }

        //Income

    }