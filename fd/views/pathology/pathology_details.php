
<style>
.checkbox {
        width: 20px;
        height: 20px;
      }
</style>
<div class="row">
  <div class="">
    <div class="table-responsive">
      <div class="col-md-5">
        <table class="table table-hover table-sm">
          <tr>
            <td class="col-lg-3"><label><?php echo $this->lang->line('bill_no'); ?></label></td>
            <td class="col-lg-3"><?php echo $bill_prefix.$result->id ?></td>
          </tr>
          <tr>
            <td><label><?php echo $this->lang->line('doctor_name'); ?></label></td>
            <td><?php echo $result->doctor_name ?></td>
          </tr>
          <!-- <tr>
          <td><label><?php echo $this->lang->line('blood_group'); ?></label></td>
          <td><?php echo $result->blood_group_name ?></td>
        </tr> -->
        <tr>
          <td><label><?php echo $this->lang->line('generated_by'); ?></label></td>
          <td><?php echo $result->name." ".$result->surname."(".$result->employee_id.")"; ?></td>
        </tr>
        <tr>
          <td><label><?php echo $this->lang->line('note'); ?></label></td>
          <td><?php echo $result->note ?></td>
        </tr>
        
      </table>
    </div>
    <div class="col-md-2">
      <table class="table table-hover table-sm">
        <tr>
          <td class="col-lg-3"><label><?php echo $this->lang->line('case_id'); ?></label></td>
          <td class="col-lg-3"><?php echo $result->case_reference_id ?></td>
        </tr>
        <tr>
          <td><label><?php echo $this->lang->line('age'); ?></label></td>
          <td> </td>
        </tr>
        <tr>
          <td><label><?php echo $this->lang->line('mobile_no'); ?></label></td>
          <td><?php echo $result->mobileno ?></td>
        </tr>
        <tr>
          <td><label><?php echo $this->lang->line('address'); ?></label></td>
          <td><?php echo $result->address ?></td>
        </tr>
      </table>
    </div>
    <div class="col-md-5">
      <table class="table table-hover table-sm">
        <tr>
          <td><label><?php echo $this->lang->line('patient_name'); ?></label></td>
          <td><?php echo $result->patient_name." (".$result->patient_id.")" ?></td>
        </tr>
        <tr>
          <td><label><?php echo $this->lang->line('gender'); ?></label></td>
          <td><?php echo $result->gender ?></td>
        </tr>
        <tr>
          <td><label><?php echo $this->lang->line('email'); ?></label></td>
          <td><?php echo $result->email ?></td>
        </tr>
      </table>
    </div>

  
<div class="col-md-5 text-center">
  <a class="btn btn-sm btn-warning bulk_sample_collection" data-bill_id="<?=$result->id?>">Sample Collect</a>
  <a class="btn btn-sm btn-success bulk_report_entry" data-bill_id="<?=$result->id?>">Report Entry</a>
  <a class="btn btn-sm btn-success bulk_report_print" data-case_id="<?=$result->case_reference_id?>"data-bill_id="<?=$result->id?>">Report Print</a>

</div>

</div>
<!-- //============= -->

