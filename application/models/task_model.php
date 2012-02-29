<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Task_model extends Model {

  function Task_model() {
    parent::Model();
    $this->load->model('Tag_model', 'tags');
  }

  // Grab all tasks.
  function view_all() {
    $this->db->where('user_id', $this->tank_auth->get_user_id());
    $query = $this->db->get('tasks');
    return $query->result();
  }

  function num_tasks($project_id = FALSE) {
    $this->db->select('project_id, count(*) as numtasks');
    $this->db->from('tasks');
    if ($project_id) {
      $this->db->where('project_id', $project_id);
    }
    $this->db->group_by('project_id');
    $query = $this->db->get();
    foreach ($query->result() as $row) {
      $numtasks[$row->project_id] = $row->numtasks;
    }
    return $numtasks;
  }

  // Close a task.
  function close($id) {
    $this->db->where('id' , $id);
    $this->db->where('user_id', $this->tank_auth->get_user_id());
    $now = date('Y-m-d H:i:s');
    $data = array( 'closed' => $now );
    $this->db->update('tasks', $data);
  }

  // Reopen a task.
  function reopen($id) {
    $this->db->where('id' , $id);
    $this->db->where('user_id', $this->tank_auth->get_user_id());
    $data = array( 'closed' => '0000-00-00 00:00:00' );
    $this->db->update('tasks', $data);
  }

  // Grab a specific task by ID.
  function view($id) {
    $this->db->where('id', $id);
    $this->db->where('user_id', $this->tank_auth->get_user_id());
    $query = $this->db->get('tasks');
    return $query->row();
  }

  // Grab all tasks tagged with a specific tag.
  function view_by_tag($tagname) {
    // First we have to get the tag's ID
    $this->db->where('name', $tagname);
    $this->db->where('user_id', $this->tank_auth->get_user_id());
    $query = $this->db->get('tags');
    $row = $query->row();
    if (!$row)
      return false;
    $tagid = $row->id;

    // Then we grab all the ID's of tasks with that tag
    $this->db->where('tag_id', $tagid);
    $query = $this->db->get('tagstasks');
    foreach ($query->result() as $row) {
      $tasks[] = $row->task_id;
    }

    // Finally, we grab all of those tasks' data by their ID's
    $this->db->where_in('id', $tasks);
    $query = $this->db->get('tasks');
    return $query->result();
  }

  // Grab all tasks under a specific project.
  function view_by_project($project_id) {
    $this->db->where('project_id', $project_id);
    $this->db->where('closed', '0000-00-00 00:00:00');
    $this->db->order_by('id', 'desc');
    $query = $this->db->get('tasks');
    return $query->result();
  }

  // Add a new task.
  function create($userid, $projectid, $title, $description = '', $tags = '') {
    // First we insert the task itself.
    $data = array(
      'title' => strip_tags($title),
      'user_id' => strip_tags($userid),
      'project_id' => strip_tags($projectid),
      'description' => strip_tags($description)
    );
    $this->db->insert('tasks', $data);
    $task_id = $this->db->insert_id();

    // Now we need to grab the tags and insert them into the tag/task table.
    $tags = strip_tags(trim(strtolower($tags)));
    if ($tags != ' ' && $tags != '') {
      $tags = explode(' ', $tags);
      foreach ($tags as $tag) {
        $data = array(
          'tag_id' => $this->tags->get_id($tag),
          'task_id' => $task_id,
        );
        $this->db->insert('tagstasks', $data);
      }
    }

    return $task_id;
  }

  // Update a task's title.
  function change_title($id, $newtitle) {
    $data = array('title' => trim($newtitle));

    $this->db->where('id', $id);
    $this->db->update('tasks', $data);
  }

  // Update a task's description.
  function change_description($id, $newdesc) {
    $data = array('description' => trim($newdesc));

    $this->db->where('id', $id);
    $this->db->update('tasks', $data);
  }

  // Update a task's tags.
  function change_tags($id, $tags) {
    // Remove all pre-existing tags for this task so we can start fresh.
    $this->tags->remove_task_tags($id);

    $tags = strip_tags(trim(strtolower($tags)));
    if ($tags != ' ' && $tags != '') {
      $tags = explode(' ', $tags);
      // One by one, insert each new tag into the tagstasks table.
      foreach ($tags as $tag) {
        $data = array(
          'tag_id' => $this->tags->get_id($tag),
          'task_id' => $id
        );
        $this->db->insert('tagstasks', $data);
      }
    }
  }
}
