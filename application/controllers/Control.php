<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Model');
		$this->load->library('session');

	}
	public function index()
	{
		$this->load->view('home_page');
	}
	public function student()
	{
		$this->load->view('student_login');
	}
	public function student_register_page()
	{
		$this->load->view('student_register_page');
	}
	public function student_register()
	{
		$name=$this->input->post('name');
		$gender=$this->input->post('gender');
		$address=$this->input->post('address');
		$city=$this->input->post('city');
		$state=$this->input->post('state');
		$zip=$this->input->post('zip');
		$branch=$this->input->post('branch');
		$semester=$this->input->post('semester');
		$email=$this->input->post('email');
		$password=$this->input->post('password');

		$config['upload_path']='./image';
		$config['allowed_types']="*";
		$this->load->library('upload',$config);
		if(!$this->upload->do_upload('image'))
		{
			print_r($this->upload->display_errors());
		}
		else
		{
			$image=$this->upload->data();
			$img=$image['file_name'];

		}
		$data=array(
			'name'=>$name,
			'gender'=>$gender,
			'address'=>$address,
			'city'=>$city,
			'state'=>$state,
			'zip'=>$zip,
			'branch'=>$branch,
			'semester'=>$semester,
			'email'=>$email,
			'password'=>$password,
			'image'=>$img
		);

		$this->Model->add_student('student',$data);
		redirect(base_url('index.php/Control/student'));
	}
	public function student_login()
	{
		$email=$this->input->post('email');
		$password=$this->input->post('password');
		$login_data=$this->Model->select_student_login('student',$email,$password);

		if($login_data!=false)
		{
			$this->session->set_userdata('student_id',$login_data['student_id']);
			redirect(base_url('index.php/Control/student_logged_page'));
		}
		else
		{
			$this->session->set_flashdata('error','invalid email/password');
			redirect(base_url('index.php/Control/student'));
		}

	}
	public function student_logged_page()
	{
		if($this->session->userdata('student_id')!="")
		{
			$id=$this->session->userdata('student_id');
			$result['details']=$this->Model->student_details('student',$id);
			$this->load->view('student_logged_page',$result);
		}
		else
		{
			redirect(base_url('index.php/Control/student'));
		}
	}
	public function my_profile()
	{
		if($this->session->userdata('student_id')!="")
		{
			$id=$this->uri->segment(3);
			$result['details']=$this->Model->student_detail('student',$id);
			$this->load->view('my_profile',$result);

		}
		else
		{
			redirect(base_url('index.php/Control/student'));
		}
	}
	public function edit_profile()
	{
		if($this->session->userdata('student_id')!="")
		{
			$id=$this->uri->segment(3);
			$result['details']=$this->Model->collect_student_details('student',$id);
			$this->load->view('edit_profile',$result);
		}
		else
		{
			redirect(base_url('index.php/Control/student'));
		}
	}
	public function update_profile()
	{
		if($this->session->userdata('student_id')!="")
		{
			$id=$this->uri->segment(3);
			$name=$this->input->post('name');
			$gender=$this->input->post('gender');
			$address=$this->input->post('address');
			$city=$this->input->post('city');
			$state=$this->input->post('state');
			$zip=$this->input->post('zip');
			$branch=$this->input->post('branch');
			$semester=$this->input->post('semester');
			$email=$this->input->post('email');
			$password=$this->input->post('password');

			if($_FILES['image']['name']!="")
			{
				$config['upload_path']='./image/';
				$config['allowed_types']='*';
				$this->load->library('upload',$config);
				if(!$this->upload->do_upload('image'))
				{
					print_r($this->upload->display_errors());
				}
				else
				{
					$image=$this->upload->data();
					$img=$image['file_name'];
				}

				$data=array(
					'name'=>$name,
					'gender'=>$gender,
					'address'=>$address,
					'city'=>$city,
					'state'=>$state,
					'zip'=>$zip,
					'branch'=>$branch,
					'semester'=>$semester,
					'email'=>$email,
					'password'=>$password,
					'image'=>$img	
				);
			}
			else
			{
				$data=array(
					'name'=>$name,
					'gender'=>$gender,
					'address'=>$address,
					'city'=>$city,
					'state'=>$state,
					'zip'=>$zip,
					'branch'=>$branch,
					'semester'=>$semester,
					'email'=>$email,
					'password'=>$password
				);
			}

			$this->Model->update_profile('student',$data,$id);
			redirect(base_url('index.php/Control/student_logged_page'));
		}
		else
		{
			redirect(base_url('index.php/Control/student'));
		}
	}
	public function student_logout()
	{
		if($this->session->userdata('student_id')!="")
		{
			$this->session->sess_destroy();
			redirect(base_url('index.php/Control/student'));
		}
		else
		{
			redirect(base_url('index.php/Control/student'));
		}	
	}
	public function send_feedback()
	{
		if($this->session->userdata('student_id')!="")
		{
			$id=$this->session->userdata('student_id');
			$result['details']=$this->Model->select_student_details($id);
			// print_r($result['details']);
			// exit();
			$this->load->view('send_feedback',$result);
		}
		else
		{
			redirect(base_url('index.php/Control/student'));
		}
	}
	public function send_feedback_search()
	{
		if($this->session->userdata('student_id')!="")
		{
			$id=$this->session->userdata('student_id');
			$searched_item=$this->input->post('search');
			$result['details']=$this->Model->send_feedback_search($id,$searched_item);
			$this->load->view('send_feedback',$result);
		}
		else
		{
			redirect(base_url('index.php/Control/student'));
		}
	}
	public function feedback()
	{
		if($this->session->userdata('student_id')!="")
		{
			$course_id=$this->uri->segment(3);
			$student_id=$this->session->userdata('student_id');	
			$result=$this->Model->feedback($course_id,$student_id);
			// print_r($result['details']);
			// exit();
			foreach ($result as $key => $value) 
			{
				$faculty_id=$value->faculty_id;
				$student_id=$value->student_id;
				$course_id=$value->course_id;
				$date=$this->input->post('date');
				$student_name=$value->name;
				$semester=$value->semester;
				$branch_name=$value->branch;
				$subject_name=$value->subject_name;
				$student_email=$value->email;
				$feedback=$this->input->post('feedback');

				$data=array(
					'faculty_reference'=>$faculty_id,
					'student_reference'=>$student_id,
					'course_reference'=>$course_id,
					'date'=>$date,
					'student_name'=>$student_name,
					'student_semester'=>$semester,
					'student_branch'=>$branch_name,
					'student_subject'=>$subject_name,
					'student_email'=>$student_email,
					'feedback'=>$feedback
				);

				$this->Model->store_feedback('feedback',$data);
				redirect(base_url('index.php/Control/send_feedback'));
			}
		}
		else
		{
			redirect(base_url('index.php/Control/student'));
		}
	}


	//faculty
	public function faculty()
	{
		$this->load->view('faculty_login');
	}
	public function faculty_register_page()
	{
		$this->load->view('faculty_register_page');
	}
	public function faculty_register()
	{
		$faculty_name=$this->input->post('faculty_name');
		$faculty_gender=$this->input->post('faculty_gender');
		$faculty_address=$this->input->post('faculty_address');
		$faculty_dob=$this->input->post('faculty_dob');
		$faculty_phone_number=$this->input->post('faculty_phone_number');
		$faculty_city=$this->input->post('faculty_city');
		$faculty_state=$this->input->post('faculty_state');
		$faculty_zip=$this->input->post('faculty_zip');
		$faculty_email=$this->input->post('faculty_email');
		$faculty_password=$this->input->post('faculty_password');

		$config['upload_path']='./image';
		$config['allowed_types']="*";
		$this->load->library('upload',$config);
		if(!$this->upload->do_upload('faculty_image'))
		{
			print_r($this->upload->display_errors());
		}
		else
		{
			$image=$this->upload->data();
			$img=$image['file_name'];

		}
		$data=array(
			'faculty_name'=>$faculty_name,
			'faculty_gender'=>$faculty_gender,
			'faculty_address'=>$faculty_address,
			'faculty_dob'=>$faculty_dob,
			'faculty_phone_number'=>$faculty_phone_number,
			'faculty_city'=>$faculty_city,
			'faculty_state'=>$faculty_state,
			'faculty_zip'=>$faculty_zip,
			'faculty_email'=>$faculty_email,
			'faculty_password'=>$faculty_password,
			'faculty_image'=>$img,
			'status'=>'registered'
		);

		$this->Model->add_faculty('faculty',$data);
		redirect(base_url('index.php/Control/faculty'));
	}
	public function faculty_login()
	{
		$faculty_email=$this->input->post('faculty_email');
		$faculty_password=$this->input->post('faculty_password');
		$login_data=$this->Model->select_faculty_login('faculty',$faculty_email,$faculty_password);

		if($login_data!=false)
		{
			$this->session->set_userdata('faculty_id',$login_data['faculty_id']);
			redirect(base_url('index.php/Control/faculty_logged_page'));
		}
		else
		{
			$this->session->set_flashdata('error','invalid email/password/not confirmed');
			redirect(base_url('index.php/Control/faculty'));
		}
	}
	public function faculty_logged_page()
	{
		if($this->session->userdata('faculty_id')!="")
		{
			$id=$this->session->userdata('faculty_id');
			$result['details']=$this->Model->faculty_details('faculty',$id);
			$this->load->view('faculty_logged_page',$result);
		}
		else
		{
			redirect(base_url('index.php/Control/faculty'));
		}
	}
	public function faculty_my_profile()
	{
		if($this->session->userdata('faculty_id')!="")
		{
			$id=$this->uri->segment(3);
			$result['details']=$this->Model->faculty_my_profile('faculty',$id);
			$this->load->view('faculty_profile',$result);

		}
		else
		{
			redirect(base_url('index.php/Control/faculty'));
		}
	}
	public function faculty_edit_profile()
	{
		if($this->session->userdata('faculty_id')!="")
		{
			$id=$this->uri->segment(3);
			$result['details']=$this->Model->faculty_edit_profile('faculty',$id);
			$this->load->view('faculty_edit_profile',$result);
		}
		else
		{
			redirect(base_url('index.php/Control/faculty'));
		}
	}
	public function faculty_profile_update()
	{
		if($this->session->userdata('faculty_id')!="")
		{	
			$id=$this->uri->segment(3);
			$faculty_name=$this->input->post('faculty_name');
			$faculty_gender=$this->input->post('faculty_gender');
			$faculty_address=$this->input->post('faculty_address');
			$faculty_dob=$this->input->post('faculty_dob');
			$faculty_phone_number=$this->input->post('faculty_phone_number');
			$faculty_city=$this->input->post('faculty_city');
			$faculty_state=$this->input->post('faculty_state');
			$faculty_zip=$this->input->post('faculty_zip');
			$faculty_email=$this->input->post('faculty_email');
			$faculty_password=$this->input->post('faculty_password');

			if($_FILES['image']['name']!="")
			{
				$config['upload_path']='./image/';
				$config['allowed_types']='*';
				$this->load->library('upload',$config);
				if(!$this->upload->do_upload('image'))
				{
					print_r($this->upload->display_errors());
				}
				else
				{
					$image=$this->upload->data();
					$img=$image['file_name'];
				}

				$data=array(
					'faculty_name'=>$faculty_name,
					'faculty_gender'=>$faculty_gender,
					'faculty_address'=>$faculty_address,
					'faculty_dob'=>$faculty_dob,
					'faculty_phone_number'=>$faculty_phone_number,
					'faculty_city'=>$faculty_city,
					'faculty_state'=>$faculty_state,
					'faculty_zip'=>$faculty_zip,
					'faculty_email'=>$faculty_email,
					'faculty_password'=>$faculty_password,
					'faculty_image'=>$img	
				);
			}
			else
			{
				$data=array(
					'faculty_name'=>$faculty_name,
					'faculty_gender'=>$faculty_gender,
					'faculty_address'=>$faculty_address,
					'faculty_dob'=>$faculty_dob,
					'faculty_phone_number'=>$faculty_phone_number,
					'faculty_city'=>$faculty_city,
					'faculty_state'=>$faculty_state,
					'faculty_zip'=>$faculty_zip,
					'faculty_email'=>$faculty_email,
					'faculty_password'=>$faculty_password
				);				
			}
			$this->Model->faculty_profile_update('faculty',$data,$id);
			redirect(base_url('index.php/Control/faculty_logged_page'));
		}
		else
		{
			redirect(base_url('index.php/Control/faculty'));
		}	
	}


	public function subject_registration()
	{
		if($this->session->userdata('faculty_id')!="")
		{	
			// $id=$this->uri->segment(3);
			$this->load->view('subject_registration');
		}
		else
		{
			redirect(base_url('index.php/Control/faculty'));
		}
	}
	public function faculty_register_subject()
	{
		if($this->session->userdata('faculty_id')!="")
		{	
			// $id=$this->uri->segment(3);
			$result['details']=$this->Model->select_branch('branch');
			$this->load->view('faculty_register_subject',$result);
		}
		else
		{
			redirect(base_url('index.php/Control/faculty'));
		}
	}
	public function select_subject()
	{
		if($this->session->userdata('faculty_id')!="")
		{
			$id=$this->input->post('id');
			$result=$this->Model->select_subject('subject',$id);

			foreach ($result as $key => $value) 
			{
			?>
				<option value="<?php echo $value->subject_id;?>"><?php echo $value->subject_name;?></option>	
			<?php
			}
		}
		else
		{
			redirect(base_url('index.php/Control/faculty'));
		}
	}
	public function register_branch_subject()
	{
		if($this->session->userdata('faculty_id')!="")
		{
			// $id=$this->session->userdata('faculty_id');
			$branch_id=$this->input->post('select_branch');
			$subject_id=$this->input->post('select_subject');
			$result=$this->Model->select_registered_course($branch_id,$subject_id);
			
			foreach ($result as $key => $value) 
			{
				$id=$this->session->userdata('faculty_id');
				$branch_name=$value->branch_name;
				$subject_name=$value->subject_name;
				
				$data=array(
					'faculty_ref'=>$id,
					'branch_name'=>$branch_name,
					'subject_name'=>$subject_name
				);
				$this->Model->insert_registerd_course('selected_course',$data);	
				redirect(base_url('index.php/Control/subject_registration'));
			}
		}
		else
		{
			redirect(base_url('index.php/Control/faculty'));
		}
	}
	public function faculty_view_registered_subjects()
	{
		if($this->session->userdata('faculty_id')!="")
		{	
			$id=$this->session->userdata('faculty_id');
			$result['details']=$this->Model->faculty_view_registered_subjects('selected_course',$id);
			$this->load->view('view_registed_subjects',$result);
		}
		else
		{
			redirect(base_url('index.php/Control/faculty'));
		}
	}
	public function course_delete()
	{
		if($this->session->userdata('faculty_id')!="")
		{
			$id=$this->uri->segment(3);
			$this->Model->course_delete('selected_course',$id);
			redirect(base_url('index.php/Control/faculty_view_registered_subjects'));
		}
		else
		{
			redirect(base_url('index.php/Control/faculty'));
		}
	}
	public function view_feedback()
	{
		if($this->session->userdata('faculty_id')!="")
		{
			$id=$this->session->userdata('faculty_id');
			$result['details']=$this->Model->view_feedback('feedback',$id);
			$this->load->view('view_feedback',$result);
		}
		else
		{
			redirect(base_url('index.php/Control/faculty'));
		}	
	}
	public function feedback_delete()
	{
		if($this->session->userdata('faculty_id')!="")
		{
			$id=$this->uri->segment(3);
			$this->Model->feedback_delete('feedback',$id);
			redirect(base_url('index.php/Control/view_feedback'));
		}
		else
		{
			redirect(base_url('index.php/Control/faculty'));
		}	
	}
	public function faculty_logout()
	{
		if($this->session->userdata('faculty_id')!="")
		{
			$this->session->sess_destroy();
			redirect(base_url('index.php/Control/faculty'));
		}
		else
		{
			redirect(base_url('index.php/Control/faculty'));
		}	
	}

	//admin
	public function admin()
	{
		$this->load->view('admin');
	}
	public function admin_register_page()
	{
		$this->load->view('admin_register_page');
	}
	public function admin_register()
	{
		$admin_name=$this->input->post('admin_name');
		$admin_gender=$this->input->post('admin_gender');
		$admin_address=$this->input->post('admin_address');
		$admin_phone_number=$this->input->post('admin_phone_number');
		$admin_city=$this->input->post('admin_city');
		$admin_state=$this->input->post('admin_state');
		$admin_zip=$this->input->post('admin_zip');
		$admin_email=$this->input->post('admin_email');
		$admin_password=$this->input->post('admin_password');

		$config['upload_path']='./image';
		$config['allowed_types']="*";
		$this->load->library('upload',$config);
		if(!$this->upload->do_upload('admin_image'))
		{
			print_r($this->upload->display_errors());
		}
		else
		{
			$image=$this->upload->data();
			$img=$image['file_name'];

		}
		$data=array(
			'admin_name'=>$admin_name,
			'admin_gender'=>$admin_gender,
			'admin_address'=>$admin_address,
			'admin_phone_number'=>$admin_phone_number,
			'admin_city'=>$admin_city,
			'admin_state'=>$admin_state,
			'admin_zip'=>$admin_zip,
			'admin_email'=>$admin_email,
			'admin_password'=>$admin_password,
			'admin_image'=>$img
		);

		$this->Model->add_admin('admin',$data);
		redirect(base_url('index.php/Control/admin'));
	}
	public function admin_login()
	{
		$admin_email=$this->input->post('admin_email');
		$admin_password=$this->input->post('admin_password');
		$login_data=$this->Model->select_admin_login('admin',$admin_email,$admin_password);

		if($login_data!=false)
		{
			$this->session->set_userdata('admin_id',$login_data['admin_id']);
			redirect(base_url('index.php/Control/admin_logged_page'));
		}
		else
		{
			$this->session->set_flashdata('error','invalid email/password');
			redirect(base_url('index.php/Control/admin'));
		}
	}
	public function admin_logged_page()
	{
		if($this->session->userdata('admin_id')!="")
		{
			$id=$this->session->userdata('admin_id');
			$result['details']=$this->Model->admin_details('admin',$id);
			$this->load->view('admin_logged_page',$result);
		}
		else
		{
			redirect(base_url('index.php/Control/admin'));
		}
	}
	public function add_subjects()
	{
		if($this->session->userdata('admin_id')!="")
		{
			$result['details']=$this->Model->add_subjects('branch');
			$this->load->view('add_subjects',$result);
		}	
		else
		{
			redirect(base_url('index.php/Control/admin'));
		}
	}
	public function add_branch_subject()
	{
		if($this->session->userdata('admin_id')!="")
		{
			$select_branch_id=$this->input->post('select_branch');
			$subject_name=$this->input->post('subject_name');
			$data=array(
				'branch_ref'=>$select_branch_id,
				'subject_name'=>$subject_name
			);

			$this->Model->add_new_subject('subject',$data);
			redirect(base_url('index.php/Control/add_subjects'));

		}	
		else
		{
			redirect(base_url('index.php/Control/admin'));
		}
	}
	public function view_registered_courses()
	{
		if($this->session->userdata('admin_id')!="")
		{
			$result['details']=$this->Model->view_registered_courses();
			$this->load->view('view_registered_courses',$result);
		}	
		else
		{
			redirect(base_url('index.php/Control/admin'));
		}
	}
	public function course_search()
	{
		if($this->session->userdata('admin_id')!="")
		{
			$searched_item=$this->input->post('search');
			$result['details']=$this->Model->course_search($searched_item);
			$this->load->view('view_registered_courses',$result);
		}	
		else
		{
			redirect(base_url('index.php/Control/admin'));
		}
	}
	public function branch_subject_delete()
	{
		if($this->session->userdata('admin_id')!="")
		{
			$id=$this->uri->segment(3);
			$this->Model->branch_subject_delete('subject',$id);
			redirect(base_url('index.php/Control/view_registered_courses'));
		}	
		else
		{
			redirect(base_url('index.php/Control/admin'));
		}

	}
	public function registered_faculty()
	{
		if($this->session->userdata('admin_id')!="")
		{
			$result['details']=$this->Model->view_registered_faculty('faculty');
			$this->load->view('registered_faculty',$result);

		}	
		else
		{
			redirect(base_url('index.php/Control/admin'));
		}
	}
	public function faculty_delete()
	{
		if($this->session->userdata('admin_id')!="")
		{
			$id=$this->uri->segment(3);
			$this->Model->faculty_delete('faculty',$id);
			redirect(base_url('index.php/Control/registered_faculty'));
		}	
		else
		{
			redirect(base_url('index.php/Control/admin'));
		}
	}
	public function status_conformation()
	{
		if($this->session->userdata('admin_id')!="")
		{
			$id=$this->uri->segment(3);
			$data=array(
				'status'=>'confirmed'
			);
			$this->Model->status_conformation('faculty',$data,$id);
			redirect(base_url('index.php/Control/registered_faculty'));
		}	
		else
		{
			redirect(base_url('index.php/Control/admin'));
		}
	}
	public function admin_logout()
	{
		if($this->session->userdata('admin_id')!="")
		{	
			$this->session->sess_destroy();
			redirect(base_url('index.php/Control/admin'));
		}	
		else
		{
			redirect(base_url('index.php/Control/admin'));
		}
	}


}