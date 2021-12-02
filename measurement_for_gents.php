<?php 
include("./mpdf/mpdf.php");
$token =genrate_tokens();
$zoho_auth = $token['crm_token'];
$project_auth = $token['project_token'];
$id = $_REQUEST['id'];
$data = get_data_in_crm($id,$zoho_auth);
$Sales_OrderID = $data['Sales_Order']['id'];
$project_data = get_project_id($Sales_OrderID, $zoho_auth);
$Current_Date = date("d-m-Y");
$project_id = $project_data['ProjectID'];
$pdfname =  $project_data['Subject'];
$genratpdf = genrate_pdf($data,$pdfname,$Current_Date);
// echo "<pre>"; print_r($genratpdf);die(); 
$mpdf = new mpdf([
  'mode' => 'utf-8',
  'format' => 'A4-L',
  'orientation' => 'L'
  ]);  
$new_mpdf = $mpdf->WriteHTML($genratpdf);
 $file_name = $pdfname.".pdf";
  $mpdf->Output('uploads/'.$file_name, 'F');      
    $pdf_name = "./uploads/".$file_name;
        if(function_exists('curl_file_create')) { 
             $cFile = curl_file_create($pdf_name);
            }else{ 
             $cFile = '@' . realpath($pdf_name);
            }
    $get_all_attchment = attachment_function($Sales_OrderID,$zoho_auth);
    $get_project_data = get_project_data($project_id,$project_auth);
    // echo'<pre>'; print_r($get_project_data);die;
    if (!empty($get_all_attchment['data']) && !empty($get_project_data)){
        foreach ($get_all_attchment['data'] as $key => $value){
            $attachment_id = $value['id']; 
            $delete_attchment = delete_attchment($Sales_OrderID,$zoho_auth,$attachment_id);
        }
    foreach ($get_project_data['dataobj'] as $key => $Return){
    $res_id = $Return['res_id'];
    $delete_attchment_in_zoho_project = delete_attchment_in_zoho_project($project_id,$project_auth,$res_id);
        } 
$query = array('file'=> $cFile);
 $attech_resp = Attachment($Sales_OrderID,$zoho_auth,$query);
    if (!empty($attech_resp) ){
   $attachemnt_query = array(
        'uploaddoc' => $cFile
    );
    $inserteddocumant = insert_doucment_in_zoho_project($attachemnt_query,$project_id,$project_auth);
    if (!empty($inserteddocumant)) {
        unlink($pdf_name);
        unlink('error_log');
        echo "Attachment uploaded successful";
    }else{
        echo "Something Wrong !";
    }

 }
    }else{
        $query = array('file'=> $cFile);
 $attech_resp = Attachment($Sales_OrderID,$zoho_auth,$query);
    if (!empty($attech_resp) ){
   $attachemnt_query = array(
        'uploaddoc' => $cFile
    );
    $inserteddocumant = insert_doucment_in_zoho_project($attachemnt_query,$project_id, $project_auth);
    if (!empty($inserteddocumant)) {
        unlink($pdf_name);
        unlink('error_log');
        echo "Attachment uploaded successful";
    }else{
        echo "Something Wrong !";
    }

 }
    }




