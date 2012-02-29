<?php if ($tasks): ?>
  <ul class="noformat" id="task-list">
    <?php foreach($tasks as $task): ?>
      <li>
        <a href="/tasks/view/<?php echo $task->id; ?>" title="View Task">
          <span class="num">#<?php echo $task->id . '</span>: ' . $task->title; ?>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>

<?php else: ?>
  <p>Sorry! There are no tasks for this tag.</p>
<?php endif; ?>
