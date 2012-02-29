<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tasks extends Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('Task_model', 'tasks');
		$this->load->model('Tag_model', 'tags');
		$this->load->model('Project_model', 'projects');
		$this->load->model('Comment_model', 'comments');

		if (!$this->tank_auth->is_logged_in())
			redirect('/auth/login/');
	}


  // List all tasks.
	function index() {
	  $data['tasks'] = $this->tasks->view_all();
    $data['title'] = "Your Tasks";
    $this->load->view('includes/header', $data);

    if ($data['tasks']) {
      foreach ($data['tasks'] as $task) {
        $task->tags = $this->tags->get_by_task_id($task->id);
        $task->project = $this->projects->task_id_to_name($task->id);
      }

      $this->load->view('tasks/list', $data);

    } else {
      $data['content'] = "<div class='block first center'><div class='block-header'><h2>No tasks added yet</h2></div><div class='block-content'><p>You don't have any tasks yet. Care to <a href='/tasks/add'>add one now</a>?</p></div>";
      $this->load->view('utility/content', $data);
    }

	  $this->load->view('includes/footer');
	}

  function tag($tagname = FALSE) {
    if (!$tagname) {
      redirect('/tasks/');
    }

    $data['tasks'] = $this->tasks->view_by_tag($tagname);

    foreach ($data['tasks'] as $task) {
      $task->tags = $this->tags->get_by_task_id($task->id);
      $task->project = $this->projects->task_id_to_name($task->id);
    }

	  $data['title'] = "Tasks Tagged \"$tagname\"";
	  $this->load->view('includes/header', $data);
		$this->load->view('tasks/list', $data);
	  $this->load->view('includes/footer');
  }



  // Add a task via the Add Task form.
	function add() {
	  $this->form_validation->set_rules('title', 'Title', 'trim|required');
	  $this->form_validation->set_rules('project', 'Project', 'trim|required');
	  $this->form_validation->set_rules('description', 'Description', 'trim');
	  $this->form_validation->set_rules('tags', 'Tags', 'trim');

	  if ($this->form_validation->run() == FALSE)	{
	    // Display the form since it hasn't been submitted successfully.
			$data['title'] = "Create A Task";
	    $this->load->view('includes/header', $data);
		  $this->load->view('tasks/add');
	    $this->load->view('includes/footer');
		} else {
		  // Create the task and redirect to its View Task page.
		  $task_id = $this->tasks->create(
		    $this->tank_auth->get_user_id(),
		    $this->projects->get_id($this->input->post('project')),
		    $this->input->post('title'),
		    $this->input->post('description'),
		    $this->input->post('tags')
	    );
			redirect('/tasks/view/' . $task_id);
		}
	}

  // View a specific task by ID.
	function view($id = 0) {
	  $this->load->library('typography');

	  if ($id == 0)
	    redirect('/tasks');

	  $task = $this->tasks->view($id);
	  $project = $this->projects->task_id_to_name($id);
    $task->project = $project;
    $task->description = $this->typography->auto_typography(auto_link($task->description));

	  $data['title'] = 'Task #' . $task->id . ' For ' . $project;
	  $data['task'] = $task;
    $data['tags'] = $this->tags->get_by_task_id($id);
    $data['closed'] = $task->closed == '0000-00-00 00:00:00' ? FALSE : TRUE;

	  $comments = $this->comments->get_by_task_id($id);
	  foreach ($comments as $comment) {
	    $comment->content = $this->typography->auto_typography(auto_link($comment->content));
	  }
	  $data['comments'] = $comments;

    $data['commentform'] = $this->load->view('comments/form', $data, TRUE);
	  $data['commentlist'] = $this->load->view('comments/view', $data, TRUE);

    $this->load->view('includes/header', $data);
	  $this->load->view('tasks/view', $data);
    $this->load->view('includes/footer');
	}

  // Handles the AJAX edit-in-place on task pages
	function update($id = 0) {
	  if ($id == 0)
	    redirect('/tasks');

	  $this->load->library('typography');

    // If the Title was edited...
    if ($this->input->post('id') == 'title') {
      $content = strip_tags(trim($this->input->post('value')));
      $this->tasks->change_title($id, $content);
      $data['content'] = $content;

    // If the description was edited...
    } else if ($this->input->post('id') == 'description') {
      $content = strip_tags(trim($this->input->post('value')));
      $this->tasks->change_description($id, $content);
      $data['content'] = $this->typography->auto_typography(auto_link($content));

    // If the tags were edited...
    } else if ($this->input->post('id') == 'tags') {
      $content = strip_tags(trim($this->input->post('value')));
      if (!empty($content)) {
        $this->tasks->change_tags($id, $content);
        $tags = $this->tags->get_by_task_id($id);

        $content = "";
        foreach ($tags as $tag) {
          $content .= "<span class='tag'>" . $tag->name . "</span> ";
        }
      } else {
        $this->tags->remove_task_tags($id);
        $content = '<span class="small">(no tags)</span>';
      }
      $data['content'] = $content;
    }

    $this->load->view('utility/content', $data);
	}



  // Returns the task's description straight from the DB without the <br /> to <p>
  // conversion done, so that when editing descriptions, you see that instead of
  // the HTML version.
	function clean_description($id = 0) {
	  if ($id == 0)
	    redirect('/tasks');

    $task = $this->tasks->view($id);
	  $data['content'] = $task->description;
    $this->load->view('utility/content', $data);
	}

	// Returns the task's tags as a space separated plaintext list for AJAX editing.
	function clean_tags($id = 0) {
	  if ($id == 0)
	    redirect('/tasks');

    $tags = $this->tags->get_by_task_id($id);
    $data['content'] = '';
    if ($tags) {
      foreach ($tags as $tag) {
        $data['content'] .= $tag->name . ' ';
      }
    }
    $this->load->view('utility/content', $data);
	}
}