function genrate_pdf($data,$pdfname,$Current_Date){
                !empty($one = $data["Measure_circumference_of_the_head_parallel_to_t"]) ? $one : $one ="&nbsp;&nbsp;";
                !empty($two = $data["Measure_circumference_of_the_middle_of_the_neck"]) ? $two  : $two ="flase";
                !empty( $three = $data["Measure_circumference_of_the_base_of_the_neck"]) ?$three: $three ="&nbsp;&nbsp;";
                !empty($four = $data["circumference_above_chest"]) ? $four : $four ="&nbsp;&nbsp;";
                !empty($five = $data["circumference_around_chest_across_nipples_while"]) ? $five : $five ="&nbsp;&nbsp;";
                !empty($six = $data["circumference_of_rib_cage_keeping_measuring_tap"]) ? $six : $six ="&nbsp;&nbsp;";
                !empty($seven = $data["circumference_around_waist_at_ribbon"]) ? $seven : $seven ="&nbsp;&nbsp;";
                !empty($eight = $data["circumference_of_the_upper_hip_at_the_hip_bone"]) ? $eight : $eight ="&nbsp;&nbsp;";
                !empty($nine = $data["circumference_around_widest_part_of_the_hip_lo"]) ? $nine  : $nine ="&nbsp;&nbsp;";
                !empty($ten = $data["circumference_of_the_top_of_the_thigh_directly"]) ? $ten : $ten ="&nbsp;&nbsp;";
                !empty($eleven = $data["circumference_of_thigh_parallel_to_floor"]) ? $eleven : $eleven ="&nbsp;&nbsp;";
                !empty($Twelve = $data["circumference_of_knee_parallel_to_floor"]) ? $Twelve : $Twelve ="&nbsp;&nbsp;";
                !empty($Thirteen = $data["circumference_of_calf_parallel_to_floor"]) ? $Thirteen : $Thirteen ="&nbsp;&nbsp;";
                !empty($Fourteen = $data["circumference_of_ankle_parallel_to_floor"]) ? $Fourteen : $Fourteen ="&nbsp;&nbsp;";
                !empty($Fifteen = $data["Measure_from_ankle_around_to_heel"]) ? $Fifteen : $Fifteen ="&nbsp;&nbsp;";
                !empty( $Sixteen = $data["Measure_high_hip_height_from_lower_edge_of_wai"]) ? $Sixteen: $Sixteen ="&nbsp;&nbsp;";
                !empty($Seventeen = $data["Measure_low_hip_height_from_lower_edge_of_wais"]) ? $Seventeen : $Seventeen ="&nbsp;&nbsp;";
                !empty($Eighteen = $data["leg_length_from_lower_edge_of_waist_ribbon_to"]) ? $Eighteen : $Eighteen ="&nbsp;&nbsp;";
                !empty($Nineteen = $data["the_length_of_the_foot_from_heel_to_longest_to"]) ? $Nineteen : $Nineteen ="&nbsp;&nbsp;";
                !empty($Twenty = $data["seat_height_placing_ruler_under_crotch_from_l"]) ? $Twenty : $Twenty ="&nbsp;&nbsp;";
                !empty($Twentyone = $data["inseam_by_placing_ruler_under_crotch_from_rul"]) ? $Twentyone  : $Twentyone ="&nbsp;&nbsp;";
                !empty($Twentytwo = $data["shoulder_arm_length_from_neck"]) ? $Twentytwo : $Twentytwo ="&nbsp;&nbsp;";
                !empty($Twentythree = $data["circumference_of_armhole_around_tip_of_shoulde"]) ? $Twentythree : $Twentythree ="&nbsp;&nbsp;";
                !empty($Twentyfour = $data["While_flexing_circumference_of_widest_part_of"]) ? $Twentyfour  : $Twentyfour ="&nbsp;&nbsp;";
                !empty($Twentyfive = $data["While_flexing_circumference_of_widest_part_of1"]) ? $Twentyfive  : $Twentyfive ="&nbsp;&nbsp;";
                !empty($Twentysix = $data["circumference_of_wrist"]) ?  $Twentysix : $Twentysix ="&nbsp;&nbsp;";
                !empty($Twentyseven = $data["circumference_of_widest_part_of_hand"]) ? $Twentyseven : $Twentyseven ="&nbsp;&nbsp;";
                !empty($Twentyeight = $data["front_length_from_shoulder_at_neck_straight_do"] ) ? $Twentyeight : $Twentyeight ="&nbsp;&nbsp;";
                !empty($Twentynine = $data["center_front_length_from_base_of_neck_to_lower"]) ? $Twentynine : $Twentynine ="&nbsp;&nbsp;";
                !empty($thirty = $data["Chest_width_Hang_your_arms_relaxed_Place_rul"]) ? $thirty : $thirty ="&nbsp;&nbsp;";
                !empty($thirty_one = $data["back_length_from_base_of_neck_straight_down_to"]) ? $thirty_one : $thirty_one ="&nbsp;&nbsp;";
                !empty($thirty_two = $data["shoulder_height_from_shoulder_at_neck_straight"]) ? $thirty_two : $thirty_two ="&nbsp;&nbsp;";
                !empty($thirty_three = $data["shoulder_slope_from_shoulder_tip_to_center_bac"]) ? $thirty_three : $thirty_three ="&nbsp;&nbsp;";
                !empty($thirty_four = $data["Back_width_Hang_your_arms_relaxed_Place_rule"]) ? $thirty_four : $thirty_four ="&nbsp;&nbsp;";
                !empty($thirty_five = $data["body_circumference_from_back_neck_down_spine"]) ? $thirty_five : $thirty_five ="&nbsp;&nbsp;";
                !empty($thirty_six = $data["seat_circumference_from_lower_edge_of_waist_ri"]) ? $thirty_six  : $thirty_six ="&nbsp;&nbsp;";
                !empty($thirty_seven = $data["Sleeve_head_Place_ruler_under_arm_parallel_to"]) ? $thirty_seven : $thirty_seven ="&nbsp;&nbsp;";
                !empty($thirty_eight = $data["Jacket_length_from_Back_of_neck_to_under_butt"]) ? $thirty_eight : $thirty_eight ="&nbsp;&nbsp;";
                !empty($thirty_nine = $data["Waist_height_from_top_of_ruler_under_arm_to_l"]) ? $thirty_nine : $thirty_nine ="&nbsp;&nbsp;";
                !empty($forty = $data["Tail_length_from_lower_edge_of_waist_ribbon_t"]) ? $forty : $forty ="&nbsp;&nbsp;";
                !empty($forty_one = $data["Waist_Knee_height_from_lower_edge_of_waist_rib"]) ? $forty_one : $forty_one ="&nbsp;&nbsp;";
                !empty($forty_two = $data["Knee_height_from_floor_to_highest_point_on_kn"] ) ? $forty_two: $forty_two ="&nbsp;&nbsp;";
                !empty($forty_three = $data["Height_from_floor_to_highest_point_on_head_k"]) ? $forty_three : $forty_three ="&nbsp;&nbsp;";
                !empty($forty_five = $data["Shoulder_length_length_from_neck_to_shoulder"]) ?  $forty_five: $forty_five ="&nbsp;&nbsp;";
                !empty($forty_six = $data["Sleeve_from_shoulder_bone_to_wrist"]) ? $forty_six : $forty_six ="&nbsp;&nbsp;";
                !empty($forty_nine = $data["shoulder_width_across_back_from_shoulder_tip_t"]) ? $forty_nine : $forty_nine ="&nbsp;&nbsp;";
                !empty($fifty_four = $data["girth_of_the_body_run_tape_from_corn_point_wh"]) ? $fifty_four : $fifty_four ="&nbsp;&nbsp;";
    //get Sales Order Id....
                  $shape = $data['Shape'];

$html = '<!DOCTYPE html>
<html>
<head>
 	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
 	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
  	<meta name="x-apple-disable-message-reformatting" />
</head>
<body style="padding: 0 !important;margin: 0 !important;display: block !important; min-width: 100% !important;width: 100% !important;background: #ffffff;-webkit-text-size-adjust: none;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="max-width: 920px; margin: auto;">
	<tr>
     	<td style="text-align: left;width: 80%;"><p style=" font-size: 19px;font-weight:bold;">Name: </p>'.$pdfname.'</td>
     	<td style="text-align: left; width: 20%;"><p style=" font-size: 19px;font-weight:bold;">Date : </p>'.$Current_Date.'</td>
   	</tr>
</table><br>

<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="max-width: 920px; margin: auto;"> 
   <tr><br>
            <td style=" width: 80%; text-align: left; font-size: 17px;padding-bottom: 0; "> Please have 2 rulers and a non stratchable ribbon. It is preffered to stand in front of a full length mirror. Wear tightly fitted clothes or as less as possible. Tie ribbon around waist. </td>
            <td style="text-align: right; font-size: 23px; width: 20%;   padding-bottom: 0;"><img src="./images/Gents/Logo-2.png" alt="Logo-2" border="0" "width:80px"></td>
          </tr>
</table>
   <br>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="max-width: 920px; margin: auto;">
        <tr>
            <td style="text-align: left; font-size: 21px; width: 45%; padding-top: 0;"> Selected shoulder shape describes you the best. </td>
                 
                       <td style="text-align:center;padding:10px;">
                        <img src="./images/Gents/Sloped.jpg">
                        <p style="font-size:21px;">Sloped</p>
                        </td>
                        <br>';
                          if($shape == 'Sloped'){
                          	 $html.='<input type="radio" value="" checked="checked">';
                          }else{
                       		 $html.='<input type="radio" value="" >';
                          }
                          $html.= '<td style="text-align:center;padding:10px;">
                        <img src="./images/Gents/Regular.jpg">
                        <p style="font-size:21px;">Regular</p>  </td>
                        <br>';
                     	if ($shape == 'Regular') {
                        	$html.='<input type="radio" value="" checked="checked">';
                        }else{
 							$html.='<input type="radio" value="" >';
 				        }
	                      $html.=' <td style="text-align:center;padding:10px;">
	                        <img src="./images/Gents/Squared.jpg">
	                         <p style="font-size:21px;">Squared</p>
	                        </td><br>';
                      	if($shape == 'Squared'){
                        	 $html.='<input type="radio" value="" checked="checked">';
                        }                     
                        else{
 								  $html.='<input type="radio" value="" >';
                           }
						
                    
        $html.= '</tr>
    </table>
   <table>
        <tr>
            <td>
                <div class="relative" style="position: relative;display: inline-block;">
                        <img src="./images/Gents/Male-Num-Form-Small-1.jpg" alt="Male-Num-Form-Small-1">
                            <div style="position: absolute;top: 485px;left: 93px;"> 
                                <div style="position: absolute;top: 21px;left: 30px;padding:3px 7px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;display: inline-block;text-align: center;line-height: 20px;font-weight:bold;">'.$one.'</span> 
                                    </div>                                              
                            </div>

                            <div class="measureBox box2" style="top: 524px;left: 106px;position: absolute;"> 
                               <div style="position: absolute;top: 21px;left: 30px;padding:3px 7px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;display: inline-block;text-align: center;font-weight:bold;line-height: 20px;">'.$two.'</span>    
                                    </div>                                                  
                            </div>

                            <div class="measureBox box4" style="top: 542px;left: 125px;position: absolute;"> 
                                <div style="position: absolute;top: 21px;left: 30px;padding:3px 7px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;display: inline-block;font-weight:bold;text-align: center;line-height: 20px;">'.$three.'</span>
                                    </div>                                                      
                            </div>
                            <div class="measureBox box4" style="top: 581px;left: 125px;position: absolute;"> 
                                <div style="position: absolute;top: 21px;left: 30px;padding:3px 7px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;display: inline-block;text-align: center;font-weight:bold;line-height: 20px;">'.$four.'</span>
                                    </div>                                                      
                            </div>
                            <div class="measureBox box4" style="top: 592px;left: 150px;position: absolute;"> 
                                <div style="position: absolute;top: 21px;left: 30px;padding:3px 7px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;display: inline-block;font-weight:bold;text-align: center;line-height: 20px;">'.$five.'</span>
                                    </div>                                                      
                            </div>

                            <div class="measureBox box4" style="top: 635px;left: 130px;position: absolute;"> 
                                <div style="position: absolute;top: 21px;left: 30px;padding:3px 7px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$six.'</span>    
                                    </div>                                                  
                            </div>

                            <div class="measureBox box4" style="top: 670px;left: 136px;position: absolute;"> 
                                <div style="position: absolute;top: 21px;left: 30px;padding:3px 7px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$seven.'</span>
                                    </div>                                                    
                            </div>
                            <div class="measureBox box4" style="top:685px;left: 43px;position: absolute;"> 
                                <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;display: inline-block;text-align: center;line-height: 20px;font-weight:bold;">'.$Eighteen.'</span>    
                                </div>                                                  
                            </div>

                            <div class="measureBox box4" style="top:696px;left: 135px;position: absolute;"> 
                                <div style="position: absolute;top: 21px;left: 30px;padding:3px 7px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$eight.'</span>    
                                    </div>                                                  
                            </div>

                               <div class="measureBox box4" style="top:715px;left: 168px;position: absolute;"> 
                                <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$Twenty.'</span>    
                                </div>                                                  
                            </div>

                            <div class="measureBox box4" style="top: 722px;left: 135px;position: absolute;"> 
                                <div style="position: absolute;top: 21px;left: 30px;padding:3px 7px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$nine.'</span>
                                </div>                                                      
                            </div>

                            <div class="measureBox box4" style="top: 742px;left: 137px;position: absolute;"> 
                                <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$ten.'</span>    
                                </div>                                                  
                            </div>
                            <div class="measureBox box4" style="top: 777px;left: 139px;position: absolute;"> 
                               <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$eleven.'</span>    
                                </div>                                                  
                            </div>
                           <div class="measureBox box4" style="top: 819px;left: 136px;position: absolute;"> 
                                <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$Twelve.'</span>    
                                </div>                                                  
                            </div>
                             <div class="measureBox box4" style="top: 835px;left: 168px;position: absolute;"> 
                               <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$Twentyone.'</span>    
                                </div>                                                  
                            </div>
                             <div class="measureBox box4" style="top: 854px;left: 127px;position: absolute;"> 
                               <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$Thirteen.'</span>    
                                </div>                                                  
                            </div>

                             <div class="measureBox box4" style="top: 918px;left: 126px;position: absolute;"> 
                                <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$Fourteen.'</span>    
                                </div>                                                  
                            </div>

                             <div class="measureBox box4" style="top: 966px;left: 140px;position: absolute;"> 
                                <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$Nineteen.'</span>    
                                </div>                                                  
                            </div>
                    
                </div>

            </td>

                <td>                               
                    <div class="relative block" style="position: relative;display: inline-block;">
                        <h1 style="color:#fff;font-size:80px;">T</h1>
                        <img class="Item2" style="width: 127px;position: relative;top: 0;margin:0 auto;display:block;" src="./images/Gents/Male-Num-Form-Small-2.jpg">
                        <div style="position: absolute;top: 556px;left: 225px;"> 
                            <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$Twentytwo.'</span>    
                                </div>                                              
                        </div>
                        <div style="position: absolute;top: 575px;left: 232px;"> 
                           <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$Twentythree.'</span>    
                                </div>                                              
                        </div>
                        <div style="position: absolute;top: 598px;left: 220px;"> 
                           <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$Twentyfour.'</span> 
                                </div>                                              
                        </div>
                        <div style="position: absolute;top: 586px;left: 285px;"> 
                           <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$thirty.'</span>    
                                </div>                                              
                        </div>
                        <div style="position: absolute;top: 623px;left: 239px;"> 
                           <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$Twentyeight.'</span> 
                                </div>                                              
                        </div>
                            <div style="position: absolute;top: 623px;left: 259px;"> 
                           <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$Twentynine.'</span> 
                                </div>                                              
                        </div>
                        <div style="position: absolute;top: 650px;left: 220px;"> 
                            <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$Twentyfive.'</span>    
                                </div>                                              
                        </div>
                        <div style="position: absolute;top: 696px;left: 221px;"> 
                            <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$Twentysix.'</span>    
                                </div>                                              
                        </div>
                        <div style="position: absolute;top: 716px;left: 223px;"> 
                            <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$Twentyseven.'</span>    
                                </div>                                              
                        </div>
                    </div>

                    <br><br><br>
                    <div class="relative block" style="position: relative;display: inline-block;">
                       <img class="Item6" src="./images/Gents/Male-Num-Form-Small-6.jpg" style="width: 140px;position: relative;top: 50px;">
                       <div style="position: absolute;top: 857px;left: 225px;"> 
                            <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$forty_five.'</span>    
                                </div>                                              
                        </div>
                          <div style="position: absolute;top: 895px;left: 278px;"> 
                            <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$forty_nine.'</span>    
                                </div>                                              
                        </div>
                         <div style="position: absolute;top: 909px;left: 243px;"> 
                           <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$fifty_four.'</span>    
                                </div>                                              
                        </div>
                         <div style="position: absolute;top: 950px;left: 196px;"> 
                           <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$forty_six.'</span>    
                                </div>                                              
                        </div>
                    </div>
                </td>

                    <td>
                        <div class="relative block" style="position: relative;display: inline-block;">
                              <h1 style="color:#fff;font-size:70px;">T</h1>
                            <img class="Item3" style="width: 140px;position: relative;top: 15px;margin:0 auto;display:block;" src="./images/Gents/Male-Num-Form-Small-3.jpg">
                            <div style="position: absolute;top: 584px;left: 388px;"> 
                               <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$thirty_one.'</span> 
                                </div>                                              
                            </div>
                            <div style="position: absolute;top: 583px;left: 411px;"> 
                                <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$thirty_two.'</span>    
                                </div>                                              
                            </div>
                            <div style="position: absolute;top: 591px;left: 436px;"> 
                                <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$thirty_three.'</span>    
                                </div>                                              
                            </div>
                             <div style="position: absolute;top: 596px;left: 372px;"> 
                                <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$thirty_four.'</span>    
                                </div>                                              
                            </div>
                        </div>
                        <br><br><br><br><br>
                        
                        <div class="relative block" style="position: relative;display: inline-block;">
                            <img class="Item7" src="./images/Gents/Male-Num-Form-Small-7.jpg" style="width: 100px;" >
                        </div>
                    </td>

                    <td>
                        <div class="relative block" style="position: relative;display: inline-block;">
                        <h1 style="color:#fff;font-size:65px;">T</h1>
                          <img class="Item4" style="width: 95px;position: relative;top: 15px;margin:0 auto;display:block;" src="https://i.ibb.co/QPyN870/Male-Num-Form-Small-4.jpg">
                               <div style="position: absolute;top: 555px;left: 491px;"> 
                                <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$thirty_five.'</span>    
                                </div>                                              
                            </div>
                             <div style="position: absolute;top: 662px;left: 490px;"> 
                                <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$thirty_six.'</span>    
                                </div>                                              
                            </div>
                        </div>
                        <br><br><br><br><br><br>

                        <div class="relative block" style="position: relative;display: inline-block;">
                           <img class="Item8" style="width: 75px;position: relative;top: 50px;left: 30px;" src="./images/Gents/Male-Num-Form-Small-8.jpg">

                        </div>
                    </td>

                    <td>
                        <div class="relative block" style="position: relative;display: inline-block;">
                         <h1 style="color:#fff;">T</h1>
                            <img class="Item5" style="width: 127px;position: relative;top: 15px;margin:0 auto;display:block;" src="./images/Gents/Male-Num-Form-Small-5.jpg">
                                 <div style="position: absolute;top: 540px;left: 600px;"> 
                                	<div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$thirty_eight.'</span>    
                                </div>                                              
                            </div>
                            <div style="position: absolute;top: 581px;left: 591px;"> 
                               <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$thirty_nine.'</span>    
                                </div>                                              
                            </div>
                             <div style="position: absolute;top: 575px;left: 692px;"> 
                                <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$forty_three.'</span>    
                                </div>                                              
                            </div>
                            <div style="position: absolute;top: 645px;left: 591px;"> 
                                <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$forty.'</span>    
                                </div>                                              
                            </div>
                             <div style="position: absolute;top: 690px;left: 678px;"> 
                                <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$forty_one.'</span>    
                                </div>                                              
                            </div>
                             <div style="position: absolute;top: 764px;left: 678px;"> 
                                <div style="position: absolute;top: 21px;left: 30px;padding:4px 5px;background-color:yellow;border-radius: 100%;text-align: center;"> 
                                    <span style="cursor: pointer;color: black;font-size: 8px;font-weight: 600;width: 20px;height: 20px;font-weight:bold;display: inline-block;text-align: center;line-height: 20px;">'.$forty_two.'</span>    
                                </div>                                              
                            </div>
                        </div><br><br><br><br>
                        <div class="relative block" style="position: relative;display: inline-block;">
                            <img class="Item9" style="width:80px;position: relative;top: 80px;left: 30px;" src="./images/Gents/Male-Num-Form-Small-9.jpg">
                        </div>
                    </td>   
        </tr>
    </table>
               
   </body>
</html>';
return $html;

}

