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

        
        <div class="col-md-3">
        <?= form_open_multipart($form_action, ['method' => 'POST'])?>
        <?= isset($input->id) ? form_hidden('id', $input->id) : '';?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <?php if(isset($input->image)):?>
                                <img src="<?= base_url("uploads/user/$input->image"); ?>" alt="" height=200>
                            <?php endif?>
                        </div>
                        <div class="form-group text-center">
                            <label for="">Photo</label>
                            <br>
                            <!-- <input type="file" name="photo" id=""> -->
                            <?= form_upload('image');?>
                            <?= form_error('image');?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-body">
                        
                            <div class="form-group">
                                <label for="">Nama</label>
                                <!-- <input type="text" class="form-control" required autofocus> -->
                                <?= form_input('name', $input->name, [
                                    'class'     => 'form-control',
                                    'placeholder' => 'Masukkan nama anda',
                                    'required'  => true,
                                    'autofocus' => true
                                ]);?>
                                <?= form_error('name');?>
                            </div>
                            <div class="form-group">
                                <label for="">E-mail</label>
                                <!-- <input type="email" class="form-control" required> -->
                                <?= form_input('email', $input->email, [
                                    'type'      => 'email',
                                    'class'     => 'form-control',
                                    'placeholder'   => 'Masukkan email aktif anda',
                                    'required'  => true
                                ]);?>
                                <?= form_error('email');?>
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <!-- <input type="password" class="form-control" required> -->
                                <?= form_password('password', '', [
                                    'class'     => 'form-control',
                                    'placeholder'   => 'Minimal password 8 digit !'
                                ]);?>
                                <?= form_error('password');?>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="<?= base_url('profile'); ?>" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        <?= form_close();?>
        </div>
    </div>
</main>