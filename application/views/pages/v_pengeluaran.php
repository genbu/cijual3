<!--================ Content Wrapper===========================================-->
<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Kode pengeluaran</th>
        <th>Jumlah</th>
        <th>Total Harga</th>
        <th class="span3">
            <a href="<?php echo site_url('pengeluaran/pages_tambah_pengeluaran')?>" class="btn btn-mini btn-block btn-inverse" data-toggle="modal">
                <i class="icon-plus-sign icon-white"></i> Tambah Data
            </a>
        </th>
    </tr>
    </thead>
    <tbody>
    <?php
    $no=1;
    if(isset($data_pengeluaran)){
        foreach($data_pengeluaran as $row){
            ?>
            <tr class="gradeX">
                <td><?php echo $no++; ?></td>
                <td><?php echo date("d M Y",strtotime($row->tanggal_pengeluaran)); ?></td>
                <td><?php echo $row->kd_pengeluaran; ?></td>
                <td><?php echo $row->jumlah; ?> Items</td>
                <td><?php echo currency_format($row->total_harga); ?></td>
                <td>
                    <a class="btn btn-mini" href="<?php echo site_url('pengeluaran/detail_pengeluaran/'.$row->kd_pengeluaran)?>">
                        <i class="icon-eye-open"></i> View</a>
                    <a class="btn btn-mini" href="<?php echo site_url('pengeluaran/hapus/'.$row->kd_pengeluaran)?>"
                       onclick="return confirm('Anda Yakin ?');">
                        <i class="icon-trash"></i> Hapus</a>
                    <a class="btn btn-mini btnPrint" href="<?php echo site_url('cetak/print_pengeluaran/'.$row->kd_pengeluaran)?>">
                        <i class="icon-print"></i> Print</a>
                </td>
            </tr>
        <?php }
    }
    ?>

    </tbody>
</table>



