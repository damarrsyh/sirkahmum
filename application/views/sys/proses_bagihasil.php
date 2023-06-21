<style type="text/css">
.errors{
  background-color: #FFD4FF !important;
}
</style>
<!-- BEGIN PAGE HEADER-->
<div class="row-fluid">
   <div class="span12">
      <!-- BEGIN STYLE CUSTOMIZER -->
      <div class="color-panel hidden-phone">
         <div class="color-mode-icons icon-color"></div>
         <div class="color-mode-icons icon-color-close"></div>
         <div class="color-mode">
            <p>THEME COLOR</p>
            <ul class="inline">
               <li class="color-black current color-default" data-style="default"></li>
               <li class="color-blue" data-style="blue"></li>
               <li class="color-brown" data-style="brown"></li>
               <li class="color-purple" data-style="purple"></li>
               <li class="color-white color-light" data-style="light"></li>
            </ul>
            <label class="hidden-phone">
            <input type="checkbox" class="header" checked value="" />
            <span class="color-mode-label">Fixed Header</span>
            </label>                   
         </div>
      </div>
      <!-- END BEGIN STYLE CUSTOMIZER -->
      <!-- BEGIN PAGE TITLE-->
      <h3 class="form-section">
        Proses Akhir Bulan <small>Perhitungan Bagi Hasil</small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-money"></i>Proyeksi Distribusi Bagi Hasil</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body form">
      <div class="clearfix">
         <!-- BEGIN FILTER FORM -->
         <form class="form-horizontal" id="proses_bonus" method="post" action="<?php echo site_url('sys/do_bagihasil_tabungan'); ?>">
            <div class="alert alert-error <?php echo ($this->session->flashdata('failed')==false)?"hide":""; ?>">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success <?php echo ($this->session->flashdata('success')==false)?"hide":""; ?>">
               <button class="close" data-dismiss="alert"></button>
               Proses Bonus Sukses.
            </div>
            <div style="padding:5px 10px 10px 10px;">
              <table>
                <tr>
                  <td width="20%">Periode :</td>
                  <td>             
                     <input type="text" id="from_date" name="from_date" class="m-wrap date-picker" value="<?php echo date('d/m/Y',strtotime($kontrol_periode['periode_awal'])) ?>">
                     <input type="text" id="thru_date" name="thru_date" class="m-wrap date-picker" value="<?php echo date('d/m/Y',strtotime($kontrol_periode['periode_akhir'])) ?>">
                     <button type="button" id="btn_view" class="btn blue">Generate</button>
                     <span id="txt_from_date" style="display:none;"><?php echo date('d/m/Y',strtotime($kontrol_periode['periode_awal'])) ?></span>
                     <span id="txt_thru_date" style="display:none;"><?php echo date('d/m/Y',strtotime($kontrol_periode['periode_akhir'])) ?></span>
                  </td>
                </tr>
                <tr>
                  <td style="padding-top:10px;white-space:nowrap;">Tanggal Transaksi :</td>
                  <td style="padding-top:10px;">
                    <input type="text" id="trx_date" name="trx_date" class="m-wrap date-picker" value="<?php echo date('d/m/Y',strtotime($kontrol_periode['periode_akhir'])) ?>">
                    <span id="txt_trx_date" style="display:none;"></span>
                  </td>
                </tr>
                <tr>
                  <td colspan="2"><hr size="1"></td>
                </tr>
                <tr>
                  <td colspan="2">
                    <table style="background:#eee;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-right:solid 1px #CCC;">
                      <tr>
                        <td style="padding:5px 5px 5px 15px;">1. Pembiayaan yang diberikan</td>
                        <td style="padding:5px 5px 5px 15px;" align="right">: Rp.</td>
                        <td style="padding:5px 5px 5px 15px;" align="right"><span id="td_span_1"></span><input readonly="" type="text" style="display:none;background-color:#eee;text-align:right;width:180px;border-color:#eee;box-shadow:none;transition:none;" name="span_1" id="span_1"></td>
                      </tr>
                      <tr>
                        <td style="padding:0px 5px 5px 15px;">2. Pendapatan Operasional</td>
                        <td style="padding:0px 5px 5px 15px;" align="right">: Rp.</td>
                        <td style="padding:0px 5px 5px 15px;" align="right"><span id="td_span_2"></span><input readonly="" type="text" style="display:none;background-color:#eee;text-align:right;width:180px;border-color:#eee;box-shadow:none;transition:none;" name="span_2" id="span_2"></td>
                      </tr>
                      <tr>
                        <td style="padding:0px 5px 5px 15px;">3. Dana Pihak ke-3</td>
                        <td style="padding:0px 5px 5px 15px;" align="right">: Rp.</td>
                        <td style="padding:0px 5px 5px 15px;" align="right"><span id="td_span_3"></span><input readonly="" type="text" style="display:none;background-color:#eee;text-align:right;width:180px;border-color:#eee;box-shadow:none;transition:none;" name="span_3" id="span_3"></td>
                      </tr>
                      <tr>
                        <td style="padding:0px 5px 5px 15px;">4. Porsi Pendapatan untuk DP3</td>
                        <td style="padding:0px 5px 5px 15px;" align="right">: Rp.</td>
                        <td style="padding:0px 5px 5px 15px;" align="right"><span id="td_span_4"></span><input readonly="" type="text" style="display:none;background-color:#eee;text-align:right;width:180px;border-color:#eee;box-shadow:none;transition:none;" name="span_4" id="span_4"></td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr id="tr_produk9">
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr id="tr_produk10">
                  <td colspan="2">Produk Tabungan Anggota</td>
                </tr>
                <tr id="tr_produk11">
                  <td colspan="2">
                    <table>
                      <thead>
                        <tr>
                          <td align="center" width="230" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;">Nama Produk</td>
                          <td align="center" width="150" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;">Saldo Dana</td>
                          <td align="center" width="100" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;">Rate (%)</td>
                          <td align="center" width="150" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-right:solid 1px #CCC;">Jumlah Bonus</td>
                        </tr>
                      </thead>
                      <tbody id="tr_produk_tabungan_anggota">
                      </tbody>
                    </table>
                  </td>
                </tr>
                <tr id="tr_head_komposisi" style="display:none;">
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr id="tr_head_komposisi" style="display:none;">
                  <td colspan="2">Komposisi Proyeksi Distribusi Bagi Hasil</td>
                </tr>
                <tr id="tr_body_komposisi" style="display:none;">
                  <td colspan="2">
                    <table>
                      <thead>
                        <tr>
                          <td align="center" width="230" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;">Nama Produk</td>
                          <td align="center" width="150" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;">Saldo Dana</td>
                          <td align="center" width="150" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;">Nisbah (%)</td>
                          <td align="center" width="100" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;">Rate (%)</td>
                          <td align="center" width="150" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-right:solid 1px #CCC;">Jumlah</td>
                        </tr>
                      </thead>
                      <tbody id="tr_produk_komposisi">
                      </tbody>
                    </table>
                  </td>
                </tr>
                <tr id="tr_produk1" style="display:none;">
                  <td colspan="2">Produk Deposito</td>
                </tr>
                <tr id="tr_produk2" style="display:none;">
                  <td colspan="2">
                    <table>
                      <thead>
                        <tr>
                          <td align="center" width="280" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;">Nama Produk</td>
                          <td align="center" width="150" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;">Saldo Dana</td>
                          <td align="center" width="100" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;">Nisbah</td>
                          <td align="center" width="90" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-right:solid 1px #CCC;">Rate (%)</td>
                        </tr>
                      </thead>
                      <tbody id="tr_produk_deposito">
                      </tbody>
                      </span>
                    </table>
                  </td>
                </tr>
                <tr id="tr_produk3">
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr id="tr_produk4">
                  <td colspan="2">Produk Tabungan Mudharabah</td>
                </tr>
                <tr id="tr_produk5">
                  <td colspan="2">
                    <table>
                      <thead>
                        <tr>
                          <td align="center" width="280" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;">Nama Produk</td>
                          <td align="center" width="150" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;">Saldo Dana</td>
                          <td align="center" width="70" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;">Nisbah</td>
                          <td align="center" width="70" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-right:solid 1px #CCC;">Rate (%)</td>
                          <td align="center" width="120" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-right:solid 1px #CCC;">Jumlah Bagi Hasil</td>
                        </tr>
                      </thead>
                      <tbody id="tr_produk_mudharabah">
                      </tbody>
                    </table>
                  </td>
                </tr>
                <tr id="tr_produk6">
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr id="tr_produk7">
                  <td colspan="2">Produk Tabungan Wadiah</td>
                </tr>
                <tr id="tr_produk8">
                  <td colspan="2">
                    <table>
                      <thead>
                        <tr>
                          <td align="center" width="230" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;">Nama Produk</td>
                          <td align="center" width="150" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;">Saldo Dana</td>
                          <td align="center" width="100" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;">Rate (%)</td>
                          <td align="center" width="150" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-right:solid 1px #CCC;">Jumlah Bonus</td>
                        </tr>
                      </thead>
                      <tbody id="tr_produk_wadiah">
                      </tbody>
                    </table>
                  </td>
                </tr>
              </table>
            </div>
            <div class="form-actions">
               <button type="button" id="btn_print" class="btn blue">Print</button>
               <button type="button" id="btn_proses" class="btn green">Proses Bagi Hasil</button>
               <button type="button" id="btn_cancel" class="btn red">Batal</button>
               <button type="button" id="komposisi_bahas" class="btn purple" style="display:none;">Lihat Komposisi Bahas</button>
            </div>
         </form>
          <!-- END FILTER-->
      </div>
     <table style="display:none;" id="table_menyetujui">
       <tr>
         <td align="center"><?php echo date("d-m-Y");?> , Menyetujui</td>
       </tr>
       <tr>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td align="center"><?php echo $this->session->userdata('officer_name');?></td>
       </tr>
       <tr>
         <td align="center"><?php echo $this->session->userdata('officer_title').' '.$this->session->userdata('institution_name');?></td>
       </tr>
     </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->



