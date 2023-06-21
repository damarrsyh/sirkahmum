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
        KOREKSI ANGSURAN <small></small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- DIALOG BRANCH -->
<div id="dialog_branch" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
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

<!-- DIALOG REMBUG -->
<div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
  <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
     <h3>Cari Rembug</h3>
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
      <div class="caption"><i class="icon-globe"></i>List Koreksi Angsuran</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body">
      <div class="clearfix">
         <!-- BEGIN FILTER FORM -->
         <?php echo $this->session->flashdata('notification'); ?>
         <form action="javascript:;" method="post">
            <input type="hidden" name="branch" id="branch" value="<?php echo $this->session->userdata('branch_name') ?>">
            <input type="hidden" name="branch_code" id="branch_code" value="<?php echo $this->session->userdata('branch_code') ?>">
            <input type="hidden" name="branch_id" id="branch_id" value="<?php echo $this->session->userdata('branch_id') ?>">
            <table id="filter-form">
               <tr>
                  <td style="padding-bottom:10px;" width="100">Cabang</td>
                  <td>
                     <input type="text" name="branch" class="m-wrap mfi-textfield" readonly="" style="background:#eee;" value="<?php echo $this->session->userdata('branch_name'); ?>"> 
                     <?php if($this->session->userdata('flag_all_branch')){ ?>
                     <a id="browse_branch" class="btn blue" style="margin-top:8px;padding:4px 10px;" data-toggle="modal" href="#dialog_branch">...</a>
                     <?php } ?>
                  </td>
               </tr>
               <tr id="field_rembug">
                  <td style="padding-bottom:10px;" width="100">Rembug</td>
                  <td>
                    <input type="hidden" name="cm_code" id="cm_code" value="00000">
                     <input type="text" name="rembug" id="rembug" class="m-wrap mfi-textfield" readonly="" style="background:#eee;" value="Semua Rembug"> 
                     <a id="browse_rembug" class="btn blue" style="margin-top:8px;padding:4px 10px;" data-toggle="modal" href="#dialog_rembug">...</a>
                  </td>
               </tr>
               <tr>
                  <td></td>
                  <td>
                     <button class="green btn" id="showgrid">Double Detail</button>
                     <button class="green btn" id="koreksix1">Koreksi Double</button>
                  </td>
               </tr>
               <tr>
                  <td></td>
                  <td>
                     <button class="green btn" id="showgrid2">Master &lt;&gt; Detail</button>
                     <button class="green btn" id="koreksix2">Koreksi Master</button>
                  </td>
               </tr>
            </table>
         </form>
          <p><hr></p>

          <div id="koreksi1">
          <table id="list485"></table>
          <div id="plist485"></div>
          </div>
          <div id="koreksi2">
          <table id="list486"></table>
          <div id="plist486"></div>
          </div>
          <!-- END FILTER-->
     </div>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>   
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/jquery.form.js" type="text/javascript"></script>        
<!-- END PAGE LEVEL SCRIPTS -->

<script>
   jQuery(document).ready(function() {
      App.init(); // initlayout and core plugins
      $("input#mask_date,.mask_date").livequery(function(){
        $(this).inputmask("d/m/y");  //direct mask
      });
   });
</script>


