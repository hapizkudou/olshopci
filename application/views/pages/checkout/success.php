<main role="main" class="container">
    <?php $this->load->view('layouts/_alert');?>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">
                    Berhasil
                </div>
                <div class="card-body">
                    <h5 class="card-title">Nomor Order : <?= $content->invoice;?></h5>
                    <p class="cart-text">Terima kasih, sudah berbelanja</p>
                    <p class="cart-text">Silahkan lakukan pembayaran untuk bisa kami proses selanjutnya dengan cara :</p>
                    <ol>
                        <li>
                            <p class="cart-text">Lakukan pembayaran pada rekening <strong>BCA 321456789</strong> a/n <strong>PT.olshopCI</strong></p>
                        </li>
                        <li>
                            <p class="cart-text">Sertakan keterangan dengan nomor order : <strong><?= $content->invoice;?></strong></p>
                        </li>
                        <li>
                            <p class="cart-text">Total pembayaran : <strong>Rp<?= number_format($content->total, '0', ',', '.');?>-</strong></p>
                        </li>
                    </ol>
                    <p class="cart-text">Jika sudah, silahkan kirimkan bukti transfer di halaman konfirmasi atau bisa <a href="<?= base_url("myorder/detail/$content->invoice")?>">klik di sini!</a></p>
                    <a href="<?= base_url('/');?>" class="btn btn-primary"><i class="fas fa-angle-left"></i> Kembali berbelanja</a>
                </div>
            </div>
        </div>
    </div>
</main>