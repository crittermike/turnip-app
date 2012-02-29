<div class="block">
  <div class="block-header"><h2><?php echo $project->name;?> Time</h2></div>
  <div class="block-content"><?php echo $project->chart; ?></div>
</div>

<div class="block first">
  <div class="block-header"><h2>Time Log</h2></div>
  <div class="block-content">

    <?php if ($project->times): ?>
      <table>
        <thead>
          <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($project->times as $time): ?>
            <tr>
              <td class="nonlinks"><?php echo $time->date; ?></td>
              <td class="nonlinks"><?php echo decimal_to_time($time->duration); ?></td>
              <td class="nonlinks"><?php echo $time->description; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

    <?php else: ?>
      <h3 class="aligncenter">No time entries for this project.</h3>
    <?php endif; ?>

  </div>
</div>

<div class="block last">
  <div class="block-header"><h2>Open Tasks</h2><a href="/tasks/add" class="addtask right button">Add Task</a></div>
  <div class="block-content">
    <?php if ($project->tasks): ?>

      <?php foreach ($project->tasks as $task): ?>
        <h3><a href="/tasks/view/<?php echo $task->id; ?>"><?php echo $task->title; ?></a></h3>
      <?php endforeach; ?>

    <?php else: ?>
      <h3 class="aligncenter">No open tasks for this project.</h3>
    <?php endif; ?>
  </div>
</div>
