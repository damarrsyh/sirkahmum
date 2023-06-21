<style type="text/css">
<!--
#hor-minimalist-b
{
  
  font-size: 12px;
  background: #fff;
  /*margin: 10px;*/
  margin-top: 10px;
  border-collapse: collapse;
  text-align: left;
}
#hor-minimalist-b th
{
  font-size: 12px;
  font-weight: normal;
  color: #000;
  padding: 5px 3px;
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
  /*width: 20%;*/
  padding: 8px;
  font-weight: bold;
  text-align: left;
}
#hor-minimalist-b .jumlah
{
  border: 1px solid #262626;
  color: #000;
  width: 10%;
  padding: auto;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .pokok
{
  border: 1px solid #262626;
  color: #000;
  width: 14%;
  padding: 5px;
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
  padding: 6px 6px;
  font-size: 10px;
}
#hor-minimalist-b .val_anggota
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  text-align: left;
  padding: 6px 6px;
  font-size: 10px;
}
#hor-minimalist-b .val_jumlah
{
  border: 1px solid #262626;
  color: #000;
  text-align: center;
  padding: 5px 5px;
  font-size: 10px;
}
#hor-minimalist-b .val_pokok
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  padding: 5px 5px;
  text-align: right;
  font-size: 10px;
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
        Rekap Outstanding Piutang Berdasarkan Produk
        </div>
        <!--  
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:14px;">
        Tanggal : <?php echo $tanggal1_;?> s/d <?php echo $tanggal2_;?>
        </div> 
        -->
        <hr>
      </div>
      <table id="hor-minimalist-b" align="center">
        <tbody>
          <tr>
            <td class="no" style="width:40px;">Kode</td>
            <td class="anggota" style="width:90px;">Keterangan</td>
            <td class="jumlah" style="width:50px;">Akun</td>
            <td class="pokok" style="width:60px;">Pokok</td>
            <td class="pokok" style="width:60px;">Margin</td>
            <td class="pokok" style="width:60px;">Catab</td>
            <td class="pokok" style="width:50px;">% Akun</td>
            <td class="pokok" style="width:50px;">% Pokok</td>
          </tr>
          <?php
              $sum_akun = 0;
              $sum_pokok = 0;
              foreach ($result as $data):     
              $sum_akun+=$data['num'];     
              $sum_pokok+=$data['pokok'];     
              ?>  
          <?php 
              endforeach;
          ?>  
          <?php
          $no = 1; 
          $total_akun  = 0;
          $total_pokok    = 0;
          $total_margin   = 0;
          $total_catab   = 0;
          foreach ($result as $data):      
              $total_akun    +=  $data['num'];  
              $total_pokok      +=  $data['pokok'];     
              $total_margin     +=  $data['margin'];     
              $total_catab     +=  $data['catab'];     
              $persen_jumlah = $data['num']/$sum_akun*100;
              $persen_nominal = $data['pokok']/$sum_pokok*100; 
              ?>
          <tr class="value">
            <td class="val_no"><?php echo $no++;?></td>
            <td class="val_anggota"><?php echo $data['product_name'];?></td>
            <td class="val_jumlah"><?php echo $data['num'];?></td>
            <td class="val_pokok"><?php echo number_format($data['pokok'],0,',','.');?></td>
            <td class="val_pokok"><?php echo number_format($data['margin'],0,',','.');?></td>
            <td class="val_pokok"><?php echo number_format($data['catab'],0,',','.');?></td>
            <td class="val_jumlah"><?php echo number_format($persen_jumlah,2,',','.');?></td>
            <td class="val_jumlah"><?php echo number_format($persen_nominal,2,',','.');?></td>
          </tr>
        <?php 
          endforeach;
        ?>      
        <tr class="value">
            <td class="val_kosong">&nbsp;</td>
            <td class="val_kosong2">&nbsp;</td>
            <td class="val_jumlah"><?php echo $total_akun;?></td>
            <td class="val_pokok"><?php echo number_format($total_pokok,0,',','.');?></td>
            <td class="val_pokok"><?php echo number_format($total_margin,0,',','.');?></td>
            <td class="val_pokok"><?php echo number_format($total_catab,0,',','.');?></td>
        </tr>
    </tbody>
</table>
</page>




