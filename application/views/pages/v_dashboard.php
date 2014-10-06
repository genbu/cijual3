<!--========================= Content Wrapper ==============================-->
<div class="container">
    <h1 class="text-info" style="text-align: center">CIJUAL Apps</h1>
    <h2 style="text-align: center">Aplikasi pengeluaran dan Inventori Barang</h2>
    <br/>
<?php if(isset($dt_contact)){
foreach($dt_contact as $row){
?>
    <div class="row well" style="text-align: center">
        <h3><?php echo $row->nama?></h3>
        <h4><?php echo $row->desc?></h4>
        <h5 class="muted"><?php echo $row->alamat?></h5>
        <h5 class="muted"><a href="mailto:<?php echo $row->email?>"><?php echo $row->email?></a> || <?php echo $row->telp?> || <a href="<?php echo $row->website?>" target="_blank"><?php echo $row->website?></a></h5>

    </div>
<?php }
}
?>
	<div class="row well">
		<h4>Notifikasi :</h4>
		<p>Pemberitahuan Stok Kurang :</p>
	</div>


</div>


