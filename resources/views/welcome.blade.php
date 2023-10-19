<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <style>
        .card {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .card-header {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .card-content {
            margin-bottom: 10px;
        }

        .follow-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
            border-radius: 4px;
        }

        .notification-bell {
            position: absolute;
            top: 10px;
            /* Sesuaikan dengan jarak dari atas */
            right: 10px;
            /* Sesuaikan dengan jarak dari kanan */
            width: 40px;
            height: 40px;
            cursor: pointer;
        }

        .notification-bell .bell {
            fill: #999;
        }

        .notification-bell .badge {
            fill: #ff0000;
        }

        .notification-bell .badge-text {
            fill: #fff;
            font-size: 12px;
            font-weight: bold;
            text-anchor: middle;
            dominant-baseline: central;
        }

        .notification-container {
            position: absolute;
            top: 50px;
            right: 10px;
            width: 300px;
            max-height: 300px;
            overflow-y: auto;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            display: none;
        }

        .notification-card {
            border-bottom: 1px solid #ddd;
            padding: 5px;
            margin-bottom: 5px;
        }

        .notification-card:last-child {
            border-bottom: none;
        }

        /* CSS untuk tombol logout */
        .logout-button {
            background-color: #FF5733;
            /* Warna latar belakang tombol */
            color: #fff;
            /* Warna teks tombol */
            padding: 10px 20px;
            /* Padding di dalam tombol */
            border: none;
            /* Hilangkan border tombol */
            border-radius: 5px;
            /* Membuat sudut tombol sedikit bulat */
            cursor: pointer;
            /* Ubah kursor saat diarahkan ke tombol */
            font-size: 16px;
            /* Ukuran teks tombol */
            margin-bottom: 10px;
        }

        /* Efek hover saat kursor diarahkan ke tombol */
        .logout-button:hover {
            background-color: #E63C0F;
            /* Warna latar belakang saat dihover */
        }

        .notif-button {
            background-color: #4CAF50;
            /* Warna latar belakang tombol */
            color: #fff;
            /* Warna teks tombol */
            padding: 10px 20px;
            /* Padding di dalam tombol */
            border: none;
            /* Hilangkan border tombol */
            border-radius: 5px;
            /* Membuat sudut tombol sedikit bulat */
            cursor: pointer;
            /* Ubah kursor saat diarahkan ke tombol */
            font-size: 16px;
            /* Ukuran teks tombol */
            margin-bottom: 10px;
        }

        .notif-button:hover {
            background-color: #E63C0F;
            /* Warna latar belakang saat dihover */
        }

        @media screen and (max-width: 600px) {
            .card {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <svg class="notification-bell" xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
        <circle cx="50" cy="50" r="40" fill="#ff9800" />
        <rect x="42.5" y="25" width="15" height="25" fill="#ff9800" />
        <path class="bell" d="M50 50 Q50 80 70 90 Q50 80 30 90 Z" fill="#ff5722" />
        <circle cx="50" cy="35" r="7" fill="#fff" />
    </svg>


    <div class="notification-container">
        @foreach ($notifications as $notification)
        <div id="notification{{ $notification->id }}">
            <form id="formReadNotification{{ $notification->id }}"
                action="{{ route('read.notification', $notification->id) }}" method="post">
                <div class="notification-card">
                    <p>{{ $notification->pesan }}</p>

                <button type="submit" onclick="readNotification({{ $notification->id }})" class="notif-button">Tandai sudah dibaca!</button>
                </div>
            </form>
        </div>
        @endforeach
    </div>
    <div class="alert-success">

    </div>
    <form action="{{ route('process.logout') }}" method="post">
        @csrf
        <button class="logout-button" type="submit">Logout</button>
    </form>

    @foreach ($allUsers as $urutan => $user)
        <div class="card">
            <div class="card-header">Akun {{ $urutan += 1 }}</div>
            <div class="card-content">
                <p>Nama: {{ $user->name }}</p>
                <p>Email: {{ $user->email }}</p>
                <p>Biodata: {{ $user->biodata }}</p>
            </div>
            @if ($user->id != Auth::user()->id)
                @if ($user->isFollow(Auth::user()->id))
                    <form id="formFollow{{ $urutan }}"
                        action="{{ route('process.follow', [$user->id, Auth::user()->id]) }}" method="post">
                        @csrf
                        <button type="submit" onclick="buttonFollow({{ $urutan }})"
                            class="follow-button{{ $urutan }} follow-button">Following</button>
                    </form>
                @else
                    <form id="formFollow{{ $urutan }}"
                        action="{{ route('process.follow', [$user->id, Auth::user()->id]) }}" method="post">
                        @csrf
                        <button type="submit" onclick="buttonFollow({{ $urutan }})"
                            class="follow-button{{ $urutan }} follow-button">Follow</button>
                    </form>
                @endif
            @else
                <button class="follow-button">Your Account</button>
            @endif
        </div>
    @endforeach

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        const bellIcon = document.querySelector('.notification-bell');
        const notificationContainer = document.querySelector('.notification-container');

        bellIcon.addEventListener('click', function() {
            notificationContainer.style.display = notificationContainer.style.display === 'none' ? 'block' : 'none';
        });

        // ajax untuk proses follow
        function buttonFollow(num) {
            $("#formFollow" + num).off("submit");
            $("#formFollow" + num).submit(function(event) {
                event.preventDefault();
                let route = $(this).attr("action");
                $.ajax({
                    url: route,
                    method: "POST",
                    headers: {
                        'X-CSRF-Token': "{{ csrf_token() }}"
                    },
                    success: function success(response) {
                        if (response.success) {
                            $("#alert-success").show();
                            $("#alert-success").text(response.message);
                            if (response.follow) {
                                $(".follow-button" + num).text("Following");
                            } else {
                                $(".follow-button" + num).text("Follow");
                            }
                        }
                    }
                });
            });
        }

        function readNotification(num) {
            $("#formReadNotification" + num).submit(function(event){
                event.preventDefault();
                let route = $(this).attr("action");
                $.ajax({
                    url: route,
                    method: "PUT",
                    headers: {
                        "X-CSRF-Token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            $("#notification" + num).hide();
                        }
                    }
                });
            });
        }
    </script>
</body>

</html>
