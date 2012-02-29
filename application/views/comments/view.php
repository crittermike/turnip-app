<div id="comments">
  <?php if ($comments): ?>
    <?php foreach ($comments as $comment): ?>
      <div class="comment">
        <span class="posted">Posted on <?php echo $comment->posted; ?></span>
        <div class="content"><?php echo $comment->content; ?></div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>
