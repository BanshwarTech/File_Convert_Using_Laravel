<?php

namespace App\Http\Controllers;
use App\Exports\ClientsExport;
use App\Models\ClientData;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Carbon\Carbon;

class FilesController extends Controller
{
    public function index(Request $request)
    {
// UPDATE client_data 
// SET created_at = '2024-09-28 00:00:00' 
// WHERE id BETWEEN 1 AND 10;
        $date = $request->input('date');
    
        
        $today = Carbon::today()->startOfDay();
        $yesterday = Carbon::yesterday()->startOfDay();
        $twoDaysAgo = Carbon::today()->subDays(2)->startOfDay();
    
       
        if ($date == "today") {
            $clients = ClientData::whereDate('created_at', $today)->paginate(10);
        } elseif ($date == "yesterday") {
            $clients = ClientData::whereDate('created_at', $yesterday)->paginate(10);
        } elseif ($date == "two_days_ago") {
            $clients = ClientData::whereDate('created_at', $twoDaysAgo)->paginate(10);
        } else {
            $clients = ClientData::paginate(10); 
        }
    
        $data = [
            'title' => 'Client Information'
        ];
    
        return view('welcome', compact('data', 'clients'));
    }
    
    // generate pdf file 
    public function generatePDF(Request $request)
    {
        $clientData = ClientData::get();
        $data = [
            'title' => 'CLient Generate PDF',
            'date' => date('Y-m-d'),
            'clientData' => $clientData,
        ];
        $pdf = Pdf::loadView('generate-client-pdf', $data);
        return $pdf->download('clients.pdf');
    }
    // export csv
    public function exportCsv()
    {
        $clients = ClientData::all();

        // Define the CSV file headers
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=clients.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        // Add CSV column names
        $columns = ['#', 'Name', 'Email', 'Phone Number', 'Company Name', 'Address'];

        // Callback to create the CSV content
        $callback = function () use ($clients, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $index = 0;
            foreach ($clients as $client) {
                $index++;
                $row = [
                    $index,
                    $client->first_name . " " . $client->last_name,
                    $client->email,
                    $client->phone_number,
                    $client->company_name,
                    $client->address,
                ];
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
    public function exportDocx()
    {
        $clients = ClientData::all(); // Retrieve all client data from the database

        // Create a new PHPWord object
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Add title to the document
        $section->addText('Client Data', ['bold' => true, 'size' => 16]);

        // Add a table to the document
        $table = $section->addTable();

        // Add table header row
        $table->addRow();
        $table->addCell(2000)->addText('#');
        $table->addCell(2000)->addText('Name');
        $table->addCell(4000)->addText('Email');
        $table->addCell(2000)->addText('Phone Number');
        $table->addCell(4000)->addText('Company Name');
        $table->addCell(6000)->addText('Address');

        // Add table data rows
        $index = 0;
        foreach ($clients as $client) {
            $index++;
            $table->addRow();
            $table->addCell(2000)->addText($index);
            $table->addCell(2000)->addText($client->first_name . " " . $client->last_name);
            $table->addCell(4000)->addText($client->email);
            $table->addCell(2000)->addText($client->phone_number);
            $table->addCell(4000)->addText($client->company_name);
            $table->addCell(6000)->addText($client->address);
        }

        // Save the document to a temporary file
        $fileName = 'clients.docx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        // Write the Word document to the temporary file
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($temp_file);

        // Return the DOCX file as a download response
        return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
    }
    // export excel 
    public function exportExcel()
    {
        return Excel::download(new ClientsExport, 'clients.xlsx');
    }
    // export json file
    public function exportJson()
    {
        $clients = ClientData::all();

        return response()->json($clients)->header('Content-Disposition', 'attachment; filename=clients.json');
    }
    // export xml 
    public function exportXml()
    {
        $clients = ClientData::all();

        $xml = new \SimpleXMLElement('<clients/>');

        foreach ($clients as $client) {
            $clientNode = $xml->addChild('client');
            $clientNode->addChild('first_name', $client->first_name . " " . $client->last_name);
            $clientNode->addChild('email', $client->email);
            $clientNode->addChild('phone_number', $client->phone_number);
            $clientNode->addChild('company_name', $client->company_name);
            $clientNode->addChild('address', $client->address);
        }

        $response = response($xml->asXML(), 200)->header('Content-Type', 'text/xml');
        return $response->header('Content-Disposition', 'attachment; filename=clients.xml');
    }

    // search functionality 
    public function search(Request $request)
    {
        $query = $request->input('query');
        if ($query) {
            $clients = ClientData::when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('first_name', 'like', "%{$query}%")
                    ->orWhere('last_name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->orWhere('phone_number', 'like', "%{$query}%")
                    ->orWhere('company_name', 'like', "%{$query}%");
            })->paginate(10);
        } else {
            $clients = collect();
        }

        $date = [
            'title' => 'Client Information'
        ];

        return view('welcome', compact('date', 'clients'));
    }

    // about-us client
    public function aboutUs()
    {
        return view('about-us');
    }
}
