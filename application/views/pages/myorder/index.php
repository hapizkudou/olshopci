<main role="main" class="container">
    <?php $this->load->view('layouts/_alert');?>
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
                            Daftar Orders
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($content as $row):
                                    ?>
                                    <tr>
                                        <td>
                                            <strong>
                                                <a href="<?= base_url("myorder/detail/$row->invoice")?>">#<?= $row->invoice;?></a>
                                            </strong>
                                        </td>
                                        <td><?= str_replace('-', '/', date("d-m-Y", strtotime($row->date)));?></td>
                                        <td><strong>Rp<?= number_format($row->total, '0', ',', '.');?>,-</strong></td>
                                        <td>
                                            <?php $this->load->view('layouts/_status', ['status' => $row->status]);?>
                                        </td>
                                    </tr>
                                    <?php
                                    endforeach
                                    ?>
                                </tbody>
                            </table>
                            <nav aria-label="Page navigation example">
                                <?= $pagination?>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>