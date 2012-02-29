<span class="hide id"><?php echo $task->id; ?></span>

<div class="block first">

  <div class="block-header">
    <h2><?php echo $title;?></h2>
  </div>

  <div class="block-content">
    <h2 id="title" class="text-editable<?php if ($closed) echo ' closed'; ?>"><?php echo $task->title; ?></h2>

    <div id="tags" class="tag-editable">

    <?php if ($tags): ?>

      <?php foreach ($tags as $tag): ?>
        <span class="tag"><?php echo $tag->name; ?></span>
      <?php endforeach; ?>

    <?php else: ?>
      <span class="small">(no tags)</span>
    <?php endif; ?>

    </div>

    <div id="description" class="textarea-editable"><?php echo $task->description; ?></div>
  </div>
</div>

<div class="block second">
  <div class="block-header">
    <h2>Comments</h2>
  </div>
  <div class="block-content">
    <?php echo $commentform; ?>
    <?php echo $commentlist; ?>
  </div>
</div>
