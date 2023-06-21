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
      <!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<h3 class="page-title">
			Pembayaran Angsuran<small> Pengaturan Pembayaran Angsuran</small>
		</h3>
		<ul class="breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo site_url('dashboard'); ?>">Home</a> 
				<i class="icon-angle-right"></i>
			</li>
         <li><a href="#">Transaction</a><i class="icon-angle-right"></i></li>
         <li><a href="#">Pembiayaan</a><i class="icon-angle-right"></i></li>
			   <li><a href="#">Pembayaran Angsuran</a></li>	
		</ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN ADD DEPOSITO -->
<div id="add">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Pembayaran Angsuran</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_add" class="form-horizontal">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Pembayaran Angsuran Berhasil Diproses !
            </div>
            <br>
            <input name="saldo_pokok" id="saldo_pokok" type="hidden"/>
            <input name="saldo_memo" id="saldo_memo" type="hidden"/>
            <input name="saldo_catab" id="saldo_catab" type="hidden"/>
            <input name="saldo_margin" id="saldo_margin" type="hidden"/>
            <input name="branch_id" id="branch_id" type="hidden"/>
            <input name="account_financing_id" id="account_financing_id" type="hidden"/>
            <input name="account_financing_schedulle_id" id="account_financing_schedulle_id" type="hidden"/>
            <input name="account_saving_id" id="account_saving_id" type="hidden"/>
            <input name="periode" id="periode" type="hidden"/>
            <input name="bayar_pokok_before" id="bayar_pokok_before" type="hidden"/>
            <input name="bayar_margin_before" id="bayar_margin_before" type="hidden"/>
            <input name="counter_angsuran" id="counter_angsuran" type="hidden"/>
            <div class="control-group">
               <label class="control-label">No. Pembiayaan<span class="required">*</span></label>
               <div class="controls">
               <input type="text" name="no_rekening" id="no_rekening" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug">...</a>
         </label>
      
      <div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
           <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h3>Cari No Rekening</h3>
           </div>
               <div class="modal-body">
                  <div class="row-fluid">
                     <div class="span12">
                        <h4>Masukan Kata Kunci</h4>
                        <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"></p>
                        <p><select name="result" id="result" size="7" class="span12 m-wrap"></select></p>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
                  <button type="button" id="select" class="btn blue">Select</button>
               </div>
          </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama<span class="required">*</span></label>
               <div class="controls">
                  <input name="nama" id="nama" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Produk<span class="required">*</span></label>
               <div class="controls">
                  <input name="produk" id="produk" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Pokok Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend input-append">
                    <span class="add-on">Rp</span>
                      <input name="pokok_pembiayaan" id="pokok_pembiayaan" type="text" data-required="1" class="small m-wrap mask-money" style="background-color:#eee;"/>
                    <span class="add-on">,00</span>
                  </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Margin Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                  <span class="add-on">Rp</span>
                    <input name="margin_pembiayaan" id="margin_pembiayaan" data-required="1" type="text" class="small m-wrap mask-money" style="background-color:#eee;"/>
                  <span class="add-on">,00</span>
                </div>
               </div>
            </div>  
            <div class="control-group">
               <label class="control-label">Jangka Waktu<span class="required">*</span></label>
               <div class="controls">
                  <input name="jangka_waktu" id="jangka_waktu" data-required="1" type="text" class="m-wrap" readonly="readonly" style="background-color:#eee;width:50px;"/><span id="periode_jangka_waktu"></span>
               </div>
            </div>           
            <h3 class="form-section">Angsuran</h3>
            <div class="control-group">
               <label class="control-label">Pokok<span class="required">*</span></label>
               <div class="controls">
                 <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                      <input name="pokok" id="pokok" data-required="1" type="text" class="small m-wrap mask-money" style="background-color:#eee;"/>
                   <span class="add-on">,00</span>
                 </div>
              </div>
            </div>    
            <div class="control-group">
               <label class="control-label">Margin<span class="required">*</span></label>
               <div class="controls">
                 <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                    <input name="margin" id="margin" data-required="1" type="text" class="small m-wrap mask-money" style="background-color:#eee;"/>
                   <span class="add-on">,00</span>
                 </div>
               </div>
            </div>    
            <div class="control-group">
               <label class="control-label">Catab<span class="required">*</span></label>
               <div class="controls">
                 <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                      <input name="cadangan_tabungan" id="cadangan_tabungan" data-required="1" type="text" class="small m-wrap mask-money" style="background-color:#eee;"/>
                    <span class="add-on">,00</span>
                 </div>
               </div>
            </div>    
            <div class="control-group">
               <label class="control-label">Wajib<span class="required">*</span></label>
               <div class="controls">
                 <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                      <input name="wajib" id="wajib" data-required="1" type="text" class="small m-wrap mask-money" style="background-color:#eee;"/>
                    <span class="add-on">,00</span>
                 </div>
               </div>
            </div>    
            <div class="control-group">
               <label class="control-label">Kelompok<span class="required">*</span></label>
               <div class="controls">
                 <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                      <input name="kelompok" id="kelompok" data-required="1" type="text" class="small m-wrap mask-money" style="background-color:#eee;"/>
                    <span class="add-on">,00</span>
                 </div>
               </div>
            </div>    
            <div class="control-group">
               <label class="control-label">Total Angsuran<span class="required">*</span></label>
               <div class="controls">
                 <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                    <input name="total_angsuran" id="total_angsuran" data-required="1" type="text" class="small m-wrap mask-money" style="background-color:#FFFF7F;"/>
                   <span class="add-on">,00</span>
                 </div>
               </div>
            </div>   
            <div class="control-group">
               <label class="control-label">Jatuh Tempo Angsuran<span class="required">*</span></label>
               <div class="controls">
                  <input name="jtempo_angsuran" id="jtempo_angsuran" data-required="1" type="text" class="small m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>    
            <div class="control-group">
               <label class="control-label">Angsuran Terbayar<span class="required">*</span></label>
               <div class="controls">
                  <input name="text_c_angsuran" id="text_c_angsuran" data-required="1" type="text" class="m-wrap" readonly="readonly" style="width:50px;background-color:#eee;"/>
               </div>
            </div>   
            <div class="control-group">
               <label class="control-label">Frekuensi Pembayaran<span class="required">*</span></label>
               <div class="controls">
                  <input name="freq_pembayaran" id="freq_pembayaran" data-required="1" type="text" class="m-wrap" style="width:50px;"/>
               </div>
            </div>   
            <div id="non_reguler" style="display:none;">       
            <div class="control-group">
               <label class="control-label">Bayar Pokok<span class="required">*</span></label>
               <div class="controls">
                 <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                      <input name="bayar_pokok" id="bayar_pokok" data-required="1" type="text" class="small m-wrap mask-money"/>
                    <span class="add-on">,00</span>
                 </div>
                 <span id="sisa_bayar_pokok" style="font-size:11px;font-style:italic;color:red"></span>
               </div>
            </div>          
            <div class="control-group">
               <label class="control-label">Bayar Margin<span class="required">*</span></label>
               <div class="controls">
                 <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                      <input name="bayar_margin" id="bayar_margin" data-required="1" type="text" class="small m-wrap mask-money"/>
                    <span class="add-on">,00</span>
                 </div>
                 <span id="sisa_bayar_margin" style="font-size:11px;font-style:italic;color:red"></span>
               </div>
            </div>  
            </div>
            <div class="control-group">
               <label class="control-label">Nominal Pembayaran<span class="required">*</span></label>
               <div class="controls">
                 <div class="input-prepend input-append">
                    <span class="add-on">Rp</span>
                      <input name="nominal_pembayaran" id="nominal_pembayaran" data-required="1" type="text" class="small m-wrap mask-money"/>
                    <span class="add-on">,00</span>
                 </div>
               </div>
            </div>       
            <div class="control-group">
               <label class="control-label">Tanggal Bayar<span class="required">*</span></label>
               <div class="controls">
                  <input name="tgl_bayar" id="tgl_bayar" data-required="1" type="text" class="mask_date date-picker small m-wrap"/>
               </div>
            </div>         
            <div class="control-group">
               <label class="control-label">Keterangan<span class="required">*</span></label>
               <div class="controls">
                  <textarea id="keterangan" name="keterangan" class="m-wrap medium"></textarea>
               </div>
            </div>     
            <div class="control-group">
               <label class="control-label">Tipe Kas<span class="required">*</span></label>
               <div class="controls">
                  <select class="m-wrap medium" id="cash_type" name="cash_type">
                    <option value="" selected="selected">PILIH TIPE KAS</option>
                    <option value="0">Cash</option>
                    <option value="1">Pinbuk</option>
                  </select>
               </div>
            </div>
            <div id="t_cash">
            <div class="control-group">
               <label class="control-label">Kas Petugas<span class="required">*</span></label>
               <div class="controls">
                  <select class="m-wrap medium chosen" id="account_cash_code" name="account_cash_code">
                    <option value="">PILIH KAS/BANK</option>
                    <?php foreach($account_cash as $kas){ ?>
                    <option value="<?php echo $kas['account_cash_code'] ?>"><?php echo $kas['account_cash_name'] ?></option>
                    <?php } ?>
                  </select>
               </div>
            </div>
            </div>
            <div id="t_pinbuk">
            <div class="control-group">
               <label class="control-label">No. Rekening Tabungan<span class="required">*</span></label>
               <div class="controls">
                  <input name="no_rek_tabungan" id="no_rek_tabungan" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
                  <input name="saldo_memoz" id="saldo_memoz" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            </div>
            <div class="form-actions">
               <button type="submit" class="btn green">Save</button>
               <button type="reset" class="btn">Reset</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END ADD REMBUG -->

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

