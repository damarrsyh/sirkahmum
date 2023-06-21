<style type="text/css">
<!--
#hor-minimalist-b
{
  
  font-size: 12px;
  background: #fff;
  margin: 10px;
  margin-top: 10px;
  margin-left: 5px;
  border-collapse: collapse;
  text-align: left;
}
#hor-minimalist-b th
{
  font-size: 15px;
  font-weight: normal;
  color: #000;
  padding: 10px 8px;
  border-top: 2px solid #6678b1;
  border-bottom: 2px solid #6678b1;
}
#hor-minimalist-b .no
{
  border: 1px solid #262626;
  color: #000;
  width: 5%;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .anggota
{
  border: 1px solid #262626;
  color: #000;
  width: 20%;
  padding: 10px;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .jumlah
{
  border: 1px solid #262626;
  color: #000;
  width: 10%;
  padding: 10px;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .pokok
{
  border: 1px solid #262626;
  color: #000;
  width: 20%;
  padding: 10px;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .nominal
{
  border-bottom: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  border-right: 1px solid #262626;
  color: #000;
  width: 20%;
  text-align: right;
  padding: 6px 8px;
}

/*value*/
.value
{
  font-size: 11px;
}
#hor-minimalist-b .val_no
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .val_anggota
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .val_jumlah
{
  border: 1px solid #262626;
  color: #000;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .val_pokok
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  padding: 6px 20px;
  text-align: right;
}
#hor-minimalist-b .val_kosong
{
  border-bottom: 1px solid #fff;
  border-right: 1px solid #fff;
  border-top: 1px solid #fff;
  color: #000;
  padding: 6px 8px;
  text-align: center;
}
#hor-minimalist-b .val_kosong2
{
  border-bottom: 1px solid #fff;
  border-right: 1px solid #262626;
  border-top: 1px solid #fff;
  color: #000;
  padding: 6px 8px;
  text-align: center;
}
-->
</style>
<page>
      <div style="width:100%;">
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:20px;">
        <?php echo strtoupper($this->session->userdata('institution_name')) ;?>
        </div>
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:16px;">
        <?php echo $cabang;?>
        </div>
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:16px;">
        Rekap Pelunasan Pembiayaan Berdasarkan Cabang
        </div>
        <div style="text-align:left;padding-top:20px;font-family:Arial;font-size:12px;">
        Tanggal : <?php echo $tanggal1_;?> s/d <?php echo $tanggal2_;?>
        </div>
        <hr>
      </div>
<table id="hor-minimalist-b" align="center">
    <tbody>
      <tr>
            <td class="no" style="width:80px;">Kode</td>
            <td class="anggota" style="width:100px;">Keterangan</td>
            <td class="jumlah">Jumlah</td>
            <td class="pokok">Nominal</td>
            <td class="pokok" style="width:70px;">Persentase Jumlah</td>
            <td class="pokok" style="width:70px;">Persentase Nominal</td>
      </tr>
      <?php
        $sum_anggota = 0;
        $sum_pokok = 0;
        foreach ($result as $data):     
        $sum_anggota+=$data['num'];     
        $sum_pokok+=$data['amount'];     
      ?>
      <?php 
          endforeach;
      ?>      
      <?php
      $no = 1; 
      $total_anggota = 0;
      $total_pokok = 0;
        foreach ($result as $data):     
        $total_anggota+=$data['num'];     
        $total_pokok+=$data['amount'];      
        $persen_jumlah = $data['num']/$sum_anggota*100;
        $persen_nominal = $data['amount']/$sum_pokok*100;
      ?>
      <tr class="value">
            <td class="val_anggota" style="padding:5px;"><?php echo $no++;?></td>
            <td class="val_anggota" style="padding:5px;"><?php echo $data['branch_name'];?></td>
            <td class="val_jumlah" style="padding:5px;"><?php echo $data['num'];?></td>
            <td class="val_pokok" style="padding:5px;"><?php echo number_format($data['amount'],0,',','.');?></td>
            <td class="val_jumlah"><?php echo number_format($persen_jumlah,2,',','.');?></td>
            <td class="val_jumlah"><?php echo number_format($persen_nominal,2,',','.');?></td>
      </tr>
    <?php 
        endforeach;
    ?>      
      <tr class="value">
            <td class="val_kosong" style="padding:5px;">&nbsp;</td>
            <td class="val_kosong2" style="padding:5px;">&nbsp;</td>
            <td class="val_jumlah" style="padding:5px;"><?php echo $total_anggota;?></td>
            <td class="val_pokok" style="padding:5px;"><?php echo number_format($total_pokok,0,',','.');?></td>
      </tr>
    </tbody>
</table>
</page>