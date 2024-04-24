<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <title>ToDo using jquery Ajax</title>
</head>

<body>

    <div class="modal fade" id="Student_AddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Submit Your Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="error-message">

                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="">Name</label>
                            <input type="text" class="form-control Name" id="edit-name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="">Class</label>
                            <input type="text" class="form-control Class" id="edit-class" required>
                        </div>
                        <div class="col-md-6">
                            <label for="">Roll no</label>
                            <input type="text" class="form-control Roll_no" id="edit-roll" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="submitajax">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            PHP - AJAX - CRUD Todo List .
                            <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                data-target="#Student_AddModal">
                                Add
                            </button>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="message-show">

                        </div>
                        <table class="table table-bordered table-striped table-dark">
                            <thead>
                                <tr>
                                    <th width="10%">ID</th>
                                    <th>Name</th>
                                    <th>Class</th>
                                    <th>Roll no</th>
                                    <th width="20%">Action</th>
                                </tr>

                            </thead>
                            <tbody class="studentdata">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#submitajax").on("click", function () {
                const functionToRun = $(this).html();
                if (functionToRun == "Save") {
                    adddtodo();
                } else {
                    const id = $(this).attr("data-id");
                    update(id);
                }
            });
            function adddtodo() {
                var Name = $('.Name').val();
                var stu_class = $('.Class').val();
                var Roll_no = $('.Roll_no').val();
                console.log("Name", Name);
                console.log("stu_class", stu_class);
                console.log("Roll_no", Roll_no);
                if (Name != '' & stu_class != '' & Roll_no != '') {
                    $.ajax({
                        type: "POST",
                        url: "action.php",
                        data: {
                            'checking_add': true,
                            'Name': Name,
                            'Class': stu_class,
                            'Roll_no': Roll_no,
                        },
                        success: function (response) {
                            location.reload(true);
                            console.log("response151", response);
                            if (response) {
                                getdata();
                            }
                        }
                    });
                    $('#Student_AddModal').modal('toggle');
                }
                else {
                    $('.error-message').append('\
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">\
                            <strong>Hey!</strong> Please enter all fileds.\
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                <span aria-hidden="true">&times;</span>\
                            </button>\
                        </div>\
                    ');
                }
            }

        });

        function getdata() {
            $.ajax({
                type: "GET",
                url: "action.php",
                success: function (response) {
                    console.log(response);
                    var rowId = 1;
                    console.log("response", response);
                    if (response.status) {
                        response.data.forEach(function (todo) {
                            var row = `<tr>
                            <td id="row-id-${todo.id}">${rowId++}</td>
                            <td id="row-name-${todo.id}">${todo.Name}</td>
                            <td id="row-class-${todo.id}">${todo.Class}</td>
                            <td id="row-roll_no-${todo.id}">${todo.Roll_no}</td>
                            <td>
                            <button class="btn btn-primary" onclick="editTodo(${todo.id})">Edit</button>
                            <button class="btn btn-danger" onclick="deletedata(${todo.id})" id="deleteButton">Delete</button>

                            </td>
                        </tr>`;
                            $(".studentdata").append(row);
                        });
                    }
                },
                error: function () {
                    alert("Failed to fetch todos.");
                },
            });
        }
        function deletedata(id) {
            $.ajax({
                type: "POST",
                url: "action.php",
                data: {
                    'checking_delete': true,
                    'id': id,
                },
                success: function (response) {
                    location.reload(true);
                },
            });
        }

        function update(id) {
            var row_id = id;
            var Name = $('#edit-name').val();
            var stu_class = $('#edit-class').val();
            var Roll_no = $('#edit-roll').val();
            $.ajax({
                type: "POST",
                url: "action.php",
                data: {
                    'checking_update': true,
                    'id': row_id,
                    'Name': Name,
                    'Class': stu_class,
                    'Roll_no': Roll_no,
                },
                success: function (data) {
                    location.reload(true);
                }
            });
        }

        function editTodo(id) {
            $('#Student_AddModal').modal('show');
            console.log("#row-name" + id);
            const Name = $("#row-name-" + id).html();
            const Class = $("#row-class-" + id).html();
            const Roll_no = $("#row-roll_no-" + id).html();
            $("#edit-name").val(Name);
            $("#edit-class").val(Class);
            $("#edit-roll").val(Roll_no);

            $("#submitajax").html("Update");
            $("#submitajax").attr("data-id", id);
        }
        $(document).ready(function () {
            getdata();

        });


    </script>

</body>

</html>