<?php
include('../functions.php');
authorized();
handleRoute();
$name = $_SESSION["user_firstname"] . " " . $_SESSION["user_lastname"];
$user_id = $_SESSION["user_id"];
$token = $_COOKIE["token"];
$contacts = getContacts($token);
$cvInfo = getCVInfoPersonal($token);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>User portral</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="../img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/animate/animate.min.css" rel="stylesheet">
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/custom.css" rel="stylesheet">
    <!-- datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <!-- kit -->
    <script src="https://kit.fontawesome.com/1c8503ddd9.js" crossorigin="anonymous"></script>
</head>

<body>
    <div id="toast-container" class="toast-container position-absolute bottom-0 end-0 p-3 bottom-center">
    </div>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-success" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <nav class="navbar navbar-expand-sm bg-white navbar-light sticky-top p-0 shadow">
        <div class="container-fluid p-0 justify-content-start">
            <a href="../index.php" class="btn btn-success rounded-0 p-4 d-flex align-items-center justify-content-center">
                <i class="d-inline fa fa-arrow-left ms-3 me-3"></i>
            </a>
            <a class="navbar-brand h1 d-flex align-items-center text-uppercase p-0 m-0">
                <img src="../img/logo.png" alt="" width="auto" height="50" class="d-inline-block align-text-top">
                &nbsp;Create your CV & Find the right job
            </a>
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <span class="nav-link dropdown-toggle border border-success rounded-pill text-center p-2" role="button" style="width: 10rem;">
                        <?php echo $name; ?>
                    </span>
                    <ul class="dropdown-menu dropdown-menu-start p-3 border border-success border-3 rounded-3" aria-labelledby="navbarDropdown">
                        <li>
                            <div class="d-flex flex-column">
                                <p class="text-uppercase"><?php echo $name; ?></p>
                                <p class="text-uppercase">id: <b class="fs-6">#<?php echo $user_id; ?></b></p>
                            </div>
                        </li>
                        <li>
                            <form class="text-center mt-1 mb-1 pr-0 pl-0" action="./index.php" method="POST">
                                <?php
                                if (isset($_POST["logoutBtn"])) {
                                    logout();
                                }
                                ?>
                                <button class="btn btn-outline-danger rounded-pill w-100" type="submit" name="logoutBtn" id="logoutBtn"><i class="fas fa-sign-out-alt"></i>&nbsp;&nbsp;&nbsp;Log out</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    <div class="container-fluid pt-3 custom-linear-gradient-background-container">
        <div class="container wow slideInRight" data-wow-delay="1s">
            <nav>
                <div class="nav nav-pills nav-justified nav-tabs custom-nav-tabs" id="nav-tab" role="tablist">
                    <span class="nav-link rounded-pill active custom-nav-link fw-bold" id="nav-cv-infomation-tab" data-bs-toggle="tab" data-bs-target="#nav-cv-infomation" type="button" role="tab" aria-controls="nav-cv-infomation" aria-selected="true">Your CV</span>
                    <span class="nav-link rounded-pill custom-nav-link fw-bold position-relative" id="nav-contacts-tab" data-bs-toggle="tab" data-bs-target="#nav-contacts" type="button" role="tab" aria-controls="nav-contacts" aria-selected="false">Contacts list
                        <?php
                        if (count($contacts) > 0) {
                            echo '<span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                            <span class="visually-hidden">New alerts</span>
                        </span>';
                        }
                        ?>
                    </span>
                </div>
            </nav>
            <div class="tab-content mt-3" id="nav-tabContent" style="min-height: 100vh;">
                <div class="tab-pane pt-2 fade show active" id="nav-cv-infomation" role="tabpanel" aria-labelledby="nav-cv-infomation-tab">
                    <div class="row d-flex justify-content-between pt-3 pb-3">
                        <div class="col-7">
                            <div class="p-0 row mb-2 p-2 rounded custom-editor-area" id="skillArea">
                            </div>
                            <div class="p-0 row mb-2 p-2 rounded custom-editor-area" id="certificateArea">
                            </div>
                            <div class="p-0 row mb-2 p-2 rounded custom-editor-area" id="experienceArea">
                            </div>
                            <div class="p-0 row mb-2 p-2 rounded custom-editor-area" id="educationArea">
                            </div>
                        </div>
                        <div class="col-4 pl-3 rounded personal-infomation-container rounded">
                            <div class="row p-2 mb-4">
                                <div class="text-center h4 text-center fw-bold">
                                    Personal Infomation
                                </div>
                                <img src="../img/<?php echo $_SESSION["gender"] ? "man.png" : "woman.png" ?>" class="img-thumbnail rounded-circle" width="100%">
                            </div>
                            <div class="p-0 row flex-nowrap mb-1" id="nameArea">
                            </div>
                            <div class="p-0 row flex-nowrap mb-1" id="dateOfBirthArea">
                            </div>
                            <div class="p-0 row flex-nowrap mb-1" id="addressArea">
                            </div>
                            <div class="p-0 row flex-nowrap mb-1" id="phoneArea">
                            </div>
                            <div class="p-0 row flex-nowrap mb-4" id="deriseJobArea">
                            </div>
                            <div class="row p-0 m-0 mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="switchStatus" onchange="onChangeInput('switchStatus')">
                                    <label class="form-check-label ml-2" for="flexSwitchCheckChecked">Job search status</label>
                                </div>
                            </div>
                            <div class="p-0 row flex-nowrap mb-4" id="careerGoalsArea">
                            </div>
                            <div class="p-0 row flex-nowrap mb-1">
                                <div class="col-12">
                                    <button id="saveCVBtn" class="btn btn-success w-100" onclick="onSaveCVData()" disabled>Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane pt-2 fade" id="nav-contacts" role="tabpanel" aria-labelledby="nav-contacts-tab" style="min-height: 100vh;background-color: #FFFFFF;">
                    <div class="row p-2">
                        <table id="tableContacts" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Phone number</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($contacts as $contact) {
                                ?>
                                    <tr>
                                        <td><?php echo $contact["contact_id"] ?></td>
                                        <td><?php echo $contact["contact_name"] ?></td>
                                        <td><?php echo $contact["phone"] ?></td>
                                        <td><?php echo $contact["email"] ?></td>
                                        <td><?php echo $contact["message"] ?></td>
                                        <td><span class="btn btn-danger w-100 delete-contact-btn" onclick="onDeleteContact('<?php echo $contact['contact_id'] ?>')"><i class="fas fa-trash-alt"></i></span></td>
                                    </tr>
                                <?php
                                };
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/wow/wow.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/counterup/counterup.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../lib/isotope/isotope.pkgd.min.js"></script>
    <script src="../lib/lightbox/js/lightbox.min.js"></script>
    <!-- datatable -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
    <script src="../js/index.js"></script>
    <!-- Toast -->
    <script src="../js/toast.js"></script>
    <!-- richtext-editor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>
