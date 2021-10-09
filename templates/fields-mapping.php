<?php
if ( ! defined( 'ABSPATH' ) ) {
     exit;
 }                                    
 ?>
<div  class="vx_div">
   <div class="vx_head">
<div class="crm_head_div"> <?php _e('5. Map Form Fields to Google Sheets Fields.', 'gravity-forms-googlesheets-crm'); ?></div>
<div class="crm_btn_div" title="<?php _e('Expand / Collapse','gravity-forms-googlesheets-crm') ?>"><i class="fa crm_toggle_btn vx_action_btn fa-minus"></i></div>
<div class="crm_clear"></div> 
  </div>
  <div class="vx_group" style="padding: 10px 0px; border-width: 0px; background-color: transparent;">


  <div id="vx_fields_div">
  <?php 
   $req_span=" <span class='vx_red vx_required'>(".__('Required','gravity-forms-googlesheets-crm').")</span>";
 $req_span2=" <span class='vx_red vx_required vx_req_parent'>(".__('Required','gravity-forms-googlesheets-crm').")</span>";
 $options=$this->gf_fields_options($form_id,'',$this->account,$feed['id']); 
  foreach($map_fields as $k=>$v){
        if(isset($v['name_c'])){
  $v['name']=$v['name_c'];      
  $v['label']=__('Custom Field','gravity-forms-googlesheets-crm');      
  } 
  if( in_array($v['name'] , array("OwnerId","AccountId","ContractId") )){
   // continue;
}
if($module == "Order" && in_array($v['name'] , array("Status" ))){
    continue;
} 
  $sel_val=isset($map[$k]['field']) ? $map[$k]['field'] : ""; 
  $val_type=isset($map[$k]['type']) && !empty($map[$k]['type']) ? $map[$k]['type'] : "field"; 

  $options=$this->gf_fields_options($form_id,$sel_val,$this->account,$feed['id']); 

    $display="none"; $btn_icon="fa-plus";
//  if(isset($map[$k][$val_type]) && !empty($map[$k][$val_type])){
    $display="block"; 
    $btn_icon="fa-minus";   
 // }
  $required=isset($v['req']) && $v['req'] == "true" ? true : false;
   $req_html=$required ? $req_span : "";
  ?>
<div class="crm_panel crm_panel_100">
<div class="crm_panel_head2">
<div class="crm_head_div"><span class="crm_head_text crm_text_label">  <?php echo $v['label'];?></span> <?php echo $req_html ?></div>
<div class="crm_btn_div">
<?php
 if(! $required){   
?>
<i class="vx_remove_btn vx_remove_btn vx_action_btn fa fa-trash-o" title="<?php _e('Delete','gravity-forms-googlesheets-crm'); ?>"></i>
<?php } ?>
<i class="fa crm_toggle_btn vx_action_btn vx_btn_inner <?php echo $btn_icon ?>" title="<?php _e('Expand / Collapse','gravity-forms-googlesheets-crm') ?>"></i>
</div>
<div class="crm_clear"></div> </div>
<div class="more_options crm_panel_content" style="display: <?php echo $display ?>;">
  <?php if(!isset($v['name_c'])){ ?>

  <div class="crm-panel-description">
  <span class="crm-desc-name-div"><?php echo __('Name:','gravity-forms-googlesheets-crm')." ";?><span class="crm-desc-name"><?php echo $v['name']; ?></span> </span>
  <?php if($this->post('type',$v) !=""){ ?>
    <span class="crm-desc-type-div">, <?php echo __('Type:','gravity-forms-googlesheets-crm')." ";?><span class="crm-desc-type"><?php echo $v['type'] ?></span> </span>
<?php
   }
  if($this->post('maxlength',$v) !=""){ 
   ?>
   <span class="crm-desc-len-div">, <?php echo __('Max Length:','gravity-forms-googlesheets-crm')." ";?><span class="crm-desc-len"><?php echo $v['maxlength']; ?></span> </span>
  <?php 
  }
  ?>
   </div> 
  <?php
  }
  ?>

<div class="vx_margin">

<?php
    if(isset($v['name_c'])){
?>
<div class="entry_row">
<div class="entry_col1 vx_label"><?php _e('Field API Name','gravity-forms-googlesheets-crm') ?></div>
<div class="entry_col2">
<input type="text" name="meta[map][<?php echo $k ?>][name_c]" value="<?php echo $v['name_c'] ?>" placeholder="<?php _e('Field API Name','gravity-forms-googlesheets-crm') ?>" class="vx_input_100">
<div class="howto"><?php echo __('In Google Sheets, go to setup -> customize -> leads -> fields and copy API name of a field','gravity-forms-googlesheets-crm')?></div>
</div>
<div class="crm_clear"></div>
</div> 
<?php             
    }
?>
<div class="entry_row">
<div class="entry_col1 vx_label"><label  for="vx_type_<?php echo $k ?>"><?php _e('Field Type','gravity-forms-googlesheets-crm') ?></label></div>
<div class="entry_col2">
<select name='meta[map][<?php echo $k ?>][type]'  id="vx_type_<?php echo $k ?>" class='vxc_field_type vx_input_100'>
<?php
  foreach($sel_fields as $f_key=>$f_val){
  $select="";
  if($this->post2($k,'type',$map) == $f_key)
  $select='selected="selected"';
  ?>
  <option value="<?php echo $f_key ?>" <?php echo $select ?>><?php echo $f_val?></option>    
  <?php } ?> 
</select>
</div>
<div class="crm_clear"></div>
</div>  
<div class="entry_row entry_row2">
<div class="entry_col1 vx_label">
<label for="vx_field_<?php echo $k ?>" style="<?php if($this->post2($k,'type',$map) != ''){echo 'display:none';} ?>" class="vxc_fields vxc_field_"><?php _e('Select Field','%dd%') ?></label>

<label for="vx_value_<?php echo $k ?>" style="<?php if($this->post2($k,'type',$map) != 'value'){echo 'display:none';} ?>" class="vxc_fields vxc_field_value"> <?php _e('Custom Value','%dd%') ?></label>
</div>
<div class="entry_col2">
<div class="vxc_fields vxc_field_value" style="<?php if($this->post2($k,'type',$map) != 'value'){echo 'display:none';} ?>">
<textarea name='meta[map][<?php echo $k?>][value]'  id="vx_value_<?php echo $k ?>" placeholder='<?php _e("Custom Value",'%dd%')?>' class='vx_input_100 vxc_field_input'><?php $text_val=$this->post2($k,'value',$map); echo htmlentities($text_val); ?></textarea>
<div class="howto"><?php echo sprintf(__('You can add a form field %s in custom value from following form fields','%dd%'),'<code>{field_id}</code>')?></div>
</div>


<select name="meta[map][<?php echo $k ?>][field]"  id="vx_field_<?php echo $k ?>" class="vxc_field_option vx_input_100">
<?php echo $options ?>
</select>


</div>
<div class="crm_clear"></div>
</div>  

  </div></div>
  <div class="clear"></div>
  </div>
<?php
  }
  ?> 
 
 <div id="vx_field_temp" style="display:none"> 
  <div class="crm_panel crm_panel_100 vx_fields">
