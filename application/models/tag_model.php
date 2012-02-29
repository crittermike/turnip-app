<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tag_model extends Model {

  function Tag_model() {
    parent::Model();
  }

  // Generate a tag ID based on its name, even if it must be created.
  function get_id($name) {
    $this->db->where('name', $name);
    $this->db->where('user_id', $this->tank_auth->get_user_id());
    $query = $this->db->get('tags');
    if (!$query->row()) {
      $this->create($name);
      return $this->db->insert_id();
    } else {
      return $query->row()->id;
    }
  }

  // Get all tags associated with a task.
  function get_by_task_id($task_id) {
    $this->db->where('task_id', $task_id);
    $query = $this->db->get('tagstasks');

    // If there are no tags for this task, just quit.
    if ($query->num_rows() == 0)
      return FALSE;

    // Put all the tag ID's into an array.
    foreach ($query->result() as $row)
      $tags[] = $row->tag_id;

    // Use that array to grab all the tag names
    $this->db->where_in('id', $tags);
    $this->db->where('user_id', $this->tank_auth->get_user_id());
    $query = $this->db->get('tags');

    return $query->result();
  }

  // Create a new tag.
  function create($name) {
    $data = array(
      'name' => strip_tags(trim($name)),
      'user_id' => $this->tank_auth->get_user_id(),
    );
    $this->db->insert('tags', $data);
  }

  // Remove all tags associated with a task. Used when editing the tags, since it
  // is easier to just remove them and re-add them than try and figure out which
  // ones already exist and only add the new ones.
	function remove_task_tags($task_id) {
	  $this->db->where('task_id', $task_id);
	  $this->db->delete('tagstasks');
	}
}
