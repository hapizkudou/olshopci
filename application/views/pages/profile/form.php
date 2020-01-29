<main role="main" class="container">
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
                            Profile
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
                                <a href="<?= base_url('profile'); ?>" class="btn btn-secondary">Kembali</a>
                            <?= form_close();?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>