<!-- File: /app/views/posts/index.ctp -->

<h1>Blog posts</h1>
<?php echo $html->link( 'Add Post', 'add', array('controller' => 'posts', 'action' => 'add' )); ?>
<br /><br />
<table>
	<tr>
		<th>Id</th>
		<th>Title</th>
		<th>Action</th>
		<th>Created</th>
	</tr>

	<!-- Here is where we loop through our $posts array, printing out post info -->

	<?php foreach ($posts as $post): ?>
	<tr>
		<td><?php echo $post['Post']['id']; ?></td>
		<td>
			<?php echo $html->link($post['Post']['title'], "/posts/view/".$post['Post']['id']); ?>
		</td>
		<td>
			<?php echo $html->link( 'Delete', array( 'action' => 'delete', 'id' => $post['Post']['id'] ), null, 'Are you sure?') ?>
			<?php echo $html->link('Edit', array('action'=>'edit', 'id'=>$post['Post']['id']));?>
		</td>
		<td><?php echo $post['Post']['created']; ?></td>
	</tr>
	<?php endforeach; ?>

</table>