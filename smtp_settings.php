<?php
$page_title = "SMTP Settings";
include("includes/header.php");

$qry = "SELECT * FROM tbl_smtp_settings where id='1'";
$result = mysqli_query($mysqli, $qry);
$row = mysqli_fetch_assoc($result);
$count = $result->num_rows;

if (isset($_POST['submit']) && PURCHASE == '') {
    if (
        empty(validate_input($_POST['smtp_type'])) ||
        empty(validate_input($_POST['smtp_host'])) ||
        empty(validate_input($_POST['smtp_email'])) ||
        empty(validate_input($_POST['smtp_secure'])) ||
        empty(validate_input($_POST['port_no']))
    ) {
        $_SESSION['msg'] = "15";
        $_SESSION['class'] = 'error';
        header("Location:smtp_settings.php");
        exit;
    }

    if ($_POST['smtp_type'] == "gmail") {
        if ($_POST['smtp_password']) {
            $password = $_POST['smtp_password'];
        } else {
            $password = $row['smtp_password'];
        }
    } else {
        if ($_POST['smtp_password']) {
            $password = $_POST['smtp_password'];
        } else {
            $password = $row['smtp_gpassword'];
        }
    }


    if ($_POST['smtp_type'] == "gmail") {
        $data = array(
            'smtp_type'  =>  validate_input($_POST['smtp_type']),
            'smtp_host'  =>  validate_input($_POST['smtp_host']),
            'smtp_email'  =>  validate_input($_POST['smtp_email']),
            'smtp_password'  =>  validate_input($password),
            'smtp_secure'  =>  validate_input($_POST['smtp_secure']),
            'port_no'  =>  validate_input($_POST['port_no'])
        );
    } else {
        $data = array(
            'smtp_type' => validate_input($_POST['smtp_type']),
            'smtp_ghost' => validate_input($_POST['smtp_host']),
            'smtp_gemail' => validate_input($_POST['smtp_email']),
            'smtp_gpassword' => validate_input($password),
            'smtp_gsecure' => validate_input($_POST['smtp_secure']),
            'gport_no' =>  validate_input($_POST['port_no'])
        );
    }

    $sql = "SELECT * FROM tbl_smtp_settings WHERE id='1'";
    $res = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

    if (mysqli_num_rows($res) > 0) {
        $update = Update('tbl_smtp_settings', $data, "WHERE id = '1'");
    } else {
        $insert = Insert('tbl_smtp_settings', $data);
    }

    $_SESSION['class'] = "success";
    $_SESSION['msg'] = "11";
    // die;
    header("Location:smtp_settings.php");
    exit;
}
?>
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
            <div class="col-lg-12" style="margin-bottom: 20px">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?php if ($row['smtp_type'] == "gmail") { _e('active'); } ?>" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" >Gmail SMTP</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?php if ($row['smtp_type'] == "server") { _e('active'); } ?>" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" >Server SMTP</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <br>
                                <form class="row g-3" action="" method="post" enctype="multipart/form-data">
                                    <br><br>
                                    <input type="hidden" name="smtp_type" value="gmail">
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">SMTP Host</label>
                                        <input type="text" class="form-control" name="smtp_host"  value="<?php if ($count > 0) {
                                                                                                                                _e($row['smtp_host']);
                                                                                                                            } ?>" placeholder="mail.example.in" class="form-control">
                                    </div>
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Email</label>
                                        <input type="text" class="form-control" name="smtp_email" value="<?php if ($count > 0) {
                                                                                                                _e($row['smtp_email']);
                                                                                                            } ?>" placeholder="info@example.com" class="form-control">
                                    </div>
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="smtp_password"  placeholder="********" class="form-control">
                                    </div>
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">SMTPSecure</label>
                                        <select name="smtp_secure" class="form-control label ui selection fluid dropdown">
                                            <option value="tls" <?php if ($row['smtp_secure'] == 'tls') {
                                                                    echo 'selected';
                                                                } ?>>TLS</option>
                                            <option value="ssl" <?php if ($row['smtp_secure'] == 'ssl') {
                                                                    echo 'selected';
                                                                } ?>>SSL</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Port No.</label>
                                        <input type="text" class="form-control" name="port_no" value="<?php if ($count > 0) {
                                                                                                            _e($row['port_no']);
                                                                                                        } ?>" placeholder="Enter Port No." class="form-control">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" name="submit" class="btn btn-primary <?php _e(PURCHASE); ?>">Save</button>
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <br>
                                <form class="row g-3" action="" method="post" enctype="multipart/form-data">
                                    <br><br>
                                    <input type="hidden" name="smtp_type" value="server">
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">SMTP Host</label>
                                        <input type="text" class="form-control" name="smtp_host"  value="<?php if ($count > 0) {
                                                                                                                                _e($row['smtp_ghost']);
                                                                                                                            } ?>" placeholder="mail.example.in" class="form-control">
                                    </div>
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Email</label>
                                        <input type="text" class="form-control" name="smtp_email" value="<?php if ($count > 0) {
                                                                                                                _e($row['smtp_gemail']);
                                                                                                            } ?>" placeholder="info@example.com" class="form-control">
                                    </div>
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="smtp_password"  placeholder="********" class="form-control">
                                    </div>
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">SMTPSecure</label>
                                        <select name="smtp_secure" class="form-control label ui selection fluid dropdown">
                                            <option value="tls" <?php if ($row['smtp_gsecure'] == 'tls') {
                                                                    echo 'selected';
                                                                } ?>>TLS</option>
                                            <option value="ssl" <?php if ($row['smtp_gsecure'] == 'ssl') {
                                                                    echo 'selected';
                                                                } ?>>SSL</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Port No.</label>
                                        <input type="text" class="form-control" name="port_no" value="<?php if ($count > 0) {
                                                                                                            _e($row['gport_no']);
                                                                                                        } ?>" placeholder="Enter Port No." class="form-control">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" name="submit" class="btn btn-primary <?php _e(PURCHASE); ?>">Save</button>
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include("includes/footer.php"); ?>