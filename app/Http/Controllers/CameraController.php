<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\User;
use DB;
use App\KmsClient;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\NvrController;
use App\CameraPermission;
use App\Proxy;
use App\Camera;
use App\EdgePermission;
use App\NvrPermission;
use App\Account;
use App\Nvr;
use App\NvrCamera;
use App\Edge;
use \Cache;
use \Response;
use File;
Use Jenssegers\Agent\Agent;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

define("PUBLIC_PATH", "/home/e-ai/transcoding/cms/public/");
define("OPERATION_PATH", "/home/e-ai/transcoding/operations/");

class CameraController extends Controller
{
	public function getFileHls($cam_id, $file_name){
		$file_content = Cache::store('redis')->get('hls_camera_'.$cam_id.'_'.$file_name,function() {
				abort(404);
				// return null;
		});
		// return Response::make($file_content)->header('Content-Type', 'm3u8/mp4');
		if (str_contains($file_name, '.ts')) {
			return Response::make($file_content)->header('Content-Type', 'video/MP2T');
		} else {
			return Response::make($file_content)->header('Content-Type', 'application/x-mpegURL');
		}
	}


	public function liveView(){
		$cameras = EdgePermission::cameras()->get();
		foreach($cameras as $camera){
			if(NvrCamera::where('cam_id',$camera->id)->first()){
				$camera->nvr_id = NvrCamera::where('cam_id',$camera->id)->first()->nvr_id;
			}
			else{
				$camera->nvr_id = null;
			}
		}
		$nvrs = NvrPermission::nvrs();
		$edges = EdgePermission::edges();
		$agent = new Agent();
		if($agent->isMobile()){
			$title = 'Live View';
			return view('device.m_live_view', compact('cameras','nvrs','edges','title'));
		}
		return view('device.live_view', compact('cameras','nvrs','edges'));
	}

	public function getStreamList() {
		$server = "localhost";
		$username = "hoangnv";
		$password = "bkcs2022";
		$database = "transcoding";

		$conn = mysqli_connect($server, $username, $password, $database);

		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		$sql = "SELECT stream_input_camera FROM streams GROUP BY stream_input_camera";
		$result = mysqli_query($conn, $sql);

		$stream_list = array();
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				array_push($stream_list, $row["stream_input_camera"]);
			}
		} else {
			echo "0 results";
		}

		mysqli_close($conn);
		return $stream_list;
	}

	public function addCamera(Request $req) {
		// Get data from form
		$camName = $req->input('camera_name');
		$camUrl = $req->input('camera_url');
		$data = array(
			"camera_name" => $camName,
			"camera_url" => $camUrl
		);
		$dataJson = json_encode($data);

		$file = 'cameraAdd.json';
		file_put_contents($file, $dataJson);

		// Execute the camera adding operation
		$cmd = OPERATION_PATH . 'camera-add ' . PUBLIC_PATH . $file;
		$output = shell_exec($cmd);
		unlink(PUBLIC_PATH . $file);
		echo '<h1>' . $output . '</h1>';
		header("refresh: 3; url=/cameras");
		exit();
	}

	public function deleteCamera($cam_name) {
		$conn = mysqli_connect('localhost', 'hoangnv', 'bkcs2022', 'transcoding');
		if ($conn->connect_errno > 0) {
			die('Connection failed: ' . mysqli_connect_error());
		}
		$sql = 'DELETE FROM cameras WHERE camera_name="' . $cam_name . '"';
		$msg = '';

		if (mysqli_query($conn, $sql)) {
			// exec(OPERATION_PATH . 'restartGst.sh');
			$msg = 'Camera deleted: ' . $cam_name;
		} else {
			$msg = 'Error deleting camera: ' . mysqli_error($conn);
		}
		mysqli_close($conn);

		// Restart the program
		header("refresh: 0; url=/api/notification/cameras/" . $msg);
		exit();
	}

	public function addStream(Request $req) {
		// Get data from form
		$streamInput = $req->input('stream_input_camera');
		$streamRes = $req->input('stream_resolution');
		$streamCodec = $req->input('stream_codec');

		// Extract resolution
		$res = explode("x", $streamRes);
		$streamWidth = intval($res[0]);
		$streamHeight = intval($res[1]);

		// Create stream ID and path
		$streamId = $streamInput . '_';
		$zeroBufferLength = 6 - strlen($res[1]);
		for ($x = 0; $x < $zeroBufferLength; $x++) {
			$streamId .= '0';
		}
		$streamId .= $streamHeight;
		
		// Set bitrate value
		if ($streamHeight <= 360) {
			$streamBitrate = 500000;
		} elseif ($streamHeight <= 576) {
			$streamBitrate = 1000000;
		} elseif ($streamHeight <= 720) {
			$streamBitrate = 1500000;
		} else {
			$streamBitrate = 2000000;
		}

		$conn = mysqli_connect('localhost', 'hoangnv', 'bkcs2022', 'transcoding');
		if ($conn->connect_errno > 0) {
			die('Connection failed: ' . mysqli_connect_error());
		}
		$sql = "INSERT INTO streams VALUES ('" 
				. $streamId . "', '" . $streamInput . "', "
				. $streamWidth . ", " . $streamHeight . ", '"
				. $streamCodec . "', " . $streamBitrate . ");";
		
		if (mysqli_query($conn, $sql)) {
			// exec(OPERATION_PATH . 'restartGst.sh');
			echo "<h1>Add stream completed!</h1>";
		} else {
			echo "<h1>Error: " . $sql . "</h1><br>" . mysqli_error($conn);
		}

		mysqli_close($conn);
		header("refresh: 3; url=/streams");
		exit();
	}

	public function deleteStream($stream_id) {
		$conn = mysqli_connect('localhost', 'hoangnv', 'bkcs2022', 'transcoding');
		if ($conn->connect_errno > 0) {
			die('Connection failed: ' . mysqli_connect_error());
		}
		$sql = 'DELETE FROM streams WHERE stream_id="' . $stream_id . '"';
		$msg = 'Update: ';

		if (mysqli_query($conn, $sql)) {
			// exec(OPERATION_PATH . 'restartGst.sh');
			$msg = 'Stream deleted: ' . $stream_id;
		} else {
			$msg = 'Error deleting stream: ' . mysqli_error($conn);
		}

		mysqli_close($conn);
		header("refresh: 0; url=/api/notification/streams/" . $msg);
	}

}