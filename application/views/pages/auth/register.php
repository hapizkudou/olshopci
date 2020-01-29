<main role="main" class="container">
    <?php $this->load->view('layouts/_alert')?>
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    Daftar Akun baru sekarang !!
                </div>
                <div class="card-body">
                    <?= form_open('register', ['method' => 'POST'])?> <!-- mengarahkan ke controller/class register dengan method defaultnya yaitu index(olshopci.test/register *karna index tidak perlu dibuat di urlnya) bisa aja di dalam controller register bisa ada method lainnya-->
                        <div class="form-group">
                            <label for="">Nama</label>
                            <?=
                                form_input('name', $input->name, [
                                    'class' => 'form-control', 'placeholder' => 'Masukkan nama anda', 'required' => true, 'autofocus' => true
                                    ]
                                );
                            ?>
                            <?= form_error('name');?>
                        </div>
                        <div class="form-group">
                            <label for="">E-mail</label>
                            <?= 
                                form_input([
                                    'type'          => 'email',
                                    'name'          => 'email',
                                    'value'         => $input->email,
                                    'class'         => 'form-control',
                                    'placeholder'   => 'Masukkan email aktif anda',
                                    'required'      => true
                                    ]
                                );
                            ?>
                            <?= form_error('email')?>
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <?= 
                                form_password('password', '', [
                                    'class'         => 'form-control',
                                    'placeholder'   => 'Minimal password 8 digit !',
                                    'required'      => true
                                ]);
                            ?>
                            <?= form_error('password')?>
                        </div>
                        <div class="form-group">
                            <label for="">Komfirmasi Password</label>
                            <?= 
                                form_password('password_confirmation', '', [
                                    'class'         => 'form-control',
                                    'placeholder'   => 'Ulangin password anda !',
                                    'required'      => true
                                ]);
                            ?>
                            <?= form_error('password_confirmation')?>
                        </div>
                        <button type="submit" class="btn btn-primary">Daftar</button>
                    <?= form_close()?>
                </div>
            </div>
        </div>
    </div>
</main>