<style type="text/css">
<!--
#hor-minimalist-b
{
  
  font-size: 12px;
  background: #fff;
  margin: 10px;
  margin-top: 10px;
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
  text-align: left;
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
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:22px;">
        <?php echo strtoupper($this->session->userdata('institution_name')) ;?>
        </div>
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
        <?php echo $cabang;?>
        </div>
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
        List Saldo Anggota Berdasarkan Kecamatan
        </div>
        <div style="text-align:left;padding-top:20px;font-family:Arial;font-size:13px;">
        Tanggal : <?php echo $tanggal1_;?> s/d <?php echo $tanggal2_;?>
        </div>
        <hr>
      </div>
<table id="hor-minimalist-b" align="center">
    <tbody>
      <tr>
            <td class="no" style="width:50px;">No</td>
            <td class="pokok" style="width:150px;">Kecamatan</td>
            <td class="pokok" style="width:150px;">Desa</td>
            <td class="pokok" style="width:150px;">Majelis</td>
            <td class="pokok" style="width:50px;">Jumlah</td>
      </tr>
      <?php
      $no = 1; 
      $total_anggota = 0;
      foreach ($result as $data):
        $total_anggota+=$data['num'];     
      ?>
      <tr class="value">
            <td class="val_no"><?php echo $no++;?></td>
            <td class="val_anggota"><?php echo $data['kecamatan'];?></td>
            <td class="val_anggota"><?php echo $data['desa'];?></td>
            <td class="val_anggota"><?php echo $data['cm_name'];?></td>
            <td class="val_anggota" align="center"><?php echo number_format($data['num'],0,',','.');?></td>
      </tr>
    <?php 
        endforeach;
    ?>      
      <tr class="value">
            <td class="val_kosong2" colspan="4">&nbsp;</td>
            <td class="val_anggota" align="center"><?php echo number_format($total_anggota,0,',','.');?></td>
      </tr>
    </tbody>
</table>
</page>