function genrate_tokens(){
    $get_token = file_get_contents("crm_auth_token_gents.txt");
    $get_accesstoken = json_decode($get_token, true);
    $crm_auth_token = $get_accesstoken["token"];
    $time = $get_accesstoken["time"];
    $currenttime = time();
    if ($currenttime - $time > 3000)
    {
        $crm_auth_token = crm_access_token();
        $newarr["time"] = time();
        $newarr["token"] = $crm_auth_token;
        $newjson = json_encode($newarr);
        file_put_contents("crm_auth_token_gents.txt", $newjson);
    }
    $get_token = file_get_contents("project_auth_token_gents.txt");
    $get_accesstoken = json_decode($get_token, true);
    $projectauthtoken = $get_accesstoken["token"];
    $time = $get_accesstoken["time"];
    $currenttime = time();
    if ($currenttime - $time > 3000)
    {
        $projectauthtoken = project_auth_token();
        $newarr["time"] = time();
        $newarr["token"] = $projectauthtoken;
        $newjson = json_encode($newarr);
        file_put_contents("project_auth_token_gents.txt", $newjson);
    }
    $token_arr['crm_token'] =$crm_auth_token;
    $token_arr['project_token'] =$projectauthtoken;
    return $token_arr;
}

function get_data_in_crm($id ,$zoho_aut){
     $header_arry = ['Authorization: Zoho-oauthtoken '.$zoho_aut];
     $url = "https://www.zohoapis.com/crm/v2/Measurement_for_Gents/".$id;  
      $result = curlRequest($url,"","GET",$header_arry); 
      $decoders = json_decode($result,true);
      return  $data = $decoders['data'][0];
}

