<?= $this->extend('admin/admincom') ?>

<?= $this->section('content') ?>
<h1 class="mt-4">District Management</h1>

<hr>
<div class="d-flex justify-content-end">
    <span>
        <i class="bi bi-plus-square" id="showFormBtn"></i>
    </span>
</div>
<div class="form-container">
    <?= csrf_field() ?>
    <input type="hidden" id="id" value="">
    <div class="form-group">
        <label class="form-label">Board</label>
        <input class="form-control" type="text" name="board" id="board">
    </div>
    <div class="form-group">
        <label class="form-label">District</label>
        <input class="form-control" type="text" name="name" id="name">
    </div>
    <div class="form-group">
        <label class="form-label">District(Bangla)</label>
        <input class="form-control" type="text" name="bn_name" id="bn_name">
    </div>
    <div class="form-group">
        <label class="form-label">Latitude</label>
        <input class="form-control" type="text" name="lat" id="lat">
    </div>
    <div class="form-group">
        <label class="form-label">Longitude</label>
        <input class="form-control" type="text" name="lon" id="lon">
    </div>
    <div class="form-group">
        <label class="form-label">Website</label>
        <input class="form-control" type="text" name="url" id="url">
    </div>

    <div class="form-group my-2">
        <input type="button" class="btn btn-outline-primary" value="ADD" id="addBtn">
        <input type="button" class="btn btn-outline-danger" value="Clear" id="clearBtn">
    </div>

    <br>

</div>
<table class="table table-striped table-hover table-sm">
    <thead>
        <tr>
            <th>ID</th>
            <th>Board id</th>
            <th>District</th>
            <th>District(bangla)</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Website</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="maindata">

    </tbody>

</table>
<img src="" height="200px" alt="">
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        $(".form-container").hide();
        $("#showFormBtn").click(function() {
            $(".form-container").toggle(300);
        });

        //clearform
        function clearform() {
            $("#board").val("");
            $("#name").val("");
            $("#bn_name").val("");
            $("#lat").val("");
            $("#lon").val("");
            $("#url").val("");

            $("#id").val("");
            $("#addBtn").val('Add');
            $(".form-container").hide(1500);
        }
        //clearform end
        //clearBtn
        $("#clearBtn").click(function() {
            clearform();
        })
        //clearBtn end

        // addBtn

        $("#addBtn").click(function() {
            $.post("<?= site_url("admin/districts/new") ?>", {
                id: $("#id").val(),
                board_id: $("#board").val(),
                name: $("#name").val(),
                bn_name: $("#bn_name").val(),
                lat: $("#lat").val(),
                lon: $("#lon").val(),
                url: $("#url").val(),
                'action': "insert"
            }, function(d) {
                if (d.success) {
                    Swal.fire(
                        'Good job!',
                        d.message,
                        'success'
                    ).then(() => {
                        loaddata();
                    })
                }

            })
        });
        // addBtn end
        function showdata(d) {
            // console.log(d);
            $html = ``;
            $.each(d, function(index, row) {
                // console.log(row);
                $html += `<tr class='singlerow'>`;
                $html += `<td >${row.id}</td>`;
                $html += `<td class='board_id'>${row.board_id}</td>`;
                $html += `<td class='name'>${row.name}</td>`;
                $html += `<td class='bn_name'>${row.bn_name}</td>`;
                $html += `<td class='lat'>${row.lat}</td>`;
                $html += `<td class='lon'>${row.lon}</td>`;
                $html += `<td class=''><a href="${row.url}" class="url link-info">${row.url}</a></td>`;


                $html += `<td><a href='javascript:void(0)' class='editBtn' data-id='${row.id}'><i class="bi bi-pencil-square"></i></a><a href='javascript:void(0)' class='deleteBtn' data-id='${row.id}'><i class="bi bi-trash-fill"></i></a></td>`;
                $html += `</tr>`;
            });
            $("#maindata").html($html);


        }

        function loaddata() {
            $.getJSON("<?= base_url(); ?>admin/districts/all", function(data) {
                showdata(data);
            });
            clearform()
        }
        loaddata();


        //editBtn
        $("#maindata").on("click", ".editBtn", function() {
            $t = $(this);
            $id = $t.data("id");
            let board_id = $t.parent().parent().find('.board_id').html();
            let name = $t.parent().parent().find('.name').html();
            let bn_name = $t.parent().parent().find('.bn_name').html();
            let lat = $t.parent().parent().find('.lat').html();
            let lon = $t.parent().parent().find('.lon').html();
            let url = $t.parent().parent().find('.url').html();
            $("#board").val(board_id);
            $("#name").val(name);
            $("#bn_name").val(bn_name);
            $("#lat").val(lat);
            $("#lon").val(lon);
            $("#url").val(url);
            $("#id").val($id);
            $("#addBtn").val('Update');
            $(".form-container").show(400);
        })
        // });
        //editBtn end
        //deleteBtn start
        $("#maindata").on("click", ".deleteBtn", function() {
            $t = $(this);
            $id = $t.data("id");
            // swal confirm
            Swal.fire({
                title: 'Do you want to delete the record??',
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: 'Delete',
                denyButtonText: `Don't delete`,
            }).then((result) => {
                console.log(result);
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    //           
                    // ajax            
                    $.post("<?= site_url("admin/districts/delete") ?>", {
                        'id': $id,
                        'action': "delete"
                    }, function(d) {
                        if (d.success) {
                            Swal.fire(
                                'Good job!',
                                d.message,
                                'success'
                            ).then(() => {
                                loaddata();
                            })
                        }
                    })
                    // ajax end
                    // 
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            })
            // swal end
        });
        //deleteBtn end
    });
</script>
<?= $this->endSection() ?>