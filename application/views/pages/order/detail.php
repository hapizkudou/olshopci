<main role="main" class="container">
    <?php $this->load->view('layouts/_alert');?>
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            Detail Orders #<?= $orders->invoice;?>
                            <div class="float-right">
                                <?php $this->load->view('layouts/_status', ['status' => $orders->status])?>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Tanggal        : <?= str_replace('-', '/', date("d-m-Y", strtotime($orders->date)));?></p>
                            <p class="card-text">Nama Pengirim  : <?= $orders->name;?></p>
                            <p class="card-text">Telepon        : <?= $orders->phone;?></p>
                            <p class="card-text">Alamat         : <?= $orders->address;?></p>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-center">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($orders_detail as $row):
                                    ?>
                                    <tr>
                                        <td>
                                            <p><img src="<?= $row->image ? base_url("uploads/product/$row->image"): "https://placehold.co/70x70" ;?>" alt="" height=50><strong> <?= $row->title?></strong></p>
                                        </th>
                                        <td class="text-center">
                                            Rp<?= number_format($row->price, '0', ',', '.');?>,-
                                        </td>
                                        <td class="text-center">
                                            <?= $row->qty?>
                                        </td>
                                        <td class="text-center">
                                            Rp<?= number_format($row->subtotal, '0', ',', '.');?>,-
                                        </td>
                                    </tr>
                                    <?php
                                    endforeach
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right" colspan="3">
                                            <strong>Total :</strong>
                                        </td>
                                        <td class="text-center">
                                            <strong>Rp<?= number_format($orders->total, '0', ',', '.');?>,-</strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="card-footer">
                            <form action="<?= base_url("order/update/$orders->id")?>" method="POST">
                                <input type="hidden" name="id" value="<?= $orders->id?>">
                                <div class="input-group">
                                    <select name="status" id="" class="form-control">
                                        <option value="waiting" <?= $orders->status == 'waiting' ? 'selected' : ''?>>
                                            Menunggu Pembayaran
                                        </option>
                                        <option value="paid" <?= $orders->status == 'paid' ? 'selected' : ''?>>
                                            Dibayar
                                        </option>
                                        <option value="delivered" <?= $orders->status == 'delivered' ? 'selected' : ''?>>
                                            Dikirim
                                        </option>
                                        <option value="cancel" <?= $orders->status == 'cancel' ? 'selected' : ''?>>
                                            Batal
                                        </option>
                                    </select>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php if(isset($orders_confirm)):?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            Bukti Transfer
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card-body">
                                    <p class="card-text">
                                        Dari Rekening   : <?= $orders_confirm->account_number;?>
                                    </p>
                                    <p class="card-text">
                                        Atas Nama       : <?= $orders_confirm->account_name;?>
                                    </p>
                                    <p class="card-text">
                                        Nominal         : Rp<?= number_format($orders_confirm->nominal, '0', ',', '.')?>,-
                                    </p>
                                    <p class="card-text">
                                        Catatan         : <br> <?= $orders_confirm->note;?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card-body">
                                    <img src="<?= base_url("uploads/confirm/$orders_confirm->image")?>" alt="" height=300>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif?>
        </div>
    </div>
</main>