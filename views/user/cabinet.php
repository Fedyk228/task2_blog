<?php
?>

<h1 class="s-title">Cabinet page</h1>

<?php if($role == 'admin') : ?>
<a href="/web/user/accounts" class="me-3">Manage users</a>
<a href="/web/posts/categories" class="me-3">Manage categories</a>

<?php endif; ?>

<a href="/web/posts" class="me-3">Manage posts</a>
<a href="/web/comments">Manage comments</a>