</body>
<script>
    let tableContacts = null;
    let deleteCurrentDeleteBtnHoverIn = null;
    $(document).ready(function() {
        tableContacts = $('#tableContacts').DataTable({
            search: {
                return: true,
            },
        });
    });

    const onDeleteContact = (contactId) => {
        if (!contactId) {
            return
        }
        const DOM = getDOMControl();
        const formData = new FormData();
        formData.append("contact_id", contactId)
        DOM.allDeleteContactBtn.forEach(elm => {
            elm.disabled = true
        })
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "../fetch/post/removeContact.php",
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
                if (success) {
                    deleteCurrentDeleteBtnHoverIn && tableContacts.row($(deleteCurrentDeleteBtnHoverIn).parents('tr')).remove().draw();
                    if(tableContacts.rows().count() === 0){
                        DOM.contactsTab.innerHTML = "Contacts list";
                    }
                    $.toast({
                        type: 'success',
                        title: 'Notification',
                        content: 'Success',
                        delay: 3000,
                    })
                };
                error && $.toast({
                    type: 'error',
                    title: 'Notification',
                    content: 'Error',
                    delay: 3000,
                });
                DOM.allDeleteContactBtn.forEach(elm => {
                    elm.disabled = false;
                })
            },
            error: function(err) {
                console.log(err)
                $.toast({
                    type: 'error',
                    title: 'Notification',
                    content: 'Error',
                    delay: 3000,
                });
                DOM.allDeleteContactBtn.forEach(elm => {
                    elm.disabled = false;
                })
            }
        });
    }
    const CVData = {
        cv_id: "<?php echo $cvInfo["cv_id"] ?>",
        name: "<?php echo $cvInfo["name"] == "null" ? "" : $cvInfo["name"] ?>",
        date_of_birth: "<?php echo $cvInfo["date_of_birth"] == "null" ? "" : $cvInfo["date_of_birth"] ?>",
        address: "<?php echo $cvInfo["address"] == "null" ? "" : $cvInfo["address"] ?>",
        phone: "<?php echo $cvInfo["phone"] == "null" ? "" : $cvInfo["phone"] ?>",
        detail: <?php echo $cvInfo["detail"] == "null" ? '{careerGoals: "",skill: "",certificate: "",experience: "",education: ""}' : $cvInfo["detail"] ?>,
        desiredJob: "<?php echo $cvInfo["desired_job"] == "null" ? "" : $cvInfo["desired_job"] ?>",
        status: <?php echo $cvInfo["status"] == "0" ? "false" : "true" ?>
    }
    const cloneCVDataString = JSON.stringify(CVData);
    const isValidCVData = () => {
        const {
            cv_id,
            name,
            date_of_birth,
            address,
            phone,
            desiredJob
        } = CVData;
        const isSameAsOldData = cloneCVDataString === JSON.stringify(CVData);
        const isfullRequiredData = Boolean(cv_id) && Boolean(name) && Boolean(date_of_birth) && Boolean(address) && Boolean(phone) && Boolean(desiredJob) && true;
        return !isSameAsOldData && isfullRequiredData && true;
    }
    const getDOMControl = () => {
        return {
            nameInput: document.getElementById("txtName"),
            nameArea: document.getElementById("nameArea"),
            dateOfBirthInput: document.getElementById("txtDateOfBirth"),
            dateOfBirthArea: document.getElementById("dateOfBirthArea"),
            addressInput: document.getElementById("txtAddress"),
            addressArea: document.getElementById("addressArea"),
            phoneInput: document.getElementById("txtPhone"),
            phoneArea: document.getElementById("phoneArea"),
            deriseJobInput: document.getElementById("txtDeriseJob"),
            deriseJobArea: document.getElementById("deriseJobArea"),
            careerGoalsInput: document.getElementById("txtCareerGoals"),
            careerGoalsArea: document.getElementById("careerGoalsArea"),
            statusSwitch: document.getElementById("switchStatus"),
            skillArea: document.getElementById("skillArea"),
            skillInput: document.getElementById("txtSkill"),
            certificateArea: document.getElementById("certificateArea"),
            certificateInput: document.getElementById("txtCertificate"),
            experienceArea: document.getElementById("experienceArea"),
            experienceInput: document.getElementById("txtExperience"),
            educationArea: document.getElementById("educationArea"),
            educationInput: document.getElementById("txtEducation"),
            windowEditor: window.editor,
            saveCVBtn: document.getElementById("saveCVBtn"),
            allDeleteContactBtn: document.querySelectorAll(".delete-contact-btn"),
            contactsTab: document.getElementById("nav-contacts-tab")
        }
    }
    const onChangeInput = (inputId) => {
        const DOM = getDOMControl();
        switch (inputId) {
            case "txtName":
                CVData.name = DOM.nameInput.value
                break;
            case "txtDateOfBirth":
                CVData.date_of_birth = DOM.dateOfBirthInput.value
                break;
            case "txtAddress":
                CVData.address = DOM.addressInput.value
                break;
            case "txtPhone":
                CVData.phone = DOM.phoneInput.value
                break;
            case "txtDeriseJob":
                CVData.desiredJob = DOM.deriseJobInput.value
                break;
            case "txtCareerGoals":
                CVData.detail.careerGoals = DOM.careerGoalsInput.value
                break;
            case "switchStatus":
                CVData.status = DOM.statusSwitch.checked
                break;
            case "txtSkill":
                CVData.detail.skill = window.editor.getData();
                break;
            case "txtCertificate":
                CVData.detail.certificate = window.editor.getData();
                break;
            case "txtExperience":
                CVData.detail.experience = window.editor.getData();
                break;
            case "txtEducation":
                CVData.detail.education = window.editor.getData();
                break;
            default:
                break;
        }
        DOM.saveCVBtn.disabled = !isValidCVData();
    }
    const onBlurInput = () => {
        initializationLabel()
    }

    const initializationOnClick = () => {
        const DOM = getDOMControl();
        DOM.nameArea.onclick = (e) => {
            DOM.nameArea.innerHTML = `<div class="col-2">
                <label class="col-form-label"><i class="fas fa-2x fa-file-signature text-dark"></i></label>
            </div>
            <div class="col-10">
             <input type="text" class="form-control w-100 h-100" value="${CVData.name}" id="txtName" name="txtName" placeholder="Name" onchange="onChangeInput('txtName')" onblur="onBlurInput()">
            </div>`;
            DOM.nameArea.onclick = null;
            focusIsHaveInput();
        }
        DOM.dateOfBirthArea.onclick = (e) => {
            DOM.dateOfBirthArea.innerHTML = `<div class="col-2">
                <label class="col-form-label"><i class="fas fa-2x fa-birthday-cake text-dark"></i></label>
            </div>
            <div class="col-10">
             <input type="date" class="form-control w-100 h-100" value="${CVData.date_of_birth}" id="txtDateOfBirth" name="txtDateOfBirth" placeholder="Date of birth" onchange="onChangeInput('txtDateOfBirth')" onblur="onBlurInput()">
            </div>`;
            DOM.dateOfBirthArea.onclick = null;
            focusIsHaveInput();
        }
        DOM.addressArea.onclick = (e) => {
            DOM.addressArea.innerHTML = `<div class="col-2">
                <label class="col-form-label"><i class="fas fa-2x fa-address-book text-dark"></i></label>
            </div>
            <div class="col-10">
             <input type="text" class="form-control w-100 h-100" value="${CVData.address}" id="txtAddress" name="txtAddress" placeholder="Address" onchange="onChangeInput('txtAddress')" onblur="onBlurInput()">
            </div>`;
            DOM.addressArea.onclick = null;
            focusIsHaveInput();
        }
        DOM.phoneArea.onclick = (e) => {
            DOM.phoneArea.innerHTML = `
            <div class="col-2">
                <label class="col-form-label"><i class="fas fa-2x fa-mobile text-dark"></i></label>
            </div>
            <div class="col-10">
             <input type="tel" class="form-control w-100 h-100" value="${CVData.phone}" id="txtPhone" name="txtPhone" placeholder="Phone number" onchange="onChangeInput('txtPhone')" onblur="onBlurInput()">
            </div>`;
            DOM.phoneArea.onclick = null;
            focusIsHaveInput();
        }
        DOM.deriseJobArea.onclick = (e) => {
            DOM.deriseJobArea.innerHTML = `
            <div class="col-2">
                <label class="col-form-label"><i class="fas fa-2x fa-briefcase text-dark"></i></label>
            </div>
            <div class="col-10">
                <input class="form-control w-100 h-100" list="datalistOptionsOccupation" id="txtDeriseJob" name="txtDeriseJob" value="${CVData.desiredJob}" placeholder="Type to search job..." onchange="onChangeInput('txtDeriseJob')" onblur="onBlurInput()">
                    <datalist id="datalistOptionsOccupation">
                        ${[...occupations].map(occupation => `<option value="${occupation}" class="text-uppercase">${occupation}</option>`).join("")}
                    </datalist>
            </div>`;
            DOM.deriseJobArea.onclick = null;
            focusIsHaveInput();
        }
        DOM.careerGoalsArea.onclick = (e) => {
            DOM.careerGoalsArea.innerHTML = `
            <div class="col-2">
                <label class="col-form-label"><i class="fas fa-2x fa-align-justify text-dark"></i></label>
            </div>
            <div class="col-10">
            <div class="form-floating">
                <textarea class="form-control" rows="5" placeholder="Career goals..." id="txtCareerGoals" name="txtCareerGoals" onchange="onChangeInput('txtCareerGoals')" onblur="onBlurInput()">${CVData.detail.careerGoals}</textarea>
                <label>Career Goals</label>
            </div>
            </div>`;
            DOM.careerGoalsArea.onclick = null;
            focusIsHaveInput();
        }
        DOM.educationArea.onclick = (e) => {
            DOM.educationArea.innerHTML = `
            <div class="col-12 fw-bold h3">Education</div>
            <div class="col-12">
                <div id="txtEducation"></div>
            </div>`;
            DOM.educationArea.click = null;
            ClassicEditor
                .create(document.querySelector('#txtEducation')).then(editor => {
                    window.editor = editor;
                    window.editor.setData(CVData.detail.education);
                    window.editor.focus();
                    window.editor.model.document.on('change:data', () => {
                        onChangeInput("txtEducation");
                    });
                    window.editor.ui.focusTracker.on('change:isFocused', (evt, name, isFocused) => {
                        if (!isFocused) {
                            window.editor.destroy().then(() => {
                                    window.editor = null;
                                    initializationLabel()
                                })
                                .catch(error => {
                                    console.log(error);
                                });
                        }
                    });
                })
                .catch(error => {
                    console.error(error);
                });
            focusIsHaveInput();
        }
        DOM.skillArea.onclick = (e) => {
            DOM.skillArea.innerHTML = `
            <div class="col-12 fw-bold h3">Skill</div>
            <div class="col-12">
                <div id="txtSkill"></div>
            </div>`;
            DOM.skillArea.onclick = null;
            ClassicEditor
                .create(document.querySelector('#txtSkill')).then(editor => {
                    window.editor = editor;
                    window.editor.setData(CVData.detail.skill)
                    window.editor.focus();
                    window.editor.model.document.on('change:data', () => {
                        onChangeInput("txtSkill");
                    });
                    window.editor.ui.focusTracker.on('change:isFocused', (evt, name, isFocused) => {
                        if (!isFocused) {
                            window.editor.destroy().then(() => {
                                    window.editor = null;
                                    initializationLabel()
                                })
                                .catch(error => {
                                    console.log(error);
                                });
                        }
                    });
                })
                .catch(error => {
                    console.error(error);
                });
            focusIsHaveInput();
        }
        DOM.certificateArea.onclick = (e) => {
            DOM.certificateArea.innerHTML = `
            <div class="col-12 fw-bold h3">Education</div>
            <div class="col-12">
                <div id="txtCertificate"></div>
            </div>`;
            DOM.certificateArea.onclick = null;
            ClassicEditor
                .create(document.querySelector('#txtCertificate')).then(editor => {
                    window.editor = editor;
                    window.editor.setData(CVData.detail.certificate)
                    window.editor.focus();
                    window.editor.model.document.on('change:data', () => {
                        onChangeInput("txtCertificate");
                    });
                    window.editor.ui.focusTracker.on('change:isFocused', (evt, name, isFocused) => {
                        if (!isFocused) {
                            window.editor.destroy().then(() => {
                                    window.editor = null;
                                    initializationLabel()
                                })
                                .catch(error => {
                                    console.log(error);
                                });
                        }
                    });
                })
                .catch(error => {
                    console.error(error);
                });
            focusIsHaveInput();
        }
        DOM.experienceArea.onclick = (e) => {
            DOM.experienceArea.innerHTML = `
            <div class="col-12 fw-bold h3">Education</div>
            <div class="col-12">
                <div id="txtExperience"></div>
            </div>`;
            DOM.experienceArea.onclick = null;
            ClassicEditor
                .create(document.querySelector('#txtExperience')).then(editor => {
                    window.editor = editor;
                    window.editor.setData(CVData.detail.experience)
                    window.editor.focus();
                    window.editor.model.document.on('change:data', () => {
                        onChangeInput("txtExperience");
                    });
                    window.editor.ui.focusTracker.on('change:isFocused', (evt, name, isFocused) => {
                        if (!isFocused) {
                            window.editor.destroy().then(() => {
                                    window.editor = null;
                                    initializationLabel()
                                })
                                .catch(error => {
                                    console.log(error);
                                });
                        }
                    });
                })
                .catch(error => {
                    console.error(error);
                });
            focusIsHaveInput();
        }
        DOM.saveCVBtn.onclick = (e) => {
            e.preventDefault();
            const formData = new FormData();
            formData.append("cv_id", CVData.cv_id)
            formData.append("name", CVData.name)
            formData.append("address", CVData.address)
            formData.append("phone", CVData.phone)
            formData.append("date_of_birth", CVData.date_of_birth)
            formData.append("detail", JSON.stringify(CVData.detail))
            formData.append("status", CVData.status ? "1" : "0")
            formData.append("desired_job", CVData.desiredJob)
            e.target.disabled = true;
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: "../fetch/post/updateCV.php",
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
                    e.target.disabled = false;
                },
                error: function(err) {
                    console.log(err)
                    $.toast({
                        type: 'error',
                        title: 'Notification',
                        content: 'Error',
                        delay: 3000,
                    });
                    e.target.disabled = false;
                }
            });
        }
        DOM.allDeleteContactBtn.forEach(elm => {
            elm.onmouseover = (e) => {
                deleteCurrentDeleteBtnHoverIn = e.target;
                console.log("[deleteCurrentDeleteBtnHoverIn]", deleteCurrentDeleteBtnHoverIn)
            }
        })
    }
    const focusIsHaveInput = () => {
        const DOM = getDOMControl();
        if (DOM.addressInput) DOM.addressInput.focus();
        if (DOM.nameInput) DOM.nameInput.focus();
        if (DOM.dateOfBirthInput) DOM.dateOfBirthInput.focus();
        if (DOM.phoneInput) DOM.phoneInput.focus();
        if (DOM.deriseJobInput) DOM.deriseJobInput.focus();
    }
    const initializationLabel = () => {
        const DOM = getDOMControl();
        if (DOM.nameArea) DOM.nameArea.innerHTML = `<div class="col-2">
                <label class="col-form-label"><i class="fas fa-2x fa-file-signature text-dark"></i></label>
            </div>
            <div class="col-10">
                <label class="col-form-label btn btn-light shadow-sm w-100 h-100 d-flex align-items-center"><p data-toggle="tooltip" data-bs-placement="bottom" title="${CVData.name}">${CVData.name}</p></label>
            </div>`;
        if (DOM.dateOfBirthArea) DOM.dateOfBirthArea.innerHTML = `<div class="col-2">
                <label class="col-form-label"><i class="fas fa-2x fa-birthday-cake text-dark"></i></label>
            </div>
            <div class="col-10">
                <label class="col-form-label btn btn-light shadow-sm w-100 h-100 d-flex align-items-center"><p data-toggle="tooltip" data-bs-placement="bottom" title="${CVData.date_of_birth}">${CVData.date_of_birth}</p></label>
            </div>`;
        if (DOM.addressArea) DOM.addressArea.innerHTML = `<div class="col-2">
                <label class="col-form-label"><i class="fas fa-2x fa-address-book text-dark"></i></label>
            </div>
            <div class="col-10">
                <label class="col-form-label btn btn-light shadow-sm w-100 h-100 d-flex align-items-center"><p data-toggle="tooltip" data-bs-placement="bottom" title="${CVData.address}">${CVData.address}</p></label>
            </div>`;
        if (DOM.phoneArea) DOM.phoneArea.innerHTML = `<div class="col-2">
                <label class="col-form-label"><i class="fas fa-2x fa-mobile text-dark"></i></label>
            </div>
            <div class="col-10">
                <label class="col-form-label btn btn-light shadow-sm w-100 h-100 d-flex align-items-center"><p data-toggle="tooltip" data-bs-placement="bottom" title="${CVData.phone}">${CVData.phone}</p></label>
            </div>`;
        if (DOM.deriseJobArea) DOM.deriseJobArea.innerHTML = `<div class="col-2">
                <label class="col-form-label"><i class="fas fa-2x fa-briefcase text-dark"></i></label>
            </div>
            <div class="col-10">
                <label class="col-form-label btn btn-light shadow-sm w-100 h-100 d-flex align-items-center"><p class="text-uppercase" data-toggle="tooltip" data-bs-placement="bottom" title="${CVData.desiredJob}">${CVData.desiredJob}</p></label>
            </div>`;
        if (DOM.careerGoalsArea) DOM.careerGoalsArea.innerHTML = `<div class="col-2">
                <label class="col-form-label"><i class="fas fa-2x fa-align-justify text-dark"></i></label>
            </div>
            <div class="col-10">
                <label class="col-form-label btn btn-light shadow-sm w-100 h-100 d-flex align-items-center" ><p data-toggle="tooltip" data-bs-placement="bottom" title="${CVData.detail.careerGoals}">${CVData.detail.careerGoals}</p></label>
            </div>`;
        if (DOM.skillArea) DOM.skillArea.innerHTML = `
             <div class="col-12 fw-bold h3">Skill</div>
            <div class="col-12 text-break">
            ${CVData.detail.skill || `<label class="col-form-label btn btn-light shadow-sm w-100 h-100 d-flex align-items-center"><p>Click to edit...</p></lablel>`}
            </div>`;
        if (DOM.educationArea) DOM.educationArea.innerHTML = `
            <div class="col-12 fw-bold h3">Education</div>
            <div class="col-12 text-break">
            ${CVData.detail.education|| `<label class="col-form-label btn btn-light shadow-sm w-100 h-100 d-flex align-items-center"><p>Click to edit...</p></lablel>`}
            </div>`;
        if (DOM.experienceArea) DOM.experienceArea.innerHTML = `
            <div class="col-12 fw-bold h3">Experience</div>
            <div class="col-12 text-break">
            ${CVData.detail.experience || `<label class="col-form-label btn btn-light shadow-sm w-100 h-100 d-flex align-items-center"><p>Click to edit...</p></lablel>`}
            </div>`;
        if (DOM.certificateArea) DOM.certificateArea.innerHTML = `
            <div class="col-12 fw-bold h3">Certificate</div>
            <div class="col-12 text-break">
            ${CVData.detail.certificate || `<label class="col-form-label btn btn-light shadow-sm w-100 h-100 d-flex align-items-center"><p>Click to edit...</p></lablel>`}
            </div>`;
        DOM.statusSwitch.checked = CVData.status;
        initializationOnClick();
    }
    initializationLabel();
</script>

</html>