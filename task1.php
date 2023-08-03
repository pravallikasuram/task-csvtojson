
<?php

$csv_file_path = "file.csv";

$connection = mysqli_connect('localhost', 'root', '', 'testing');

if ($connection->connect_error) {

    die("Database connection failed: " . $connection->connect_error);

}

// Open the CSV file for reading

if (($handle = fopen($csv_file_path, "r")) !== false) {

    fgetcsv($handle);

    while (($data = fgetcsv($handle)) !== false) {

        $origin_dfc = $data[0];

        $dest_mdo = $data[1];

        $scac = $data[2];

        $trailer_nbr = $data[3];

        $bol_nbr = $data[4];

        $ship_date = $data[5];

        $est_arrival_date = $data[6];

        $customer_order_nbr = $data[7];

        $work_order_nbr = $data[8];

        $delivery_date = $data[9];

        $sku = $data[10];

        $order_line_nbr = $data[11];

        $ship_qty = $data[12];

        $lpn = $data[13];

        $master_plabel = $data[14];


        // Escape the data to prevent SQL injection

        $origin_dfc = mysqli_real_escape_string($connection, $origin_dfc);  

        $dest_mdo = mysqli_real_escape_string($connection, $dest_mdo);

        $scac = mysqli_real_escape_string($connection, $scac);

        $trailer_nbr = mysqli_real_escape_string($connection, $trailer_nbr);

        $bol_nbr = mysqli_real_escape_string($connection, $bol_nbr);

        $ship_date = mysqli_real_escape_string($connection, $ship_date);  

        $est_arrival_date = mysqli_real_escape_string($connection, $est_arrival_date);

        $customer_order_nbr = mysqli_real_escape_string($connection, $customer_order_nbr);

        $work_order_nbr = mysqli_real_escape_string($connection, $work_order_nbr);

        $delivery_date = mysqli_real_escape_string($connection, $delivery_date);

        $sku = mysqli_real_escape_string($connection, $sku);

        $order_line_nbr = mysqli_real_escape_string($connection, $order_line_nbr);

        $ship_qty = mysqli_real_escape_string($connection, $ship_qty);

        $lpn = mysqli_real_escape_string($connection, $lpn);

        $master_plabel = mysqli_real_escape_string($connection, $master_plabel);


        // Check if the data exists in the database before inserting

        $check_query = "SELECT COUNT(*) as count FROM data WHERE lpn = '$lpn'";

        $check_result = mysqli_query($connection, $check_query);

        $row_count = mysqli_fetch_assoc($check_result)['count'];

        if ($row_count === "0") {

            // Insert the data into the database

            $sql = "INSERT INTO data (origin_dfc, dest_mdo, scac, trailer_nbr, bol_nbr, ship_date, est_arrival_date, customer_order_nbr, work_order_nbr, delivery_date, sku, order_line_nbr, ship_qty, lpn, master_plabel)

             VALUES ('$origin_dfc', '$dest_mdo', '$scac', '$trailer_nbr', '$bol_nbr', '$ship_date', '$est_arrival_date', '$customer_order_nbr', '$work_order_nbr', '$delivery_date', '$sku', '$order_line_nbr', '$ship_qty', '$lpn', '$master_plabel')";

            $result = mysqli_query($connection, $sql);

            if (!$result) {

                die("Error inserting data: " . mysqli_error($connection));

            }

        }

    }

    fclose($handle);

    // Read the data from the database

    $result = $connection->query("SELECT * FROM data");

    if($result == TRUE) {

        echo "Record created successfully";

        echo "<br>";

    }else{

        echo "Error: " . $sql . "<br>" .$conn->error;

    }

    // Fetch the data as an array

    $row = array();

    $csv_data = [];

    while ($row = $result->fetch_assoc()) {

        $csv_data[] = $row;

    }

    // Close the database connection

    $connection->close();

    // Convert the data to JSON format

    $json_data = json_encode($csv_data, JSON_PRETTY_PRINT);

    // Write the JSON data to an output file

    $output_file_path = 'output1.json';

    file_put_contents($output_file_path, $json_data);

    echo "Data converted and written to $output_file_path successfully.\n";

} else {

    echo "Error opening CSV file.\n";

}

?>