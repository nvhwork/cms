@extends('../layouts/index')
@section('content')
    <div class="content-camera p-flex flex-column">
        <div class="p-5">
            <form action="/api/add-stream" method="post">
                <div class="form-column">
                    <div class="form-group col-md-12">
                        <h2 style="text-align: center;">Create a new stream to transcode</h2>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="stream_input_camera">Select a camera</label>
                        <select class="form-control" name="stream_input_camera" id="stream_input_camera">
                            <?php
                                $conn = mysqli_connect("localhost", "hoangnv", "bkcs2022", "transcoding");
                                if (!$conn) {
                                    die("Connection failed: " . mysqli_connect_error());
                                }
                                $result = mysqli_query($conn, "SELECT camera_name FROM cameras");
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '
                                        <option>'. $row["camera_name"] .'</option>
                                    ';
                                }
                                mysqli_close($conn);
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-12 form-row">
                        <div class="col-md-6">
                            <label for="stream_resolution">Resolution</label>
                            <select name="stream_resolution" id="stream_resolution" class="form-control">
                                <option>640x360</option>
                                <option>1024x576</option>
                                <option>1280x720</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="stream_codec">Codec</label>
                            <select name="stream_codec" id="stream_codec" class="form-control">
                                <option>H.264</option>
                                <option>H.265</option>
                            </select>
                        </div>
                    </div>                    
                    <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="/streams" class="btn btn-success">Back to stream list</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
