<main role="main" class="container">
    <?php $this->load->view('layouts/_alert')?>
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            Kategori: <strong><?= isset($category) ? $category->title : 'Semua Kategori'?></strong>
                            <span class="float-right">
                                Urutkan Harga : <a href="<?= base_url('shop/sortBy/asc'); ?>"><span class="badge badge-primary">Termurah</span></a> | <a href="<?= base_url('shop/sortBy/desc'); ?>"><span class="badge badge-primary">Termahal</span></a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php foreach ($content as $row) :?>
                <div class="col-md-6">
                    <div class="card mb-3">
                        <img src="<?= $row->image? base_url("uploads/product/$row->image") : "https://placehold.co/70x70" ;?>" class="card-img-top" alt="..." height=300>
                        <div class="card-body">
                            <h5 class="card-title"><?= $row->product_title;?></h5>
                            <p class="card-text"><strong>Rp<?= number_format($row->price, '0', ',', '.');?>,-</strong></p>
                            <p class="card-text"><?= substr($row->description, 0, 100)." ...";?></p>
                            <a href="<?= base_url("shop/category/$row->category_slug") ?>" class="badge badge-primary">
                                <i class="fas fa-tags"></i> <?= $row->category_title;?>
                            </a>
                        </div>
                        <div class="card-footer">
                            <form action="<?= base_url('cart/add')?>" method="POST">
                            <input type="hidden" name="id_product" value="<?= $row->id?>">
                                <div class="input-group">
                                    <input type="number" name="qty"  value="1" class="form-control">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach?>
            </div>
            <nav aria-label="Page navigation example">
                <?= $pagination;?>
            </nav>
        </div>

        <div class="col-md-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            Pencarian
                        </div>
                        <div class="card-body">
                            <!-- <form action=""> mungkin bisa make get -->
                            <?= form_open(base_url('shop/search'), ['method' => 'POST'])?>
                                <div class="input-group">
                                    <input type="text" name="keyword" value="<?= $this->session->userdata('keyword');?>" class="form-control" placeholder="Cari">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        <a href="<?= base_url('shop/reset');?>" class="btn btn-primary">
                                            <i class="fas fa-eraser"></i>
                                        </a>
                                    </div>
                                </div>
                            <?= form_close();?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            Kategori
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <a href="<?= base_url('/')?>">Semua Kategori</a>
                            </li>
                            <?php foreach(getCategories() as $value) :?>
                            <li class="list-group-item">
                                <a href="<?= base_url("shop/category/$value->slug");?>"><?= $value->title?></a>
                            </li>
                            <?php endforeach?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

        
