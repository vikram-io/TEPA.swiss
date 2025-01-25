<?php
if (isset($_GET['query'])) {
    $query = trim($_GET['query']);
    $filePath = 'TEPA_IMPACT_ANALYSIS_All_HS_CODES.csv';

    if (!file_exists($filePath)) {
        echo json_encode(["error" => "Data file not found."]);
        exit;
    }

    $file = fopen($filePath, 'r');
    $headers = fgetcsv($file);
    $results = [];

    while (($row = fgetcsv($file)) !== false) {
        $rowData = array_combine($headers, $row);

        if (
            strpos(strtolower($rowData['hs_code']), strtolower($query)) !== false ||
            strpos(strtolower($rowData['description']), strtolower($query)) !== false
        ) {
            $results[] = $rowData;
        }
    }

    fclose($file);
    header('Content-Type: application/json');
    echo json_encode($results);
    exit;
}
?>