<div class="table-responsive">
  <div class="col-md-12">
    <table class="table table-hover table-sm">

      <thead>
        <tr class="line">
          <td><strong>#</strong></td>
          <td><strong><?php echo $this->lang->line('category_name'); ?></strong></td>
          <td><strong><?php echo $this->lang->line('test_name'); ?></strong></td>
          <td><strong><?php echo "Print Bill" ?></strong></td>
            <td  width="15%"><strong><?php echo "Select All" ?></strong><input type="checkbox" id="select_all" class="checkbox" />

          </td>
          <td width="15%"><strong><?php echo $this->lang->line('sample_collected'); ?></strong></td>
          <td><strong><?php echo $this->lang->line('expected_date'); ?></strong></td>
          <td><strong><?php echo $this->lang->line('approved_by'); ?></strong></td>
          <!-- <td class="text-right"><strong><?php echo $this->lang->line('tax'); ?></strong></td> -->
          <!-- <td class="text-right"><strong><?php echo $this->lang->line('amount'); ?></strong></td> -->
          <td class="text-right"><strong><?php echo $this->lang->line('action'); ?></strong></td>
        </tr>
      </thead>
      <tbody>
        <?php
        $row_counter=1;
        if(!empty($result->pathology_report)){
        foreach ($result->pathology_report as $report_key=> $report_value) {
          $pathotest=$this->pathology_model->getTestbyCategory($report_value->category_id,$result->id);
          $test ='<ul style="list-style:none;">';
              $actions ='<div style="list-style:none;">';
              $checkbox ='<div">';
              foreach ($pathotest as $key => $d) {
                $checkbox .= "<input id='checkbox'style='margin-top:5px ! important;' href='#'data-case_id='$result->case_reference_id ' data-bill_id=' $report_value->pathology_bill_id'data-test_id='$d->id' class='checkbox' type='checkbox' name='checkbox[]'>";
                $actions .= "<a href='javascript:void(0)' data-loading-text='<i class=\"fa fa-circle-o-notch fa-spin\"></i>' onclick='print_report_individual($report_value->pathology_bill_id,$d->id)' class='print_report_individual' data-toggle='tooltip' data-record-id=\"" . $result->id . "\"  data-placement='bottom'  data-original-title='" . $this->lang->line('print_bill') . "'><i class='fa fa-print'></i></a>";
                $test .= '<li>'.$d->test_name ."(".$d->short_name.")".'</li>';
              }
              $actions .='</div>';
              $checkbox .='</div>';
              $test .='</ul>';

          $tax_amount = ($report_value->apply_charge*$report_value->tax_percentage/100);
          $taxamount  = amountFormat($tax_amount)
          ?>
          <tr>
            <td><?php echo $row_counter; ?></td>
            <td><strong><?php echo $report_value->category_name; ?></strong>
            </td>
            <td><strong><?php echo $test; ?></strong></td>
            <td class="text-center">
              <strong ><?php echo $actions?> </strong></td>
              <td class="text-center">
                <strong class="text-center"><?php echo $checkbox;?> </strong></td>
            <td class="text-left">
              <label>
                <?php echo composeStaffNameByString($report_value->collection_specialist_staff_name,$report_value->collection_specialist_staff_surname,$report_value->collection_specialist_staff_employee_id); ?>
              </label>
              <br/>
              <label for=""><?php echo $this->lang->line('pathology'); ?> : </label>
              <?php
              echo $report_value->pathology_center;
              ?>
              <br/>
              <?php echo $this->customlib->YYYYMMDDTodateFormat($report_value->collection_date); ?>
            </td>
            <td>
              <?php
              echo  $this->customlib->YYYYMMDDTodateFormat($report_value->reporting_date); ?>
            </td>
            <td class="text-left">
              <label for=""><?php echo $this->lang->line('approved_by'); ?> : </label>
              <?php
              echo composeStaffNameByString($report_value->approved_by_staff_name,$report_value->approved_by_staff_surname,$report_value->approved_by_staff_employee_id);
              ?>
              <br/>
              <?php
              echo  $this->customlib->YYYYMMDDTodateFormat($report_value->parameter_update);
              ?>
            </td>
            <!-- <td class="text-right"><?php echo $currency_symbol.$taxamount."(".$report_value->tax_percentage."%)"; ?></td>
            <td class="text-right"><?php echo $currency_symbol.$report_value->apply_charge; ?></td> -->
            <td class="text-right">
              <?php
              if($is_bill){ if ($this->rbac->hasPrivilege('pathology_add_edit_collection_person', 'can_view')) {
                ?>
                <a href='javascript:void(0)'  data-loading-text='<i class="fa fa-circle-o-notch fa-spin"></i>' data-record-id='<?php echo $report_value->id;?>' class='btn btn-default btn-xs add_collection' data-toggle='tooltip' title='<?php echo $this->lang->line("add_edit_collection_person"); ?>'><i class='fa fa-user-plus'></i></a>
              <?php } if ($this->rbac->hasPrivilege('pathology_add_edit_report', 'can_view')) {
                if($report_value->collection_specialist_staff_employee_id != ""){
                  ?>
                  <a href='javascript:void(0)'  data-loading-text='<i class="fa fa-circle-o-notch fa-spin"></i>' data-record-id='<?php echo $report_value->id;?>' class='btn btn-default btn-xs add_report' data-toggle='tooltip' title='<?php echo $this->lang->line("add_edit_report"); ?>'><i class='fa fa-flask'></i></a>
                  <?php
                }
              } } }
              ?>
              <a href='javascript:void(0)'  data-loading-text='<i class="fa fa-circle-o-notch fa-spin"></i>' onclick="print_pathology_report(<?php echo $report_value->category_id;?>,<?php echo $report_value->pathology_bill_id;?>)"data-record-id='<?php echo $report_value->id;?>' class='btn btn-default btn-xs ' data-toggle='tooltip' title='<?php echo $this->lang->line("print"); ?>'><i class='fa fa-print'></i></a>
              <?php
              if($report_value->pathology_report != ""){
                ?>
                <a href="<?php echo site_url('admin/pathology/downloadReport/'.$report_value->id) ?>" class='btn btn-default btn-xs' data-toggle='tooltip' title='<?php echo $this->lang->line("download"); ?>'><i class="fa fa-download"></i></a>
                <?php
              }
              ?>
            </td>
          </tr>
          <?php
          $row_counter++;
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
</div>
</div>

<script type="text/javascript">


$(document).on('click','.bulk_sample_collection',function(){
  var bill_id=$(this).data('bill_id');
  var bulk_sample=$('#bulk_sample');
    var $this = $(this);
  $.ajax({
    url: '<?php echo base_url() ?>admin/pathology/bulk_sample',
    type: "POST",
    data: {'bill_id': bill_id,'is_bill': 'yes'},
    dataType:"JSON",
    beforeSend: function(){
    $this.button('loading');
    },
    success: function (data) {
      $("#collected_by").val(data.report.collection_specialist);
      $("#collectionbulkModal .modal-body").find('input[name="pathology_report_id"]').val(data.report.id);
      $("#collectionbulkModal .modal-body").find('input[name="pathology_bill_id"]').val(data.report.pathology_bill_id);
      $("#collectionbulkModal .modal-body").find('input[name="pathology_center"]').val(data.report.pathology_center);
      $("#collectionbulkModal .modal-body").find('input[name="collected_date"]').datepicker("update", new Date(data.report.collection_date));
      $('#collectionbulkModal').modal('show');
      bulk_sample.removeClass('modal_loading');
    },
    error: function () {
      alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
      $this.button('reset');
    },  complete: function(){
      $this.button('reset');
    }
  });
});
$('#select_all').on('click', function () {
  if (this.checked) {
    $('.checkbox').each(function () {
      this.checked = true;
    });
  } else {
    $('.checkbox').each(function () {
      this.checked = false;
    });
  }
});
$('.bulk_report_print').on('click', function () {
  let obj =  [];
  var case_id = $(this).data('case_id');
  var id = $(this).data('bill_id');
    $.each($("input[class='checkbox']:checked"), function () {
    var bill_id = $(this).data('bill_id');
    var test_id = $(this).data('test_id');
    item = {};
    item ["bill_id"] = bill_id;
    item ["test_id"] = test_id;
    obj.push(item);
  });
  if (obj.length == 0) {
      $('.checkbox').each(function () {
        this.checked = true;
      });
    
    $.each($("input[class='checkbox']:checked"), function () {
    var bill_id = $(this).data('bill_id');
    var test_id = $(this).data('test_id');
    item = {};
    item ["bill_id"] = bill_id;
    item ["test_id"] = test_id;
    obj.push(item);
  });
// errorMsg("Oops! Select any bill to print!");
}
  $.ajax({
    url: '<?php echo base_url("admin/pathology/bulk_pathology_print") ?>',
    type: 'post',
    data: {'datae':JSON.stringify(obj),'case_id':case_id,'id':id},
    dataType:"json",
    success: function (data) {
      popup(data.page);
    },
    error: function(xhr) { // if error occured
      alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
      //$this.button('reset');

    },
    complete: function() {
    //  $this.button('reset');
    }
  });

});



</script>
