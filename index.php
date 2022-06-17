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
    <div id="toast-container" class="toast-container position-absolute bottom-0 end-0 p-3 bottom-center">
    </div>
    <!-- detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
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
                <div class="modal-body" id="detailModalBody">

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
    <nav class="navbar navbar-expand-sm bg-white navbar-light sticky-top p-0 shadow d-flex flex-column pb-2">
        <div class="container-fluid p-0 pb-1 mb-2" style="border-bottom: 1px solid rgb(242, 242, 242);">
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
        </div>
        <div class="container d-flex justify-content-center align-items-center">
            <div class="row w-75">
                <div class="col-10">
                    <input class="form-control w-100 h-100" list="datalistOptionsOccupation" id="txtFilterJob" name="txtFilterJob" placeholder="Filter job...">
                    <datalist id="datalistOptionsOccupation">
                        ${[...occupations].map(occupation => `<option value="${occupation}" class="text-uppercase">${occupation}</option>`).join("")}
                    </datalist>
                </div>
                <div class="col-2">
                    <button id="filterJobBtn" class="btn btn-outline-success w-100"><i class="fas fa-2x fa-filter"></i></button>
                </div>
            </div>
        </div>
    </nav>
    <div class="container-fluid pt-3 custom-linear-gradient-background-container">
        <div class="container">
            <div class="row">
                <?php
                $nullStringArray = array("null", "");
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
                    $desired_jobRender = '<div class="col-12 pt-2" data-toggle="tooltip" data-placement="bottom" title="' . strtoupper($CVInfo["desired_job"]) . '">
                        <p class="col-12 text-center">Looking for a job as: </p><p class="h4 col-12 text-uppercase fw-bold text-center">' . $CVInfo["desired_job"] . '</p>
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
                      <button href="#" class="btn btn-success w-100 mt-3" data-bs-toggle="modal" data-bs-target="#detailModal" onclick="getCVById(' . "'" . $CVInfo["cv_id"] . "'" . ')">Detail & Contact</button>
                    </div>
                  </div>
                  </div>';
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
            contactNameInput: document.getElementById("txtContactName"),
            contactPhoneInput: document.getElementById("txtContactPhone"),
            contactEmailInput: document.getElementById("txtContactEmail"),
            contactMessageInput: document.getElementById("txtContactMessage"),
            filterJobInput: document.getElementById("txtFilterJob"),
            sendContactBtn: document.getElementById("sendContactBtn"),
            filterJobBtn: document.getElementById("filterJobBtn"),
            datalistOptionsOccupation: document.getElementById("datalistOptionsOccupation")
        }
    }
    getDOMControl().filterJobBtn.onclick = () => {
        const filterJobValue = getDOMControl().filterJobInput.value.trim();
        if (!filterJobValue) {
            return;
        }
        window.location.replace("/baitaplon/index.php?filter_job=" + filterJobValue);
    }
    getDOMControl().datalistOptionsOccupation.innerHTML = `
        ${[...occupations].map(occupation => `<option value="${occupation}" class="text-uppercase">${occupation}</option>`).join("")}
    `
    const getAge = (dateString) => {
        const today = new Date();
        const birthDate = new Date(dateString);
        let age = today.getFullYear() - birthDate.getFullYear();
        const m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;
    }
    let detailModalData = {};
    let contactData = {
        cv_id: "",
        contact_name: "",
        phone: "",
        email: "",
        message: ""
    }
    const isValidContactData = () => {
        const emailReg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if (!emailReg.test(contactData.email)) {
            return false;
        }
        return contactData.cv_id && contactData.contact_name && contactData.phone && contactData.email && true;
    }
    const onChangeInput = (inputId) => {
        const DOM = getDOMControl();
        switch (inputId) {
            case "txtContactName":
                contactData.contact_name = DOM.contactNameInput.value;
                break;
            case "txtContactPhone":
                contactData.phone = DOM.contactPhoneInput.value;
                break;
            case "txtContactEmail":
                contactData.email = DOM.contactEmailInput.value;
                break;
            case "txtContactMessage":
                contactData.message = DOM.contactMessageInput.value;
                break;
            default:
                break;
        }
        console.log("[contactData]", contactData)
        DOM.sendContactBtn.disabled = !isValidContactData();
    }
    const onSendContactData = () => {
        const DOM = getDOMControl();
        const formData = new FormData();
        formData.append("cv_id", contactData.cv_id)
        formData.append("contact_name", contactData.contact_name)
        formData.append("email", contactData.email)
        formData.append("phone", contactData.phone)
        formData.append("message", contactData.message)
        DOM.sendContactBtn.disabled = true;
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "./fetch/post/addContact.php",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 30000,
            success: function(data) {
                const {
                    success,
                    error
                } = JSON.parse(data);
                success && $.toast({
                    type: 'success',
                    title: 'Notification',
                    content: 'Success',
                    delay: 3000,
                });
                error && $.toast({
                    type: 'error',
                    title: 'Notification',
                    content: 'Error',
                    delay: 3000,
                });
                DOM.sendContactBtn.disabled = false;
            },
            error: function(err) {
                console.log(err)
                $.toast({
                    type: 'error',
                    title: 'Notification',
                    content: 'Error',
                    delay: 3000,
                });
                DOM.sendContactBtn.disabled = false;
            }
        });
    }
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
    const renderDetailModal = (raw_detail) => {
        contactData = {
            cv_id: "",
            contact_name: "",
            phone: "",
            email: "",
            message: ""
        };
        detailModalData = raw_detail;
        if (detailModalData.detail) {
            detailModalData.detail = JSON.parse(detailModalData.detail)
        }
        console.log("[parseData]", detailModalData)
        const DOM = getDOMControl();
        if (Object.entries(detailModalData).length === 0) {
            DOM.detailModalBody.innerHTML = "";
            return
        }
        const {
            address,
            cv_id,
            date_of_birth,
            gender,
            name,
            detail,
            desired_job
        } = detailModalData
        // address: "Thanh Hóa"
        // cv_id: "4"
        // date_of_birth: "2000-09-17"
        // desired_job: "blaster"
        // detail:
        //     careerGoals: "Nope"
        // certificate: ""
        // education: "<p>eqweqw2312fsdf213123123123123123</p>"
        // experience: "<ul><li><i><strong>e12312dasdasdasd</strong></i></li><li><i><strong>ssaSSDASDAS</strong></i></li><li><i><strong>dfsdfsdfsd</strong></i></li></ul>"
        // skill: "<p>12312312</p>" [
        //     [Prototype]
        // ]: Object
        // gender: "0"
        // name: "Việt Anh"
        // phone: "0394252608"
        // status: "1"
        // username: "abcd"
        const genderText = gender === "0" ? "Female" : "Male";
        const age = ["", "null"].includes(date_of_birth) ? "" : getAge(date_of_birth) + " year old";
        const basicInfoRender = `
                    <div class="row">
                    <div class="col-8">
                        <div class="row pt-3">
                            <div class="col">
                                <label class="col-form-label"><i class="fas fa-2x fa-file-signature text-success"></i></label>
                            </div>
                            <div class="col-11">
                                <label class="col-form-label shadow-sm w-100 h-100 d-flex align-items-center justify-content-center fw-bold"><p data-toggle="tooltip" data-bs-placement="bottom" title="${name}">${name}</p></label>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col">
                                <label class="col-form-label"><i class="fas fa-2x fa-venus-mars text-success"></i></label>
                            </div>
                            <div class="col-11">
                                <label class="col-form-label shadow-sm w-100 h-100 d-flex align-items-center justify-content-center fw-bold"><p data-toggle="tooltip" data-bs-placement="bottom" title="${genderText}">${genderText}</p></label>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col">
                                <label class="col-form-label"><i class="fas fa-2x fa-birthday-cake text-success"></i></label>
                            </div>
                            <div class="col-11">
                                <label class="col-form-label shadow-sm w-100 h-100 d-flex align-items-center justify-content-center fw-bold"><p data-toggle="tooltip" data-bs-placement="bottom" title="${age}">${age}</p></label>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col">
                                <label class="col-form-label"><i class="fas fa-2x fa-address-book text-success"></i></label>
                            </div>
                            <div class="col-11">
                                <label class="col-form-label shadow-sm w-100 h-100 d-flex align-items-center justify-content-center fw-bold"><p data-toggle="tooltip" data-bs-placement="bottom" title="${address}">${address}</p></label>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col">
                                <label class="col-form-label"><i class="fas fa-2x fa-briefcase text-success"></i></label>
                            </div>
                            <div class="col-11">
                                <label class="col-form-label shadow-sm w-100 h-100 d-flex align-items-center justify-content-center fw-bold text-uppercase"><p data-toggle="tooltip" data-bs-placement="bottom" title="${desired_job}">${desired_job}</p></label>
                            </div>
                        </div>
                        ${detail.careerGoals && `<div class="row pt-3">
                            <div class="col-12 h4 fw-bold">
                                <label class="col-form-label">${detail.careerGoals}</label>
                            </div>
                        </div>`}
                    </div>
                    <div class="col-4">
                        <img src="./img/${gender === "0" ? "woman.png" : "man.png"}" class="img-fluid">
                    </div>
                    </div>
        `;
        const certificateRender = detail.certificate ? `
        <div class="tab-pane pt-2 fade" id="nav-certificate" role="tabpanel" aria-labelledby="nav-certificate-tab" style="background-color: #FFFFFF;">
        <div class="row"><div class="col-12">${detail.certificate}</div></div>
        </div>
        ` : "";
        const educationRender = detail.education ? `
        <div class="tab-pane pt-2 fade" id="nav-education" role="tabpanel" aria-labelledby="nav-education-tab" style="background-color: #FFFFFF;">
        <div class="row"><div class="col-12">${detail.education}</div></div>
        </div>
        ` : "";
        const experienceRender = detail.experience ? `
        <div class="tab-pane pt-2 fade" id="nav-experience" role="tabpanel" aria-labelledby="nav-experience-tab" style="background-color: #FFFFFF;">
        <div class="row"><div class="col-12">${detail.experience}</div></div>
        </div>
        ` : "";
        const skillRender = detail.skill ? `
        <div class="tab-pane pt-2 fade" id="nav-skill" role="tabpanel" aria-labelledby="nav-skill-tab" style="background-color: #FFFFFF;">
        <div class="row"><div class="col-12">${detail.skill}</div></div>
        </div>
        ` : "";
        contactData.cv_id = cv_id;
        DOM.detailModalBody.innerHTML = `<nav>
                <div class="nav nav-pills nav-justified nav-tabs custom-nav-tabs" id="nav-tab" role="tablist">
                    <span class="nav-link active custom-nav-link fw-bold" id="nav-basic-infomation-tab" data-bs-toggle="tab" data-bs-target="#nav-basic-infomation" type="button" role="tab" aria-controls="nav-basic-infomation" aria-selected="true">Basic</span>
                    ${certificateRender && `<span class="nav-link custom-nav-link fw-bold position-relative" id="nav-certificate-tab" data-bs-toggle="tab" data-bs-target="#nav-certificate" type="button" role="tab" aria-controls="nav-certificate" aria-selected="false">Certificate
                    </span>`}
                    ${educationRender && `<span class="nav-link custom-nav-link fw-bold position-relative" id="nav-education-tab" data-bs-toggle="tab" data-bs-target="#nav-education" type="button" role="tab" aria-controls="nav-education" aria-selected="false">Education
                    </span>`} 
                    ${experienceRender && `<span class="nav-link custom-nav-link fw-bold position-relative" id="nav-experience-tab" data-bs-toggle="tab" data-bs-target="#nav-experience" type="button" role="tab" aria-controls="nav-experience" aria-selected="false">Experience
                    </span>`} 
                    ${skillRender && `<span class="nav-link custom-nav-link fw-bold position-relative" id="nav-skill-tab" data-bs-toggle="tab" data-bs-target="#nav-skill" type="button" role="tab" aria-controls="nav-skill" aria-selected="false">Skill
                    </span>`}
                    <span class="nav-link custom-nav-link fw-bold position-relative" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Contact
                    </span>
                </div>
            </nav>
            <div class="tab-content mt-3" id="nav-tabContent">
                <div class="tab-pane pt-2 fade show active" id="nav-basic-infomation" role="tabpanel" aria-labelledby="nav-basic-infomation-tab">
                    ${basicInfoRender}
                </div>
                ${certificateRender}
                ${educationRender}
                ${experienceRender}
                ${skillRender}
                <div class="tab-pane pt-2 fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" style="background-color: #FFFFFF;">
                    <div class="row">
                        <div class="row mb-2">
                            <div class="col-2">
                                <label class="col-form-label fw-bold h4">Name</label>
                                </div>
                                <div class="col-10">
                                    <input type="text" class="form-control w-100 h-100" id="txtContactName" name="txtContactName" placeholder="Name..." onchange="onChangeInput('txtContactName')">
                                </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-2">
                                <label class="col-form-label fw-bold h4">Phone</label>
                                </div>
                                <div class="col-10">
                                    <input type="tel" class="form-control w-100 h-100" id="txtContactPhone" name="txtContactPhone" placeholder="Phone..." onchange="onChangeInput('txtContactPhone')">
                                </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-2">
                                <label class="col-form-label fw-bold h4">Email</label>
                                </div>
                                <div class="col-10">
                                    <input type="text" class="form-control w-100 h-100" id="txtContactEmail" name="txtContactEmail" placeholder="Email..." onchange="onChangeInput('txtContactEmail')">
                                </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-2">
                                <label class="col-form-label fw-bold h4">Message</label>
                                </div>
                                <div class="col-10">
                                    <div class="form-floating">
                                        <textarea class="form-control" rows="5" placeholder="Message..." id="txtContactMessage" name="txtContactMessage" onchange="onChangeInput('txtContactMessage')"></textarea>
                                        <label>Message</label>
                                    </div>
                                </div>
                        </div>
                            <div class="col-12 pt-2">
                                <button id="sendContactBtn" class="btn btn-outline-success w-100" onclick="onSendContactData()" disabled>Send</button>
                            </div>
                    </div>
                </div>
            </div>`;
    }
</script>
</html>