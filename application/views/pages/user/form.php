<main role="main" class="container">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    Tambah Pengguna
                </div>
                <div class="card-body">
                    <!-- <form action=""> -->
                    <?= form_open_multipart($form_action, ['method' => 'POST'])?>
                    <?= isset($input->id) ? form_hidden('id', $input->id) : '';?>
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
                        <div class="form-group">
                            <label for="">Role</label>
                            <br>
                            <div class="form-check form-check-inline">
                                <?= form_radio('role', 'admin', $input->role == 'admin' ? true : false, ['class' => 'form-check-input']);?>
                                <label for="" class="form-check-label">Admin</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <?= form_radio('role', 'member', $input->role == 'member' ? true : false, ['class' => 'form-check-input']);?>
                                <label for="" class="form-check-label">Member</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Status</label>
                            <br>
                            <div class="form-check form-check-inline">
                                <?= form_radio('is_active', 1, $input->is_active == 1 ? true : false, ['class' => 'form-check-input']);?>
                                <label for="" class="form-check-label">Aktif</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <?= form_radio('is_active', 0, $input->is_active == 0 ? true : false, ['class' => 'form-check-input']);?>
                                <label for="" class="form-check-label">Tidak Aktif</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Photo</label>
                            <br>
                            <!-- <input type="file" name="photo" id=""> -->
                            <?= form_upload('image');?>
                            <?= form_error('image');?>
                            <?php if(isset($input->image)):?>
                                <img src="<?= base_url("uploads/user/$input->image"); ?>" alt="" height=150>
                            <?php endif?>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="<?= base_url('user'); ?>" class="btn btn-secondary">Kembali</a>
                    <?= form_close();?>
                </div>
            </div>
        </div>
    </div>
</main>