<div class="crm_panel_head2">
<div class="crm_head_div"><span class="crm_head_text crm_text_label">  <?php _e('Custom Field', 'gravity-forms-googlesheets-crm');?></span> </div>
<div class="crm_btn_div">
<i class="vx_remove_btn vx_action_btn fa fa-trash-o" title="<?php _e('Delete','gravity-forms-googlesheets-crm'); ?>"></i>
<i class="fa crm_toggle_btn vx_action_btn vx_btn_inner fa-minus" title="<?php _e('Expand / Collapse','gravity-forms-googlesheets-crm') ?>"></i>
</div>
<div class="crm_clear"></div> </div>
<div class="more_options crm_panel_content" style="display: block;">

<?php
    if($api_type  != 'web'){
?>

  <div class="crm-panel-description">
  <span class="crm-desc-name-div"><?php echo __('Name:','gravity-forms-googlesheets-crm')." ";?><span class="crm-desc-name"></span> </span>
  <span class="crm-desc-type-div">, <?php echo __('Type:','gravity-forms-googlesheets-crm')." ";?><span class="crm-desc-type"></span> </span>
  <span class="crm-desc-len-div">, <?php echo __('Max Length:','gravity-forms-googlesheets-crm')." ";?><span class="crm-desc-len"></span> </span>

   </div> 

<?php
    }
