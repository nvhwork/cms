<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Events\RedisEvent;
use \Cache;
use \Validator;
use phpseclib\Crypt\RSA;
use App\Edge;
use App\Camera;
use Auth;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

use Carbon\Carbon;
use Tymon\JWTAuth\Claims\Issuer;
use Tymon\JWTAuth\Claims\IssuedAt;
use Tymon\JWTAuth\Claims\Expiration;
use Tymon\JWTAuth\Claims\NotBefore;
use Tymon\JWTAuth\Claims\JwtId;
use Tymon\JWTAuth\Claims\Subject;

class ApiEdgeController extends Controller
{
    public function uploadToCache(Request $req){
    	$file_content = "";
	    if ($files = $req->file('file')) {
			$file_content = $files->get();
			Cache::store('redis')->put('hls_camera_'.$req->stream_id.'_'.$files->getClientOriginalName(), $file_content, 280);
    		return "done";
	    }
	    return response("false", 404);
	}

    // public function login(Request $req, $edge_id, $serial_number){
    // 	//Need to install phpseclib
    // 	// composer require phpseclib/phpseclib:~2.0
    //     //check serila numbers
    //     //Return emcrypted token
    // 	$edge = Edge::where([['serial_number',$serial_number],['id',$edge_id]])->first();
	// 	// return $edge;
    // 	if ($edge == null){
    // 		return response("Edge not found.", 404);
    // 	}
    // 	//Else


    //     $msg = $edge->token;
    //     $key = $edge->publickey;
    //     $encrypted = '';
    //     //$key for test
    //     // $key ="ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQDhPj6eBKOEw2qjAjtT5DDIwybZFZatQ0KhqmGRRlw6jeBNKlK/5hKwwdUdFULq5ZHdmur6YxAf69T2TjFGL7DR26wdmy6HE9NPRfxNMzJmY76JE4StfWm1eTTa0qb7IFe0ls6Ao9Ncix9M/8X5FXycunFwmMW0DJJlxH/z+Ju5nYMqNcaDlzwjJ+g6qLABp592uZpAqDW5npX5cyyHeZb2D7Df0NtmqG8ekMMZDhzbPyhNB7LGJaOO5fWB7hdUQJdrrl2qnmxVcJSyZJu9CJgP/25owcaeCK2+THHQnLGvJwBzMuIBDmJNlKk9XMowddc1cdR88HNagNj3hfqQasAz map@map2-virtual-machine";
    //     $rsa = new RSA();
    //     $rsa->loadKey($key);
         
    //     $encrypted = $rsa->encrypt($msg);


    //     $data = [
	// 	    'iss' => new Issuer('dasvision.vn'),
	// 	    'iat' => new IssuedAt(Carbon::now('UTC')) ,
	// 	    'exp' => new Expiration(Carbon::now('UTC')->addSeconds(10)),
	// 	    'nbf' => new NotBefore(Carbon::now('UTC')),
	// 	    'sub' => new Subject('for-io'),
	// 	    'jti' => new JwtId(Str::uuid()->toString()),
	// 	    'edge_id' => $edge->id
	// 	];

	//     $customClaims = JWTFactory::customClaims($data);
	//     $payload = JWTFactory::make($customClaims);
	//     $jwt_token = JWTAuth::encode($payload);

    //     return ['token' => base64_encode($encrypted), 'edge_id'=>$edge->id, 'jwt_token'=>$jwt_token->get()];
    // }

    public function getConfig(Request $req, $edge_id,  $token){
        //Check token_name(token)
        $edge = Edge::where([['token',$token],['id',$edge_id]])->first();
        if ($edge == null){
        	return response("Edge not found.", 404);
        }
        $cams = Camera::where('edge_id', $edge->id)->get();
        return $cams;
    }

	public function notify($nav, $msg) {
		echo '<h1>' . $msg . '</h1>';
		header("refresh: 3; url=/" . $nav);
		exit();
	}

