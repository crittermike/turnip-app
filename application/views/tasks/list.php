<div class="block">
  <div class="block-header">
    <h2>Your Tasks</h3>

    <a href="/tasks/add" title="Add Task" class="left button addtask">New Task</a>
    <form class="alignright" action="">
      <div>
        <span id="taskfilter">
          <label for="task-filter">Filter</label>
          <input name="task-filter" id="task-filter" type="text" />
        </span>
        <span id="taskradios">
          <input type="radio" id="radioall" name="taskradio" />
          <label for="radioall">All Tasks</label>
          <input type="radio" id="radioopen" name="taskradio" checked="checked" />
          <label for="radioopen">Open Tasks</label>
          <input type="radio" id="radioclosed" name="taskradio" />
          <label for="radioclosed">Closed Tasks</label>
        </span>
      </div>
    </form>
  </div>

  <div class="block-content">
    <table cellpadding="0" cellspacing="0" id="task-list">
      <thead>
        <tr>
          <th>#</th>
          <th>Project</th>
          <th>Task</th>
          <th>Tags</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($tasks as $task): ?>

          <?php $class = 'open'; ?>
          <?php if ($task->closed != "0000-00-00 00:00:00"): ?>
            <?php $class = 'closed hide'; ?>
          <?php endif; ?>

          <tr class="<?php echo $class; ?>">
            <td class="nonlinks num">
              <?php echo $task->id; ?>
            </td>
            <td class="nonlinks project">
              <?php echo $task->project; ?>
            </td>
            <td class="links title">
              <a href="/tasks/view/<?php echo $task->id; ?>" title="View or edit this task">
                <?php echo $task->title; ?>
              </a>
            </td>
            <td class="nonlinks">
              <?php if ($task->tags): ?>
                <?php foreach ($task->tags as $tag): ?>
                  <a class="tag" title="View tasks with this tag" href="/tasks/tag/<?php echo $tag->name; ?>"><?php echo $tag->name; ?></a>
                <?php endforeach; ?>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
