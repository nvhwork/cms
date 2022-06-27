@extends('../layouts/index')
@section('content')
    <div class="content-camera p-flex flex-column">
        <div class="p-5">
            <form action="/api/login" method="post">
                <div class="form-column">
                    <div class="form-group col-md-12">
                        <h2 style="text-align: center;">Login</h2>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                    </div>
                    <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-primary">Sign in</button>
                        <!-- <a href="/cameras" class="btn btn-success">Back to camera list</a> -->
                    </div>
                </div>
            </form>
        </div>
    </div> 
@endsection