?>
<div class="vx_margin">

<?php
    if($api_type  == 'web'){
?>
<div class="entry_row">
<div class="entry_col1 vx_label"><?php _e('Field API Name','gravity-forms-googlesheets-crm') ?></div>
<div class="entry_col2">
<input type="text" name="name_c" placeholder="<?php _e('Field API Name','gravity-forms-googlesheets-crm') ?>" class="vx_input_100">
<div class="howto"><?php echo __('In Google Sheets, go to setup -> customize -> leads -> fields and copy API name of a field','gravity-forms-googlesheets-crm')?></div>
</div>
<div class="crm_clear"></div>
</div> 
<?php
    }
?>
<div class="entry_row">
<div class="entry_col1 vx_label"><label  for="vx_type"><?php _e('Field Type','gravity-forms-googlesheets-crm') ?></label></div>
<div class="entry_col2">
<select name='type' class='vxc_field_type vx_input_100'>
<?php
  foreach($sel_fields as $f_key=>$f_val){
  ?>
  <option value="<?php echo $f_key ?>"><?php echo $f_val?></option>    
  <?php } ?> 
</select>
</div>
<div class="crm_clear"></div>
</div>  
<div class="entry_row entry_row2">
<div class="entry_col1 vx_label">
<label for="vx_field" class="vxc_fields vxc_field_"><?php _e('Select Field','%dd%') ?></label>
<label for="vx_value" class="vxc_fields vxc_field_value" style="display: none;"> <?php _e('Custom Value','%dd%') ?></label>
</div>
<div class="entry_col2">
<div class="vxc_fields vxc_field_value" style="display: none;">
<textarea name='value'  placeholder='<?php _e("Custom Value",'%dd%')?>' class="vx_input_100 vxc_field_input"></textarea>
<div class="howto"><?php echo sprintf(__('You can add a form field %s in custom value from following form fields','%dd%'),'<code>{field_id}</code>')?></div>
</div>

<select name="field"  class="vxc_field_option vx_input_100">
<?php echo $options ?>
</select>


</div>
<div class="crm_clear"></div>
</div>  

  </div></div>
  <div class="clear"></div>
  </div>
   </div>
   <!--end field box template--->
     <?php
  if($api_type =="web"){
  if(vxg_googlesheets::$is_pr){
   ?>
  <div class="vx_fields_footer">
  <div class="vx_row">
  <div class="vx_col1"> &nbsp;</div><div class="vx_col2">
  <button type="button" class="button button-default" id="xv_add_custom_field"><i class=" fa fa-plus-circle" ></i> <?php _e('Add Custom Field','gravity-forms-googlesheets-crm')?></button></div>
  <div class="clear"></div></div>
   </div>
 <?php } }else{ ?> 
   <div class="crm_panel crm_panel_100">
<div class="crm_panel_head2">
<div class="crm_head_div"><span class="crm_head_text ">  <?php _e("Add New Field", 'gravity-forms-googlesheets-crm');?></span> </div>
<div class="crm_btn_div"><i class="fa crm_toggle_btn vx_btn_inner fa-minus" style="display: none;" title="<?php _e('Expand / Collapse','gravity-forms-googlesheets-crm') ?>"></i></div>
<div class="crm_clear"></div> </div>
<div class="more_options crm_panel_content" style="display: block;">

<div class="vx_margin">
<div style="display: table">
  <div style="display: table-cell; width: 85%; padding-right: 14px;">
<select id="vx_add_fields_select" class="vx_input_100" autocomplete="off">
<option value=""></option>
<?php
$json_fields=array();
 foreach($fields as $k=>$v){
     $v['type']=ucfirst($v['type']);
     if(!empty($v['options'])){
         $ops=array();
      foreach($v['options'] as $vv){
          $ops[$vv['value']]=$vv['label'];
      }
    $v['options']=$ops;     
     }
     $json_fields[$k]=$v;
   $disable='';
   if(isset($map_fields[$k])){
    $disable='disabled="disabled"';   
   } 
echo "<option value='{$k}' {$disable} >{$v['label']}</option>";   
} ?>
</select>
  </div><div style="display: table-cell;">
 <button type="button" class="button button-default" style="vertical-align: middle;" id="xv_add_custom_field"><i class="fa fa-plus-circle" ></i> <?php _e('Add Field','gravity-forms-googlesheets-crm')?></button>
  
  </div></div>
 

  </div></div>
  <div class="clear"></div>
  </div>
  <!--add new field box template--->
  <script type="text/javascript">
var crm_fields=<?php echo json_encode($json_fields); ?>;

</script> 
  <?php
 }
 ?>
  </div>

  <div class="clear"></div>
  </div>
  </div>
