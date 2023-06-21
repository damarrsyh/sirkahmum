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
        Laporan <small></small>
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

<!-- DIALOG REMBUG -->
<div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>Cari Rembug</h3>
   </div>
   <div class="modal-body">
      <div class="row-fluid">
         <div class="span12">
            <h4>Masukan Kata Kunci</h4>
            <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"><br><select name="result" id="result" size="7" class="span12 m-wrap"></select></p>
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
      <button type="button" id="select" class="btn blue">Select</button>
   </div>
</div>

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue">
  <div class="portlet-title">
     <div class="caption"><i class="icon-reorder"></i>LEMBAR ABSENSI ANGGOTA</div>
     <div class="tools">
     </div>
  </div>

  <div class="portlet-body form">
     <!-- BEGIN FORM-->
     <form action="#" method="post" enctype="multipart/form-data" id="form_add" class="form-horizontal">
        <div class="control-group">
           <label class="control-label">Kantor Cabang</label>
           <div class="controls">
              <input type="text" name="branch_name" id="branch_name" data-required="1" class="medium m-wrap" value="<?php echo $this->session->userdata('branch_name'); ?>" readonly style="background:#EEE"/>
              <input type="hidden" name="branch_code" id="branch_code" value="<?php echo $this->session->userdata('branch_code') ?>">
              <input type="hidden" name="branch_id" id="branch_id" value="<?php echo $this->session->userdata('branch_id') ?>">
              <?php
              if($this->session->userdata('flag_all_branch')=="1"){
              ?>
              <a id="browse_branch" class="btn blue" data-toggle="modal" href="#dialog_kantor_cabang">...</a>
              <?php } ?>
           </div>
        </div>
		
        <div class="control-group">
           <label class="control-label">Rembug</label>
           <div class="controls">
            <input type="text" name="cm_name" id="cm_name" class="medium m-wrap" readonly style="background:#EEE;" VALUE="Semua Rembug">
            <input type="hidden" name="cm_code" id="cm_code" value="00000">
            <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug">...</a>
           </div>
        </div>

        <div class="control-group">
            <label class="control-label">Tahun</label> 
            <div class="controls">
                <input type="text" name="tahun" id="tahun" class="medium m-wrap" value="0" style="text-align: right"; /> 
            </div>
        </div>
        <!--
		    <div class="control-group">
           <label class="control-label">Tahun </label>
           <div class="controls">
             <input type="text" name="tanggal" id="tanggal" tabindex="2" placeholder="dd/mm/yyyy" class="mask_date date-picker" value="<?php echo $current_date; ?>" maxlength="10" style="width:90px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">                     
           </div>
        </div>
		    -->
        <div class="form-actions">
           <button type="submit" id="export_pdf" class="btn green" >PDF</button> 
           <button type="submit" id="export_excel" class="btn green">Excel</button> 
        </div>
     </form>
     <!-- END FORM-->
      <p><hr></p>
      <!-- END FILTER-->
        <div id="showin">
        <table id="list485"></table>
        <div id="plist485"></div>
        </div>
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
      App.init(); 
      $(".mask-date").inputmask("d/m/y");
   });
</script>

<script type="text/javascript">

// Begin Show Grid
$('#showin').hide();

$("#showgrid").click(function(){
  $('#showin').show();
  $('#list485').show();
  $('#plist485').show();
  showin();
  $('#list485').trigger('reloadGrid');
})

var showin = function(){

  jQuery("#list485").jqGrid({
    url: site_url+'laporan/jqgrid_list_anggota_absen',
    //data: mydata,
    datatype: 'json',
    height: 'auto',
    autowidth: true,
    postData: {
      branch_code : function(){return $("#branch_code").val()},
      tanggal : function(){return $("#tanggal").val()},
      tanggal2 : function(){return $("#tanggal2").val()},
      cm_code : function(){return $("#cm_code").val()},
    },
    rowNum: 30,
    rowList: [50,100,150,200],
    colNames:['ID','Nama','Majelis','Tanggal Gabung','Hadir','Ijin','Sakit','Abstain'],
    colModel:[
      {name:'cif_no',index:'cif_no'},
      {name:'nama',index:'nama'},
      {name:'cm_code',index:'cm_name'},
      {name:'tgl_gabung',index:'tgl_gabung'},
      {name:'hadir',index:'h'},
      {name:'ijin',index:'i'},
      {name:'sakit',index:'s'},
      {name:'abstain',index:'a'},
    ],
    shrinkToFit: true,
    pager: "#plist485",
    viewrecords: true,
    sortname: 'cif_no',
    sortorder: 'asc' ,
    grouping:false,
    rownumbers: true
  });
}
//  END

// BEGIN SEARCH BRANCH
$("#keyword","#dialog_kantor_cabang").keypress(function(e){
   keyword = $(this).val();
   if(e.which==13){
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
   }
});

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



// BEGIN SEARCH REMBUG
$("#keyword","#dialog_rembug").keypress(function(e){
   keyword = $(this).val();
   if(e.which==13){
      var branch = $("#branch_code").val();
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_rembug_by_keyword",
         dataType: "json",
         data: {keyword:keyword,branch_code:branch},
         success: function(response){
            html = '<option value="all" cm_name="Semua Rembug">Semua Rembug</option>';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
            }
            $("#result","#dialog_rembug").html(html);
         }
      })
   }
});

$("#browse_rembug").click(function(){
   keyword = $("#keyword","#dialog_rembug").val();
   branch = $("#branch_code").val();
   $.ajax({
         type: "POST",
         url: site_url+"cif/get_rembug_by_keyword",
         dataType: "json",
         data: {keyword:keyword,branch_code:branch},
         success: function(response){
            html = '<option value="all" cm_name="Semua Rembug">Semua Rembug</option>';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
            }
            $("#result","#dialog_rembug").html(html);
         }
      })
});

$("#select","#dialog_rembug").click(function(){
  $(".close","#dialog_rembug").trigger('click');
  cm_code = $("#result","#dialog_rembug").val();
  cm_name = $("#result option:selected","#dialog_rembug").attr('cm_name');
  $("#cm_code").val(cm_code);
  $("#cm_name").val(cm_name);
});

$("#result option","#dialog_rembug").live('dblclick',function(){
  $("#select","#dialog_rembug").trigger('click');
});

$("#export_excel").click(function(e){
  e.preventDefault();
  branch_code = $("#branch_code").val();
  cm_code = $("#cm_code").val();
  ///tanggal = $("#tanggal").val().replace(/\//g,''); 
  tahun =$("#tahun").val(); 
  window.open(site_url+"laporan_to_excel/export_lembar_absen_anggota/"+branch_code+"/"+cm_code+"/"+tahun);
});

$("#export_csv").click(function(e){
  e.preventDefault();
  branch_code = $("#branch_code").val();
  cm_code = $("#cm_code").val();
  tahun =$("#tahun").val();
  window.open(site_url+"laporan_to_csv/export_lembar_absen_anggota/"+branch_code+"/"+cm_code+"/"+tanggal+"/"+tanggal2);
});

$("#export_pdf").click(function(e){
  e.preventDefault();
  branch_code = $("#branch_code").val();
  cm_code = $("#cm_code").val();
  ///tanggal = $("#tanggal").val().replace(/\//g,'');
  tahun =$("#tahun").val();
  window.open(site_url+"laporan_to_pdf/export_lembar_absen_anggota/"+branch_code+"/"+cm_code+"/"+tahun);
});

</script>