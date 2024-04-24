<?php
include ("connection.php");

$query = "SELECT * FROM cruud";
$query_run = mysqli_query($conn, $query);
$result_array = [];

if (mysqli_num_rows($query_run) > 0) {
    foreach ($query_run as $row) {
        array_push($result_array, $row);
    }
    header('Content-type: application/json');
    echo json_encode(["status" => 1, "data" => $result_array]);
} else {
    echo json_encode(["status" => 0, "data" => "No Record Found"]);
}

if (isset($_POST['checking_add'])) {
    $Name = $_POST['Name'];
    $Class = $_POST['Class'];
    $Roll_no = $_POST['Roll_no'];

    $query = "INSERT INTO `cruud`(`Name`, `Class`, `Roll_no`) VALUES ('$Name','$Class','$Roll_no')";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        echo json_encode(["status" => 1, "data" => "Successfully Stored"]);
        die();
    } else {
        echo json_encode(["status" => 0, "data" => "Something Went Wrong.!"]);
    }

}
if (isset($_POST['checking_delete'])) {
    $id = $_POST['id'];
    $queryy = "DELETE FROM `cruud` WHERE id='$id'";
    $query_run = mysqli_query($conn, $queryy);
    if ($query_run) {
        echo $return = "Successfully deleted";
    } else {
        echo $return = "Something Went Wrong.!";
    }
}
if (isset($_POST['checking_update'])) {
    $id = $_POST['id'];
    $Name = $_POST['Name'];
    $Class = $_POST['Class'];
    $Roll_no = $_POST['Roll_no'];
    $query = "UPDATE cruud SET  Name ='$Name', Class = '$Class',Roll_no = '$Roll_no' WHERE id='$id' ";
    $query_run = mysqli_query($conn, $query);
    if ($query_run) {
        return [
            "status" => true,
            "message" => "Successfully edited"
        ];
    } else {
        return [
            "status" => false,
            "message" => "Something Went Wrong !"
        ];
    }
}

?>