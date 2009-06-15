<div>Archive</div>
<div>
    <?php foreach($posts as $post) : ?>
        <h2><?php echo $post['title']; ?></h2>
        <hr />
        <div><?php echo $post['body']; ?></div>
    <?php endforeach; ?>
</div>