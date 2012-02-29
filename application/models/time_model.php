<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Time_model extends Model {

  function Time_model() {
    parent::Model();
    $this->load->model('Project_model', 'projects');
  }




  /**
   *  Create a new time entry.
   *
   *  @param int $user_id
   *    The ID of the user the time belongs to.
   *  @param string $time
   *    The time logged in HH:MM format.
   *  @param string $data
   *    The date string in YYYY-MM-DD format.
   *  @param string $project
   *    The name of the project.
   *  @param string $description
   *    A short description of the time entered.
   */
  function add($user_id, $time, $date, $project, $description) {
    $this->load->helper('time_converter');
    $data = array(
      'user_id'     => $user_id,
      'project_id'  => $this->projects->get_id($project),
      'date'        => trim(strip_tags($date)),
      'duration'    => time_to_decimal(trim(strip_tags($time))),
      'description' => trim(strip_tags($description))
    );
    $this->db->insert('time', $data);
  }




  /**
   * Fetch all time entries.
   *
   * Optionally, filter by start date and end date.
   *
   * @param string $start
   *   The start date string in YYYY-MM-DD format.
   * @param string $end
   *   The end date string in YYYY-MM-DD format.
   * @return object
   *   The resulting object fetched from the DB.
   */
  function view_all($start = FALSE, $end = FALSE, $limit = FALSE) {
    $this->db->select('*, time.id as time_id');
    $this->db->from('time');
    $this->db->join('projects', 'projects.id = time.project_id');
    if ($start)
      $this->db->where('date >=', $start);
    if ($end)
      $this->db->where('date <=', $end);
    $this->db->where('time.user_id', $this->tank_auth->get_user_id());
    $this->db->order_by('time.date', 'desc');
    $this->db->order_by('time.id', 'desc');
    if ($limit) {
      $this->db->limit($limit);
    }
    $query = $this->db->get();
    return $query->result();
  }





  /**
   * Fetch all time entries for a specific project.
   *
   * Optionally, filter by start date and end date.
   *
   * @param int $project_id
   *   The ID of the project
   * @param int $limit
   *   An optional limit of number of results returned.
   * @return object
   *   The resulting object fetched from the DB.
   */
  function view_by_project($project_id, $limit = FALSE) {
    $this->db->where('project_id', $project_id);
    $this->db->order_by('date', 'desc');
    $this->db->order_by('time.id', 'desc');
    if ($limit) {
      $this->db->limit($limit);
    }
    $query = $this->db->get('time');
    return $query->result();
  }




  /**
   * Grab a task by its ID.
   *
   * @param int $id
   *   The ID of the task.
   * @return object
   *   The task's row in the DB.
   */
  function view_by_id($id) {
    $this->db->where('id', $id);
    $this->db->where('user_id', $this->tank_auth->get_user_id());
    $query = $this->db->get('time');
    return $query->row();
  }




  /**
   * Remove all tags associated with a task.
   *
   * This is used when editing the task, since removing and re-adding is easier than
   * figuring out which have changed, and only altering those.
   *
   * @param int
   *   The ID of the task
   */
  function remove_task_tags($task_id) {
    $this->db->where('task_id', $task_id);
    $this->db->delete('tagstasks');
  }





  /**
   * Sum the time entered per project for a given amount of time.
   *
   * @param string startdate
   *   Optional start date in YYYY-MM-DD format.
   * @param string enddate
   *   Option end date in YYYY-MM-DD format.
   */
  function sum_time($startdate = NULL, $enddate = NULL) {
    $this->db->select('name, SUM(time.duration) AS sum');
    $this->db->from('time');
    $this->db->join('projects', 'projects.id = time.project_id');
    $this->db->group_by('project_id');

    if ($startdate && !$enddate) {
      $enddate = $startdate;
    }

    if ($startdate && $enddate) {
      $this->db->where('date >=', $startdate);
      $this->db->where('date <=', $enddate);
    }

    $this->db->where('time.user_id', $this->tank_auth->get_user_id());
    $query = $this->db->get();
    $result = $query->result();

    $times = array();
    foreach ($result as $row) {
      $times[$row->name] = $row->sum;
    }
    return $times;
  }




  /**
   * Fetch the time per project per day for the given time span.
   *
   * This is the main method of giving time data to line graphs.
   *
   * @param $startdate
   *   String date formatted as YYYY-MM-DD
   * @param $enddate
   *   String date formatted as YYYY-MM-DD
   * @return
   *   Array formatted as '$times[projectname][date] = totaltime'
   */
  function span_time($startdate = NULL, $enddate = NULL, $projectid = NULL) {
    $this->db->select('name, date, SUM(time.duration) AS sum');
    $this->db->from('time');
    $this->db->join('projects', 'projects.id = time.project_id');
    $this->db->group_by('project_id');
    $this->db->group_by('date');
    $this->db->order_by('project_id');

    if ($startdate && !$enddate) {
      $enddate = $startdate;
    }

    if ($startdate && $enddate) {
      $this->db->where('date >=', $startdate);
      $this->db->where('date <=', $enddate);
    }
    if ($projectid) {
      $this->db->where('project_id', $projectid);
    }

    $this->db->where('time.user_id', $this->tank_auth->get_user_id());

    $query = $this->db->get();
    $result = $query->result();

    $times = array();
    foreach ($result as $row) {
      $times[$row->name][$row->date] = $row->sum;
    }
    return $times;
  }

  function change_date($id, $newdate) {
    $data = array('date' => $newdate);

    $this->db->where('id', $id);
    $this->db->where('user_id', $this->tank_auth->get_user_id());
    $this->db->update('time', $data);
  }

  function change_description($id, $newdescription) {
    $data = array('description' => $newdescription);

    $this->db->where('id', $id);
    $this->db->where('user_id', $this->tank_auth->get_user_id());
    $this->db->update('time', $data);
  }

  function change_project($id, $newproject) {
    $projectid = $this->projects->get_id($newproject);
    $data = array('project_id' => $projectid);

    $this->db->where('id', $id);
    $this->db->where('user_id', $this->tank_auth->get_user_id());
    $this->db->update('time', $data);
  }

  function change_duration($id, $newduration) {
    $data = array('duration' => time_to_decimal(trim(strip_tags($newduration))));

    $this->db->where('id', $id);
    $this->db->where('user_id', $this->tank_auth->get_user_id());
    $this->db->update('time', $data);
  }



  /**
   * Returns the date of the earliest time tracked.
   *
   * Optionally filter by project.
   *
   * @param int $projectid
   *   Optional ID of a project to filter by.
   * @return string $date
   *   The earliest date in YYYY-MM-DD format.
   */
  function earliest_time_date($projectid = FALSE) {
    $this->db->order_by('date', 'asc');
    if ($projectid) {
      $this->db->where('project_id', $projectid);
    }
    $this->db->where('user_id', $this->tank_auth->get_user_id());
    $this->db->limit(1);
    $query = $this->db->get('time');
    return $query->row() ? $query->row()->date : FALSE;
  }
}
