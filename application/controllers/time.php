<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Time extends Controller
{
	function __construct() {
		parent::__construct();

		$this->load->model('Time_model', 'time');
    $this->load->helper('time_converter');
    $this->load->helper('date');
    $this->load->helper('percentage');
		if (!$this->tank_auth->is_logged_in())
			redirect('/auth/login/');
	}

	function index() {
    $start = $this->input->post('time-start');
    if (!$start)
      $start = $this->time->earliest_time_date(); // If no start date specified, set it to the first day of the month.

    $end = $this->input->post('time-end');
    if (!$end)
      $end = date('Y-m-d'); // If no end date specified, set it to today.

	  $data['title'] = "Your Time";
	  $data['entries'] = $this->time->view_all($start, $end, 50);
    $data['start'] = $start;
    $data['end'] = $end;
    $this->load->view('includes/header', $data);


    if (!count($data['entries'])) { // No time has been logged yet.
      $data['content'] = "<div class='block first center'><div class='block-header'><h2>No time added yet</h2></div><div class='block-content'><p>You haven't added any time yet. Sweet, I love this part!</p><p>See that form at the top right? Just enter a time, a project name (the project will be created for you), and a description, and you're on your way.</p></div>";
      $this->load->view('utility/content', $data);
    }


    else { // If there has been some time logged.

      foreach($data['entries'] as $entry) {
        $entry->duration = decimal_to_time($entry->duration);
        if (date('Y-m-d') == $entry->date) {
          // Change today's date to read "Today" instead.
          $entry->date = 'Today';
        }
      }

      $times = $this->time->span_time($start, $end);
      foreach ($times as $project => $value) {
        $data['series'][$project] = array();
        $data['series'][$project]['name'] = $project;
      }

      // Loop through dates using timestamp (the 60*60 below is to account for DST),
      // adding a day (60*60*24) each time.
      for ($day = strtotime($start); $day <= strtotime($end); $day = strtotime('+1 day', $day)) {
        $date = date('Y-m-d', $day);
        foreach ($times as $project => $value) {
          $data['series'][$project]['data'][] = isset($times[$project][$date]) ? $times[$project][$date] + 0.0 : 0;
        }
      }

      $data['allgraph'] = $this->load->view('graphs/time_line', $data, TRUE);

      $data['sumtimes'] = $this->time->sum_time(date('Y-m-d'));
      $data['daytotal'] = array_sum($data['sumtimes']);
      $data['daygraph'] = $this->load->view('graphs/time_pie', $data, TRUE);

      $data['sumtimes'] = $this->time->sum_time(date('Y-m-d', time() - (60 * 60 * 24 * date('w'))), date('Y-m-d'));
      $data['weektotal'] = array_sum($data['sumtimes']);
      $data['weekgraph'] = $this->load->view('graphs/time_pie', $data, TRUE);

      $data['sumtimes'] = $this->time->sum_time(date('Y-m-01'), date('Y-m-d'));
      $data['monthtotal'] = array_sum($data['sumtimes']);
      $data['monthgraph'] = $this->load->view('graphs/time_pie', $data, TRUE);

	    $this->load->view('time/list', $data);
    }
    $this->load->view('includes/footer');
	}


	function add() {
    $time = $this->input->post('timeform-time');
    $project = $this->input->post('timeform-project');
    $description = $this->input->post('timeform-description');
    $date = $this->input->post('timeform-date');

    if (empty($date)) {
      // No date was selected, so we default to today.
      $date = date('Y-m-d');
    }

    $this->time->add(
      $this->tank_auth->get_user_id(),
      $time,
      $date,
      $project,
      $description
    );
	}


  // Handles the AJAX edit-in-place on time pages
	function update() {
    if (strstr($this->input->post('id'), 'date')) {
      // If the date was edited...
      $id = str_replace('date-', '', $this->input->post('id'));
      $content = strip_tags(trim($this->input->post('value')));
      $this->time->change_date($id, $content);
      $data['content'] = $content;
    } else if (strstr($this->input->post('id'), 'project')) {
      // If the project was edited
      $id = str_replace('project-', '', $this->input->post('id'));
      $content = strip_tags(trim($this->input->post('value')));
      $this->time->change_project($id, $content);
      $data['content'] = $content;
    } else if (strstr($this->input->post('id'), 'description')) {
      // If the description was edited
      $id = str_replace('description-', '', $this->input->post('id'));
      $content = strip_tags(trim($this->input->post('value')));
      $this->time->change_description($id, $content);
      $data['content'] = $content;
    } else if (strstr($this->input->post('id'), 'time')) {
      // If the description was edited
      $id = str_replace('time-', '', $this->input->post('id'));
      $content = strip_tags(trim($this->input->post('value')));
      $this->time->change_duration($id, $content);
      $data['content'] = $content;
    }

    $this->load->view('utility/content', $data);
	}
}
