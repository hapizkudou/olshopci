<main role="main" class="container">
    <?php
    $this->load->view('layouts/_alert');
    ?>
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <span>
                        Kategori
                    </span>
                    <a href="<?= base_url('category/create')?>" class="btn btn-sm btn-info">
                        Tambah <i class="fas fa-plus"></i>
                    </a>
                    <div class="float-right">
                        <!-- <form action=""> mungkin bisa make get -->
                        <!-- fitur search dengan menggunakan method post dan memanfaatkan session -->
                        <?= form_open(base_url('category/search'), ['method' => 'POST']);?>
                            <div class="input-group">
                                <input type="text" name="keyword" value="<?= $this->session->userdata('keyword');?>" class="form-control form-control-sm text-center" placeholder="Cari">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-sm btn-info">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <a href="<?= base_url('category/reset');?>" class="btn btn-info btn-sm">
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
                                <th scope="col">Title</th>
                                <th scope="col">Slug</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($content as $row) :
                            ?>
                            <tr>
                                <td><?= $no++?></td>
                                <td><?= $row->title;?></td>
                                <td><?= $row->slug;?></td>
                                <td>
                                    <?= form_open(base_url("category/erase/$row->id"), ['method' => 'POST']); ?>
                                    <?= form_hidden('id', $row->id); ?>
                                        <a href="<?= base_url("category/edit/$row->id")?>" class="btn btn-sm">
                                            <i class="fas fa-edit text-info"></i>
                                        </a>
                                        <button type="submit" class="btn btn-sm" onclick="return confirm('Apakah kamu yakin menghapus kategori ini?')">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    <?= form_close();?>
                                </td>
                            </tr>
                            <?php
                            endforeach
                            ?>
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation example">
                        <?= $pagination;?>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</main>