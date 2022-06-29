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
    <div class="content-camera">
        <div class="d-flex flex-column">
            <div class="p-3">
                <h1 style="text-align: center;">Account List</h1>
                <a href="/register" class="btn btn-success">Register a new user account</a>
            </div>
            <div class="p-3">
                <?php
                    $conn = mysqli_connect("localhost", "hoangnv", "bkcs2022", "transcoding");
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }
                    $result = mysqli_query($conn, "SELECT username, role FROM accounts");
                    $index = 0;

                    echo '  <table class="p-2 table table-hover table-dark">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Role</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>    ';
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($_SESSION['username'] === $row['username']) {
                            $delBtn = '<button class="btn btn-danger" disabled>Delete</a>';
                        } else {
                            $delBtn = '<a href="/api/delete-account/'. $row["username"] .'" class="btn btn-danger">Delete</a>';
                        }
                        echo '  <tr>
                                    <th scope="row">'. ++$index .'</th>
                                    <td>'. $row["username"] .'</td>
                                    <td>'. $row["role"] .'</td>
                                    <td>'. $delBtn .'</td>
                                </tr>   ';
                    }
                    echo '      </tbody>
                            </table>    ';
                    mysqli_close($conn);
                ?>
            </div>
            
        </div>
    </div> 
@endsection
