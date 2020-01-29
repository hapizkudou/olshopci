<main role="main" class="container">
    <?php $this->load->view('layouts/_alert');?>
    <div class="row">
        <div class="col-md-3">
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('layouts/_menu');?>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            Konfirmasi Orders #<?= $orders->invoice?>
                            <div class="float-right">
                                <?php $this->load->view('layouts/_status', ['status' => $orders->status]);?>
                            </div>
                        </div>
                        <div class="card-body">
                            <?= form_open_multipart($form_action, ['method' => 'POST']);?>
                                <?= form_hidden('id_orders', $orders->id);?>
                                <div class="form-group">
                                    <label for="">Transaksi</label>
                                    <input type="text" class="form-control" value="<?= $orders->invoice?>" readonly>
                                    <!-- valuenya berasal dari no order transaksi -->
                                </div>
                                <div class="form-group">
                                    <label for="">Dari Rekening a/n</label>
                                    <input type="text" name="account_name" value="<?= $input->account_name?>" class="form-control">
                                    <?= form_error('account_name');?>
                                </div>
                                <div class="form-group">
                                    <label for="">No. Rekening</label>
                                    <input type="text" name="account_number" value="<?= $input->account_number?>" class="form-control">
                                    <?= form_error('account_number');?>
                                </div>
                                <div class="form-group">
                                    <label for="">Sebesar</label>
                                    <input type="number" name="nominal" value="<?= $input->nominal?>" class="form-control">
                                    <?= form_error('nominal');?>
                                </div>
                                <div class="form-group">
                                    <label for="">Catatan</label>
                                    <textarea name="note" id="" cols="30" rows="5" class="form-control">-</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Bukti Transfer</label>
                                    <br>
                                    <input type="file" name="image" id="">
                                    <?php if($this->session->flashdata('image_error')) :?>
                                        <br>
                                        <small class="text-form text-danger">
                                            <?= $this->session->flashdata('image_error')?>
                                        </small>
                                    <?php endif?>
                                </div>
                        </div>
                        <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Konfirmasi Pembanyaran</button>
                            <?= form_close();?>
                            <!-- tag penutup dibuat disini karena terpisah dari card-body -->
                        </div>
                    </div>
                </div>
            </div>
        </div>                
    </div>
</main>