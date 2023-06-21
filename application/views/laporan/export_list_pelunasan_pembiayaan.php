<?php 
  $CI = get_instance();
?>
<style type="text/css">
<!--
#hor-minimalist-b
{
  
  background: #fff;
  margin: 10px;
  margin-top: 10px;
  border-collapse: collapse;
  text-align: left;
}
#hor-minimalist-b .title {
  font-size: 10px;
  font-weight: bold;
  color: #000;
  padding: 8px;
  border: 1px solid #262626;
  text-align: center;
}

#hor-minimalist-b .konten {
  font-size: 9px;
  color: #000;
  padding: 8px;
  border: 1px solid #262626;
  text-align: center;
}

#hor-minimalist-b .nominal {
  font-size: 10px;
  color: #000;
  padding: 8px;
  border: 1px solid #262626;
  text-align: right;
}

#hor-minimalist-b .total_saldo {
  font-size: 10px;
  font-weight: bold;
  color: #000;
  padding: 8px;
  border: 1px solid #262626;
  text-align: right;
}

#hor-minimalist-b .zero {
  font-size: 10px;
  font-weight: bold;
  color: #000;
  padding: 8px;
  border-right: 1px solid #262626;
  text-align: center;
}

-->
</style>
<div style="width:100%;">
  <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:22px;">
  <?php echo strtoupper($this->session->userdata('institution_name')) ;?>
  </div>
  <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
  <?php echo $cabang; ?>
  </div>
  <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
  Laporan Pelunasan Pembiayaan
  </div>
  <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
  Tanggal : <?php echo $CI->format_date_detail($from,'id',false,'-');?> s.d <?php echo $CI->format_date_detail($thru,'id',false,'-');?>
  </div>
  <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
  Petugas : <?php echo $petugas; ?>
  </div>
</div>
<hr />
<table id="hor-minimalist-b" align="center">
  <tbody>
    <tr>
      <td class="title" rowspan="2">No.</td>
      <td class="title" rowspan="2">Tgl Lunas</td>
      <td class="title" colspan="2">Anggota</td>
      <td class="title" rowspan="2">Majelis</td>
      <td class="title" rowspan="2">Sumber Dana</td>
      <!-- <td class="title" rowspan="2"> -->
      <td class="title" colspan="3">Pembiayaan</td>
      <td class="title" rowspan="2">Jangka <br>Waktu</td>
      <td class="title" rowspan="2">Jatuh <br>Tempo</td>
      <td class="title" colspan="3">Saldo <br>Hutang</td>
      <td class="title" colspan="3">Saldo <br>Tabungan</td>
      <td class="title" rowspan="2">Verif</td>
      <!-- <td class="title" rowspan="2">Saldo Wajib</td>
      <td class="title" rowspan="2">Saldo Kelompok</td> -->
    </tr>
    <tr>
      <td class="title">Rekening</td>
      <td class="title">Nama</td>
      <td class="title">Jenis</td>
      <td class="title">Pokok</td>
      <td class="title">Margin</td>
      <td class="title">Cnt</td>
      <td class="title">Pokok</td>
      <td class="title">Margin</td>
      <td class="title">Catab</td>
      <td class="title">Wajib</td>
      <td class="title">Klpk</td>
    </tr>
    <?php 
    $no = 1;
    foreach($result as $data){
    $tanggal_lunas = $data['tanggal_lunas'];
    $rekening = $data['account_financing_no'];
    $nama = $data['nama'];
    $majelis = $data['cm_name'];
    $sumber_dana = $data['krd'];
    $pokok = $data['pokok'];
    $margin = $data['margin'];
    $jangka_waktu = $data['jangka_waktu'];
    $jtempo = $data['tanggal_jtempo'];
    $saldo_pokok = $data['saldo_pokok'];
    $saldo_margin = $data['saldo_margin'];
    $periode_jangka_waktu = $data['periode_jangka_waktu'];
    $counter = $data['counter_angsuran'];
    $financing_type = $data['financing_type'];
    $saldo_wajib = $data['saldo_wajib'];
    $saldo_catab = $data['saldo_catab'];
    $saldo_kelompok = $data['saldo_kelompok'];
    $status_pelunasan = $data['status_pelunasan'];

    $sisa = $jangka_waktu - $counter;

    if($periode_jangka_waktu == '0'){
      $periode = 'Hari';
    } else if($periode_jangka_waktu == '1'){
            $periode = 'Minggu';
    } else if($periode_jangka_waktu == '2'){
            $periode = 'Bulan';
    } else if($periode_jangka_waktu == '3'){
            $periode = 'Jatuh Tempo';
    }
    if($financing_type == '0'){
      $pembiayaan = 'Kelompok';
    } else {
      $pembiayaan = 'Individu';
    }

    if($status_pelunasan =='0'){
      $stat_lunas ='T';
    } else {
      $stat_lunas ='Y';
    }
    ?>
    <tr>
      <td class="konten"><?php echo $no++;?></td>
      <td class="konten"><?php echo $CI->format_date_detail($tanggal_lunas,'id',false,'-');?></td>
      <td class="konten"><?php echo $rekening; ?></td>
      <td class="konten"><?php echo $nama; ?></td>
      <td class="konten"><?php echo $majelis; ?></td>
      <td class="konten"><?php echo $sumber_dana; ?></td>
      <td class="konten"><?php echo $pembiayaan; ?></td>
      <td class="nominal"><?php echo number_format($pokok,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($margin,0,',','.'); ?></td>
      <td class="konten"><?php echo $jangka_waktu.' '.$periode; ?></td>
      <td class="konten"><?php echo $CI->format_date_detail($jtempo,'id',false,'-'); ?></td>
      <td class="konten"><?php echo $sisa;?></td>
      <td class="nominal"><?php echo number_format($saldo_pokok,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($saldo_margin,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($saldo_catab,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($saldo_wajib,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($saldo_kelompok,0,',','.'); ?></td>
      <td class="konten"><?php echo $stat_lunas;?></td>
    </tr>      
    <?php } ?>
  </tbody>
</table>
