<div class="row">
    <div class="col-xs-12 col-md-6">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?= $button;?> Cart</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
                    <i class="fa fa-minus"></i></button>
                     <button type="button" class="btn btn-box-tool" onclick="location.reload()" title="Collapse">
              <i class="fa fa-refresh"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="date">Tgl Transaksi <?php echo form_error('tgl_transaksi') ?></label>
            <input type="text" class="form-control" name="tgl_transaksi" id="tgl_transaksi" placeholder="Tgl Transaksi" value="<?php echo $tgl_transaksi; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Tiket <?php echo form_error('id_tiket') ?></label>
            <input type="text" class="form-control" name="id_tiket" id="id_tiket" placeholder="Id Tiket" value="<?php echo $id_tiket; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Kursi <?php echo form_error('id_kursi') ?></label>
            <input type="text" class="form-control" name="id_kursi" id="id_kursi" placeholder="Id Kursi" value="<?php echo $id_kursi; ?>" />
        </div>
	    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('cart') ?>" class="btn btn-default">Cancel</a>
	</form>
         </div>
        </div>
    </div>
</div>