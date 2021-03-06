@extends('../layouts/index')
@section('content')
    <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['role'])) {
            header("refresh: 0, url=/login");
            exit;
        } else {
            $sess = $_SESSION['role'];
            if ($sess !== 'Administrator') {
                echo '<h1>You don\'t have permission to access this site</h1>';
                header("refresh: 3, url=/");
                exit;
            }
        }
    ?>
    <div class="content-camera p-flex flex-column">
        <div class="p-5">
            <form action="/api/add-camera" method="post">
                <div class="form-column">
                    <div class="form-group col-md-12">
                        <h2 style="text-align: center;">Add camera</h2>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="camera_name">Camera name</label>
                        <input type="text" class="form-control" id="camera_name" name="camera_name" placeholder="Enter a name for camera" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="camera_url">URL</label>
                        <input type="text" class="form-control" id="camera_url" name="camera_url" placeholder="Enter camera URL" required>
                    </div>
                    <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="/cameras" class="btn btn-success">Back to camera list</a>
                    </div>
                </div>
            </form>
        </div>
    </div> 
@endsection
