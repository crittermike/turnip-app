<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Comment_model extends Model {

  function Comment_model() {
    parent::Model();
  }

  // Get all tags associated with a task.
  function get_by_task_id($task_id) {
    $this->db->where('task_id', $task_id);
    $this->db->order_by('posted', 'desc');
    $this->db->join('users', 'comments.user_id = users.id');
    $query = $this->db->get('comments');
    return $query->result();
  }

  function get_by_id($id) {
    $this->db->where('id', $id);
    $query = $this->db->get('comments');
    return $query->row();
  }

  // Create a new tag.
  function add($task_id, $text) {
    $data = array(
      'task_id' => $task_id,
      'user_id' => $this->tank_auth->get_user_id(),
      'content' => strip_tags(trim($text))
    );
    $this->db->insert('comments', $data);
  }
}
