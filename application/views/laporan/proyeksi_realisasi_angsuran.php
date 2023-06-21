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
        Laporan <small>Proyeksi Realisasi Angsuran</small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- DIALOG BRANCH -->
<div id="dialog_kantor_cabang" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>Cari Kantor Cabang</h3>
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

<!-- DIALOG CM -->
<div id="dialog_cm" class="modal hide fade"  data-width="500" style="margin-top:-200px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>Cari Rembug Pusat</h3>
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

<!-- DIALOG FA -->
<div id="dialog_fa" class="modal hide fade"  data-width="500" style="margin-top:-200px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>Cari Kas Petugas</h3>
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

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Proyeksi Realisasi Angsuran</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body" style="padding:0;">
      <div class="clearfix">
            <!-- BEGIN FILTER-->
          <form action="javascript:;" style="padding:10px 10px 0 10px;">
            <input type="hidden" name="branch" id="branch" value="<?php echo $this->session->userdata('branch_name') ?>">
            <input type="hidden" name="branch_code" id="branch_code" value="<?php echo $this->session->userdata('branch_code') ?>">
            <input type="hidden" name="branch_id" id="branch_id" value="<?php echo $this->session->userdata('branch_id') ?>">
            <input name="fa_code" type="hidden" id="fa_code" value="00000" />
            <input name="cm_code" type="hidden" id="cm_code" value="00000" />
                <table id="filter-form">
                   <tr>
                      <td width="100">Cabang</td>
                      <td><input type="text" name="branch_name" id="branch_name" data-required="1" class="medium m-wrap" value="<?php echo $this->session->userdata('branch_name'); ?>" readonly style="background:#EEE"/>
                        <?php
                  if($this->session->userdata('flag_all_branch')=="1"){
                  ?>
                  <a id="browse_branch" class="btn blue" data-toggle="modal" href="#dialog_kantor_cabang">...</a>
                  <?php } ?></td>
                   </tr>
                   <tr id="field_petugas">
                     <td>Petugas</td>
                     <td><input type="text" name="fa" readonly="readonly" value="SEMUA PETUGAS" class="medium m-wrap" style="background:#EEE;" >
                      <a id="browse_fa" class="btn blue" data-toggle="modal" href="#dialog_fa">...</a></td>
                   </tr>
                   <tr id="field_majelis">
                     <td>Majelis</td>
                     <td><input type="text" name="cm" readonly="readonly" value="SEMUA MAJELIS" class="medium m-wrap" style="background:#EEE;" >
                     <a id="browse_cm" class="btn blue" data-toggle="modal" href="#dialog_cm">...</a></td>
                   </tr>
                   <tr>
                    <td>Produk</td>
                    <td>
                      <select name="produk" id="produk" class="chosen m-wrap">
                        <option value="0000">Semua</option>
                        <?php foreach($produk as $data):?>
                        <option value="<?php echo $data['product_code'];?>"><?php echo $data['product_name'];?></option>
                        <?php endforeach?>
                      </select>
                    </td>
                  </tr>
                   <tr>
                      <td>Tanggal</td>
                      <td valign="top">
                        <input type="text" name="tanggal" id="tanggal" tabindex="2" placeholder="dd/mm/yyyy" class="mask_date date-picker" value="<?php echo $current_date; ?>" maxlength="10" style="width:90px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                        sd
                        <input type="text" name="tanggal2" id="tanggal2" tabindex="2" placeholder="dd/mm/yyyy" class="mask_date date-picker" value="<?php echo $current_date; ?>" maxlength="10" style="width:90px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                      </td>
                   </tr>
                   <tr>
                      <td>&nbsp;</td>
                      <td>
                         <button class="green btn" id="previewpdf">PDF</button>
                         <button class="green btn" id="previewxls">Excel</button>
                         <button class="green btn" id="previewcsv">CSV</button>
                      </td>
                   </tr>
                </table>
             </form>
          <!-- END FILTER-->
      </div>
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


<script>
   jQuery(document).ready(function() {    
      App.init(); // initlayout and core plugins
      
      $("#tanggal").inputmask("d/m/y");  //direct mask       
      $("#tanggal2").inputmask("d/m/y");  //direct mask      
   });
</script>

