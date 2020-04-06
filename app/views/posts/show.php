<?php require APPROOT . '/views/inc/header.php'?>
  <a href="<?php echo URLROOT ?>/posts" class="btn btn-light"><i class="fas fa-backward"></i> Back</a>
  <br>
  <h1><?php echo $data['post']->title ?></h1>
  <div class="bg-secondary text-white p-2 mb-3">
    Written By <?php echo $data['post']->name ?> On <?php echo $data['post']->created_at ?>
  </div>
  <p><?php echo $data['post']->body; ?></p>
  <hr>
  <?php if ($_SESSION['user_id'] == $data['post']->user_id): ?>
    <a href="<?php echo URLROOT?>/posts/edit/<?php echo $data['post']->id ?>" class='btn btn-dark'>Edit</a>
    <form method="POST" action="<?php echo URLROOT; ?>/posts/delete/<?php echo $data['post']->id ?>" class="float-right">
      <input type="submit" class="btn btn-danger" value="Delete">
    </form>
  <?php endif; ?>
<?php require APPROOT . '/views/inc/footer.php'?>