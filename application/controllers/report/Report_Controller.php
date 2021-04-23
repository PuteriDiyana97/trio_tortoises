<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Report_Controller extends My_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('report/Reports');
        $this->load->model('report/Report_point');
        $this->load->model('report/Report_members');
        $this->load->model('report/Report_vouchers');
        $this->load->model('report/Report_sales');
    }

    public function master_voucher()
    {
        $data = array();
        $selected_id_enc = $this->input->get('ids');
        $selected_id = encryptor('decrypt',$selected_id_enc);
        //pre($selected_id_enc);
        // $data['member_list']= $this->Report_vouchers->voucher_detail($selected_id);

        $this->data = $data;
        $this->middle = 'reports/report_master_voucher';
        $this->layout();    
    }

    // list for datatable
    public function master_voucher_list()
    {
        $output =  array(
                            "draw" => '',
                            "recordsTotal" => 0,
                            "recordsFiltered" => 0,
                            "data" => '',
                        );
        $data = array();

            $no = $_POST['start'];
            $data = array();
            $list = $this->Report_vouchers->get_datatables();
            //pre($list); die();
            foreach ($list as $field) 
            {
                $no++;
                $row = array();

                $id = $field->id;
                $id_enc = encryptor('encrypt',$id);

                $nationality = $field->country;
                
                if ($nationality == 'Malaysia' || $nationality == 'malaysia' || $nationality == 'MALAYSIA') {
                    $nationality = 'MALAYSIAN';
                } else if ($nationality == 'Singapore' || $nationality == 'singapore' || $nationality == 'SINGAPORE') {
                    $nationality = 'SINGAPOREAN';
                } else{
                    $nationality = 'ASIAN';
                }

                $voucher_type = $field->voucher_type;
                
                if ($voucher_type == 1) {
                    $voucher_type = 'BIRTHDAY VOUCHER';
                } else{
                    $voucher_type = 'REGULAR VOUCHER';
                }

                $row["id"] = $id_enc;
                $row[] = $no;
                $row[] = $field->contact_no;
                // $row[] = $field->name;
                $row[] = $nationality;
                $row[] = strtoupper($field->voucher_name); 
                $row[] = $voucher_type;

                // $row[] = '   <a href="javascript:void(0)" class="btn_view" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="View" data-original-title="View" ><i class="fa fa-edit kt-font-brand"></i></a>&nbsp;&nbsp;
                //          <a href="javascript:void(0)" class="btn_delete" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete" ><i class="fa fa-trash kt-font-dangerous"></i></a>';
     
                $data[] = $row;
            }
     
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Report_vouchers->count_all(),
                "recordsFiltered" => $this->Report_vouchers->count_filtered(),
                "data" => $data,
            );
        //output dalam format JSON
        echo json_encode($output);
    }

    public function master_voucher_export()
    {
        $filter_date_start = $this->input->post('fds');
        $filter_date_end   = $this->input->post('fde');

        $filter_date = array(
                                'filter_date_start' => $filter_date_start,
                                'filter_date_end'   => $filter_date_end,
                            );

      //pre($filter_date);
      // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $export_title = 'Master Voucher Report';
        //name the worksheet
        $spreadsheet->getActiveSheet()->setTitle($export_title);

        $row = 1;
        $col = 1;

        // set the names of header cells
        $array_data_header = array(
                                    "MEMBER ID",
                                   // "MEMBER NAME",
                                    "NATIONALITY",
                                    "VOUCHER NAME",
                                    "VOUCHER TYPE",
                                  );

        //assign header to first row
        foreach($array_data_header as $value)
        {
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
            $col++;
        }
        //get highest column
        $highest_column = $spreadsheet->getActiveSheet()->getHighestDataColumn();

        // add style to the header
          $styleArray = array(
            'font' => array(
              'bold' => true,
            ),
            'alignment' => array(
              'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
              'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'bottom' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => array('rgb' => '333333'),
                ),
            ),
            'fill' => array(
              'type'       => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
              'rotation'   => 90,
              'startcolor' => array('rgb' => '0d0d0d'),
              'endColor'   => array('rgb' => 'f2f2f2'),
            ),
          );

        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highest_column . $row)->applyFromArray($styleArray);

          // auto fit column to content
        foreach(range('A', $highest_column) as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
          }

        $row++;

        $list = $this->Report_vouchers->get_data_export($filter_date); //$filter_date
       // pre($list); die();

        foreach ($list as $field)
              {
                $nationality = $field->country;
                
                if ($nationality == 'Malaysia' || $nationality == 'malaysia' || $nationality == 'MALAYSIA') {
                    $nationality = 'MALAYSIAN';
                } else if ($nationality == 'Singapore' || $nationality == 'singapore' || $nationality == 'SINGAPORE') {
                    $nationality = 'SINGAPOREAN';
                } else{
                    $nationality = 'ASIAN';
                }

                $voucher_type = $field->voucher_type;
                
                if ($voucher_type == 1) {
                    $voucher_type = 'BIRTHDAY VOUCHER';
                } else{
                    $voucher_type = 'REGULAR VOUCHER';
                }
                  
                $array_data_body = array(
                                            $field->contact_no,
                                            //$field->name,
                                            $nationality,
                                            $field->voucher_name,
                                            $voucher_type,
                                    );

                $col = 1;

                    foreach ( $array_data_body as $value )
                    {
                        $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
                        $col++;
                    }
                    $spreadsheet->getActiveSheet()->getStyle('A'.$row.':'.$highest_column.$row)->getAlignment()->setHorizontal('center');

                    $row++;
              }

        $filepath = 'export_files/';
        //save our workbook as this file name
        $filename = str_replace(' ', '', $export_title).'_'.date('YmdHis').'.xlsx';
        
        //#PHPSpreadsheet Step 3: Create Output Xlsx
        $objWriter = IOFactory::createWriter($spreadsheet, 'Xlsx');

        //force user to download the Excel file without writing it to server's HD
        // $objWriter->save('php://output');
        $objWriter->save($filepath.$filename);

        if ( file_exists($filepath.$filename) )
        {
            $filesave = 1;
        }
        else
        {
            $filesave = 0;
        }

        $result = array(
                        'filesave' => $filesave,
                        'filename' => $filename,
                        );

        echo json_encode($result);
    }

    public function master_point()
    {
        $data = array();

        // $data['total_male'] = $this->Report_point->count_gender('male');
        // $data['total_female'] = $this->Report_point->count_gender('female');

        $this->data = $data;
        $this->middle = 'reports/report_master_point';
        $this->layout();    
    }

     // list for datatable
    public function master_point_list()
    {
        $output =  array(
                            "draw" => '',
                            "recordsTotal" => 0,
                            "recordsFiltered" => 0,
                            "data" => '',
                        );
        $data = array();

            $no = $_POST['start'];
            $data = array();
            $list = $this->Report_point->get_datatables();
            //pre($list); die();
            foreach ($list as $field) 
            {
                $no++;
                $row = array();

                $id = $field->id;
                $id_enc = encryptor('encrypt',$id);
                $point_used =  '0';

                    if (!empty($field->point_used)) {
                        $point_used = $field->point_used;
                    }

                $row["id"] = $id_enc;
                $row[] = $no;
                $row[] = strtoupper($field->gender);
                $row[] = $point_used;
                $row['gender_check'] = strtolower($field->gender);

                // $row[] = '   <a href="javascript:void(0)" class="btn_view" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="View" data-original-title="View" ><i class="fa fa-edit kt-font-brand"></i></a>&nbsp;&nbsp;
                //          <a href="javascript:void(0)" class="btn_delete" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete" ><i class="fa fa-trash kt-font-dangerous"></i></a>';
     
                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Report_point->count_all(),
                "recordsFiltered" => $this->Report_point->count_filtered(),
                "data" => $data,
            );
        //output dalam format JSON
        echo json_encode($output);
    }

    public function master_point_export()
    {
        $filter_date_start = $this->input->post('fds');
        $filter_date_end   = $this->input->post('fde');

        $filter_date = array(
                                'filter_date_start' => $filter_date_start,
                                'filter_date_end'   => $filter_date_end,
                            );

       // pre($filter_date);


       
      // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $export_title = 'Master Point Report';
        //name the worksheet
        $spreadsheet->getActiveSheet()->setTitle($export_title);

        $row = 1;
        $col = 1;

        // set the names of header cells
        $array_data_header = array(
                                    "GENDER",
                                    "TOTAL POINT USED",
                                  );

        //assign header to first row
        foreach($array_data_header as $value)
        {
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
            $col++;
        }
        //get highest column
        $highest_column = $spreadsheet->getActiveSheet()->getHighestDataColumn();

        // add style to the header
          $styleArray = array(
            'font' => array(
              'bold' => true,
            ),
            'alignment' => array(
              'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
              'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'bottom' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => array('rgb' => '333333'),
                ),
            ),
            'fill' => array(
              'type'       => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
              'rotation'   => 90,
              'startcolor' => array('rgb' => '0d0d0d'),
              'endColor'   => array('rgb' => 'f2f2f2'),
            ),
          );

        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highest_column . $row)->applyFromArray($styleArray);

          // auto fit column to content
        foreach(range('A', $highest_column) as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
          }

        $row++;

       $list = $this->Report_point->get_data_export($filter_date); 
        // pre($list); die();

        foreach ($list as $field)
              {
                $deduct_points =  '0';

                    if (!empty($field->point_used)) {
                        $deduct_points = $field->point_used;
                    }

                $array_data_body = array(
                                            strtoupper($field->Gender),
                                            $deduct_points,
                                    );

                $col = 1;

                    foreach ( $array_data_body as $value )
                    {
                        $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
                        $col++;
                    }
                    $spreadsheet->getActiveSheet()->getStyle('A'.$row.':'.$highest_column.$row)->getAlignment()->setHorizontal('center');

                    $row++;
              }

        $filepath = 'export_files/';
        //save our workbook as this file name
        $filename = str_replace(' ', '', $export_title).'_'.date('YmdHis').'.xlsx';
        
        //#PHPSpreadsheet Step 3: Create Output Xlsx
        $objWriter = IOFactory::createWriter($spreadsheet, 'Xlsx');

        //force user to download the Excel file without writing it to server's HD
        // $objWriter->save('php://output');
        $objWriter->save($filepath.$filename);

        if ( file_exists($filepath.$filename) )
        {
            $filesave = 1;
        }
        else
        {
            $filesave = 0;
        }

        $result = array(
                        'filesave' => $filesave,
                        'filename' => $filename,
                        );

        echo json_encode($result);
    }

    public function member_sales()
    {
        $data = array();

        $this->data = $data;
        $this->middle = 'reports/report_member_sales';
        $this->layout();    
    }

    public function member_sales_list()
    {
        $output =  array(
                            "draw" => '',
                            "recordsTotal" => 0,
                            "recordsFiltered" => 0,
                            "data" => '',
                        );
        $data = array();

            $no = $_POST['start'];
            $data = array();
            $list = $this->Report_sales->get_datatables();
           // pre($list); die();
            foreach ($list as $field) 
            {
                $no++;
                $row = array();

                $id = $field->id;
                $id_enc = encryptor('encrypt',$id);
                $deduct_points =  '0';
                $nationality = $field->country;
                
                if ($nationality == 'Malaysia' || $nationality == 'malaysia' || $nationality == 'MALAYSIA') {
                    $nationality = 'MALAYSIAN';
                }

                if (!empty($field->deduct_points)) {
                    $deduct_points = $field->deduct_points;
                }

                $row["id"] = $id_enc;
                $row[] = $no;
                $row[] = $field->contact_no;
                $row[] = strtoupper($field->name); 
                $row[] = strtoupper($nationality);
                $row[] = $deduct_points;

                // $row[] = '   <a href="javascript:void(0)" class="btn_view" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="View" data-original-title="View" ><i class="fa fa-edit kt-font-brand"></i></a>&nbsp;&nbsp;
                //          <a href="javascript:void(0)" class="btn_delete" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete" ><i class="fa fa-trash kt-font-dangerous"></i></a>';
     
                $data[] = $row;
            }
    
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Report_sales->count_all(),
                "recordsFiltered" => $this->Report_sales->count_filtered(),
                "data" => $data,
            );
        //output dalam format JSON
        echo json_encode($output);
    }

    public function master_sales_export()
    {
        $filter_date_start = $this->input->post('fds');
        $filter_date_end   = $this->input->post('fde');

        $filter_date = array(
                                'filter_date_start' => $filter_date_start,
                                'filter_date_end'   => $filter_date_end,
                            );

       //pre($filter_date);
      // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $export_title = 'Master Sales Report';
        //name the worksheet
        $spreadsheet->getActiveSheet()->setTitle($export_title);

        $row = 1;
        $col = 1;

        // set the names of header cells
        $array_data_header = array(
                                    "MEMBER ID",
                                    "MEMBER NAME",
                                    "GENDER",
                                    "TOTAL POINTS USED",
                                  );

        //assign header to first row
        foreach($array_data_header as $value)
        {
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
            $col++;
        }
        //get highest column
        $highest_column = $spreadsheet->getActiveSheet()->getHighestDataColumn();

        // add style to the header
          $styleArray = array(
            'font' => array(
              'bold' => true,
            ),
            'alignment' => array(
              'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
              'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'bottom' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => array('rgb' => '333333'),
                ),
            ),
            'fill' => array(
              'type'       => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
              'rotation'   => 90,
              'startcolor' => array('rgb' => '0d0d0d'),
              'endColor'   => array('rgb' => 'f2f2f2'),
            ),
          );

        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highest_column . $row)->applyFromArray($styleArray);

          // auto fit column to content
        foreach(range('A', $highest_column) as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
          }

        $row++;

       $list = $this->Report_sales->get_data_export($filter_date);
      //  pre($list);die();
        foreach ($list as $field)
              {     
                $deduct_points =  '0';

                if (!empty($field->deduct_points)) {
                    $deduct_points = $field->deduct_points;
                }

                $nationality = $field->country;
                
                if ($nationality == 'Malaysia' || $nationality == 'malaysia' || $nationality == 'MALAYSIA') {
                    $nationality = 'MALAYSIAN';
                } else if ($nationality == 'Singapore' || $nationality == 'singapore' || $nationality == 'SINGAPORE') {
                    $nationality = 'SINGAPOREAN';
                } else{
                    $nationality = 'ASIAN';
                }
                    
                  $array_data_body = array(
                                            $field->contact_no,
                                            strtoupper($field->name),
                                            strtoupper($nationality),
                                            $deduct_points,
                                    );
                    
                    $col = 1;

                    foreach ( $array_data_body as $value )
                    {
                        $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
                        $col++;
                    }
                    $spreadsheet->getActiveSheet()->getStyle('A'.$row.':'.$highest_column.$row)->getAlignment()->setHorizontal('center');

                    $row++;
              }

        $filepath = 'export_files/';
        //save our workbook as this file name
        $filename = str_replace(' ', '', $export_title).'_'.date('YmdHis').'.xlsx';
        
        //#PHPSpreadsheet Step 3: Create Output Xlsx
        $objWriter = IOFactory::createWriter($spreadsheet, 'Xlsx');

        //force user to download the Excel file without writing it to server's HD
        // $objWriter->save('php://output');
        $objWriter->save($filepath.$filename);

        if ( file_exists($filepath.$filename) )
        {
            $filesave = 1;
        }
        else
        {
            $filesave = 0;
        }

        $result = array(
                        'filesave' => $filesave,
                        'filename' => $filename,
                        );

        echo json_encode($result);
    }

    public function master_member()
    {
        $data = array();

        $this->data = $data;
        $this->middle = 'reports/report_master_member';
        $this->layout();    
    }

    public function master_member_list()
    {
        $output =  array(
                            "draw" => '',
                            "recordsTotal" => 0,
                            "recordsFiltered" => 0,
                            "data" => '',
                        );
        $data = array();

            $no = $_POST['start'];
            $data = array();
            $list = $this->Report_members->get_datatables();
           //pre($list); die();
            foreach ($list as $field) 
            {
                $no++;
                $row = array();

                $id = $field->id;
                $id_enc = encryptor('encrypt',$id);
                $current_points = $field->sum_points - $field->deduct_points;
                
                $deduct_points =  '0';

                if (!empty($field->deduct_points)) {
                    $deduct_points = $field->deduct_points;
                }

                $nationality = $field->country;
                
                if ($nationality == 'Malaysia' || $nationality == 'malaysia' || $nationality == 'MALAYSIA') {
                    $nationality = 'MALAYSIAN';
                } else if ($nationality == 'Singapore' || $nationality == 'singapore' || $nationality == 'SINGAPORE') {
                    $nationality = 'SINGAPOREAN';
                } else if ($nationality == 'Indonesia' || $nationality == 'indonesia' || $nationality == 'INDONESIA') {
                    $nationality = 'INDONESIAN';
                }else if ($nationality == 'Thailand' || $nationality == 'thailand' || $nationality == 'THAILAND') {
                    $nationality = 'THAI';
                }else if ($nationality == 'Vietnam' || $nationality == 'vietnam' || $nationality == 'VIETNAM') {
                    $nationality = 'VIETNAMESE';
                }else if ($nationality == 'Philippines' || $nationality == 'philippines' || $nationality == 'PHILIPPINES') {
                    $nationality = 'PHILIPPINE';
                }else if ($nationality == 'INDIA') {
                    $nationality = 'INDIAN';
                }else if ($nationality == 'MYANMAR') {
                    $nationality = 'BURMESE';
                }else if ($nationality == 'CHINA') {
                    $nationality = 'CHINESE';
                }else{
                    $nationality = '-';
                }

                if (!empty($field->deduct_points)) {
                    $deduct_points = $field->deduct_points;
                }

                $row["id"] = $id_enc;
                $row[] = $no;
                $row[] = $field->contact_no;
                $row[] = strtoupper($field->name);
                $row[] = strtoupper($field->gender);
                $row[] = strtoupper($nationality);
                $row[] = $current_points;
                $row[] = $deduct_points;
                
                // $row[] = '   <a href="javascript:void(0)" class="btn_view" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="View" data-original-title="View" ><i class="fa fa-edit kt-font-brand"></i></a>&nbsp;&nbsp;
                //          <a href="javascript:void(0)" class="btn_delete" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete" ><i class="fa fa-trash kt-font-dangerous"></i></a>';
     
                $data[] = $row;
            }
     
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Report_members->count_all(),
                "recordsFiltered" => $this->Report_members->count_filtered(),
                "data" => $data,
            );
        //output dalam format JSON
        echo json_encode($output);
    }

    public function master_member_export()
    {
        $filter_date_start = $this->input->post('fds');
        $filter_date_end   = $this->input->post('fde');

        $filter_date = array(
                                'filter_date_start' => $filter_date_start,
                                'filter_date_end'   => $filter_date_end,
                            );

      // pre($filter_date);
      // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $export_title = 'Member Report';
        //name the worksheet
        $spreadsheet->getActiveSheet()->setTitle($export_title);

        $row = 1;
        $col = 1;

        // set the names of header cells
        $array_data_header = array(
                                    "MEMBER ID",
                                    "MEMBER NAME",
                                    "COUNTRY",
                                    "CURRENT POINTS",
                                    "TOTAL POINTS",
                                  );

        //assign header to first row
        foreach($array_data_header as $value)
        {
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
            $col++;
        }
        //get highest column
        $highest_column = $spreadsheet->getActiveSheet()->getHighestDataColumn();

        // add style to the header
          $styleArray = array(
            'font' => array(
              'bold' => true,
            ),
            'alignment' => array(
              'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
              'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'bottom' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => array('rgb' => '333333'),
                ),
            ),
            'fill' => array(
              'type'       => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
              'rotation'   => 90,
              'startcolor' => array('rgb' => '0d0d0d'),
              'endColor'   => array('rgb' => 'f2f2f2'),
            ),
          );

        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highest_column . $row)->applyFromArray($styleArray);

          // auto fit column to content
        foreach(range('A', $highest_column) as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
          }

        $row++;

        $list = $this->Report_members->get_data_export($filter_date); //
       // pre($list); die();

        foreach ($list as $field)
        { 
                $current_points = $field->sum_points - $field->deduct_points;
                $deduct_points =  '0';
                $nationality = $field->country;
                
                if ($nationality == 'Malaysia' || $nationality == 'malaysia' || $nationality == 'MALAYSIA') {
                    $nationality = 'MALAYSIAN';
                } else if ($nationality == 'Indonesia' || $nationality == 'indonesia' || $nationality == 'INDONESIA') {
                    $nationality = 'INDONESIAN'; 
                } else if ($nationality == 'Singapore' || $nationality == 'singapore' || $nationality == 'SINGAPORE') {
                    $nationality = 'SINGAPOREAN';
                } else if ($nationality == 'Thailand' || $nationality == 'thailand' || $nationality == 'THAILAND') {
                    $nationality = 'THAI';
                } else if ($nationality == 'Vietnam' || $nationality == 'vietnam' || $nationality == 'VIETNAM') {
                    $nationality = 'VIETNAMESE';
                } else if ($nationality == 'PHILIPPINES'){
                    $nationality = 'PHILIPPINE';
                } else if ($nationality == 'AFGHANISTAN') {
                    $nationality = 'AFGHAN';
                } else if ($nationality == 'ALBANIA') {
                    $nationality = 'ALBANIAN';
                } else if ($nationality == 'ALGERIA') {
                    $nationality = 'ALGERIAN';
                } else if ($nationality == 'ARGENTINA') {
                    $nationality = 'ARGENTINIAN';
                } else if ($nationality == 'AUSTRALIA') {
                    $nationality = 'AUSTRALIAN';
                } else if ($nationality == 'AUSTRIA') {
                    $nationality = 'AUSTRIAN';
                } else if ($nationality == 'BANGLADESH') {
                    $nationality = 'BANGLADESHI';
                } else if ($nationality == 'BELGIUM') {
                    $nationality = 'BELGIAN';
                } else if ($nationality == 'BOLIVIA') {
                    $nationality = 'BOLIVIAN';
                } else if ($nationality == 'BOTSWANA') {
                    $nationality = 'BATSWANA';
                } else if ($nationality == 'BRAZIL') {
                    $nationality = 'BRAZILIAN';
                } else if ($nationality == 'UNITED KINGDOM') {
                    $nationality = 'BRITISH';
                } else if ($nationality == 'BULGARIA') {
                    $nationality = 'BULGARIAN';
                } else if ($nationality == 'CAMBODIA') {
                    $nationality = 'CAMBODIAN';
                } else if ($nationality == 'CAMEROON') {
                    $nationality = 'CAMEROONIAN';
                } else if ($nationality == 'CANADA') {
                    $nationality = 'CANADIAN';
                } else if ($nationality == 'CHILE') {
                    $nationality = 'CHILEAN';
                } else if ($nationality == 'CHINA') {
                    $nationality = 'CHINESE';
                } else if ($nationality == 'COLOMBIA') {
                    $nationality = 'COLOMBIAN';
                } else if ($nationality == 'COSTA RICA') {
                    $nationality = 'COSTA RICAN';
                } else if ($nationality == 'CROATIA') {
                    $nationality = 'CROATIAN';
                } else if ($nationality == 'CUBA') {
                    $nationality = 'CUBAN';
                } else if ($nationality == 'CZECH REPUBLIC') {
                    $nationality = 'CZECH';
                } else if ($nationality == 'DENMARK') {
                    $nationality = 'DANISH';
                } else if ($nationality == 'DOMINICAN REPUBLIC') {
                    $nationality = 'DOMINICAN';
                } else if ($nationality == 'ECUADOR') {
                    $nationality = 'ECUADORIAN';
                } else if ($nationality == 'EGYPT') {
                    $nationality = 'EGYPTIAN';
                } else if ($nationality == 'SALVADORIAN') {
                    $nationality = 'EL SAVADOR';
                } else if ($nationality == 'ENGLAND') {
                    $nationality = 'ENGLISH';
                } else if ($nationality == 'ESTONIAN') {
                    $nationality = 'ESTONIA';
                } else if ($nationality == 'ETHIOPIA') {
                    $nationality = 'ETHIOPIAN';
                } else if ($nationality == 'FIJI') {
                    $nationality = 'FIJIAN';
                } else if ($nationality == 'FINLAND') {
                    $nationality = 'FINNISH';
                } else if ($nationality == 'FRANCE') {
                    $nationality = 'FRENCH';
                } else if ($nationality == 'GERMANY') {
                    $nationality = 'GERMAN';
                } else if ($nationality == 'GHANA') {
                    $nationality = 'GHANAIAN';
                } else if ($nationality == 'GREECE') {
                    $nationality = 'GREEK';
                } else if ($nationality == 'GUATEMALA') {
                    $nationality = 'GUATEMALAN';
                } else if ($nationality == 'HAITI') {
                    $nationality = 'HAITIAN';
                } else if ($nationality == 'HONDURAS') {
                    $nationality = 'HONDURAN';
                } else if ($nationality == 'HUNGARY') {
                    $nationality = 'HUNGARIAN';
                } else if ($nationality == 'ICELAND') {
                    $nationality = 'ICELANDIC';
                } else if ($nationality == 'INDIA') {
                    $nationality = 'INDIAN';
                } else if ($nationality == 'IRAN') {
                    $nationality = 'IRANIAN';
                } else if ($nationality == 'IRAQ') {
                    $nationality = 'IRAQI';
                } else if ($nationality == 'IRELAND') {
                    $nationality = 'IRISH';
                } else if ($nationality == 'ITALY') {
                    $nationality = 'ITALIAN';
                } else if ($nationality == 'JAMAICA') {
                    $nationality = 'JAMAICAN';
                } else if ($nationality == 'JAPAN') {
                    $nationality = 'JAPANESE';
                } else if ($nationality == 'JORDAN') {
                    $nationality = 'JORDANIAN';
                } else if ($nationality == 'KENYA') {
                    $nationality = 'KENYAN';
                } else if ($nationality == 'KUWAIT') {
                    $nationality = 'KUWAITI';
                } else if ($nationality == 'LAOS') {
                    $nationality = 'LAO';
                } else if ($nationality == 'LATVIA') {
                    $nationality = 'LATVIAN';
                } else if ($nationality == 'LEBANON') {
                    $nationality = 'LEBANESE';
                } else if ($nationality == 'LIBYA') {
                    $nationality = 'LIBYAN';
                } else if ($nationality == 'LITHUANIA') {
                    $nationality = 'LITHUANIAN';
                } else if ($nationality == 'MADAGASCAR') {
                    $nationality = 'MALAGASY';
                } else if ($nationality == 'MALIMALIAN') {
                    $nationality = 'MALIAN';
                } else if ($nationality == 'MALTA') {
                    $nationality = 'MALTESE';
                } else if ($nationality == 'MEXICO') {
                    $nationality = 'MEXICAN';
                } else if ($nationality == 'MONGOLIA') {
                    $nationality = 'MONGOLIAN';
                } else if ($nationality == 'MOROCCO') {
                    $nationality = 'MOROCCAN';
                } else if ($nationality == 'MOZAMBIQUE') {
                    $nationality = 'MOZAMBICAN';
                }else if ($nationality == 'MYANMAR') {
                    $nationality = 'BURMESE';
                }

                if (!empty($field->deduct_points)) {
                    $deduct_points = $field->deduct_points;
                }


                $array_data_body = array(
                                            $field->contact_no,
                                            strtoupper($field->name),
                                            strtoupper($nationality),
                                            $current_points,
                                            $deduct_points,
                                    );

                $col = 1;

                    foreach ( $array_data_body as $value )
                    {
                        $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
                        $col++;
                    }
                    $spreadsheet->getActiveSheet()->getStyle('A'.$row.':'.$highest_column.$row)->getAlignment()->setHorizontal('center');

                    $row++;
              }

        $filepath = 'export_files/';
        //save our workbook as this file name
        $filename = str_replace(' ', '', $export_title).'_'.date('YmdHis').'.xlsx';
        
        //#PHPSpreadsheet Step 3: Create Output Xlsx
        $objWriter = IOFactory::createWriter($spreadsheet, 'Xlsx');

        //force user to download the Excel file without writing it to server's HD
        // $objWriter->save('php://output');
        $objWriter->save($filepath.$filename);

        if ( file_exists($filepath.$filename) )
        {
            $filesave = 1;
        }
        else
        {
            $filesave = 0;
        }

        $result = array(
                        'filesave' => $filesave,
                        'filename' => $filename,
                        );

        echo json_encode($result);
      //End Function export
    }

}
