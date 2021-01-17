<?php module_start() ?>
	<div class="p-4">
		<table style="width: auto">
			<thead>
				<th>#</th>
				<th>NICKNAME</th>
				<th>PERFIL</th>
				<th>ESTADO</th>
				<th></th>
				<th></th>
			</thead>

		<tbody>
			<?php foreach ($users as $key => $user): ?>
				<tr>
					<td><?= $key + 1 ?></td>
					<td><?= $user['nickname'] ?></td>
					<td><?= $user['account'] ?></td>
					<td class="c"><?= $user['state'] ?></td>
					<td> <a href="<?= base_url().'/'.$user['account'] ?>" target="_blank" class="btn bg-secondary">IR A PERFIL</a></td>
					<td>
						<!--<form class="" action="<?= base_url() ?>/c/users" method="post">
							<input type="hidden" name="account" value="<?= $user['account'] ?>">
							<input type="hidden" name="user" value="<?= $user['user'] ?>">
							<input type="hidden" name="pass" value="<?= $user['pass'] ?>">
							<button type="submit" class="btn">LOGUEAR</button>
						</form>
						-->
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>

		</table>
	</div>
<?php module_end() ?>

<script type="text/javascript">
	$_module = {

	}
</script>
