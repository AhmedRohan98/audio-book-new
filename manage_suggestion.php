<?php
$page_title = "Books Suggestion";
include("includes/header.php");

$sql_query = "SELECT suggest.*, user.`name` FROM tbl_song_suggest suggest 
          LEFT JOIN tbl_users user
          ON suggest.`user_id`=user.`id` ORDER BY suggest.`id` DESC";

$result = mysqli_query($mysqli, $sql_query) or die(mysqli_error($mysqli));
?>
<style>
    .datatable-table>thead>tr>th {
        vertical-align: super;
        text-align: center;
        border-bottom: 1px solid #d9d9d9;
    }

    td {
        vertical-align: middle;
        height: 70px !important;
    }
</style>
<main id="main" class="main">

    <div class="row">
        <div class="col-lg-3">
            <div class="pagetitle">
                <h1><?php _e($page_title); ?></h1>
            </div>
        </div>
    </div><br>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Book Title</th>
                                        <th>Image</th>
                                        <th>Message</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <tr class="td <?= $row['id'] ?>">
                                            <td>
                                                <?php _e($i++); ?>
                                            </td>
                                            <td>
                                                <?php _e($row['name']); ?>
                                            </td>
                                            <td>
                                                <?php _e($row['song_title']); ?>
                                            </td>
                                            <td>
                                                <?php
                                                if (file_exists('images/' . $row['song_image'])) {
                                                ?>
                                                    <span class="mytooltip tooltip-effect-3">
                                                        <span class="tooltip-item">
                                                            <img src="images/<?php _e($row['song_image']); ?>" alt="no image" style="width: 100px;height: auto;max-height: 100px;border-radius: 5px">
                                                        </span>
                                                    </span>
                                                <?php } else {
                                                ?>
                                                    <img src="" alt="no image" style="width: 100px;height: auto;border-radius: 5px">
                                                <?php
                                                } ?>
                                            </td>
                                            <td>
                                                <?php _e($row['message']); ?>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" data-id="<?php _e($row['id']); ?>" class="btn_delete_a btn btn-danger btn_delete" data-toggle="tooltip" data-tooltip="Delete"><i class="bi bi-trash-fill"></i></a>
                                            </td>
                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
        $(".btn_delete_a").click(function(e) {

            e.preventDefault();

            var _ids = $(this).data("id");
            var _table = 'tbl_song_suggest';

            swal({
                    title: "Are you sure to delete this?",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonClass: "btn-warning",
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: false,
                    showLoaderOnConfirm: true
                },
                function(isConfirm) {
                    if (isConfirm) {

                        $.ajax({
                            type: 'post',
                            url: 'processData.php',
                            dataType: 'json',
                            data: {
                                id: _ids,
                                'action': 'multi_delete',
                                'tbl_nm': _table
                            },
                            success: function(res) {
                                console.log(res);
                                if (res.status == '1') {
                                    swal({
                                        title: "Successfully",
                                        text: "Suggestion is deleted.",
                                        type: "success"
                                    }, function() {
                                        location.reload();
                                    });
                                } else if (res.status == '-2') {
                                    swal(res.message);
                                }
                            }
                        });
                    } else {
                        swal.close();
                    }
                });
        });
    </script>
</main>
<?php include("includes/footer.php"); ?>