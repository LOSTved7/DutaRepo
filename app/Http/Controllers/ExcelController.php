<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ZipArchive;
use DB;
class ExcelController extends Controller
{
    public function uploadExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);
        $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
        $request->file('file')->move(public_path('staff_upload_file'), $fileName);
        $filePath = public_path('staff_upload_file/' . $fileName);
        $zip = new \ZipArchive;
        if ($zip->open($filePath) === TRUE) {
            $sharedStrings = [];
            if (($index = $zip->locateName('xl/sharedStrings.xml')) !== false) {
                $xml = simplexml_load_string($zip->getFromIndex($index));
                foreach ($xml->si as $string) {
                    $sharedStrings[] = (string) $string->t;
                }
            }

            $i = 1;
            $final_data = [];

            while (($index = $zip->locateName("xl/worksheets/sheet{$i}.xml")) !== false) {
                $xml = simplexml_load_string($zip->getFromIndex($index));
                $rows = [];

                foreach ($xml->sheetData->row as $row) {
                    // Pre-fill 6 columns (A–F) with empty values
                    $rowData = array_fill(0, 6, '');

                    foreach ($row->c as $c) {
                        $cellRef = (string) $c['r']; // e.g. "C5"
                        preg_match('/([A-Z]+)/', $cellRef, $matches);
                        $colLetter = $matches[1];

                        // Map column letter → index
                        $colMap = ['A' => 0, 'B' => 1, 'C' => 2, 'D' => 3, 'E' => 4, 'F' => 5];

                        $value = (string) $c->v;
                        if (isset($c['t']) && $c['t'] == 's') {
                            $value = $sharedStrings[(int) $value];
                        }

                        if (isset($colMap[$colLetter])) {
                            $rowData[$colMap[$colLetter]] = $value;
                        }
                    }

                    $rows[] = $rowData;
                }

                foreach ($rows as $index => $cols) {
                    if ($index === 0)
                        continue; // skip header
                    if (empty($cols))
                        continue;

                    $final_data[] = [
                        'serial_no' => (!empty($cols[0]) && is_numeric($cols[0])) ? round((float) $cols[0], 2) : $cols[0],
                        'name' => !empty($cols[1]) ? $cols[1] : '',
                        'department' => !empty($cols[2]) ? $cols[2] : '',
                        'college' => !empty($cols[3]) ? $cols[3] : '',
                        'mobile' => !empty($cols[4]) ? $cols[4] : '',
                        'email' => !empty($cols[5]) ? $cols[5] : '',
                        'status' => 1,
                    ];
                }

                $i++;
            }

            DB::beginTransaction();
            DB::table('electrol_data')->insert($final_data);
            DB::commit();

            $zip->close();
            return back()->with('success', 'Excel file uploaded, saved & data imported successfully!');
        } else {
            return back()->with('error', 'Failed to open Excel file.');
        }
    }

}
