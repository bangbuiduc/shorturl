<form method="post" action="<?php echo admin_url( 'admin.php' ); ?>" class="create-form">
	<?php wp_nonce_field( 'bs-create-url' ) ?>
    <input type="hidden" name="action" value="bs_create_url">

    <div class="form-row align-items-end">
        <div class="col-auto">
            <label for="real_url">Dán đường dẫn <span class="required">(*)</span></label>
            <input type="text" id="real_url" name="real_url" class="form-control mb-2 mr-sm-2 real-url" required>
        </div>
        <div class="col-auto">
            <label for="short_url">Rút gọn (20 ký tự)</label>
            <input type="text" id="short_url" name="short_url" maxlength="20"
                   class="form-control mb-2 mr-sm-2 short-url">
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-primary mb-2">Submit</button>
        </div>
    </div>
    <p class="error">(*) Bắt buộc</p>

</form>