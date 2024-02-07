<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo e($title) ?></title>




    <!-- JQuery Link -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/bootstrapMain.css" />
    <link rel="stylesheet" href="/assets/main.css" />


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


    <!-- Data Tables Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script defer src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <!-- <script src="/assets/javascripts.js"></script> -->
    <!-- <script src="/assets/utube.js"></script> -->




</head>


<body class="virg-normal-font">
    <!-- Start Header -->
    <header class="container-fluid">

        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand text-center virg-karaoke-font fs-6" href="/">
                    Online Work Queue System
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['authority'] !== "karaoke") : ?>
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item ">
                                <a class="nav-link active" href="/profile">Profile</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link active" href="/office/history">History</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link active" href="/spendingplan">Spending Plan</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link active" href="/karaoke">Karaoke</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Sections
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/section/dpp">DPP</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </li>
                        </ul>
                    <?php else : ?>
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item ">
                                <a class="nav-link active" href="/spendingplan"></a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link active" href="/karaoke"></a>
                            </li>
                        </ul>
                    <?php endif ?>
                    <div>
                        <ul class="d-flex justify-content-end navbar-nav me-auto">
                            <?php if (isset($_SESSION['user'])) : ?>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="/settings">Settings</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="/logout">Logout</a>
                                </li>
                            <?php else : ?>
                                <li class="nav-item border-end">
                                    <a class="nav-link active" aria-current="page" href="/login">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="/register">Register</a>
                                </li>
                            <?php endif ?>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <!-- End Header -->