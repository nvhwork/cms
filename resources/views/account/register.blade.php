@extends('../layouts/index')
@section('content')
    <?php
        ob_start();
        session_start();
        $msg = '';
        if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
            
        }
    ?>
    <div class="content-camera p-flex flex-column">
        <div class="p-5">
            <form action="/api/register" method="post">
                <div class="form-column">
                    <div class="form-group col-md-12">
                        <h2 style="text-align: center;">Login</h2>
                    </div>
                    <div class="form-group col-md-12 form-row">
                        <div class="col-md-6">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                        </div>
                        <div class="col-md-6">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control">
                                <option>Administrator</option>
                                <option selected>Supervisor</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12 form-row">
                        <div class="col-md-6">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                        </div>
                        <div class="col-md-6">
                            <label for="confPwd">Confirm password</label>
                            <input type="password" class="form-control" id="confPwd" name="confPwd" placeholder="Re-enter password" required>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <!-- <a href="/cameras" class="btn btn-success">Back to camera list</a> -->
                    </div>
                </div>
            </form>
        </div>
    </div> 
@endsection
