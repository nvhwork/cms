@extends('../layouts/index')
@section('content')
    <div class="content-camera">
        <div class="d-flex flex-column">
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
            <div class="p-3">
                <h1 style="text-align: center;">Transcoding Streams</h1>
                <a href="/streams/add" class="btn btn-success">Create a new stream to transcode camera</a>
                <a href="/cameras" class="btn btn-info">Check the list of cameras</a>
            </div>
            <div class="p-3">
                <?php
                    $conn = mysqli_connect("localhost", "hoangnv", "bkcs2022", "transcoding");
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }
                    $result = mysqli_query($conn, "SELECT * FROM streams");
                    $index = 0;

                    echo "  <table class=\"p-2 table table-hover table-dark\">
                                <thead class=\"thead-light\">
                                    <tr>
                                        <th scope=\"col\">#</th>
                                        <th scope=\"col\">ID</th>
                                        <th scope=\"col\">Input camera name</th>
                                        <th scope=\"col\">Resolution</th>
                                        <th scope=\"col\">Codec</th>
                                        <th scope=\"col\"></th>
                                    </tr>
                                </thead>
                                <tbody>    ";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "  <tr>
                                    <th scope=\"row\">". ++$index ."</th>
                                    <td>". $row["stream_id"] ."</td>
                                    <td>". $row["stream_input_camera"] ."</td>
                                    <td>". $row["stream_width"] ."x". $row["stream_height"] ."</td>
                                    <td>". $row["stream_codec"] ."</td>
                                    <td>
                                        <a href=\"/api/delete-stream/". $row["stream_id"] .
                                        "\" class=\"btn btn-danger\">Delete</a>
                                    </td>
                                </tr>   ";
                    }
                    echo "      </tbody>
                            </table>    ";
                    mysqli_close($conn);
                ?>
            </div>
            
        </div>
    </div> 
@endsection
