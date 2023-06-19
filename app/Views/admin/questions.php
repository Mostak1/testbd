<?= $this->extend('admin/admincom') ?>

<?= $this->section('content') ?>
<h1 class="mt-4">Users Management</h1>

<hr>
<div class="d-flex justify-content-end">
    <span>
        <i class="bi bi-plus-square" id="showFormBtn"></i>
    </span>
</div>
<div class="form-container">
    <?= csrf_field() ?>
    <div class="row">
        <div class="col-md-6">
            <input type="hidden" id="id" value="">
            <div class="form-group">
                <label class="form-label">Subject</label>
                <input class="form-control" type="text" name="sid" id="sid">
            </div>
            <div class="form-group">
                <label class="form-label">Board</label>
                <input class="form-control" type="text" name="bid" id="bid">
            </div>
            <div class="form-group">
                <label class="form-label">Zilla</label>
                <input class="form-control" type="text" name="zid" id="zid">
            </div>
            <div class="form-group">
                <label class="form-label">Thana</label>
                <input class="form-control" type="text" name="tid" id="tid">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Institute</label>
                <input class="form-control" type="text" name="iid" id="iid">
            </div>
            <div class="form-group">
                <label class="form-label">Year</label>
                <input class="form-control" type="number" min="1999" max="<?= date("Y")  ?>" step="1" value="<?= date("Y") ?>" name="year" id="year">
            </div>
            <div class="form-group">
                <label class="form-label">Questions Image</label>
                <input class="form-control" type="text" name="q" id="q">
            </div>
        </div>
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
            <th>Subject</th>
            <th>Board</th>
            <th>Zilla</th>
            <th>Thana</th>
            <th>Institute</th>
            <th>Year</th>
            <th>Image</th>
            <th>Created Time</th>
            <th>Actions</th>
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
            console.log("clearform");
            $("#sid").val("");
            $("#bid").val("");
            $("#zid").val("");
            $("#iid").val("");
            $("#year").val("<?= date("Y") ?>");
            $("#q").val("");

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
            $.post("<?= site_url("admin/questions/new") ?>", {
                id: $("#id").val(),
                sid: $("#sid").val(),
                bid: $("#bid").val(),
                zid: $("#zid").val(),
                tid: $("#tid").val(),
                iid: $("#iid").val(),
                year: $("#year").val(),
                q: $("#q").val(),
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
                $html += `<td class='sid'>${row.subject_id}</td>`;
                $html += `<td class='bid'>${row.board_id}</td>`;
                $html += `<td class='zid'>${row.zilla_id}</td>`;
                $html += `<td class='tid'>${row.thana_id}</td>`;
                $html += `<td class='iid'>${row.institute_id}</td>`;
                $html += `<td class='year'>${row.year}</td>`;
                $html += `<td class='q'>${row.q_image}</td>`;
                $html += `<td class=''>${row.created_at}</td>`;

                $html += `<td><a href='javascript:void(0)' class='editBtn' data-id='${row.id}'><i class="bi bi-pencil-square"></i></a><a href='javascript:void(0)' class='deleteBtn' data-id='${row.id}'><i class="bi bi-trash-fill"></i></a></td>`;
                $html += `</tr>`;
            });
            $("#maindata").html($html);


        }

        function loaddata() {
            $.getJSON("<?= base_url(); ?>admin/questions/all", function(data) {
                showdata(data);
            });
            clearform()
        }
        loaddata();


        //editBtn
        $("#maindata").on("click", ".editBtn", function() {
            $t = $(this);
            $id = $t.data("id");
            let sid = $t.parent().parent().find('.sid').html();
            let bid = $t.parent().parent().find('.bid').html();
            let zid = $t.parent().parent().find('.zid').html();
            let tid = $t.parent().parent().find('.tid').html();
            let iid = $t.parent().parent().find('.iid').html();
            let year = $t.parent().parent().find('.year').html();
            let q = $t.parent().parent().find('.q').html();
            $("#sid").val(sid);
            $("#bid").val(bid);
            $("#zid").val(zid);
            $("#tid").val(tid);
            $("#iid").val(iid);
            $("#year").val(year);
            $("#q").val(q);
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
                    $.post("<?= site_url("admin/questions/delete") ?>", {
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