function attachment_function($Sales_OrderID,$zoho_auth){
    $header_arry = ['Authorization: Zoho-oauthtoken '.$zoho_auth];
    $url = "https://www.zohoapis.com/crm/v2/Sales_Orders/".$Sales_OrderID."/Attachments";
    $resp = curlRequest($url,"","GET",$header_arry);
    return  $decoder_data = json_decode($resp,true);


}

function delete_attchment($Sales_OrderID,$zoho_auth,$attachment_id){
    $header_arry = ['Authorization: Zoho-oauthtoken '.$zoho_auth];
      $url = "https://www.zohoapis.com/crm/v2/Sales_Orders/".$Sales_OrderID."/Attachments/".$attachment_id."";
    $resp = curlRequest($url,"","DELETE",$header_arry);
    return $decoder_data = json_decode($resp,true);

}
function delete_attchment_in_zoho_project($project_id,$zoho_auth,$res_id){
    $header_arry = array("authorization: Zoho-oauthtoken ". $zoho_auth);
     $con_url = "https://projectsapi.zoho.com/restapi/portal/661991009/projects/". $project_id."/documents/".$res_id."/";
     $resp = curlRequest($con_url,"","DELETE",$header_arry);
     return $decoder_data = json_decode($resp,true);
}
// echo '<pre>'; print_r($get_project_data);die;
function get_project_data($project_id, $zoho_auth)
{

       $header_arry = array("authorization: Zoho-oauthtoken ". $zoho_auth);
       $con_url = "https://projectsapi.zoho.com/restapi/portal/661991009/projects/" . $project_id."/documents/";
       $con_result = curlRequest($con_url, "", "GET", $header_arry);
       return $con_result = json_decode($con_result, true);
    
}


    function Attachment($Sales_OrderID,$zoho_auth,$query){
     $header_arry = ['Content-Type: multipart/form-data', 'Authorization: Zoho-oauthtoken '.$zoho_auth];
         $url = "https://www.zohoapis.com/crm/v2/Sales_Orders/".$Sales_OrderID."/Attachments";
                $resp = curlRequest($url,$query,"POST",$header_arry);
                $decoder_data = json_decode($resp,true);
                 return $decoder_data;
                              
}

