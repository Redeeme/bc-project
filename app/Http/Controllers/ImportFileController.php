<?php

namespace App\Http\Controllers;
use App\Models\TableName;
use App\Models\Task;
use Carbon\Carbon;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportFileController extends Controller
{
    public function index()
    {
        $tableNames = TableName::all();
        return view('import',[
            'tableNames' => $tableNames,
        ]);
    }
    public function importData(Request $request)
    {
        $the_file = $request->file('uploaded_file');
        if ($request->table_name == 'tasks'){
            try{
                $spreadsheet = IOFactory::load($the_file->getRealPath());
                $sheet        = $spreadsheet->getActiveSheet();
                $row_limit    = $sheet->getHighestDataRow();
                $column_limit = $sheet->getHighestDataColumn();
                $row_range    = range( 3, $row_limit );
                $column_range = range( 'F', $column_limit );
                $startcount = 2;
                $data = array();
                $task_id = Task::max('task_id');;

                $hours_start = 0;
                $minute_start = 0;
                $hours_end = 0;
                $minute_end = 0;
                foreach ( $row_range as $row ) {
                    $task_id++;
                    $hours_start = (int)($sheet->getCell( 'G' . $row )->getValue() / 60);
                    $minute_start = $sheet->getCell( 'G' . $row )->getValue() % 60;
                    $hours_end = (int)($sheet->getCell( 'H' . $row )->getValue() / 60);
                    $minute_end = $sheet->getCell( 'H' . $row )->getValue() % 60;
                    $time_start = Carbon::createFromTime(round($hours_start), $minute_start);
                    $time_end = Carbon::createFromTime(round($hours_end), $minute_end);
                    $data[] = [
                        'task_id' => $task_id,
                        'processid' =>$sheet->getCell( 'B' . $row )->getValue(),
                        'start' => $time_start,
                        'end' => $time_end,
                        'loc_start' => $sheet->getCell( 'E' . $row )->getValue(),
                        'loc_end' => $sheet->getCell( 'F' . $row )->getValue(),
                        'distance' => $sheet->getCell( 'J' . $row )->getValue(),
                        'consumption' => $sheet->getCell( 'K' . $row )->getValue(),
                        'linka' => $sheet->getCell( 'D' . $row )->getValue(),
                        'dataset' => 2,
                    ];
                    $startcount++;

                }
                return response()->json(array('$data' => $data));
                //DB::table('tbl_customer')->insert($data);
            } catch (Exception $e) {
                $error_code = $e->errorInfo[1];
                return back()->withErrors('There was a problem uploading the data!');
            }
            return back()->withSuccess('Great! Data has been successfully uploaded.');
        }elseif ($request->table_name == 'schedules'){
            try{
                $spreadsheet = IOFactory::load($the_file->getRealPath());
                $sheet        = $spreadsheet->getActiveSheet();
                $row_limit    = $sheet->getHighestDataRow();
                $column_limit = $sheet->getHighestDataColumn();
                $row_range    = range( 2, $row_limit );
                $column_range = range( 'F', $column_limit );
                $startcount = 2;
                $data = array();
                foreach ( $row_range as $row ) {
                    $data[] = [
                        'CustomerName' =>$sheet->getCell( 'A' . $row )->getValue(),
                        'Gender' => $sheet->getCell( 'B' . $row )->getValue(),
                        'Address' => $sheet->getCell( 'C' . $row )->getValue(),
                        'City' => $sheet->getCell( 'D' . $row )->getValue(),
                        'PostalCode' => $sheet->getCell( 'E' . $row )->getValue(),
                        'Country' =>$sheet->getCell( 'F' . $row )->getValue(),
                    ];
                    $startcount++;
                }
                DB::table('tbl_customer')->insert($data);
            } catch (Exception $e) {
                $error_code = $e->errorInfo[1];
                return back()->withErrors('There was a problem uploading the data!');
            }
            return back()->withSuccess('Great! Data has been successfully uploaded.');
        }elseif ($request->table_name == 'charger_tasks'){
            try{
                $spreadsheet = IOFactory::load($the_file->getRealPath());
                $sheet        = $spreadsheet->getActiveSheet();
                $row_limit    = $sheet->getHighestDataRow();
                $column_limit = $sheet->getHighestDataColumn();
                $row_range    = range( 2, $row_limit );
                $column_range = range( 'F', $column_limit );
                $startcount = 2;
                $data = array();
                foreach ( $row_range as $row ) {
                    $data[] = [
                        'CustomerName' =>$sheet->getCell( 'A' . $row )->getValue(),
                        'Gender' => $sheet->getCell( 'B' . $row )->getValue(),
                        'Address' => $sheet->getCell( 'C' . $row )->getValue(),
                        'City' => $sheet->getCell( 'D' . $row )->getValue(),
                        'PostalCode' => $sheet->getCell( 'E' . $row )->getValue(),
                        'Country' =>$sheet->getCell( 'F' . $row )->getValue(),
                    ];
                    $startcount++;
                }
                DB::table('tbl_customer')->insert($data);
            } catch (Exception $e) {
                $error_code = $e->errorInfo[1];
                return back()->withErrors('There was a problem uploading the data!');
            }
            return back()->withSuccess('Great! Data has been successfully uploaded.');
        }else{
            return back()->withErrors('There was a problem uploading the data!');
        }
    }
}
