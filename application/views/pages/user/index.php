<main role="main" class="container">
    <?php $this->load->view('layouts/_alert');?>
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <span>
                        Pengguna
                    </span>
                    <a href="<?= base_url('user/create') ?>" class="btn btn-sm btn-info">
                        Tambah <i class="fas fa-plus"></i>
                    </a>
                    <a href="<?= base_url('user/cleanImage')?>" class="btn btn-sm btn-info" onclick="return confirm('Apakah kamu yakin ingin membersihkan file image yang tidak terpakai?')">
                        Hapus <i class="fas fa-trash"></i>
                    </a>
                    <div class="float-right">
                        <!-- <form action=""> mungkin bisa make get -->
                        <?= form_open(base_url('user/search'), ['method' => 'POST']);?>
                            <div class="input-group">
                                <input type="text" name="keyword" value="<?= $this->session->userdata('keyword'); ?>" class="form-control form-control-sm text-center" placeholder="Cari">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-sm btn-info">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <a href="<?= base_url('user/reset');?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-eraser"></i>
                                    </a>
                                </div>
                            </div>
                        <?= form_close();?>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Pengguna</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Role</th>
                                <th scope="col">Status</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                foreach ($content as $row):
                            ?>
                            <tr>
                                <td><?= $no++?></td>
                                <td>
                                    <p>
                                        <img src="<?= $row->image? base_url("uploads/user/$row->image") : base_url("uploads/user/default.png") ;?>" alt="" height=50>
                                        <?= $row->name;?>
                                    </p>
                                </td>
                                <td><?= $row->email;?></td>
                                <td><?= $row->role == 'admin'? 'Admin': 'Member';?></td>
                                <td><?= $row->is_active == 1 ? 'Aktif': 'Tidak Aktif';?></td>
                                <td>
                                    <!-- <form action=""> -->
                                    <?= form_open(base_url("user/erase/$row->id"), ['method' => 'POST'])?>
                                    <?= form_hidden('id', $row->id);?>
                                        <a href="<?= base_url("user/edit/$row->id")?>" class="btn btn-sm">
                                            <i class="fas fa-edit text-info"></i>
                                        </a>
                                        <button type="submit" class="btn btn-sm" onclick="return confirm('Apakah kamu yakin ingin menghapus pengguna ini?')">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    <?= form_close();?>
                                </td>
                            </tr>
                            <?php endforeach?>
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation example">
                        <?= $pagination?>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</main>