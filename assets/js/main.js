/* -------------------- Bootstrap Custom File Input Label ------------------- */

$(".custom-file-input").on("change", function() {
    let fileName = $(this).val().split("\\").pop();
    let label = $(this).siblings(".custom-file-label");

    if (label.data("default-title") === undefined) {
        label.data("default-title", label.html());
    }

    if (fileName === "") {
        label.removeClass("selected").html(label.data("default-title"));
    } else {
        label.addClass("selected").html(fileName);
    }
});

/* ---------------------------- Add Records Modal --------------------------- */

$("#addRecords").on("hide.bs.modal", function(e) {
    // do something...
    $("#addRecordForm")[0].reset();
    $(".custom-file-label").html("Choose file");
});

/* ---------------------------- Edit Record Modal --------------------------- */

$("#editRecords").on("hide.bs.modal", function(e) {
    // do something...
    $("#editForm")[0].reset();
    $(".custom-file-label").html("Choose file");
});

/* --------------------------------- Baseurl -------------------------------- */
var base_url = $("#base_url").val();

/* -------------------------------------------------------------------------- */
/*                               Insert Records                               */
/* -------------------------------------------------------------------------- */

$(document).on("click", "#add", function(e) {
    e.preventDefault();

    var name = $("#name").val();
    var email = $("#email").val();
    var mob = $("#mob").val();
    var img = $("#img")[0].files[0];

    if (name == "" || email == "" || mob == "" || img.name == "") {
        alert("All field are required");
    } else {
        var fd = new FormData();

        fd.append("name", name);
        fd.append("email", email);
        fd.append("mob", mob);
        fd.append("img", img);

        $.ajax({
            type: "post",
            url: base_url + "/insert",
            data: fd,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {
                if (response.res == "success") {
                    toastr["success"](response.message);
                    $("#addRecords").modal("hide");
                    $("#addRecordForm")[0].reset();
                    $(".add-file-label").html("Choose file");
                    $("#recordTable").DataTable().destroy();
                    fetch();
                } else {
                    toastr["error"](response.message);
                }
            },
        });
    }
});

/* -------------------------------------------------------------------------- */
/*                                Fetch Records                               */
/* -------------------------------------------------------------------------- */

function fetch() {
    $.ajax({
        type: "get",
        url: base_url + "fetch",
        dataType: "json",
        success: function(response) {
            var i = "1";
            $("#recordTable").DataTable({
                data: response,
                responsive: true,
                dom: "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: ["copy", "excel", "pdf", "csv", "print"],
                columns: [{
                        data: "id",
                        render: function(data, type, row, meta) {
                            return i++;
                        },
                    },
                    {
                        data: "name",
                    },
                    {
                        data: "email",
                    },
                    {
                        data: "mob",
                    },
                    {
                        data: "img",
                        render: function(data, type, row, meta) {
                            var a = `
                                <img src="${base_url}/assets/uploads/${row.img}" width="150" height="150" />
                            `;
                            return a;
                        },
                    },
                    {
                        orderable: false,
                        searchable: false,
                        data: function(row, type, set) {
                            return `
                                <a href="#" id="del" class="btn btn-sm btn-outline-danger" value="${row.id}"><i class="fas fa-trash-alt"></i></a>
                                <a href="#" id="edit" class="btn btn-sm btn-outline-info" value="${row.id}"><i class="fas fa-edit"></i></a>
                            `;
                        },
                    },
                ],
            });
        },
    });
}

fetch();

/* -------------------------------------------------------------------------- */
/*                               Delete Records                               */
/* -------------------------------------------------------------------------- */

$(document).on("click", "#del", function(e) {
    e.preventDefault();

    var del_id = $(this).attr("value");

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: base_url + "delete",
                data: {
                    del_id: del_id,
                },
                dataType: "json",
                success: function(response) {
                    if (response.res == "success") {
                        Swal.fire(
                            "Deleted!",
                            "Your file has been deleted.",
                            "success"
                        );
                        $("#recordTable").DataTable().destroy();
                        fetch();
                    }
                },
            });
        }
    });
});

/* -------------------------------------------------------------------------- */
/*                                Edit Records                                */
/* -------------------------------------------------------------------------- */

$(document).on("click", "#edit", function(e) {
    e.preventDefault();

    var edit_id = $(this).attr("value");

    $.ajax({
        url: base_url + "edit",
        type: "get",
        dataType: "JSON",
        data: {
            edit_id: edit_id,
        },
        success: function(data) {
            if (data.res === "success") {
                $("#editRecords").modal("show");
                $("#edit_record_id").val(data.post.id);
                $("#edit_name").val(data.post.name);
                $("#edit_email").val(data.post.email);
                $("#edit_mob").val(data.post.mob);
                $("#show_img").html(`
                    <img src="${base_url}assets/uploads/${data.post.img}" width="150" height="150" class="rounded img-thumbnail">
                `);
            } else {
                toastr["error"](data.message, "Error");
            }
        },
    });
});

/* -------------------------------------------------------------------------- */
/*                               Update Records                               */
/* -------------------------------------------------------------------------- */

$(document).on("click", "#update", function(e) {
    e.preventDefault();

    var edit_id = $("#edit_record_id").val();
    var name = $("#edit_name").val();
    var email = $("#edit_email").val();
    var mob = $("#edit_mob").val();
    var edit_img = $("#edit_img")[0].files[0];

    if (name == "" || email == "" || mob == "") {
        alert("All field are required");
    } else {
        var fd = new FormData();

        fd.append("edit_id", edit_id);
        fd.append("name", name);
        fd.append("email", email);
        fd.append("mob", mob);
        if ($("#edit_img")[0].files.length > 0) {
            fd.append("edit_img", edit_img);
        }

        $.ajax({
            type: "post",
            url: base_url + "update",
            data: fd,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {
                if (response.res == "success") {
                    toastr["success"](response.message);
                    $("#editRecords").modal("hide");
                    $("#editForm")[0].reset();
                    $(".edit-file-label").html("Choose file");
                    $("#recordTable").DataTable().destroy();
                    fetch();
                } else {
                    toastr["error"](response.message);
                }
            },
        });
    }
});