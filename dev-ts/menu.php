<header class="p-3 mb-3 border-bottom">
    <div class="custom-container">
        <nav class="navbar navbar-expand-xl navbar-light">
            <a href="home.php" class="navbar-brand d-flex align-items-center mb-2 mb-xl-0 link-body-emphasis text-decoration-none">
                <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                    <use xlink:href="#bootstrap" />
                </svg>
                Company Name
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-xl-0">
                    <?php

                    $links = [
                        ['url' => "home.php", 'title' => 'Home'],
                        ['url' => "user_profile.php", 'title' => 'User Profile'],
                        ['url' => "time_entry.php", 'title' => 'Time Entry'],
                        ['url' => "list_entries.php", 'title' => 'Time Entry List'],
                        ['url' => "create_users.php", 'title' => 'Add New User'],
                        ['url' => "create_task.php", 'title' => 'Add New Task'],
                        ['url' => "raports.php", 'title' => 'Statistics'],
                        ['url' => "login.php", 'title' => 'Log In'],
                        ['url' => "admin_users.php", 'title' => 'Users Management'],
                        ['url' => "list_task.php", 'title' => 'Task List'],
                    ];

                    foreach($links as $link) {
                        $extraClass = "";
                        $currentUrl = basename($_SERVER['PHP_SELF']);
                        if($link ['url'] == $currentUrl ) {
                            $extraClass = ' active';
                        }
                        echo "<li class='nav-item'><a href='" . $link['url'] . "' class='nav-link px-2 link-body-emphasis" . $extraClass . "'>" . $link['title'] . "</a></li>";
                    }

                    ?>

                </ul>

                <div class="dropdown text-end">
                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu text-small">
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Sign out</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>