<script type="text/javascript">
$(function(){
/* BEGIN SCRIPT */

	/* BEGIN DIALOG ACTION BRANCH */
	$("a#browse_branch").click(function(){
	   keyword = $("#keyword","#dialog_kantor_cabang").val();
	   $.ajax({
			 type: "POST",
			 url: site_url+"cif/get_branch_by_keyword",
			 dataType: "json",
			 data: {keyword:keyword},
			 success: function(response){
				html = '';
				// html = '<option value="0000" branch_name="Semua Branch" branch_id="0000">0000 - Semua Branch</option>';
				for ( i = 0 ; i < response.length ; i++ )
				{
				   html += '<option value="'+response[i].branch_code+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
				}
				$("#result","#dialog_kantor_cabang").html(html);
			 }
		  })
	});
	
	  $("#keyword","#dialog_kantor_cabang").on('keypress',function(e){
		  if(e.which==13){
			$.ajax({
			  type: "POST",
			  url: site_url+"cif/search_cabang",
			  data: {keyword:$(this).val()},
			  dataType: "json",
			  success: function(response){
				var option = '';
				for(i = 0 ; i < response.length ; i++){
				   option += '<option value="'+response[i].branch_code+'" branch_code="'+response[i].branch_code+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
				}
				// console.log(option);
				$("#result").html(option);
			  }
			});
		  }
	  });
	
	$("#select","#dialog_kantor_cabang").click(function(){
	  $(".close","#dialog_kantor_cabang").trigger('click');
	  branch_code = $("#result","#dialog_kantor_cabang").val();
	  branch_name = $("#result option:selected","#dialog_kantor_cabang").attr('branch_name');
	  branch_id = $("#result option:selected","#dialog_kantor_cabang").attr('branch_id');
	  $("#branch_code").val(branch_code);
	  $("#branch_name").val(branch_name);
	  $("#branch_id").val(branch_id);
	});
	
	$("#result option","#dialog_kantor_cabang").live('dblclick',function(){
	  $("#select","#dialog_kantor_cabang").trigger('click');
	});
   /* END DIALOG ACTION BRANCH */

	  // BEGIN DIALOG PETUGAS
	  $("#browse_fa").click(function(){
	
		fa = $("input[name='fa']").val();
		$("#keyword","#dialog_fa").val()
		setTimeout(function(){
		  var e = $.Event('keypress');
		  e.keyCode = 13; // Character 'A'
		  $('#keyword',"#dialog_fa").trigger(e);
		},300)
	  })
	
	  $("#keyword","#dialog_fa").keypress(function(e){
		keyword = $(this).val();
		branch_code = $("input[name='branch_code']").val();
		branch_class = $("input[name='branch_class']").val();
		if(e.keyCode==13){
		  e.preventDefault();
		  $.ajax({
			 type: "POST",
			 url: site_url+"cif/search_petugas_by_cabang",
			 dataType: "json",
			 async: false,
			 data: {keyword:keyword,branch_code:branch_code},
			 success: function(response){
				html = '<option value="00000" fa_name="SEMUA PETUGAS">00000 - SEMUA PETUGAS</option>';
				for ( i = 0 ; i < response.length ; i++ )
				{
				  html += '<option value="'+response[i].fa_code+'" fa_name="'+response[i].fa_name+'">'+response[i].fa_code+' | '+response[i].fa_name+'</option>';
				}
				$("#result","#dialog_fa").html(html).focus();
				$("#result option:first-child","#dialog_fa").attr('selected',true);
			 }
		  })
		}
	  });
	
	  $("#select","#dialog_fa").click(function(){
		result_name = $("#result option:selected","#dialog_fa").attr('fa_name');
		account_cash_code = $("#result option:selected","#dialog_fa").attr('account_cash_code');
		result_code = $("#result","#dialog_fa").val();
		if(result!=null)
		{
		  $("input[name='fa']").val(result_name);
		  $("input[name='fa_name']").val(result_name);
		  $("input[name='fa_code']").val(result_code);
		  $("input[name='account_cash_code']").val(account_cash_code);
		  $("#close","#dialog_fa").trigger('click');
		}
	  });
	
	  $("#result option","#dialog_fa").livequery('dblclick',function(){
		$("#select","#dialog_fa").trigger('click');
		window.scrollTo(0,0)
	  });
	
	  $("input[name='fa']").keypress(function(e){
		if(e.keyCode==13){
		  $(this).blur();
		  e.preventDefault();
		  $("#browse_fa").trigger('click');
		}
	  });
	
	  $("#result","#dialog_fa").keypress(function(e){
		e.preventDefault();
		if(e.keyCode==13){
		  $("#select","#dialog_fa").trigger('click');
		}
	  });
	  // END DIALOG PETUGAS

	  /* BEGIN DIALOG ACTION REMBUG */
	  $("#browse_cm").click(function(){
		cm = $("input[name='cm']").val();
		$("#keyword","#dialog_cm").val()
		setTimeout(function(){
		  var e = $.Event('keypress');
		  e.keyCode = 13; // Character 'A'
		  $('#keyword',"#dialog_cm").trigger(e);
		},300)
	  });
	
	  $("#keyword","#dialog_cm").keypress(function(e){
		keyword = $(this).val();
		branch_id = $("input[name='branch_id']").val();
		branch_code = $("input[name='branch_code']").val();
		fa_code=$("input[name='fa_code']").val();
		if(e.keyCode==13){
		  e.preventDefault();
		  $.ajax({
			 type: "POST",
			 url: site_url+"cif/search_majelis_by_petugas",
			 dataType: "json",
			 async: false,
			 data: {keyword:keyword,branch_id:branch_id,branch_code:branch_code,fa_code:fa_code},
			 success: function(response){
				html = '<option value="00000" cm_name="SEMUA MAJELIS">00000 - SEMUA MAJELIS</option>';
				for ( i = 0 ; i < response.length ; i++ )
				{
				   html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
				}
				$("#result","#dialog_cm").html(html).focus();
				$("#result option:first-child","#dialog_cm").attr('selected',true);
			 }
		  });
		}
	  });
	
	  $("#select","#dialog_cm").click(function(){
		result_name = $("#result option:selected","#dialog_cm").attr('cm_name');
		result_code = $("#result","#dialog_cm").val();
		if(result!=null)
		{
		  $("input[name='cm']").val(result_name);
		  $("input[name='cm_code']").val(result_code);
		  $("#close","#dialog_cm").trigger('click');
		}
	  });
	
	  $("#result option","#dialog_cm").livequery('dblclick',function(){
		$("#select","#dialog_cm").trigger('click');
		window.scrollTo(0,0)
	  });
	
	  $("input[name='cm']").keypress(function(e){
		if(e.keyCode==13){
		  $(this).blur();
		  e.preventDefault();
		  $("#browse_cm").trigger('click');
		}
	  });
	
	  $("#result","#dialog_cm").keypress(function(e){
		e.preventDefault();
		if(e.keyCode==13){
		  $("#select","#dialog_cm").trigger('click');
		}
	  });
	   /* END DIALOG ACTION REMBUG */

      $('#previewpdf').click(function(){
		  var branch_code = $('#branch_code').val();
		  var cm_code = $('#cm_code').val();
		  var product = $('#produk').val();
		  var tanggal = $('#tanggal').val();
		  var tanggal = datepicker_replace(tanggal);
		  var tanggal2 = $('#tanggal2').val();
		  var tanggal2 = datepicker_replace(tanggal2);
		  var fa_code = $('#fa_code').val();
		  var site = '<?php echo site_url('laporan_to_pdf/export_list_proyeksi_realisasi_angsuran'); ?>';
		  var conf = true;

		  if(tanggal == '' && tanggal2 == ''){
			  alert('Tanggal belum diisi');
			  var conf = false;
		  }
	
		  if(cm_code == ''){
			  alert('Majelis belum diisi');
			  var conf = false;
		  }
	
		  if(fa_code == ''){
			  alert('Petugas belum diisi');
			  var conf = false;
		  }
	
		  if(product == ''){
			  alert('Produk belum dipilih');
			  var conf = false;
		  }

		  if(conf == true){
			  window.open(site+'/'+tanggal+'/'+tanggal2+'/'+branch_code+'/'+cm_code+'/'+product);
		  }

      });

      $('#previewxls').click(function(){
		  var branch_code = $('#branch_code').val();
		  var cm_code = $('#cm_code').val();
		  var product = $('#produk').val();
		  var tanggal = $('#tanggal').val();
		  var tanggal = datepicker_replace(tanggal);
		  var tanggal2 = $('#tanggal2').val();
		  var tanggal2 = datepicker_replace(tanggal2);
		  var fa_code = $('#fa_code').val();
		  var site = '<?php echo site_url('laporan_to_excel/export_list_proyeksi_realisasi_angsuran'); ?>';
		  var conf = true;

		  if(tanggal == '' && tanggal2 == ''){
			  alert('Tanggal belum diisi');
			  var conf = false;
		  }
	
		  if(cm_code == ''){
			  alert('Majelis belum diisi');
			  var conf = false;
		  }
	
		  if(fa_code == ''){
			  alert('Petugas belum diisi');
			  var conf = false;
		  }
	
		  if(product == ''){
			  alert('Produk belum dipilih');
			  var conf = false;
		  }

		  if(conf == true){
			  window.open(site+'/'+tanggal+'/'+tanggal2+'/'+branch_code+'/'+cm_code+'/'+product);
		  }

      });

      $('#previewcsv').click(function(){
		  var branch_code = $('#branch_code').val();
		  var cm_code = $('#cm_code').val();
		  var product = $('#produk').val();
		  var tanggal = $('#tanggal').val();
		  var tanggal = datepicker_replace(tanggal);
		  var tanggal2 = $('#tanggal2').val();
		  var tanggal2 = datepicker_replace(tanggal2);
		  var fa_code = $('#fa_code').val();
		  var site = '<?php echo site_url('laporan_to_csv/export_list_proyeksi_realisasi_angsuran'); ?>';
		  var conf = true;

		  if(tanggal == '' && tanggal2 == ''){
			  alert('Tanggal belum diisi');
			  var conf = false;
		  }
	
		  if(cm_code == ''){
			  alert('Majelis belum diisi');
			  var conf = false;
		  }
	
		  if(fa_code == ''){
			  alert('Petugas belum diisi');
			  var conf = false;
		  }
	
		  if(product == ''){
			  alert('Produk belum dipilih');
			  var conf = false;
		  }

		  if(conf == true){
			  window.open(site+'/'+tanggal+'/'+tanggal2+'/'+branch_code+'/'+cm_code+'/'+product);
		  }

      });
});
</script>
<!-- END JAVASCRIPTS -->

