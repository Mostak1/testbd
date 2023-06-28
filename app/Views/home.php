<?= $this->extend('components') ?>
<?= $this->section('content') ?>
<div class="container my-5">
    <!-- carousel starts here -->
    <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="4000">
                <img src="<?= base_url() ?>assets/img/ca1.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item" data-bs-interval="2000">
                <img src="<?= base_url() ?>assets/img/ca2.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="<?= base_url() ?>assets/img/ca3.jpg" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- --------------------------
---------------End Carousel-------
-------------------------------- -->
    <div class="home_title">~Past Exam Papers~</div>
    <div class="exam_data "></div>
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
                $html += `<a href="" class='exam_topic text-center col-md-3'> ${row.exam_name}</a>`;
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