<div class="container-fluid">
	<?php require_once 'create-form.php'; ?>

    <table class="table mt-5">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Short url</th>
            <th scope="col">Real url</th>
            <th scope="col">User id</th>
            <th scope="col">Created at</th>
            <th scope="col">Total click</th>
        </tr>
        </thead>
        <tbody>
		<?php $items = bs_all_url( true ); ?>
		<?php foreach ( $items as $i => $item ): ?>
            <tr>
                <th scope="row"><?php echo $i + 1; ?></th>
                <td><?php echo bs_generate_url($item->short_url) ?></td>
                <td><?php echo $item->real_url ?></td>
                <td><?php echo $item->user_id ?></td>
                <td><?php echo $item->created_at ?></td>
                <td><?php echo '0' ?></td>
            </tr>
		<?php endforeach; ?>
        </tbody>
    </table>
</div>