function get_project_id($sales_order_id, $zoho_auth)
{
    $header_arry = array(
        "authorization: Zoho-oauthtoken " . $zoho_auth,
    );
    $con_url = "https://www.zohoapis.com/crm/v2/Sales_Orders/".$sales_order_id;
    $con_result = curlRequest($con_url, "", "GET", $header_arry);
   $con_result = json_decode($con_result, true);
    return  $con_result['data'][0];
}

function insert_doucment_in_zoho_project($attachemnt_query, $project_id, $zoho_auth)
{

    $header_arry = array(
        "Authorization: Zoho-oauthtoken " . $zoho_auth
    );
     $attachemnt_query;
      $con_url = "https://projectsapi.zoho.com/restapi/portal/661991009/projects/" . $project_id . "/documents/";
    $con_result = curlRequest($con_url, $attachemnt_query, "POST", $header_arry);
    return $con_result = json_decode($con_result, true);

}        

function crm_access_token()
{
    $tokan_url = "https://accounts.zoho.com/oauth/v2/token?refresh_token=1000.e9619761407d943c4d8087c7bb3aa952.98d123f3e186a58fd48d07bc42ddec88&client_id=1000.BKD99X33LYZSMPAFNOV286JWW4OHND&client_secret=c4c550691ac2cd9f506a24c1aa9f3d988cbc8c0003&grant_type=refresh_token";
    $resp = curlRequest($tokan_url, "", "POST", []);
    $resp_decode = json_decode($resp, true);
    return $resp_decode["access_token"];
}

function project_auth_token(){
    $tokan_url = "https://accounts.zoho.com/oauth/v2/token?refresh_token=1000.a9cbd7547ce6e6a945b163ad69e68373.ee2b51b2f9e2b1f9d3dc0b038099dff6&client_id=1000.BKD99X33LYZSMPAFNOV286JWW4OHND&client_secret=c4c550691ac2cd9f506a24c1aa9f3d988cbc8c0003&grant_type=refresh_token";
    $resp = curlRequest($tokan_url, "", "POST", []);
    $resp_decode = json_decode($resp, true);
    return $resp_decode["access_token"];
}

function curlRequest($url, $query = null, $method, $header = null)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);
    if ($err)
    {
        return "cURL Error #:" . $err;
    }
    else
    {
        return $server_output;
    }
}

?>