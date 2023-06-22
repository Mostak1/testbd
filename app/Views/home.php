<?= $this->extend('components') ?>
<?= $this->section('content') ?>
<div class="container my-5">
    <div class="home_title">~Past Exam Papers~</div>
    <div class="exam_data"></div>

</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        // Show Exam Table data
        function showdata(d) {
            // console.log(d);
            $html = ``;

            $.each(d, function(index, row) {
                // console.log(row);

                $html += `<div class='exam_topic'> ${row.exam_name}</div>`;

            });

            $(".exam_data").html($html);



        }

        function loaddata() {
            $.getJSON("<?= base_url(); ?>admin/exams/all", function(data) {
                showdata(data);
            });
            clearform()
        }
        loaddata();

    })
</script>
<?= $this->endSection() ?>