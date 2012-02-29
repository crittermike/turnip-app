<div class="block">
  <div class="block-header"><h2>Your Projects</h2></div>
  <div class="block-content">
    <?php $count = 0; ?>
    <?php $total = count($projects); ?>
    <?php foreach ($projects as $project): ?>
      <?php $count++; ?>
      <h3>
        <a href="/projects/view/<?php echo $project->id; ?>" title="View Project">
          <?php echo $project->name; ?>
        </a>
      </h3>
      <p>
        <strong><?php echo $project->hours; ?></strong> Total :: 
        <strong><?php echo $project->numtasks; ?></strong> Open Task<?php if ($project->numtasks != 1) echo 's';?>
      </p>

      <?php if ($count < $total): ?>
        <?php echo '<hr />'; ?>
      <?php endif; ?>

    <?php endforeach; ?>
  </div>
</div>
