<?php
include('functions.php');
authorized();
handleRoute();
$filter_job = "";
if (isset($_GET["filter_job"])) {
    $filter_job = $_GET["filter_job"];
}
$allCVInfo = getCVInfoPublic($filter_job);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Recruit Website</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">

</head>

<body>
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" style="max-height: 80vh;">
            <div class="modal-content">
                <div id="spinnerDetailModal" class="bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
                    <div class="spinner-border text-success" style="width: 3rem; height: 3rem;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="detailModalBody" style="max-height: 80vh;">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-success" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->
    <nav class="navbar navbar-expand-sm bg-white navbar-light sticky-top p-0 shadow">
        <div class="container-fluid p-0">
            <a class="navbar-brand h1 d-flex align-items-center text-uppercase p-0 m-0">
                <img src="./img/logo.png" alt="" width="auto" height="50" class="d-inline-block align-text-top">
                &nbsp;Create your CV & Find the right job
            </a>
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <a href="./auth/login.php" class="btn btn-success rounded-0 p-4 d-flex align-items-center">
                <?php echo isset($_SESSION["username"]) ? "Move to user portral" : "Login" ?><i class="d-inline fa fa-arrow-right ms-3"></i>
            </a>
        </div>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    <div class="container-fluid pt-3 custom-linear-gradient-background-container">
        <div class="container">
            <div class="row">
                <?php
                $nullStringArray = array("null", "");
                for ($x = 0; $x <= 100; $x++) {
                    foreach ($allCVInfo as $CVInfo) {
                        $jsonDetail = get_object_vars(json_decode($CVInfo["detail"]));
                        $skillRender = !empty($jsonDetail["skill"]) ? '<div class="col-12 h4">Skill</div>
                    <div class="col-12 text-break">
                        ' . $jsonDetail["skill"] . '
                    </div>' : "";
                        $certificateRender = !empty($jsonDetail["certificate"]) ? '<div class="col-12 h4">Certificate</div>
                    <div class="col-12 text-break">
                        ' . $jsonDetail["certificate"] . '
                    </div>' : "";
                        $experienceRender = !empty($jsonDetail["experience"]) ? '<div class="col-12 h4">Experience</div>
                    <div class="col-12 text-break">
                        ' . $jsonDetail["experience"] . '
                    </div>' : "";
                        $educationRender = !empty($jsonDetail["education"]) ? '<div class="col-12 h4">Education</div>
                    <div class="col-12 text-break">
                        ' . $jsonDetail["education"] . '
                    </div>' : "";
                        $careerGoalsRender = !empty($jsonDetail["careerGoals"]) ? '<div class="col-12 fw-bold h3">Career Goals</div>
                    <div class="col-12 text-break">
                        ' . $jsonDetail["careerGoals"] . '
                    </div>' : "";
                        $desired_jobRender = '<div class="col-12 pt-2 long-text-need-hide-overflow" style="width: 13rem;" data-toggle="tooltip" data-placement="bottom" title="' . strtoupper($CVInfo["desired_job"]) . '">
                        Looking for a job as: <b class="h4 text-uppercase">' . $CVInfo["desired_job"] . '</b>
                    </div>';
                        echo '<div class="col-6 mb-2 wow zoomInUp">
                    <div class="card">
                    <div class="card-header">
                      ' . $CVInfo["name"] . " - " . $CVInfo["cv_id"] . '
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-7">
                            ' . $skillRender . $certificateRender . $experienceRender . $educationRender  . '
                            </div>
                            <div class="col-5">
                                <div class="col-12">
                                    <img src="./img/' . ($CVInfo["gender"] ? "man.png" : "woman.png") . '" class="img-fluid">
                                </div>
                                ' . $desired_jobRender . '
                            </div>
                        </div>
                      ' . $careerGoalsRender . '
                      <button href="#" class="btn btn-success w-100 mt-3" data-bs-toggle="modal" data-bs-target="#detailModal" onclick="getCVById(' . "'" . $CVInfo["cv_id"] . "'" . ')">Detail</button>
                    </div>
                  </div>
                  </div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <!-- Toast -->
    <script src="js/toast.js"></script>
    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script src="js/index.js"></script>
</body>
<script>
    const getDOMControl = () => {
        return {
            detailModalBody: document.getElementById("detailModalBody"),
            spinnerDetailModal: document.getElementById("spinnerDetailModal"),
        }
    }
    let detailModalData = {};
    const loadingDetailModalRenderControl = (loading = false) => {
        const {
            spinnerDetailModal
        } = getDOMControl();
        if (loading) {
            spinnerDetailModal.classList.contains("d-none") && spinnerDetailModal.classList.remove("d-none");
            return
        }
        spinnerDetailModal.classList.add("d-none");
    }
    const getCVById = (id) => {
        if (!id) {
            return;
        }
        renderDetailModal({});
        loadingDetailModalRenderControl(true);
        $.ajax({
            type: "GET",
            url: "./fetch/get/getPublicCV.php?cv_id=" +
                id,
            data: {},
            processData: false,
            contentType: false,
            cache: false,
            timeout: 30000,
            success: function(data) {
                const jsonData = JSON.parse(data);
                const {
                    error
                } = jsonData
                error && $.toast({
                    type: 'error',
                    title: 'Notification',
                    content: 'Error',
                    delay: 3000,
                });
                !error && renderDetailModal(jsonData)
                loadingDetailModalRenderControl(false);
            },
            error: function(err) {
                console.log(err)
                $.toast({
                    type: 'error',
                    title: 'Notification',
                    content: 'Error',
                    delay: 3000,
                });
                loadingDetailModalRenderControl(false);
            }
        });
    }
    const renderDetailModal = (detail) => {
        detailModalData = detail;
        if (detailModalData.detail) {
            detailModalData.detail = JSON.parse(detailModalData.detail)
        }
        console.log("[parseData]", detailModalData)
        const DOM = getDOMControl();
        if (Object.entries(detailModalData).length === 0) {
            DOM.detailModalBody.innerHTML = "";
            return
        }
        const {address, cv_id, date_of_birth, gender, name } = detailModalData
        DOM.detailModalBody.innerHTML = `<nav>
                <div class="nav nav-pills nav-justified nav-tabs custom-nav-tabs" id="nav-tab" role="tablist">
                    <span class="nav-link active custom-nav-link fw-bold" id="nav-basic-infomation-tab" data-bs-toggle="tab" data-bs-target="#nav-basic-infomation" type="button" role="tab" aria-controls="nav-basic-infomation" aria-selected="true">Your CV</span>
                    <span class="nav-link custom-nav-link fw-bold position-relative" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Contact
                    </span>
                </div>
            </nav>
            <div class="tab-content mt-3" id="nav-tabContent">
                <div class="tab-pane pt-2 fade show active" id="nav-basic-infomation" role="tabpanel" aria-labelledby="nav-basic-infomation-tab">
                    <div class="row">
                    </div>
                </div>
                <div class="tab-pane pt-2 fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" style="background-color: #FFFFFF;">
                    <div class="row">
                    </div>
                </div>
            </div>`;
    }
</script>

</html>