<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Project_model extends Model {

  function Project_model() {
    parent::Model();
  }

  function get($id = FALSE) {
    $this->db->select('projects.name, projects.id, sum(duration) as hours, count(tasks.id) as numtasks');
    $this->db->from('projects');
    $this->db->join('time', 'time.project_id = projects.id');
    $this->db->join('tasks', 'tasks.project_id = projects.id');
    $this->db->group_by('projects.id');
    $this->db->order_by('projects.name');
    $this->db->where('projects.user_id', $this->tank_auth->get_user_id());
    if ($id) {
      $this->db->where('projects.id', $id);
    }
    $query = $this->db->get();
    return $id ? $query->row() : $query->result();
  }

  // Get the ID of a project, even if it must first be created.
  function get_id($name) {
    $name = trim(strip_tags($name));

    $this->db->where('name', $name);
    $query = $this->db->get('projects');

    if (!$query->row()) {
      // If there are no results, the project doesn't exist, so we create it.
      $this->create($name);
      return $this->db->insert_id();
    } else {
      // Otherwise, the project already exists, so just return that ID.
      return $query->row()->id;
    }
  }

  // Find a project name associated with a specific task, by the task's ID.
  function task_id_to_name($taskid) {
    $this->db->where('id', $taskid);
    $query = $this->db->get('tasks');
    $project_id = $query->row()->project_id;

    $this->db->where('id', $project_id);
    $query = $this->db->get('projects');
    return $query->row()->name;
  }

  // Create a new project.
  function create($name) {
    // Don't need to strip_tags or trim because it was already done in get_id() above.
    $this->db->insert('projects', array('name' => $name, 'user_id' => $this->tank_auth->get_user_id()));
  }

  // List the names of all projects in alphabetical order to be used by autocomplete.
  function list_names() {
    $this->db->where('user_id', $this->tank_auth->get_user_id());
    $query = $this->db->get('projects');
    foreach ($query->result() as $row) {
      $names[] = $row->name;
    }
    return $names;
  }
}