<div class="vx_div">
   <div class="vx_head">
<div class="crm_head_div"> <?php _e('6. When to Send Entry to Google Sheets.', 'gravity-forms-googlesheets-crm'); ?></div>
<div class="crm_btn_div" title="<?php _e('Expand / Collapse','gravity-forms-googlesheets-crm') ?>"><i class="fa crm_toggle_btn vx_action_btn fa-minus"></i></div>
<div class="crm_clear"></div> 
  </div>

  <div class="vx_group">
  
<div class="vx_row">
  <div class="vx_col1">
  <label for="crm_manual_export">
  <?php esc_html_e('Send Entry to Google Sheets', 'gravity-forms-googlesheets-crm'); ?>
  <?php gform_tooltip("vx_manual_export") ?>
  </label>
  </div>
  <div class="vx_col2">
  <fieldset>
  <legend class="screen-reader-text"><span>
  <?php _e('Send Entry', 'gravity-forms-googlesheets-crm'); ?>
  </span></legend>
  <label for="crm_manual_export">
  <select name="meta[manual_export]" >
  <?php
  $events_arr=array(''=>__( 'When anyone submits form.', 'gravity-forms-googlesheets-crm'),'1'=>__( 'Manually send the entries to Google Sheets.', 'gravity-forms-googlesheets-crm'));
  if(self::$is_pr){
      $events_arr['2']=__( 'When payment is complete.', 'gravity-forms-googlesheets-crm');
  }
  foreach($events_arr as $k=>$v){
  $sel="";
  if($this->post('manual_export',$meta) == $k)
  $sel='selected="selected"';
                   echo "<option value='".$k."' $sel >".$v."</option>";
               } 
              ?>
  </select>
 </label>
  </fieldset>
  </div>
  <div style="clear: both;"></div>
  </div>
  
  <div class="vx_row">
  <div class="vx_col1">
  <label for="crm_optin">
  <?php _e("Opt-In Condition", 'gravity-forms-googlesheets-crm'); ?>
  <?php gform_tooltip("vx_optin_condition") ?>
  </label>
  </div>
  <div class="vx_col2">
  <div>
  <input type="checkbox" style="margin-top: 0px;" id="crm_optin" class="crm_toggle_check" name="meta[optin_enabled]" value="1" <?php echo !empty($meta["optin_enabled"]) ? "checked='checked'" : ""?>/>
  <label for="crm_optin">
  <?php _e("Enable", 'gravity-forms-googlesheets-crm'); ?>
  </label>
  </div>
  <div style="clear: both;"></div>
  <div id="crm_optin_div"  style="margin-top: 16px; <?php echo empty($meta["optin_enabled"]) ? "display:none" : ""?>">
  <div>
  <?php
  $sno=0;
  foreach($filters as $filter_k=>$filter_v){
  $sno++;
                              ?>
  <div class="vx_filter_or" data-id="<?php echo $filter_k ?>">
  <?php if($sno>1){ ?>
  <div class="vx_filter_label">
  <?php _e('OR','gravity-forms-googlesheets-crm') ?>
  </div>
  <?php } ?>
  <div class="vx_filter_div">
  <?php
  if(is_array($filter_v)){
  $sno_i=0;
  foreach($filter_v as $s_k=>$s_v){   
  $sno_i++;
  
  ?>
  <div class="vx_filter_and">
  <?php if($sno_i>1){ ?>
  <div class="vx_filter_label">
  <?php _e('AND','gravity-forms-googlesheets-crm') ?>
  </div>
  <?php } ?>
  <div class="vx_filter_field vx_filter_field1">
  <select id="crm_optin_field" name="meta[filters][<?php echo $filter_k ?>][<?php echo $s_k ?>][field]" class='optin_select_filter'>
  <?php 
  echo $this->gf_fields_options($form_id,$this->post('field',$s_v));
                ?>
  </select>
  </div>
  <div class="vx_filter_field vx_filter_field2">
  <select name="meta[filters][<?php echo $filter_k ?>][<?php echo $s_k ?>][op]" >
  <?php
                 foreach($vx_op as $k=>$v){
  $sel="";
  if($this->post('op',$s_v) == $k)
  $sel='selected="selected"';
                   echo "<option value='".$k."' $sel >".$v."</option>";
               } 
              ?>
  </select>
  </div>
  <div class="vx_filter_field vx_filter_field3">
  <input type="text" class="vxc_filter_text" placeholder="<?php _e('Value','gravity-forms-googlesheets-crm') ?>" value="<?php echo $this->post('value',$s_v) ?>" name="meta[filters][<?php echo $filter_k ?>][<?php echo $s_k ?>][value]">
  </div>
  <?php if( $sno_i>1){ ?>
  <div class="vx_filter_field vx_filter_field4"><i class="vx_icons-h vx_trash_and vxc_tips fa fa-trash-o" data-tip="Delete"></i></div>
  <?php } ?>
  <div style="clear: both;"></div>
  </div>
  <?php
  } }
                     ?>
  <div class="vx_btn_div">
  <button class="button button-default button-small vx_add_and" title="<?php _e('Add AND Filter','gravity-forms-googlesheets-crm'); ?>"><i class="vx_icons-s vx_trash_and fa fa-hand-o-right"></i>
  <?php _e('Add AND Filter','gravity-forms-googlesheets-crm') ?>
  </button>
  <?php if($sno>1){ ?>
  <a href="#" class="vx_trash_or">
  <?php _e('Trash','gravity-forms-googlesheets-crm') ?>
  </a>
  <?php } ?>
  </div>
  </div>
  </div>
  <?php
                          }
                      ?>
  <div class="vx_btn_div">
  <button class="button button-default  vx_add_or" title="<?php _e('Add OR Filter','gravity-forms-googlesheets-crm'); ?>"><i class="vx_icons vx_trash_and fa fa-check"></i>
  <?php _e('Add OR Filter','gravity-forms-googlesheets-crm') ?>
  </button>
  </div>
  </div>
  <!--------- template------------>
  <div style="display: none;" id="vx_filter_temp">
  <div class="vx_filter_or">
  <div class="vx_filter_label">
  <?php _e('OR','gravity-forms-googlesheets-crm') ?>
  </div>
  <div class="vx_filter_div">
  <div class="vx_filter_and">
  <div class="vx_filter_label vx_filter_label_and">
  <?php _e('AND','gravity-forms-googlesheets-crm') ?>
  </div>
  <div class="vx_filter_field vx_filter_field1">
  <select id="crm_optin_field" name="field" class="optin_select_filter">
  <?php 
  echo $this->gf_fields_options($form_id);
                ?>
  </select>
  </div>
  <div class="vx_filter_field vx_filter_field2">
  <select name="op" >
  <?php
                 foreach($vx_op as $k=>$v){
  
                   echo "<option value='".$k."' >".$v."</option>";
               } 
              ?>
  </select>
  </div>
  <div class="vx_filter_field vx_filter_field3">
  <input type="text" class="vxc_filter_text" placeholder="<?php _e('Value','gravity-forms-googlesheets-crm') ?>" name="value">
  </div>
  <div class="vx_filter_field vx_filter_field4"><i class="vx_icons vx_trash_and vxc_tips fa fa-trash-o"></i></div>
  <div style="clear: both;"></div>
  </div>
  <div class="vx_btn_div">
  <button class="button button-default button-small vx_add_and" title="<?php _e('Add AND Filter','gravity-forms-googlesheets-crm'); ?>"><i class="vx_icons vx_trash_and  fa fa-hand-o-right"></i>
  <?php _e('Add AND Filter','gravity-forms-googlesheets-crm') ?>
  </button>
  <a href="#" class="vx_trash_or">
  <?php _e('Trash','gravity-forms-googlesheets-crm') ?>
  </a> </div>
  </div>
  </div>
  </div>
