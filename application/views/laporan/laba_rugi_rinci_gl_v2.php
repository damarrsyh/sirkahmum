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
        LAPORAN LABA RUGI RINCI<small></small>
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

<!-- BEGIN FORM-->
<div class="portlet-body form">
   <!-- BEGIN FILTER FORM -->
   <form>
      <input type="hidden" name="branch" id="branch" value="<?php echo $this->session->userdata('branch_name'); ?>">
      <input type="hidden" name="branch_code" id="branch_code" value="<?php echo $this->session->userdata('branch_code'); ?>">
      <input type="hidden" name="branch_id" id="branch_id" value="<?php echo $this->session->userdata('branch_id'); ?>">
      <table id="filter-form">
         <tr>
            <td style="padding-bottom:10px;" width="100">Cabang</td>
            <td>
               <input type="text" name="branch" class="m-wrap mfi-textfield" readonly style="background:#EEE;" value="<?php echo $this->session->userdata('branch_name'); ?>"> 
               <?php if($this->session->userdata('flag_all_branch')=='1'){ ?><a id="browse_branch" class="btn blue" style="margin-top:8px;padding:4px 10px;" data-toggle="modal" href="#dialog_branch">...</a><?php } ?>
            </td>
         </tr>
         <tr>
            <td style="padding-bottom:10px;" width="100">Periode</td>
            <td>
               <input type="text" id="periode" name="periode" class="m-wrap small date-picker mask_date" value="<?php echo date('t/m/Y') ?>">
            </td>
         </tr>
         <tr>
            <td></td>
            <td>
               <button class="green btn" id="preview">Preview</button>
               <button class="green btn" id="previewxls">Preview Excel</button>
            </td>
         </tr>
      </table>
   </form>
   <!-- END FILTER FORM -->
   <hr size="1">
</div>

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
        $(this).inputmask("d/m/y", {autoUnmask: true});  //direct mask
      });
   });
</script>

<script type="text/javascript">
$(function(){
/* BEGIN SCRIPT */

   /* BEGIN DIALOG ACTION BRANCH */
  
   $("#browse_branch").click(function(){
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_branch_by_keyword",
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
            url: site_url+"cif/get_branch_by_keyword",
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

   $("#result option:selected").live('dblclick',function(){
    $("#select","#dialog_branch").trigger('click');
   });

   /* END DIALOG ACTION BRANCH */

   //Export ke PDF
   $("#preview").click(function(e){
        e.preventDefault();
        var branch_code = $("#branch_code").val();
        var periode_hari = $("#periode").val().substr(0,2);
        var periode_bulan = $("#periode").val().substr(2,2);
        var periode_tahun = $("#periode").val().substr(4,4);
        window.open('<?php echo site_url();?>laporan_to_pdf/export_lap_lr_rinci_v2/'+branch_code+'/'+periode_bulan+'/'+periode_tahun+'/'+periode_hari);
   });

   //Export ke Excel
   $("#previewxls").click(function(e){
        e.preventDefault();
        var branch_code = $("#branch_code").val();
        var periode_hari = $("#periode").val().substr(0,2);
        var periode_bulan = $("#periode").val().substr(2,2);
        var periode_tahun = $("#periode").val().substr(4,4);
        window.open('<?php echo site_url();?>laporan_to_excel/export_lap_lr_rinci_v2/'+branch_code+'/'+periode_bulan+'/'+periode_tahun+'/'+periode_hari);
   });


/* END SCRIPT */
})
</script>