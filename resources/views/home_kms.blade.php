@extends('../layouts/index')
@section('content')
    <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    ?>
    <div class="content-camera">
        <div class="home-kms">
        	<div class="row row-content">
        		<div class="row-title">
        			<div class="title-list-proxy">Device & Server</div>
        		</div>
                <div class="col-sm-3 col-content">
                    <a href="/cameras">
                        <div class="icon-info">
                            <img src="/js-css/img/icon/webcam1.png" class="icon-custom">
                        </div>
                        <div class="title-content">
                            <label>Cameras</label>
                            <p>See the list of Camera</p>
                        </div>
                    </a>
                </div>
                <div class="col-sm-3 col-content">
                    <a href="/streams">
                        <div class="icon-info">
                            <img src="/js-css/img/icon/play1.png" class="icon-custom">
                        </div>
                        <div class="title-content">
                            <label>Streams</label>
                            <p>See the list of currently transcoding streams</p>
                        </div>
                    </a>
                </div>
                <div class="col-sm-3 col-content">
                    <a href="/demo-hls">
                        <div class="icon-info">
                            <img src="/js-css/img/icon/monitor.png" class="icon-custom">
                        </div>
                        <div class="title-content">
                            <label>Monitor</label>
                            <p>View the streams transcoded from cameras</p>
                        </div>
                    </a>
                </div>
                <!-- <div class="col-sm-3 col-content">
                    <a href="/edge-list">
                        <div class="icon-info">
                            <img src="/js-css/img/icon/edge.png" class="icon-custom">
                        </div>
                        <div class="title-content">
                            <label>DASCAM Edges AI</label>
                            <p>See the list of Edge AI</p>
                        </div>
                    </a>
                </div>
        		<div class="col-sm-3 col-content">
                    <a href="/proxylist">
            			<div class="icon-info">
            				<img src="/js-css/img/icon/proxy4.png" class="icon-custom">
            			</div>
            			<div class="title-content">
            				<label>DASCAM Protect</label>
            				<p>See the list of DASCAM Protects</p>
            			</div>
                    </a>
        		</div>
        		<div class="col-sm-3 col-content">
                    <a href="/nvrlist">
            			<div class="icon-info">
            				<img src="/js-css/img/icon/nvr1.png" class="icon-custom">
            			</div>
            			<div class="title-content">
            				<label>Edge Storage</label>
            				<p>See the list of DASCAM Edge Storages</p>
            			</div>
                    </a>
        		</div>
                <div class="col-sm-3 col-content">
                    <a href="/kafka-list">
                        <div class="icon-info">
                            <img src="/js-css/img/icon/kafka.png" class="icon-custom">
                        </div>
                        <div class="title-content">
                            <label>DASCAM Kafka Broker</label>
                            <p>See the list of DASCAM Kafka Brokers</p>
                        </div>
                    </a>
                </div>
        	</div>
        	<div class="row row-content">
        		<div class="row-title">
        			<div class="title-list-proxy">User & Event</div>
        		</div>
                <div class="col-sm-3 col-content">
                    <a href="accountlist">
                        <div class="icon-info">
                            <img src="/js-css/img/icon/existing_user.png" class="icon-custom">
                        </div>
                        <div class="title-content">
                            <label>User Management</label>
                            <p>See the list of users and their access history</p>
                        </div>
                    </a>
                </div>
        		<div class="col-sm-3 col-content">
                    <a href="listevent">
            			<div class="icon-info">
            				<img src="/js-css/img/icon/forbidden.png" class="icon-custom">
            			</div>
            			<div class="title-content">
            				<label>Notification</label>
            				<p>See the list of notifications</p>
            			</div>
                    </a>
        		</div>
                <div class="col-sm-3 col-content">
                    <a href="event-list">
                        <div class="icon-info">
                            <img src="/js-css/img/icon/event.png" class="icon-custom">
                        </div>
                        <div class="title-content">
                            <label>Events</label>
                            <p>See the list of events</p>
                        </div>
                    </a>
                </div> -->
        	</div>
        </div>
    </div> 
@endsection
