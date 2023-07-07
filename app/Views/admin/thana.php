<?= $this->extend('admin/admincom') ?>

<?= $this->section('content') ?>
<h1 class="mt-4">Thana Management</h1>

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
        <label class="form-label">District</label>
        <select class="form-select" name="district_id" id="district_id">
            <?php foreach ($dst as $row) { ?>
                <option value="<?= $row['id'] ?>"><?= $row['name']  ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label class="form-label">Thana</label>
        <input class="form-control" type="text" name="name" id="name">
    </div>
    <div class="form-group">
        <label class="form-label">Thana(Bangla)</label>
        <input class="form-control" type="text" name="bn_name" id="bn_name">
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
<table id="myTable" class="table table-striped table-hover table-sm display">
    <thead>
        <tr>
            <th>ID</th>
            <th class="d-none">District id</th>
            <th>District</th>
            <th>Thana</th>
            <th>Thana(bangla)</th>
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
        $('#myTable').DataTable();
        $(".form-container").hide();
        $("#showFormBtn").click(function() {
            $(".form-container").toggle(300);
        });

        //clearform
        function clearform() {
            $("#district_id").val("");
            $("#name").val("");
            $("#bn_name").val("");
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
            $.post("<?= site_url("admin/thana/new") ?>", {
                id: $("#id").val(),
                district_id: $("#district_id").val(),
                name: $("#name").val(),
                bn_name: $("#bn_name").val(),
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
                $html += `<td class='district_id d-none'>${row.district_id}</td>`;
                $html += `<td class=''>${row.d_name}</td>`;
                $html += `<td class='name'>${row.name}</td>`;
                $html += `<td class='bn_name'>${row.bn_name}</td>`;
                $html += `<td class=''><a href="${row.url}" class="url link-info">${row.url}</a></td>`;


                $html += `<td><a href='javascript:void(0)' class='editBtn' data-id='${row.id}'><i class="bi bi-pencil-square"></i></a><a href='javascript:void(0)' class='deleteBtn' data-id='${row.id}'><i class="bi bi-trash-fill"></i></a></td>`;
                $html += `</tr>`;
            });
            $("#maindata").html($html);


        }

        function loaddata() {
            $.getJSON("<?= base_url(); ?>admin/thana/all", function(data) {
                showdata(data);
            });
            clearform()
        }
        loaddata();


        //editBtn
        $("#maindata").on("click", ".editBtn", function() {
            $t = $(this);
            $id = $t.data("id");
            let district_id = $t.parent().parent().find('.district_id').html();
            let name = $t.parent().parent().find('.name').html();
            let bn_name = $t.parent().parent().find('.bn_name').html();
            let url = $t.parent().parent().find('.url').html();
            $("#district_id").val(district_id);
            $("#name").val(name);
            $("#bn_name").val(bn_name);
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
                    $.post("<?= site_url("admin/thana/delete") ?>", {
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