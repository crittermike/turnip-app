<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Projects extends Controller {

	function __construct() {
		parent::__construct();

		$this->load->model('Project_model', 'projects');
		$this->load->model('Task_model', 'tasks');
		$this->load->model('Time_model', 'time');
    $this->load->helper('time_converter');

		if (!$this->tank_auth->is_logged_in())
			redirect('/auth/login/');
	}

  function index() {

    $data['title'] = "Your Projects";
    $this->load->view('includes/header', $data);
    $data['projects'] = $this->projects->get();
    $numtasks = $this->tasks->num_tasks();
    if ($data['projects']) {

      foreach ($data['projects'] as $project) {
        $project->hours = decimal_to_time($project->hours);
        $project->numtasks = isset($numtasks[$project->id]) ? $numtasks[$project->id] : 0;
      }

      $this->load->view('projects/list', $data);

    } else {
      // No projects have time associated with them.
      $data['content'] = "<div class='block first center'><div class='block-header'><h2>No projects added yet</h2></div><div class='block-content'><p>To create a project, just <a href='/time'>track some time</a> or <a href='/tasks/add'>create a task</a> and the project will be created automatically.</p></div>";
      $this->load->view('utility/content', $data);
    }
    $this->load->view('includes/footer');
  }

  function view($id = FALSE) {
    if (!$id) {
      redirect('/projects');
    }

    $project = $this->projects->get($id);

    $data['start'] = $start = $this->time->earliest_time_date($project->id);
    $data['end'] = $end = time();

    $times = $this->time->span_time(NULL, NULL,  $project->id);
    $data['series'][$project->name] = array();
    $data['series'][$project->name]['name'] = $project->name;

    for ($day = strtotime($start); $day <= $end; $day = strtotime('+1 day', $day)) {
      $date = date('Y-m-d', $day);
      $data['series'][$project->name]['data'][] = isset($times[$project->name][$date]) ? $times[$project->name][$date] + 0.0 : 0;
    }

    $project->chart = $this->load->view('graphs/time_line', $data, TRUE);
    $project->hours = decimal_to_time($project->hours);
    $project->numtasks = isset($numtasks[$project->id]) ? $numtasks[$project->id] : 0;
    $project->tasks = $this->tasks->view_by_project($project->id);
    $project->times = $this->time->view_by_project($project->id, 20);

    $data['title'] = $project->name;
    $data['project'] = $project;
    $this->load->view('includes/header', $data);
    $this->load->view('projects/view', $data);
    $this->load->view('includes/footer');
  }

	function clean_list() {
    $projects = $this->projects->list_names();
    $data['content'] = '';
    foreach ($projects as $project) {
      $data['content'] .= $project . ',';
    }
	  $this->load->view('utility/content', $data);
	}
}
