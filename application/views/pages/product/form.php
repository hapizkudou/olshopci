<main role="main" class="container">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    Tambah Produk
                </div>
                <div class="card-body">
                    <?= form_open_multipart($form_action, ['method' => 'POST'])?>
                    <?= isset($input->id) ? form_hidden('id', $input->id) : '';?>
                        <div class="form-group">
                            <label for="">Produk</label>
                            <?= form_input('title', $input->title, [
                                'class' => 'form-control',
                                'id'    => 'title',
                                'onkeyup'  => 'createSlug()',
                                'required'  => true,
                                'autofocus' => true                                
                            ]);
                            ?>
                            <?= form_error('title');?>
                        </div>
                        <div class="form-group">
                            <label for="">Deskripsi</label>
                            <?= form_textarea('description', $input->description, [
                                'class' => 'form-control',
                                'rows'  => 5
                            ]);
                            ?>
                            <?= form_error('description');?>
                        </div>
                        <div class="form-group">
                            <label for="">Harga</label>
                            <?= form_input('price', $input->price, [
                                'type'      => 'number',
                                'class'     => 'form-control',
                                'required'  => true
                            ]);?>
                            <?= form_error('price');?>
                        </div>
                        <div class="form-group">
                            <label for="">Kategori</label>
                            <?= form_dropdown('id_category', getDropdownList('category', ['id', 'title']), $input->id_category, ['class' => 'form-control']);?>
                            <?= form_error('id_category');?>
                        </div>
                        <div class="form-group">
                            <label for="">Ada Stock ?</label>
                            <br>
                            <!-- untuk form_helper radio bisa di liat di modul 8.Membuat modul Admin Produk/video no 5 -->
                            <div class="form-check form-check-inline">
                                <!-- <input type="radio" name="is_available" class="form-check-input" value=1 checked> -->
                                <?= form_radio('is_available', 1, $input->is_available == 1 ? true : false, ['class' => 'form-check-input']);?>
                                <label for="" class="form-check-label">Tersedia</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <!-- <input type="radio" name="is_available" class="form-check-input" value=0> -->
                                <?= form_radio('is_available', 0, $input->is_available == 0 ? true : false, ['class' => 'form-check-input']);?>
                                <label for="" class="form-check-label">Kosong</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Gambar Produk</label>
                            <br> <!-- cari cara biar bisa nyimpan banyak foto (untuk database mungkin bisa make array)-->
                            <?= form_upload('image');?>
                            <?php if($this->session->flashdata('image_error')) :?>
                                <small class="text-form text-danger">
                                    <?= $this->session->flashdata('image_error')?>
                                </small>
                            <?php endif?>
                            <?php if(isset($input->image)):?>
                                <img src="<?= base_url("uploads/product/$input->image")?>" alt="" height=150>
                            <?php endif?>
                        </div>
                        <div class="form-group">
                            <label for="">Slug</label>
                            <?= 
                            form_input('slug', $input->slug, [
                                'class' => 'form-control',
                                'id'    => 'slug',
                                'required'  => true
                            ]);
                            ?>
                            <?= form_error('slug');?>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="<?= base_url('product') ?>" class="btn btn-secondary">Kembali</a>
                    <?= form_close();?>
                </div>
            </div>
        </div>
    </div>
</main>