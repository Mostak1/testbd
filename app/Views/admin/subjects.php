<?= $this->extend('admin/admincom') ?>

<?= $this->section('content') ?>
<h1 class="mt-4">Subjects Management</h1>
<?= WRITEPATH ?>
<hr>
<div class="d-flex justify-content-end">
    <span>

        <span class="btn btn-outline-warning" id="showFormBtn"><i class="bi bi-plus-square"></i>Add</span>
    </span>
</div>
<!-- Form For Edit and Add -->
<div class="form-container">
    <?= csrf_field() ?>
    <form action="/upload" method="post" enctype="multipart/form-data">
        <input type="hidden" id="id" value="">
        <div class="form-group">
            <label class="form-label">Subject</label>
            <input class="form-control" type="text" name="subject" id="subject">
        </div>
        <div class="form-group">
            <label class="form-label">Class</label>
            <input class="form-control" type="text" name="class" id="class">
        </div>
        <div class="form-group row">
            <div class="col">

                <label class="form-label">Image Name</label>
                <input class="form-control" type="text" name="img_name" id="img_name">
            </div>
            <div class="col">
                <label class="form-label">Image</label>
                <input class="form-control" type="file" name="image" id="image">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Quantity</label>
            <input class="form-control" type="number" name="q" id="q">
        </div>
        <div class="form-group">
            <label class="form-label">Price</label>
            <input class="form-control" type="number" name="p" id="p">
        </div>
        <div class="form-group">
            <label class="form-label">Discount</label>
            <input class="form-control" type="number" name="d" id="d">
        </div>

        <div class="form-group my-2">
            <input type="button" class="btn btn-outline-primary" value="ADD" id="addBtn">
            <input type="button" class="btn btn-outline-danger" value="Clear" id="clearBtn">
        </div>
    </form>
    <br>

</div>
<!-- Form For Add and Edit End-->

<table id="myTable" class="table table-striped table-hover table-sm">
    <thead>
        <tr>
            <th>ID</th>
            <th>Subject</th>
            <th>Class</th>
            <th class="d-none">Image</th>
            <th>Image</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Discount</th>
            <th>Create Time</th>
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
            $("#subject").val("");
            $("#class").val("");
            $("#image").val("");
            $("#q").val("");
            $("#p").val("");
            $("#d").val("");

            $("#id").val("");
            $(".form-container").hide(1500);
        }
        //clearform end
        //clearBtn
        $("#clearBtn").click(function() {
            clearform();
        })
        //clearBtn end

        // add and update

        $("#addBtn").click(function() {
            // alert("Please enter")
            var formData = new FormData();

            formData.append('id', $("#id").val());
            formData.append('subject', $("#subject").val());
            formData.append('class', $("#class").val());
            formData.append('q', $("#q").val());
            formData.append('p', $("#p").val());
            formData.append('d', $("#d").val());
            formData.append('action', 'insert');

            if ($('#image')[0].files[0]) {
                var newImage = $('#image')[0].files[0];
                formData.append('image', newImage);
                formData.append('i', $("#img_name").val());
            }

            $.ajax({
                url: "<?= site_url("admin/subject/new") ?>",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(d) {
                    if (d.success) {
                        Swal.fire(
                            'Good job!',
                            d.message,
                            'success'
                        ).then(() => {
                            loaddata();
                        });
                    }
                }
            });
        });
        // add and update end

        function showdata(d) {
            // console.log(d);
            $html = ``;
            $.each(d, function(index, row) {
                // console.log(row);
                $html += `<tr class='singlerow'>`;
                $html += `<td >${row.id}</td>`;
                $html += `<td class='sub'>${row.subject}</td>`;
                $html += `<td class='cls'>${row.class}</td>`;
                $html += `<td class='img d-none'>${row.images}</td>`;
                $html += `<td class=''><img width="50px" src="<?= base_url() ?>/assets/HSC/${row.images}" alt="${row.images}"></td>`;
                $html += `<td class='q'>${row.quantity}</td>`;
                $html += `<td class='p'>${row.price}</td>`;
                $html += `<td class='d'>${row.discount}</td>`;
                $html += `<td>${row.created_at}</td>`;

                $html += `<td><a href='javascript:void(0)' class='editBtn btn btn-outline-primary me-2' data-id='${row.id}'><i class="bi bi-pencil-square"></i></a><a href='javascript:void(0)' class='deleteBtn btn btn-outline-danger' data-id='${row.id}'><i class="bi bi-trash-fill"></i></a></td>`;
                $html += `</tr>`;
            });
            $("#maindata").html($html);


        }

        function loaddata() {
            $.getJSON("<?= base_url(); ?>admin/subject/all", function(data) {
                showdata(data);
            });
            clearform()
        }
        loaddata();


        //editBtn
        $("#maindata").on("click", ".editBtn", function() {
            $t = $(this);
            $id = $t.data("id");
            let subject = $t.parent().parent().find('.sub').html();
            let cls = $t.parent().parent().find('.cls').html();
            let img = $t.parent().parent().find('.img').html();
            let q = $t.parent().parent().find('.q').html();
            let p = $t.parent().parent().find('.p').html();
            let d = $t.parent().parent().find('.d').html();
            $("#subject").val(subject);
            $("#class").val(cls);
            $("#img_name").val(img);
            $("#q").val(q);
            $("#p").val(p);
            $("#d").val(d);
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
                    $.post("<?= site_url("admin/subject/delete") ?>", {
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