<script>
   jQuery(document).ready(function() {    
      App.init(); // initlayout and core plugins
     
      $(".mask_date").inputmask("d/m/y");  //direct mask        
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){
	$('#t_cash').fadeOut();
	$('#t_pinbuk').fadeOut();
	
	$('#cash_type').change(function(){
		var cash_type = $(this).val();
		if(cash_type == '0'){
			$('#t_cash').fadeIn();
			$('#t_pinbuk').fadeOut();
		} else if(cash_type == '1'){
			$('#t_cash').fadeOut();
			$('#t_pinbuk').fadeIn();
		} else {
			$('#t_cash').fadeOut();
			$('#t_pinbuk').fadeOut();
		}
	});

    $("#select").click(function(){
        var no_pembiayaan = $("#result").val();
	      $("#close","#dialog_rembug").trigger('click');
        $("#no_rekening").val(no_pembiayaan);
        var account_financing_no = no_pembiayaan;
        $.ajax({
          type: "POST",
          dataType: "json",
          // async: false,
          data: {account_financing_no:account_financing_no},
          url: site_url+"transaction/get_flag_jadwal_angsuran",
          success: function(response){
            if(response.flag_jadwal_angsuran=='1'){
              $.ajax({
                type: "POST",
                dataType: "json",
                // async: false,
                data: {account_financing_no:account_financing_no},
                url: site_url+"transaction/get_cif_for_pembayaran_angsuran",
                success: function(response){
                     var c_angsuran = response.counter_angsuran;
					 if(c_angsuran == null){
						 c_angsuran = '0';
					 }
					 $('#text_c_angsuran').val(c_angsuran);
					 $("#account_financing_id").val(response.account_financing_id);
                     $("#branch_id").val(response.branch_id);
                     $("#account_saving_id").val(response.account_saving_id);
                     $("#nama").val(response.nama);
					 $("#counter_angsuran").val(response.counter_angsuran);
                     $("#produk").val(response.product_name);
                     $("#pokok_pembiayaan").val(number_format(response.pokok,0,',','.'));
                     $("#margin_pembiayaan").val(number_format(response.margin,0,',','.'));
                     $("#jangka_waktu").val(response.jangka_waktu);

                     var periode_jangka_waktu = response.periode_jangka_waktu;
                     if(periode_jangka_waktu==0){
                        periode = "Hari";
                     }else if(periode_jangka_waktu==1){
                        periode = "Minggu";
                     }else if(periode_jangka_waktu==2){
                        periode = "Bulan";
                     }else{
                        periode = "Jatuh Tempo";
                     }
                     $("#periode_jangka_waktu").html(periode);
                     $("#periode").val(response.periode_jangka_waktu);
                     $("#pokok").val(number_format(response.angsuran_pokok,0,',','.'));
                     $("#margin").val(number_format(response.angsuran_margin,0,',','.'));
                     $("#cadangan_tabungan").val(number_format(response.angsuran_catab,0,',','.'));
					 $("#wajib").val(number_format(response.angsuran_tab_wajib,0,',','.'));
					 $("#kelompok").val(number_format(response.angsuran_tab_kelompok,0,',','.'));

                     var jtempo_angsuran_next = response.jtempo_angsuran_next;
                     day    = jtempo_angsuran_next.substr(8,2);
                     month  = jtempo_angsuran_next.substr(5,2);
                     year   = jtempo_angsuran_next.substr(0,4);
                     tgl_jtempo_angsuran_next = day+'/'+month+'/'+year;

                     var angsuran_pokok = parseFloat(response.angsuran_pokok);
                     var angsuran_margin = parseFloat(response.angsuran_margin);
                     var angsuran_catab = parseFloat(response.angsuran_catab);
					 var angsuran_tab_wajib = parseFloat(response.angsuran_tab_wajib);
					 var angsuran_tab_kelompok = parseFloat(response.angsuran_tab_kelompok);
                     var total_angsuran = angsuran_pokok+angsuran_margin+angsuran_catab+angsuran_tab_wajib+angsuran_tab_kelompok;
					 
                     $("#jtempo_angsuran").val(tgl_jtempo_angsuran_next);
                     $("#no_rek_tabungan").val(response.account_saving_no);
					 $("#saldo_memoz").val(number_format(response.saldo_memo,0,',','.'));
                     $("#total_angsuran").val(number_format(total_angsuran,0,',','.'));
                     $("#saldo_pokok").val(parseFloat(convert_numeric(response.saldo_pokok,0,',','.')));
                     $("#saldo_memo").val(response.saldo_memo);
                     $("#saldo_catab").val(number_format(response.saldo_catab,0,',','.'));
                     $("#saldo_margin").val(number_format(response.saldo_margin,0,',','.'));
                     $("#account_saving_id").val(response.account_saving_id);
                     $("#branch_id").val(response.branch_id);

                     $("#freq_pembayaran").attr("readonly", false);
                     $("#freq_pembayaran").css("backgroundColor","#fff");
                     $("#pokok_pembiayaan").attr("readonly", true);
                     $("#margin_pembiayaan").attr("readonly", true);
                     $("#pokok").attr("readonly", true);
                     $("#margin").attr("readonly", true);
                     $("#cadangan_tabungan").attr("readonly", true);
                     $("#total_angsuran").attr("readonly", true);
                     $("#nominal_pembayaran").attr("readonly", true);
                     $("#nominal_pembayaran").css("backgroundColor","#eee");
                  }
              }); 
              $("#non_reguler").hide();
            }else{
              $.ajax({
                type: "POST",
                dataType: "json",
                // async: false,
                data: {account_financing_no:account_financing_no},
                url: site_url+"transaction/get_cif_for_pembayaran_angsuran_non_reguler",
                success: function(response){
                  if(response.length==0){
                    alert("Tidak ada data pembayaran angsuran yang harus dilakukan");
                  }else{
                     $("#account_financing_id").val(response.account_financing_id);
                     $("#branch_id").val(response.branch_id);
                     $("#account_saving_id").val(response.account_saving_id);
                     $("#nama").val(response.nama);
                     $("#produk").val(response.product_name);
                     $("#pokok_pembiayaan").val(number_format(response.pokok,0,',','.'));
                     $("#margin_pembiayaan").val(number_format(response.margin,0,',','.'));
                     $("#jangka_waktu").val(response.jangka_waktu);

                     var periode_jangka_waktu = response.periode_jangka_waktu;
                     if(periode_jangka_waktu==0){
                        periode = "Hari";
                     }else if(periode_jangka_waktu==1){
                        periode = "Minggu";
                     }else if(periode_jangka_waktu==2){
                        periode = "Bulan";
                     }else{
                        periode = "Jatuh Tempo";
                     }
                     $("#periode_jangka_waktu").html(periode);
                     $("#periode").val(response.periode_jangka_waktu);
                     $("#pokok").val(number_format(response.angsuran_pokok,0,',','.'));
                     $("#margin").val(number_format(response.angsuran_margin,0,',','.'));
                     $("#cadangan_tabungan").val(number_format(response.angsuran_tabungan,0,',','.'));

                     var tanggal_jtempo = response.tanggal_jtempo;
                     day    = tanggal_jtempo.substr(8,2);
                     month  = tanggal_jtempo.substr(5,2);
                     year   = tanggal_jtempo.substr(0,4);
                     tgl_jtempo = day+'/'+month+'/'+year;

                     var angsuran_pokok = parseFloat(response.angsuran_pokok);
                     var angsuran_margin = parseFloat(response.angsuran_margin);
                     var angsuran_catab = parseFloat(response.angsuran_tabungan);
                     var total_angsuran = angsuran_pokok+angsuran_margin+angsuran_catab;
					 
                     $("#jtempo_angsuran").val(tgl_jtempo);
                     $("#no_rek_tabungan").val(response.account_saving_no);
					 $("#saldo_memoz").val(number_format(response.saldo_memo,0,',','.'));
                     $("#total_angsuran").val(number_format(total_angsuran,0,',','.'));
                     $("#saldo_pokok").val(number_format(response.saldo_pokok,0,',','.'));
                     $("#saldo_memo").val(response.saldo_memo);
                     $("#saldo_catab").val(number_format(response.saldo_catab,0,',','.'));
                     $("#saldo_margin").val(number_format(response.saldo_margin,0,',','.'));
                     $("#account_saving_id").val(response.account_saving_id);
                     $("#branch_id").val(response.branch_id);
                     $("#bayar_pokok").val(number_format(response.bayar_pokok,0,',','.'));
                     $("#bayar_pokok_before").val(response.byr_pokok);
                     $("#bayar_margin").val(number_format(response.bayar_margin,0,',','.'));
                     $("#bayar_margin_before").val(response.byr_margin);
                     $("#account_financing_schedulle_id").val(response.account_financing_schedulle_id);
                     $("#freq_pembayaran").val('1');
                     var bayar_pokok = parseFloat(response.bayar_pokok);
                     var bayar_margin = parseFloat(response.bayar_margin);
                     var nominal_pembayaran = bayar_pokok+bayar_margin;
                     $("#nominal_pembayaran").val(number_format(nominal_pembayaran,0,',','.'));
                     var byr_pokok = response.byr_pokok;
                     var byr_margin = response.byr_margin;
                     var sisa_bayar_pokok = angsuran_pokok-byr_pokok;
                     var sisa_bayar_margin = angsuran_margin-byr_margin;
                     $("#sisa_bayar_pokok").html("Sisa yang harus dibayarkan Rp. "+number_format(sisa_bayar_pokok,0,',','.'));
                     $("#sisa_bayar_margin").html("Sisa yang harus dibayarkan Rp. "+number_format(sisa_bayar_margin,0,',','.'));

                     $("#freq_pembayaran").attr("readonly", true);
                     $("#freq_pembayaran").css("backgroundColor","#eee");
                     $("#pokok_pembiayaan").attr("readonly", true);
                     $("#margin_pembiayaan").attr("readonly", true);
                     $("#pokok").attr("readonly", true);
                     $("#margin").attr("readonly", true);
                     $("#cadangan_tabungan").attr("readonly", true);
                     $("#total_angsuran").attr("readonly", true);
                     $("#nominal_pembayaran").attr("readonly", true);
                     $("#nominal_pembayaran").css("backgroundColor","#eee");
                   }
                  }
              }); 
              $("#non_reguler").show();
            }
          }
        });

  });

        $("#button-dialog").click(function(){
          $("#dialog").dialog('open');
        });

        $("#keyword").on('keypress',function(e){
          if(e.which==13){
            type = $("#cif_type","#form_add").val();
            $.ajax({
              type: "POST",
              url: site_url+"cif/search_cif_for_pelunasan_pembiayaan",
              data: {keyword:$(this).val()},
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                   option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].account_financing_no+' - '+response[i].nama+' - '+response[i].cm_name+' - '+response[i].product_name+'</option>';
                }
                // console.log(option);
                $("#result").html(option);
              }
            });
          }
        });

        $("#result option").live('dblclick',function(){
           $("#select").trigger('click');
        });
      
      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
      var dTreload = function()
      {
        var tbl_id = 'pelunasan_pembiayaan_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#pelunasan_pembiayaan_table .group-checkable').live('change',function () {
          var set = jQuery(this).attr("data-set");
          var checked = jQuery(this).is(":checked");
          jQuery(set).each(function () {
              if (checked) {
                  $(this).attr("checked", true);
              } else {
                  $(this).attr("checked", false);
              }
          });
          jQuery.uniform.update(set);
      });

      $("#pelunasan_pembiayaan_table .checkboxes").livequery(function(){
        $(this).uniform();
      });




      // BEGIN FORM ADD REMBUG VALIDATION
      var form1 = $('#form_add');
      var error1 = $('.alert-error', form1);
      var success1 = $('.alert-success', form1);
      $("#btn_add").click(function(){
        $("#wrapper-table").hide();
        $("#add").show();
        form1.trigger('reset');
      });

      form1.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          // ignore: "",
          
          rules: {
              no_rekening: {
                  required: true
              },
              freq_pembayaran: {
                  required: true
              },
              tgl_bayar: {
                  required: true,
                  cek_trx_kontrol_periode : true
              },
              keterangan: {
                  required: true
              },
              cash_type: {
                  required: true
              }
          },

          invalidHandler: function (event, validator) { //display error alert on form submit              
              success1.hide();
              error1.show();
              App.scrollTo(error1, -200);
          },

          highlight: function (element) { // hightlight error inputs
              $(element)
                  .closest('.help-inline').removeClass('ok'); // display OK icon
              $(element)
                  .closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group
          },

          unhighlight: function (element) { // revert the change dony by hightlight
              $(element)
                  .closest('.control-group').removeClass('error'); // set error class to the control group
          },

          success: function (label) {
            if(label.closest('.input-append').length==0)
            {
              label
                  .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
              .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
            }
            else
            {
               label.closest('.control-group').removeClass('error').addClass('success')
               label.remove();
            }
          },

          submitHandler: function (form) {
			  var jwaktu = $('#jangka_waktu').val();
			  var cangsuran = $('#text_c_angsuran').val();
			  var freqp = $('#freq_pembayaran').val();
			  var total_angsuran = parseFloat(cangsuran) + parseFloat(freqp);
			  
			  if(total_angsuran >= jwaktu){
				  alert('Ini adalah transaksi pelunasan. Anda akan diarahkan ke menu Registrasi Pelunasan');
				  window.location.href = site_url+'rekening_nasabah/pelunasan';
			  } else {
					var total_angsuran_pokok  = parseFloat(convert_numeric($("#pokok","#form_add").val()));
					var total_angsuran        = parseFloat(convert_numeric($("#total_angsuran","#form_add").val()));
					var saldo_pokok           = parseFloat(convert_numeric($("#saldo_pokok","#form_add").val()));
					var saldo_memo            = parseFloat(convert_numeric($("#saldo_memo","#form_add").val()));
					var pokok                 = parseFloat(convert_numeric($("#pokok","#form_add").val()));
					var margin                = parseFloat(convert_numeric($("#margin","#form_add").val()));
					var bayar_pokok           = parseFloat(convert_numeric($("#bayar_pokok","#form_add").val()));
					var bayar_margin          = parseFloat(convert_numeric($("#bayar_margin","#form_add").val()));
					var bayar_pokok_before    = parseFloat(convert_numeric($("#bayar_pokok_before","#form_add").val()));
					var bayar_margin_before   = parseFloat(convert_numeric($("#bayar_margin_before","#form_add").val()));
					var freq_pembayaran       = parseFloat(convert_numeric($("#freq_pembayaran","#form_add").val()));
					var cash_type			  = $('#cash_type').val();
					var account_cash_code	  = $('#account_cash_code').val();
					var bValid = true;
					if((total_angsuran_pokok*freq_pembayaran)>saldo_pokok){
					  alert('Transaction Canceled : Total Angsuran Pokok Melebihi Saldo Pokok');
					  bValid = false;
					}
					
					if(cash_type == 1){
						if(total_angsuran>=saldo_memo){
						  alert('Transaction Canceled : Saldo Tabungan Memo Tidak Mencukupi');
						  bValid = false;
						}
					} else {
						if(account_cash_code == ''){
							alert('Kas Petugas belum dipilih');
							bValid = false;
						}
					}
		
					if((bayar_pokok_before+bayar_pokok)>pokok){
					  alert('Transaction Canceled : Bayar Pokok Melebihi Angsuran Pokok');
					  bValid = false;
					}
		
					if((bayar_margin_before+bayar_margin)>margin){
					  alert('Transaction Canceled : Bayar Margin Melebihi Angsuran Margin');
					  bValid = false;
					}
		
					if(bValid==true){
					  $.ajax({
						type: "POST",
						url: site_url+"transaction/proses_pembayaran_angsuran",
						dataType: "json",
						data: form1.serialize(),
						success: function(response){
						  if(response.success==true){
							alert('Successfully Saved Data');
							success1.show();
							error1.hide();
							form1.trigger('reset');
							form1.find('.control-group').removeClass('success');
						  }else{
							success1.hide();
							error1.show();
						  }
						  App.scrollTo(form1, -200);
						},
						error:function(){
							success1.hide();
							error1.show();
							App.scrollTo(form1, -200);
						}
					  });
					}
			  }
          }
      });

      // event untuk kembali ke tampilan data table (ADD FORM)
      $("#cancel","#form_add").click(function(){
        success1.hide();
        error1.hide();
        $("#add").hide();
        $("#wrapper-table").show();
        dTreload();
      });

      $("input#freq_pembayaran","#form_add").live('keyup',function(){
        var freq_pembayaran = 0;
        $("input#freq_pembayaran","#form_add").each(function(){
          freq_pembayaran = parseFloat(convert_numeric($(this).val()));
        });
        if(isNaN(freq_pembayaran)==true){
          freq_pembayaran = 0;
        }
        var total_angsuran = parseFloat(convert_numeric($("#total_angsuran","#form_add").val()));
        var nominal_pembayaran = freq_pembayaran*total_angsuran;
        // alert(total_angsuran);
        $("#nominal_pembayaran","#form_add").val(number_format(nominal_pembayaran,0,',','.'));
        $("#nominal_pembayaran").attr("readonly", true);
      });

      $("#bayar_pokok").live('keyup',function(){
        var bayar_pokok = parseFloat(convert_numeric($(this).val()));
        var bayar_margin = parseFloat(convert_numeric($("#bayar_margin").val()));
        var nominal_pembayaran = bayar_pokok+bayar_margin;
        $("#nominal_pembayaran","#form_add").val(number_format(nominal_pembayaran,0,',','.'));
        $("#nominal_pembayaran").attr("readonly", true);
      })

      $("#bayar_margin").live('keyup',function(){
        var bayar_margin = parseFloat(convert_numeric($(this).val()));
        var bayar_pokok = parseFloat(convert_numeric($("#bayar_pokok").val()));
        var nominal_pembayaran = bayar_pokok+bayar_margin;
        $("#nominal_pembayaran","#form_add").val(number_format(nominal_pembayaran,0,',','.'));
        $("#nominal_pembayaran").attr("readonly", true);
      })

});
</script>

<!-- END JAVASCRIPTS -->