<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/jquery.json-2.2.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/index.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/jquery.form.js" type="text/javascript"></script>       
<script src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script> 
<!-- END PAGE LEVEL SCRIPTS -->  


<script type="text/javascript">
   jQuery(document).ready(function() {    

      App.init(); // initlayout and core plugins
      $("#trx_date").change(function(){
        $("#txt_trx_date").text($(this).val());
      })
      $("#from_date").change(function(){
        $("#txt_from_date").text($(this).val());
      })
      $("#thru_date").change(function(){
        $("#txt_thru_date").text($(this).val());
      })
      $("#tanggal").inputmask("d/m/y");

      $(function(){
        // $("#btn_view").trigger('click');
      })

      $("#btn_view").click(function(){
        bValid = true;
        if($("#periode_bulan").val()=='')
        {
          $("#periode_bulan").addClass('errors');
          bValid = false;
        }
        else
        {
          $("#periode_bulan").removeClass('errors');
        }
        if($("#periode_tahun").val()=='')
        {
          $("#periode_tahun").addClass('errors');
          bValid = false;
        }
        else
        {
          $("#periode_tahun").removeClass('errors');
        }
        if (bValid==false){
          alert("Silahkan Pilih Periode")
        }else{
          
          $.ajax({
            type:"POST",
            async:true,
            url:site_url+'sys/get_data_bahas',
            dataType:'json',
            data:{
              from_date:$("#from_date").val(),thru_date:$("#thru_date").val()
            },
            success: function(response){
              $("#span_1").val(response.pembiayaan_yg_diberikan)
              $("#span_2").val(response.pendapatan_operasional)
              $("#span_3").val(response.dana_pihak_ke3)
              $("#span_4").val(response.porsi_pendapatan_dp3)
              $("#td_span_1").html(response.pembiayaan_yg_diberikan)
              $("#td_span_2").html(response.pendapatan_operasional)
              $("#td_span_3").html(response.dana_pihak_ke3)
              $("#td_span_4").html(response.porsi_pendapatan_dp3)
              generate_product_deposito(response.dana_pihak_ke3,response.porsi_pendapatan_dp3)
              generate_product_mudharabah(response.dana_pihak_ke3,response.porsi_pendapatan_dp3)
              generate_product_wadiah()
              generate_product_tabungan_anggota()
              
            },
            error:function(){
              alert("Internal server error. Please contact your IT support");
              
            }
          })
        }
      })

      function generate_product_deposito(dana_pihak_ke3,porsi_pendapatan_dp3)
      {      
        from_date=$("#from_date").val();            
        thru_date=$("#thru_date").val();            
        $.ajax({
          type:"POST",
          async:false,
          url:site_url+'sys/generate_product_deposito',
          dataType:'html',
          data:{
            from_date:from_date
            ,thru_date:thru_date
            ,dana_pihak_ke3:dana_pihak_ke3
            ,porsi_pendapatan_dp3:porsi_pendapatan_dp3
          },
          success: function(response){
            $("#tr_produk_deposito").html(response);
          },
          error:function(){
            alert("Internal server error. Please contact your IT support");
          }
        })
      }

      function generate_product_mudharabah(dana_pihak_ke3,porsi_pendapatan_dp3)
      {                  
        from_date=$("#from_date").val();            
        thru_date=$("#thru_date").val();   
        $.ajax({
          type:"POST",
          async:false,
          url:site_url+'sys/generate_product_mudharabah',
          dataType:'html',
          data:{
            from_date:from_date
            ,thru_date:thru_date
            ,dana_pihak_ke3:dana_pihak_ke3
            ,porsi_pendapatan_dp3:porsi_pendapatan_dp3
          },
          success: function(response){
            $("#tr_produk_mudharabah").html(response);
          },
          error:function(){
            alert("Internal server error. Please contact your IT support");
          }
        })
      }

      function generate_product_wadiah()
      {                  
        from_date=$("#from_date").val();            
        thru_date=$("#thru_date").val();   
          $.ajax({
            type:"POST",
            async:false,
            url:site_url+'sys/generate_product_wadiah',
            dataType:'html',
            data:{
              from_date:from_date
              ,thru_date:thru_date
            },
            success: function(response){
              $("#tr_produk_wadiah").html(response);
            },
            error:function(){
              alert("Internal server error. Please contact your IT support");
            }
          })
      }

      function generate_product_tabungan_anggota()
      {             
        from_date=$("#from_date").val();            
        thru_date=$("#thru_date").val();        
        $.ajax({
          type:"POST",
          async:false,
          url:site_url+'sys/generate_product_tabungan_anggota',
          dataType:'html',
          data:{
            from_date:from_date
            ,thru_date:thru_date
          },
          success: function(response){
            $("#tr_produk_tabungan_anggota").html(response);
          },
          error:function(){
            alert("Internal server error. Please contact your IT support");
          }
        })
      }

      $("input#wadiah_rate").live('keyup',function(){
        saldo = $(this).closest('tr').find("#wadiah_saldo").val();
        saldo = convert_numeric(saldo)
        saldo = saldo.replace(',', '.');
        // alert(saldo)
        rate = $(this).closest('tr').find("#wadiah_rate").val();
        jumlah_bonus = parseFloat(saldo*rate/100)
        $(this).closest('tr').find("#td_span_wadiah_rate").html(rate)
        $(this).closest('tr').find("#wadiah_jumlah_bonus").val(number_format(jumlah_bonus,0,',','.'))
        $(this).closest('tr').find("#td_span_wadiah_jumlah_bonus").html(number_format(jumlah_bonus,0,',','.'))
      });

      $("input#sukarela_rate").live('keyup',function(){
        saldo = $(this).closest('tr').find("#sukarela_saldo").val();
        saldo = convert_numeric(saldo)
        saldo = saldo.replace(',', '.');
        // alert(saldo)
        rate = $(this).closest('tr').find("#sukarela_rate").val();
        jumlah_bonus = parseFloat(saldo*rate/100)
        $(this).closest('tr').find("#td_span_sukarela_rate").html(rate)
        $(this).closest('tr').find("#sukarela_jumlah_bonus").val(number_format(jumlah_bonus,0,',','.'))
        $(this).closest('tr').find("#td_span_sukarela_jumlah_bonus").html(number_format(jumlah_bonus,0,',','.'))
      });

      $("input#wajib_rate").live('keyup',function(){
        saldo = $(this).closest('tr').find("#wajib_saldo").val();
        saldo = convert_numeric(saldo)
        saldo = saldo.replace(',', '.');
        // alert(saldo)
        rate = $(this).val();
        jumlah_bonus = parseFloat(saldo*rate/100)
        $(this).closest('tr').find("#td_span_wajib_rate").html(rate)
        $(this).closest('tr').find("#wajib_jumlah_bonus").val(number_format(jumlah_bonus,0,',','.'))
        $(this).closest('tr').find("#td_span_wajib_jumlah_bonus").html(number_format(jumlah_bonus,0,',','.'))
      });

      $("input#kelompok_rate").live('keyup',function(){
        saldo = $(this).closest('tr').find("#kelompok_saldo").val();
        saldo = convert_numeric(saldo)
        saldo = saldo.replace(',', '.');
        // alert(saldo)
        rate = $(this).closest('tr').find("#kelompok_rate").val();
        jumlah_bonus = parseFloat(saldo*rate/100)
        $(this).closest('tr').find("#td_span_kelompok_rate").html(rate)
        $(this).closest('tr').find("#kelompok_jumlah_bonus").val(number_format(jumlah_bonus,0,',','.'))
        $(this).closest('tr').find("#td_span_kelompok_jumlah_bonus").html(number_format(jumlah_bonus,0,',','.'))
      });

      $("#btn_proses").click(function(){
        bValid = true;
        if($("#periode_bulan").val()=='')
        {
          $("#periode_bulan").addClass('errors');
          bValid = false;
        }
        else
        {
          $("#periode_bulan").removeClass('errors');
        }
        if($("#periode_tahun").val()=='')
        {
          $("#periode_tahun").addClass('errors');
          bValid = false;
        }
        else
        {
          $("#periode_tahun").removeClass('errors');
        }
        if($("#wadiah_rate").val()=='')
        {
          alert("Silahkan Isi Rate Tabungan Wadiah");
          bValid = false;
        }
        if (bValid==false){
          // alert("Silahkan Pilih Periode")
        }else{
          
          $.ajax({
            type:"POST",
            async:true,
            url:site_url+'sys/action_proses_bagihasil',
            dataType:'json',
            data: $("#proses_bonus").serialize(),
            success: function(response){
              if (response==null) {
                alert("Internal server error. Please contact your IT support");
              } else {
                alert(response.message);
                if (response.stat=='1') {
                  $("#komposisi_bahas").show();
                  $("#btn_proses").hide();
                }else{
                  $("#komposisi_bahas").hide();
                  $("#btn_proses").show();
                }
              }
              
            },
            error:function(){
              alert("Internal server error. Please contact your IT support");
              
            }
          })
        }
      })


      $("#komposisi_bahas").click(function(){
          from_date = $("#from_date").val();
          thru_date = $("#thru_date").val();
          $.ajax({
            type:"POST",
            async:false,
            url:site_url+'sys/get_data_proyeksi_bahas',
            dataType:'json',
            data:{
              from_date:from_date,thru_date:thru_date
            },
            success: function(response){
              $("#span_1").val(response.pembiayaan_yg_diberikan)
              $("#span_2").val(response.pendapatan_operasional)
              $("#span_3").val(response.dana_pihak_ke3)
              $("#span_4").val(response.porsi_pendapatan_dp3)
              $("#td_span_1").html(response.pembiayaan_yg_diberikan)
              $("#td_span_2").html(response.pendapatan_operasional)
              $("#td_span_3").html(response.dana_pihak_ke3)
              $("#td_span_4").html(response.porsi_pendapatan_dp3)
              generate_product_komposisi(response.id_proyeksi_bahas)
            },
            error:function(){
              alert("Internal server error. Please contact your IT support");
            }
          })
      })

      function generate_product_komposisi(id_proyeksi_bahas)
      {                  
          $.ajax({
            type:"POST",
            async:false,
            url:site_url+'sys/generate_product_komposisi',
            dataType:'html',
            data:{
              id_proyeksi_bahas:id_proyeksi_bahas
            },
            success: function(response){
              $("#tr_produk1").hide();
              $("#tr_produk2").hide();
              $("#tr_produk3").hide();
              $("#tr_produk4").hide();
              $("#tr_produk5").hide();
              $("#tr_produk6").hide();
              $("#tr_produk7").hide();
              $("#tr_produk8").hide();
              $("#btn_view").hide();

              $("#tr_head_komposisi").show();
              $("#tr_body_komposisi").show();
              $("#tr_produk_komposisi").html(response);
            },
            error:function(){
              alert("Internal server error. Please contact your IT support");
            }
          })
      }
      

      $("#btn_cancel").click(function(){
        '.portlet'.location.replace(site_url);
      })
      $("#btn_print").click(function(){          
          
          $.ajax({
            type:"POST",
            // async:false,
            url:site_url+'sys/action_cek_bagihasil',
            dataType:'json',
            data: $("#proses_bonus").serialize(),
            success: function(response){
              if (response.stat=='1') {
                $("#komposisi_bahas").trigger('click');
                $("#btn_print").hide();
                $("#btn_cancel").hide();
                $("#btn_proses").hide();
                $("#komposisi_bahas").hide();
                $("#table_menyetujui").show();
                $("#wrapper-table").printElement(); //PRINT
                $("#table_menyetujui").hide();
                $("#btn_print").show();
                $("#btn_cancel").show();
                $("#komposisi_bahas").show();
                $("#btn_proses").hide();
              }else{

                /*hide & show tabungan wadiah*/
                $("input#wadiah_rate","#tr_produk_wadiah").hide();
                $('span#td_span_wadiah_rate,#tr_produk_wadiah').show();
                $('input#wadiah_jumlah_bonus,#tr_produk_wadiah').hide();
                $('span#td_span_wadiah_jumlah_bonus,#tr_produk_wadiah').show();

                /*hide & show tabungan anggota*/
                $("#sukarela_rate").hide();
                $("#td_span_sukarela_rate").show();
                $("#sukarela_jumlah_bonus").hide();
                $("#td_span_sukarela_jumlah_bonus").show();
                $("#wajib_rate").hide();
                $("#td_span_wajib_rate").show();
                $("#wajib_jumlah_bonus").hide();
                $("#td_span_wajib_jumlah_bonus").show();
                $("#kelompok_rate").hide();
                $("#td_span_kelompok_rate").show();
                $("#kelompok_jumlah_bonus").hide();
                $("#td_span_kelompok_jumlah_bonus").show();
                $("#komposisi_bahas").hide();
                $("#btn_print").hide();
                $("#btn_proses").hide();
                $("#btn_cancel").hide();
                $("#btn_view").hide();
                $("#from_date").hide();
                $("#thru_date").hide();
                $("#txt_from_date").show();
                $("#txt_thru_date").show();
                $("#table_menyetujui").show();
                $("#trx_date").hide();
                $("#txt_trx_date").show();

                $("#wrapper-table").printElement(); //PRINT

                /*hide & show tabungan wadiah*/
                $('span#td_span_wadiah_rate,#tr_produk_wadiah').hide();
                $("input#wadiah_rate","#tr_produk_wadiah").show();
                $('span#td_span_wadiah_jumlah_bonus,#tr_produk_wadiah').hide();
                $('input#wadiah_jumlah_bonus,#tr_produk_wadiah').show();
                
                $("#td_span_sukarela_rate").hide();
                $("#sukarela_rate").show();
                $("#td_span_sukarela_jumlah_bonus").hide();
                $("#sukarela_jumlah_bonus").show();
                $("#td_span_wajib_rate").hide();
                $("#wajib_rate").show();
                $("#td_span_wajib_jumlah_bonus").hide();
                $("#wajib_jumlah_bonus").show();
                $("#td_span_kelompok_rate").hide();
                $("#kelompok_rate").show();
                $("#td_span_kelompok_jumlah_bonus").hide();
                $("#kelompok_jumlah_bonus").show();
                $("#komposisi_bahas").show();
                $("#btn_print").show();
                $("#btn_proses").show();
                $("#btn_cancel").show();
                $("#btn_view").show();
                $("#from_date").show();
                $("#thru_date").show();
                $("#txt_from_date").hide();
                $("#txt_thru_date").hide();
                $("#table_menyetujui").hide();
                $("#trx_date").show();
                $("#txt_trx_date").hide();
              }
              
            },
            error:function(){
              alert("Internal server error. Please contact your IT support");
              
            }
          })   
          // $("#btn_view").trigger('click');
      });

   });

</script>
<!-- END JAVASCRIPTS -->

