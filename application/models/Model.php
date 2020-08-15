<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model extends CI_Model
{
	public function add_student($table,$data)
	{
		$this->db->insert($table,$data);
	}
	public function select_student_login($table,$email,$password)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('email',$email);
		$this->db->where('password',$password);
		if($data=$this->db->get())
		{
			return $data->row_array();
		}
		else
		{
			return false;
		}
	}
	public function student_details($table,$id)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('student_id',$id);
		$data=$this->db->get();
		return $data->result();
	}
	public function student_detail($table,$id)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('student_id',$id);
		$data=$this->db->get();
		return $data->result();
	}
	public function collect_student_details($table,$id)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('student_id',$id);
		$data=$this->db->get();
		return $data->result();
	}
	public function update_profile($table,$data,$id)
	{
		$this->db->where('student_id',$id);
		$this->db->set($data);
		$this->db->update($table);
	}

	//faculty
	public function add_faculty($table,$data)
	{
		$this->db->insert($table,$data);
	}
	public function select_faculty_login($table,$faculty_email,$faculty_password)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('faculty_email',$faculty_email);
		$this->db->where('faculty_password',$faculty_password);
		$this->db->where('status=','confirmed');
		if($data=$this->db->get())
		{
			return $data->row_array();
		}
		else
		{
			return false;
		}
	}
	public function faculty_details($table,$id)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('faculty_id',$id);
		$data=$this->db->get();
		return $data->result();
	}
	public function faculty_my_profile($table,$id)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('faculty_id',$id);
		$data=$this->db->get();
		return $data->result();
	}
	public function faculty_edit_profile($table,$id)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('faculty_id',$id);
		$data=$this->db->get();
		return $data->result();
	}
	public function faculty_profile_update($table,$data,$id)
	{
		$this->db->where('faculty_id',$id);
		$this->db->set($data);
		$this->db->update($table);
	}
	public function select_branch($table)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('branch_name','asc');
		$data=$this->db->get();
		return $data->result();
	}
	public function select_subject($table,$id)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('branch_ref',$id);
		$this->db->order_by('subject_name','asc');
		$data=$this->db->get();
		return $data->result();
	}
	public function select_registered_course($branch_id,$subject_id)
	{
		$this->db->select('branch.*,subject.*');
		$this->db->from('branch');
		$this->db->join('subject','branch.branch_id=subject.branch_ref');
		$this->db->where('subject.subject_id=',$subject_id);
		$data=$this->db->get();
		return $data->result();	
	}
	public function insert_registerd_course($table,$data)
	{
		$this->db->insert($table,$data);
	}
	public function faculty_view_registered_subjects($table,$id)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('faculty_ref',$id);
		$data=$this->db->get();
		return $data->result();
	}
	public function course_delete($table,$id)
	{
		$this->db->where('course_id',$id);
		$this->db->delete($table);
	}
	public function select_student_details($id)
	{
		$this->db->select('student.*,selected_course.*,faculty.*');
		$this->db->from('student');
		$this->db->join('selected_course','selected_course.branch_name=student.branch');
		$this->db->join('faculty','faculty.faculty_id=selected_course.faculty_ref');
		$this->db->where('student_id=',$id);
		$data=$this->db->get();
		return $data->result();
	}
	public function feedback($course_id,$student_id)
	{
		$this->db->select('selected_course.*,faculty.*,student.*');
		$this->db->from('selected_course');
		$this->db->join('faculty','faculty.faculty_id=selected_course.faculty_ref');
		$this->db->join('student','student.branch=selected_course.branch_name');
		$this->db->where('selected_course.course_id=',$course_id);
		$this->db->where('student.student_id=',$student_id);
		$data=$this->db->get();
		return $data->result();
	}
	public function send_feedback_search($id,$searched_item)
	{
		$this->db->select('student.*,selected_course.*,faculty.*');
		$this->db->from('student');
		$this->db->join('selected_course','selected_course.branch_name=student.branch');
		$this->db->join('faculty','faculty.faculty_id=selected_course.faculty_ref');
		$this->db->where('student_id=',$id);
		$this->db->like('faculty.faculty_name',$searched_item);
		$this->db->or_like('selected_course.subject_name', $searched_item);
		$data=$this->db->get();
		return $data->result();
	}
	public function store_feedback($table,$data)
	{
		$this->db->insert($table,$data);
	}
	public function view_feedback($table,$id)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('faculty_reference',$id);
		$this->db->order_by('date','desc');
		$data=$this->db->get();
		return $data->result();
	}
	public function feedback_delete($table,$id)
	{
		$this->db->where('feedback_id',$id);
		$this->db->delete($table);
	}
	public function add_admin($table,$data)
	{
		$this->db->insert($table,$data);
	}
	public function select_admin_login($table,$admin_email,$admin_password)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('admin_email',$admin_email);
		$this->db->where('admin_password',$admin_password);
		if($data=$this->db->get())
		{
			return $data->row_array();
		}
		else
		{
			return false;
		}
	}
	public function admin_details($table,$id)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('admin_id',$id);
		$data=$this->db->get();
		return $data->result();
	}
	public function add_subjects($table)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('branch_name','asc');
		$data=$this->db->get();
		return $data->result();
	}
	public function add_new_subject($table,$data)
	{
		$this->db->insert($table,$data);
	}
	public function view_registered_courses()
	{
		$this->db->select('branch.*,subject.*');
		$this->db->from('branch');
		$this->db->join('subject','branch.branch_id=subject.branch_ref');
		$this->db->order_by('branch_name','asc');
		$data=$this->db->get();
		return $data->result();	
	}
	public function course_search($searcheditem)
	{
		$this->db->select('branch.*,subject.*');
		$this->db->from('branch');
		$this->db->join('subject','branch.branch_id=subject.branch_ref');
		$this->db->like('branch.branch_name',$searcheditem);
		$this->db->or_like('subject.subject_name', $searcheditem);
		$data=$this->db->get();
		return $data->result();
	}
	public function branch_subject_delete($table,$id)
	{
		$this->db->where('subject_id',$id);
		$this->db->delete($table);
	}
	public function view_registered_faculty($table)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('faculty_name','asc');
		$data=$this->db->get();
		return $data->result();
	}
	public function faculty_delete($table,$id)
	{
		$this->db->where('faculty_id',$id);
		$this->db->delete($table);
	}
	public function status_conformation($table,$data,$id)
	{
		$this->db->where('faculty_id',$id);
		$this->db->set($data);
		$this->db->update($table);
	}

}