	public function registerAccount(Request $req) {
		// Get data from form
		$usr = $req->input('username');
		$pwd = $req->input('password');
		$role = $req->input('role');
		$confPwd = $req->input('confPwd');

		if (strcmp($pwd, $confPwd) != 0) {
			echo '<h1>The 2 input passwords are not identical!</h1>';
		} else {
			$server = "localhost";
			$username = "hoangnv";
			$password = "bkcs2022";
			$database = "transcoding";

			$conn = mysqli_connect($server, $username, $password, $database);

			if (!$conn) {
				die("Connection failed: " . mysqli_connect_error());
			}
			$hashPwd = password_hash($pwd, PASSWORD_DEFAULT);

			$sql = "INSERT INTO accounts VALUES ('" . $usr . "', '" 
					. $hashPwd . "', '" . $role . "');";
			
			if (mysqli_query($conn, $sql)) {
				echo "<h1>Add account completed!</h1>";
			} else {
				echo "<h1>Error: " . $sql . "</h1><br>" . mysqli_error($conn);
			}
			mysqli_close($conn);

		}
	
		header("refresh: 3; url=/accounts");
		exit();
	}

	public function login(Request $req) {
		if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

		// Get data from form
		$usr = $req->input('username');
		$pwd = $req->input('password');
		
		$server = "localhost";
		$username = "hoangnv";
		$password = "bkcs2022";
		$database = "transcoding";

		$conn = mysqli_connect($server, $username, $password, $database);

		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		$sql = "SELECT password, role FROM accounts WHERE username = '" . $usr . "';";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			$verify = password_verify($pwd, $row["password"]);
			if ($verify) {
				$_SESSION['username'] = $usr;
				$_SESSION['role'] = $row["role"];
				echo '<h1>Login successfully</h1>';
			} else {
				echo '<h1>Wrong password</h1>';
			}
		} else {
			echo '<h1>Username does not exist</h1>';
		}

		mysqli_close($conn);
		header("refresh: 3; url=/");
		exit();
	}

	public function logout() {
		if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
		unset($_SESSION['username']);
		unset($_SESSION['role']);

		echo '<h1>Log out successfully!</h1>';
		header("refresh: 3; url=/login");
		exit;
	}

	public function changePwd(Request $req) {
		if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
		
		if (!isset($_SESSION['username'])) {
			echo '<h1>You are not signing in!</h1>';
			header("refresh: 3; url=/login");
			exit();
		}

		$usr = $_SESSION['username'];
		$curPwd = $req->input('curPwd');
		$newPwd = $req->input('newPwd');
		$confPwd = $req->input('confPwd');

		$server = "localhost";
		$username = "hoangnv";
		$password = "bkcs2022";
		$database = "transcoding";

		$conn = mysqli_connect($server, $username, $password, $database);

		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		$sqlCheckPwd = "SELECT password FROM accounts WHERE username = '" . $usr . "';";
		$result = mysqli_query($conn, $sqlCheckPwd);
		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			$verify = password_verify($curPwd, $row["password"]);
			if (!$verify) {
				echo '<h1>Your current password is not correct! Enter again</h1>';
				mysqli_close($conn);
				header("refresh: 3; url=/change-password");
				exit();
			} else {
				if ($curPwd === $newPwd) {
					echo '<h1>New password and Current password are identical! Enter again!</h1>';
					mysqli_close($conn);
					header("refresh: 3; url=/change-password");
					exit();
				} else if ($newPwd !== $confPwd) {
					echo '<h1>New password and Confirmed new password are not identical! Enter again!</h1>';
					mysqli_close($conn);
					header("refresh: 3; url=/change-password");
					exit();
				} else {
					$sqlUpdatePwd = "UPDATE accounts SET password = '" . $newPwd . "' WHERE username = '" . $usr . "';";
					if (mysqli_query($conn, $sqlUpdatePwd)) {
						echo '<h1>Update password successfully</h1>';
					} else {
						echo '<h1>Error updating password: ' . mysqli_error($conn) . '</h1>';
					}
				}
			}
		} else {
			echo '<h1>User invalid</h1>';
		}
		mysqli_close($conn);
		header("refresh: 3; url=/");
		exit();
	}

	public function deleteAccount($usr) {
		$conn = mysqli_connect('localhost', 'hoangnv', 'bkcs2022', 'transcoding');
		if ($conn->connect_errno > 0) {
			die('Connection failed: ' . mysqli_connect_error());
		}
		$sql = 'DELETE FROM accounts WHERE username = "' . $usr . '"';
		$msg = 'Update: ';

		if (mysqli_query($conn, $sql)) {
			$msg = 'Account deleted: ' . $usr;
		} else {
			$msg = 'Error deleting account: ' . mysqli_error($conn);
		}

		mysqli_close($conn);
		header("refresh: 0; url=/api/notification/accounts/" . $msg);
	}
}