<script type="text/javascript">
$(function(){
/* BEGIN SCRIPT */

$('#koreksi1').hide();
$('#koreksi2').hide();

$("#showgrid").click(function(){
	$('#koreksi1').show();
	$('#list485').show();
	$('#plist485').show();
	$('#koreksi2').hide();
	$('#list486').hide();
	$('#plist486').hide();
	koreksi1();
	$('#list485').trigger('reloadGrid');
})

var koreksi1 = function(){
	//GRID SEMUA DATA ANGGOTA
	jQuery("#list485").jqGrid({
	  url: site_url+'koreksi/jqgrid_list_koreksi_angsuran',
	  //data: mydata,
	  datatype: 'json',
	  height: 'auto',
	  autowidth: true,
	  postData: {
		  branch_code : function(){return $("#branch_code").val()},
		  cm_code : function(){return $("#cm_code").val()}
	  },
	  rowNum: 30,
	  rowList: [50,100,150,200,250,300,350,400],
		colNames:['No. Rekening','Nama','Angsuran Ke','Jumlah Angsuran','Rembug'],
		colModel:[
		  {name:'account_financing_no',index:'account_financing_no'},
		  {name:'nama',index:'nama'},
		  {name:'angsuran_ke',index:'angsuran_ke'},
		  {name:'jumlah_angs',index:'jumlah_angs'},
		  {name:'cm_code',index:'cm_name'},
		],
		shrinkToFit: true,
		pager: "#plist485",
		viewrecords: true,
		sortname: 'account_financing_no',
		sortorder: 'asc' ,
		grouping:false,
		rownumbers: true
	});
}

$('#koreksix1').click(function(){
	var branch = $('#branch_code').val();
	var rembug = $('#cm_code').val();
	
	$.ajax({
		type: 'POST',
		url: site_url+'koreksi/proses_koreksi_angsuran',
		dataType: 'json',
		data: {branch:branch,rembug:rembug},
		success: function(respon){
			var sukses = respon.sukses;
			
			if(sukses == true){
				alert('Berhasil! Data sudah diperbaiki');
				$('#list485').trigger('reloadGrid');
			} else {
				alert('Gagal! Periksa kembali koneksi internet Anda');
				$('#list485').trigger('reloadGrid');
			}
		},
		error: function(){
			alert('Gagal! Tidak ada koneksi internet');
		}
	});
});

$("#showgrid2").click(function(){
	$('#koreksi1').hide();
	$('#list485').hide();
	$('#plist485').hide();
	$('#koreksi2').show();
	$('#list486').show();
	$('#plist486').show();
	koreksi2();
	$('#list486').trigger('reloadGrid');
})

var koreksi2 = function(){
	//GRID SEMUA DATA ANGGOTA
	jQuery("#list486").jqGrid({
	  url: site_url+'koreksi/jqgrid_list_koreksi_angsuran2',
	  //data: mydata,
	  datatype: 'json',
	  height: 'auto',
	  autowidth: true,
	  postData: {
		  branch_code : function(){return $("#branch_code").val()},
		  cm_code : function(){return $("#cm_code").val()}
	  },
	  rowNum: 30,
	  rowList: [50,100,150,200,250,300,350,400],
		colNames:['No. Rekening','Nama','Counter Angsuran','Angsuran Ke','Rembug'],
		colModel:[
		  {name:'account_financing_no',index:'account_financing_no'},
		  {name:'nama',index:'nama'},
		  {name:'counter_angsuran',index:'counter_angsuran'},
		  {name:'angsuran_ke',index:'angsuran_ke'},
		  {name:'cm_name',index:'cm_name'},
		],
		shrinkToFit: true,
		pager: "#plist486",
		viewrecords: true,
		sortname: 'account_financing_no',
		sortorder: 'asc' ,
		grouping:false,
		rownumbers: true
	});
}

$('#koreksix2').click(function(){
	var branch = $('#branch_code').val();
	var rembug = $('#cm_code').val();
	
	$.ajax({
		type: 'POST',
		url: site_url+'koreksi/proses_koreksi_angsuran2',
		dataType: 'json',
		data: {branch:branch,rembug:rembug},
		success: function(respon){
			var sukses = respon.sukses;
			
			if(sukses == true){
				alert('Berhasil! Data sudah diperbaiki');
				$('#list486').trigger('reloadGrid');
			} else {
				alert('Gagal! Periksa kembali koneksi internet Anda');
				$('#list486').trigger('reloadGrid');
			}
		},
		error: function(){
			alert('Gagal! Tidak ada koneksi internet');
		}
	});
});
/* BEGIN DIALOG ACTION BRANCH */
  
   $("#browse_branch").click(function(){
      $.ajax({
         type: "POST",
         url: site_url+"cif/search_cabang",
         dataType: "json",
         data: {keyword:$("#keyword","#dialog_branch").val()},
         success: function(response){
            html = '';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].branch_code+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
            }
            $("#result","#dialog_branch").html(html);
         }
      })
   })

   $("#keyword","#dialog_branch").keyup(function(e){
      e.preventDefault();
      keyword = $(this).val();
      if(e.which==13)
      {
         $.ajax({
            type: "POST",
            url: site_url+"cif/search_cabang",
            dataType: "json",
            data: {keyword:keyword},
            success: function(response){
               html = '';
               for ( i = 0 ; i < response.length ; i++ )
               {
                  html += '<option value="'+response[i].branch_code+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
               }
               $("#result","#dialog_branch").html(html);
            }
         })
      }
   });

   $("#select","#dialog_branch").click(function(){
      branch_id = $("#result option:selected","#dialog_branch").attr('branch_id');
      result_name = $("#result option:selected","#dialog_branch").attr('branch_name');
      result_code = $("#result","#dialog_branch").val();
      if(result!=null)
      {
          $("input[name='branch']").val(result_name);
          $("input[name='branch_code']").val(result_code);
          $("input[name='branch_id']").val(branch_id);
          $("#close","#dialog_branch").trigger('click');
      }
   });

   $("#result option:selected","#dialog_branch").live('dblclick',function(){
    $("#select","#dialog_branch").trigger('click');
   });

   /* END DIALOG ACTION BRANCH */


   /* BEGIN DIALOG ACTION REMBUG */
  
   $("#browse_rembug").click(function(){
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_rembug_by_keyword",
         dataType: "json",
         data: {keyword:$("#keyword","#dialog_rembug").val(),branch_code:$("#branch_code").val()},
         success: function(response){
            html = '<option value="00000" cm_id="00000" cm_name="Semua Rembug">00000 - Semua Rembug</option>';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].cm_code+'" cm_id="'+response[i].branch_id+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
            }
            $("#result","#dialog_rembug").html(html);
         }
      })
   })

   $("#keyword","#dialog_rembug").keyup(function(e){
      e.preventDefault();
      keyword = $(this).val();
      if(e.which==13)
      {
         $.ajax({
            type: "POST",
            url: site_url+"cif/get_rembug_by_keyword_branch_id",
            dataType: "json",
            data: {keyword:keyword,branch_id:$("#branch_id").val()},
            success: function(response){
              html = '';
              html += '<option value="00000" cm_id="00000" cm_name="Semua Rembug">00000 - Semua Rembug</option>';
              for ( i = 0 ; i < response.length ; i++ )
              {
                 html += '<option value="'+response[i].cm_code+'" cm_id="'+response[i].branch_id+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
              }
              $("#result","#dialog_rembug").html(html);
            }
         })
      }
   });

   $("#select","#dialog_rembug").click(function(){
      cm_id = $("#result option:selected","#dialog_rembug").attr('cm_id');
      cm_name = $("#result option:selected","#dialog_rembug").attr('cm_name');
      cm_code = $("#result","#dialog_rembug").val();
      if(result!=null)
      {
         $("input[name='rembug']").val(cm_name);
         $("input[name='cm_code']").val(cm_code);
         $("#close","#dialog_rembug").trigger('click');
      }
   });

   $("#result option:selected","#dialog_rembug").live('dblclick',function(){
    $("#select","#dialog_rembug").trigger('click');
   })

   /* END DIALOG ACTION REMBUG */

      $(".dataTables_filter").parent().hide(); //menghilangkan serch
      
      jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown
   
});
</script>
<!-- END JAVASCRIPTS -->