<div style="display: none;">
<?php 
$form = RGFormsModel::get_form_meta($form_id);
if(!empty($form['fields'])){
 $temp_field=new stdClass();
 $temp_field->id='status';  
 $ops=array();
 $ops[]=array('value'=>'active','text'=>'Active');    
$ops[]=array('value'=>'trash','text'=>'Trash');    
$ops[]=array('value'=>'spam','text'=>'Spam'); 
 $temp_field->choices=$ops;   
 $form['fields'][]=$temp_field;
foreach($form['fields'] as $k=>$v){
$ops=array();
 if(!empty($v->choices)){
 $ops=$v->choices;   
} 
    if(!empty($ops)){ 
?>
  <select id="cfx_op_<?php echo $v->id ?>" class="cfx_op">
  <?php
foreach($ops as $v_op){
?>
<option value="<?php echo htmlentities($v_op['value']); ?>"><?php echo htmlentities($v_op['text']); ?></option>
<?php } ?>
  </select> 
<?php        
    }
} }
   ?>
  </div>
  <!--------- template end ------------>
  </div>
  </div>
  <div style="clear: both;"></div>
  </div>

      <div class="vx_row">
  <div class="vx_col1">
  <label for="crm_primary_field3"><?php _e('Insert Row ','gravity-forms-googlesheets-crm') ?></label>
  </div><div class="vx_col2">
  <select id="crm_primary_field3" name="meta[row_type]" class="vx_sel vx_input_100" autocomplete="off">
  <?php
  $key_fields=array(''=>'Add at end - Works if first cell of row is not empty','INSERT_ROWS'=>'Add row at top of sheet - Works if first column of sheet is empty');
   echo $this->gen_select($key_fields,$meta['row_type'],false); ?>
  </select> 
  </div>
  <div class="clear"></div>
  </div>
  

    <div class="vx_row">
  <div class="vx_col1">
  <label for="crm_primary_field2"><?php _e('Data Type','gravity-forms-googlesheets-crm') ?></label>
  </div><div class="vx_col2">
  <select id="crm_primary_field2" name="meta[data_type]" class="vx_sel vx_input_100" autocomplete="off">
  <?php
  $key_fields=array(''=>'USER_ENTERED - Convert date string to Date','RAW'=>'RAW - Do not process data');
   echo $this->gen_select($key_fields,$meta['data_type'],false); ?>
  </select> 
  </div>
  <div class="clear"></div>
  </div>


  </div>    
   </div>
  <?php
   $panel_count=5;             
    
$file=self::$path.'pro/pro-mapping.php';
if(self::$is_pr && file_exists($file)){
include_once($file);
}
?>
  <div class="button-controls submit" style="padding-left: 5px;">
  <input type="hidden" name="form_id" value="<?php echo $form_id ?>">
  <button type="submit" title="<?php _e('Save Feed','gravity-forms-googlesheets-crm'); ?>" name="<?php echo $this->id ?>_submit" class="button button-primary button-hero"> <i class="vx_icons vx vx-arrow-50"></i> <?php echo empty($fid) ? __("Save Feed", 'gravity-forms-googlesheets-crm') : __("Update Feed", 'gravity-forms-googlesheets-crm'); ?> </button>
  </div>

  <?php
      do_action('add_section_mapping_'.$this->id);
  ?>

