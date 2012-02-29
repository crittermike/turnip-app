<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Comments extends Controller
{
	function __construct() {
		parent::__construct();

		$this->load->model('Task_model', 'tasks');
		$this->load->model('Comment_model', 'comments');

		if (!$this->tank_auth->is_logged_in())
			redirect('/auth/login/');
	}

  // Handles the AJAX adding of comments.
	function add() {
	  $this->load->library('typography');

	  $task_id = trim(strip_tags($this->input->post('task_id')));
	  $content = trim(strip_tags($this->input->post('content')));

    if ($this->input->post('submitclose')) {
      $this->tasks->close($task_id);
      $content = "-- TASK CLOSED --\n\n" . $content;
    } else if ($this->input->post('submitopen')) {
      $this->tasks->reopen($task_id);
      $content = "-- TASK REOPENED --\n\n" . $content;
    }

    if ($content != "") {
      $this->comments->add($task_id, $content);

      $data['comment'] = $this->comments->get_by_id($this->db->insert_id());
      $data['comment']->content = $this->typography->auto_typography(auto_link($data['comment']->content));
      $this->load->view('comments/single', $data);
    }
	}
}
