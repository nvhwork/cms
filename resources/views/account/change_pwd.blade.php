@extends('../layouts/index')
@section('content')
    <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['role'])) {
            header("refresh: 0, url=/login");
            exit;
        }
    ?>
    <div class="content-camera p-flex flex-column">
        <div class="p-5">
            <form action="/api/change-pwd" method="post">
                <div class="form-column">
                    <div class="form-group col-md-12">
                        <h2 style="text-align: center;">Change Password</h2>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="curPwd">Current Password</label>
                        <input type="password" class="form-control" id="username" name="curPwd" placeholder="Enter your current password" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="newPwd">New Password</label>
                        <input type="password" class="form-control" id="password" name="newPwd" placeholder="Enter new password" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="confPwd">Confirm New Password</label>
                        <input type="password" class="form-control" id="password" name="confPwd" placeholder="Re-enter new password" required>
                    </div>
                    <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <!-- <a href="/cameras" class="btn btn-success">Back to camera list</a> -->
                    </div>
                </div>
            </form>
        </div>
    </div> 
@endsection
