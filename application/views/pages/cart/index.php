<main role="main" class="container">
    <?php $this->load->view('layouts/_alert');?>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">
                    Cart
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center">Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($content as $row) :?>
                            <tr>
                                <td>
                                    <p><img src="<?= $row->image ? base_url("uploads/product/$row->image"): "https://placehold.co/70x70" ;?>" alt="" height=50>
                                        <strong> <?= $row->title?></strong>
                                    </p>
                                </th>
                                <td class="text-center">Rp<?= number_format($row->price, '0', ',', '.');?>,-</td>
                                <td >
                                    <form action="<?= base_url("cart/update/$row->id");?>" method="POST">
                                    <input type="hidden" name="id" value="<?= $row->id?>">
                                        <div class="input-group">
                                            <input type="number" name="qty" class="form-control text-center" value="<?= $row->qty;?>">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                                <td class="text-center">Rp<?= number_format($row->subtotal, '0', ',', '.');?>,-</td>
                                <td class="text-center">
                                    <form action="<?= base_url("cart/erase/$row->id");?>" method="POST">
                                    <input type="hidden" name="id" value="<?= $row->id?>">
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah kamu yakin ingin menghapus cart ini?')"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-right" colspan="3">
                                    <strong>Total</strong>
                                </td>
                                <td class="text-center">
                                    <strong>Rp<?= number_format(array_sum(array_column($content, 'subtotal')), '0', ',', '.')?>-</strong>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('/')?>" class="btn btn-info"><i class="fas fa-angle-left"></i> Kembali Belanja</a>
                    <a href="<?= base_url('checkout')?>" class="btn btn-success float-right">Pembanyaran <i class="fas fa-angle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</main>