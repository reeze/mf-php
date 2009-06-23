<?php echo '<?xml version="1.0" encoding="UTF-8" ?>' ?>
<feed xmlns="http://www.w3.org/2005/Atom" xml:lang="en">
  <title>MF-PHP</title>
  <link rel="alternate" href="http://www.doctrine-project.org/blog"></link>
  <id>http://www.doctrine-project.org/blog</id>
  <updated>2009-06-21T01:05:00Z</updated>
<?php foreach ($posts as $post): ?>
<entry>
  <title><?php echo $post['title'] ?></title>
  <link rel="alternate" href="<?php echo url_for('@homepage'); ?>"></link>
  <updated><?php echo $post['created_at'] ?></updated>
  <author>
    <name>reeze</name>
    <email>reeze.xia@gmail.com</email>
  </author>
  <id><?php echo url_for('@homepage'); ?></id>
  <summary type="text"><?php echo $post['content'] ?></summary>
  <content type="html"><![CDATA[<?php echo $post['content'] ?>]]></content>
</entry>
<?php endforeach; ?>
</feed>