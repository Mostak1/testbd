<?= $this->extend('admin/admincom') ?>

<?= $this->section('content') ?>
<h1 class="mt-4">Questions Management</h1>

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
                <select class="form-select" name="sid" id="sid">
                    <option value="-1">Select</option>
                    <?php foreach ($subject as $row) { ?>
                        <option value="<?= $row['id'] ?>"><?= $row['subject']  ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Board</label>
                <select class="form-select" name="bid" id="bid">
                    <option value="-1">Select</option>
                    <?php foreach ($board as $row) { ?>
                        <option value="<?= $row['id'] ?>"><?= $row['name']  ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">District</label>
                <select class="form-select" name="zid" id="zid">
                    <option value="-1">Select</option>

                </select>
                <!-- <input class="form-control" type="text" name="zid" id="zid"> -->
            </div>
            <div class="form-group">
                <label class="form-label">Thana</label>
                <select class="form-select" name="tid" id="tid">
                    <option value="-1">Select</option>

                </select>
                <!-- <input class="form-control" type="text" name="tid" id="tid"> -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Institute</label>
                <select class="form-select" name="iid" id="iid">
                    <option value="-1">Select</option>

                </select>
                <!-- <input class="form-control" type="text" name="iid" id="iid"> -->
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
            <th class="d-none">Subject id</th>
            <th class="d-none">Board id</th>
            <th class="d-none">Zilla id</th>
            <th class="d-none">Thana id</th>
            <th class="d-none">Institute id</th>
            <th>Subject</th>
            <th>Board</th>
            <th>District</th>
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
        //districts data change according to board id
        function renderDis(data) {
            data.forEach(row => {
                $("#zid").append("<option value='" + row.id + "'>" + row.name + "</option>")
            });
        }

        $("#bid").change(function() {
            $("#zid").empty();
            let id = $(this).val();
            if (id == "-1") return;
            $.getJSON("<?= base_url("districts/") ?>" + id, {}, function(d) {
                console.log(d);
                if (d.length) {
                    renderDis(d);
                }
            });
        })
        //thana data change according to districts id
        function renderThana(data) {
            data.forEach(row => {
                $("#tid").append("<option value='" + row.id + "'>" + row.name + "</option>")
            });
        }
        $("#zid").on("change", function() {
            $("#tid").empty();
            let id = $(this).val();
            if (id == "-1") return;
            $.getJSON("<?= base_url("thana/") ?>" + id, {}, function(d) {
                console.log(d);
                if (d.length) {
                    renderThana(d);
                }
            });
        })
        //institutes data change according to thanas id
        function renderIns(data) {
            data.forEach(row => {
                $("#iid").append("<option value='" + row.id + "'>" + row.name + "</option>")
            });
        }
        $("#tid").on("change", function() {
            $("#iid").empty();
            let id = $(this).val();
            if (id == "-1") return;
            $.getJSON("<?= base_url("institutes/") ?>" + id, {}, function(d) {
                console.log(d);
                if (d.length) {
                    renderIns(d);
                }
            });
        })
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
                $html += `<td class='d-none sid'>${row.subject_id}</td>`;
                $html += `<td class='d-none bid'>${row.board_id}</td>`;
                $html += `<td class='d-none zid'>${row.zilla_id}</td>`;
                $html += `<td class='d-none tid'>${row.thana_id}</td>`;
                $html += `<td class='d-none iid'>${row.institute_id}</td>`;
                $html += `<td class=''>${row.sbn}</td>`;
                $html += `<td class=''>${row.boardnm}</td>`;
                $html += `<td class=''>${row.districtnm}</td>`;
                $html += `<td class=''>${row.thananm}</td>`;
                $html += `<td class=''>${row.instnm}</td>`;
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