<?= $this->extend('admin/admincom') ?>

<?= $this->section('content') ?>
<h1 class="mt-4">Institutes Management</h1>

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
        <select class="form-select" name="did" id="did">
            <option value="-1">Select</option>
            <?php foreach ($dis as $row) { ?>
                <option value="<?= $row['id'] ?>"><?= $row['name']  ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label class="form-label">Thana</label>
        <select class="form-select" name="thana_id" id="thana_id">
            <option value="-1">Select</option>
        </select>
    </div>
    <div class="form-group">
        <label class="form-label">Institute</label>
        <input class="form-control" type="text" name="name" id="name">
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
            <th>District</th>
            <th class="d-none">d Id</th>
            <th class="d-none">Thana Id</th>
            <th>Thana</th>
            <th>Institute</th>
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
        //thana data change according to district id
        function renderDis(data) {
            data.forEach(row => {
                $("#thana_id").append("<option value='" + row.id + "'>" + row.name + "</option>")
            });
        }

        $("#did").change(function() {
            $("#thana_id").empty();
            let id = $(this).val();
            if (id == "-1") return;
            $.getJSON("<?= base_url("thana/") ?>" + id, {}, function(d) {
                console.log(d);
                if (d.length) {
                    renderDis(d);
                }
            });
        })
        //clearform
        function clearform() {
            $("#thana_id").val("");
            $("#name").val("");
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
            $.post("<?= site_url("admin/institutes/new") ?>", {
                id: $("#id").val(),
                thana_id: $("#thana_id").val(),
                name: $("#name").val(),
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
                $html += `<td >${row.d_name}</td>`;
                $html += `<td class='did d-none'>${row.district_id}</td>`;
                $html += `<td class='thana_id d-none'>${row.thana_id}</td>`;
                $html += `<td class=''>${row.t_name}</td>`;
                $html += `<td class='name'>${row.name}</td>`;
                $html += `<td class=''><a href="${row.url}" class="url link-info">${row.url}</a></td>`;


                $html += `<td><a href='javascript:void(0)' class='editBtn' data-id='${row.id}'><i class="bi bi-pencil-square"></i></a><a href='javascript:void(0)' class='deleteBtn' data-id='${row.id}'><i class="bi bi-trash-fill"></i></a></td>`;
                $html += `</tr>`;
            });
            $("#maindata").html($html);


        }

        function loaddata() {
            $.getJSON("<?= base_url(); ?>admin/institutes/all", function(data) {
                showdata(data);
            });
            clearform()
        }
        loaddata();


        //editBtn
        $("#maindata").on("click", ".editBtn", function() {
            $t = $(this);
            $id = $t.data("id");
            let did = $t.parent().parent().find('.did').html();
            let thana_id = $t.parent().parent().find('.thana_id').html();
            let name = $t.parent().parent().find('.name').html();
            let url = $t.parent().parent().find('.url').html();
            $("#thana_id").val(thana_id);
            $("#name").val(name);
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
                    $.post("<?= site_url("admin/institutes/delete") ?>", {
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