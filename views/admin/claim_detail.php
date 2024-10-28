<?php
session_start();
require_once '../../config/db.php';
require_once '../../controllers/AdminController.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    exit();
}

$adminController = new AdminController($pdo);

// Get claim ID from URL
$claimId = $_GET['id'] ?? null;

if ($claimId) {
    // Fetch claim details
    $claim = $adminController->getClaimById($claimId);

    if (!$claim) {
        echo "Claim not found.";
        exit();
    }
} else {
    echo "No claim ID provided.";
    exit();
}

// Handle Approve/Reject actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $adminController->updateClaimStatus($claimId, $action === 'approve' ? 'Approved' : 'Rejected');
}

?>
<!DOCTYPE html>

<html lang="en">
	<!--begin::Head-->
	<head><base href=""/>
		<title>Claim Gate</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<!-- <link rel="shortcut icon" href="../../assets/media/logos/favicon.ico" /> -->
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Vendor Stylesheets(used for this page only)-->
		<link href="../../assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
		<link href="../../assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="../../assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="../../assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="../../css/styles.css">
		<!--end::Global Stylesheets Bundle-->
		<script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>

	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" data-kt-app-aside-enabled="true" data-kt-app-aside-fixed="true" data-kt-app-aside-push-toolbar="true" data-kt-app-aside-push-footer="true" class="app-default">
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::App-->
		<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
			<!--begin::Page-->
			<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
				<!--begin::Header-->
				<div id="kt_app_header" class="app-header d-flex flex-column flex-stack">
					<!--begin::Header main-->
					<div class="d-flex align-items-center flex-stack flex-grow-1">
						<div class="app-header-logo d-flex align-items-center flex-stack px-lg-11 mb-2" id="kt_app_header_logo">
							<!--begin::Sidebar mobile toggle-->
							<div class="btn btn-icon btn-active-color-primary w-35px h-35px ms-3 me-2 d-flex d-lg-none" id="kt_app_sidebar_mobile_toggle">
								<i class="ki-duotone ki-abstract-14 fs-2">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
							</div>
							<!--end::Sidebar mobile toggle-->
							<!--begin::Logo-->
							<div class="fw-bolder fs-4">
							ClaimGate
							</div>
							<!--end::Logo-->
						</div>
						<!--begin::Navbar-->
						<div class="app-navbar flex-grow-1 justify-content-end" id="kt_app_header_navbar">
							<div class="app-navbar-item d-flex align-items-stretch flex-lg-grow-1 me-2 me-lg-0">
							</div>
							<!--begin::User menu-->
							<div class="app-navbar-item ms-3 ms-lg-4 me-lg-2" id="kt_header_user_menu_toggle">
								<!--begin::Menu wrapper-->
								<div class="cursor-pointer symbol symbol-30px symbol-lg-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
									<img src="../../assets/media/avatars/300-2.jpg" alt="user" />
								</div>
								<!--begin::User account menu-->
								<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
									<!--begin::Menu item-->
									<div class="menu-item px-3">
										<div class="menu-content d-flex align-items-center px-3">
											<!--begin::Avatar-->
											<div class="symbol symbol-50px me-5">
												<img alt="Logo" src="../../assets/media/avatars/300-2.jpg" />
											</div>
											<!--end::Avatar-->
											<!--begin::Username-->
											<div class="d-flex flex-column">
												<div class="fw-bold d-flex align-items-center fs-5">Jane Cooper
												<span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Pro</span></div>
												<a href="#" class="fw-semibold text-muted text-hover-primary fs-7">jane@kt.com</a>
											</div>
											<!--end::Username-->
										</div>
									</div>
									<!--end::Menu item-->
									<!--begin::Menu separator-->
									<div class="separator my-2"></div>
									<!--end::Menu separator-->
									<!--begin::Menu item-->
									<div class="menu-item px-5">
										<a href="../dist/account/overview.html" class="menu-link px-5">My Profile</a>
									</div>
									<!--end::Menu item-->
								</div>
								<!--end::User account menu-->
								<!--end::Menu wrapper-->
							</div>
							<!--end::User menu-->
							<!--begin::Header menu toggle-->
							<div class="app-navbar-item ms-3 ms-lg-4 ms-n2 me-3 d-flex d-lg-none">
								<div class="btn btn-icon btn-custom btn-color-gray-600 btn-active-color-primary w-35px h-35px w-md-40px h-md-40px" id="kt_app_aside_mobile_toggle">
									<i class="ki-duotone ki-burger-menu-2 fs-2">
										<span class="path1"></span>
										<span class="path2"></span>
										<span class="path3"></span>
										<span class="path4"></span>
										<span class="path5"></span>
										<span class="path6"></span>
										<span class="path7"></span>
										<span class="path8"></span>
										<span class="path9"></span>
										<span class="path10"></span>
									</i>
								</div>
							</div>
							<!--end::Header menu toggle-->
						</div>
						<!--end::Navbar-->
					</div>
					<!--end::Header main-->
					<!--begin::Separator-->
					<div class="app-header-separator ms-10 me-10"></div>
					<!--end::Separator-->
				</div>
				<!--end::Header-->
				<!--begin::Wrapper-->
				<div class="app-wrapper flex-column flex-row-fluid ms-10 me-10" id="kt_app_wrapper">
					<!--begin::Main-->
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						<!--begin::Content wrapper-->
						<div class="d-flex flex-column flex-column-fluid">
							<!--begin::Toolbar-->
							<div id="kt_app_toolbar" class="app-toolbar pt-5">
								<!--begin::Toolbar container-->
								<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
									<!--begin::Toolbar wrapper-->
									<div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
										<!--begin::Page title-->
										<div class="page-title d-flex flex-column gap-1 me-3 mb-2">
											<!--begin::Breadcrumb-->
											<ul class="breadcrumb breadcrumb-separatorless fw-semibold mb-6">
												<!--begin::Item-->
												<li class="breadcrumb-item text-gray-700 fw-bold lh-1">
													<a href="index.php" class="text-gray-500">
														<i class="ki-duotone ki-home fs-3 text-gray-400 me-n1"></i>
													</a>
												</li>
												<!--end::Item-->
												<!--begin::Item-->
												<li class="breadcrumb-item">
													<i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
												</li>
												<!--end::Item-->
												<!--begin::Item-->
												<li class="breadcrumb-item text-gray-700 fw-bold lh-1">Dashboards</li>
												<!--end::Item-->
												<!--begin::Item-->
												<li class="breadcrumb-item">
													<i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
												</li>
												<!--end::Item-->
												<!--begin::Item-->
												<li class="breadcrumb-item text-gray-700">Claims</li>
												<!--end::Item-->
                                                <!--begin::Item-->
												<li class="breadcrumb-item">
													<i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
												</li>
												<!--end::Item-->
                                                <!--begin::Item-->
												<li class="breadcrumb-item text-gray-700">Claim</li>
												<!--end::Item-->
											</ul>
											<!--end::Breadcrumb-->
										</div>
										<!--end::Page title-->
									</div>
									<!--end::Toolbar wrapper-->
								</div>
								<!--end::Toolbar container-->
							</div>
							<!--end::Toolbar-->
							<!--begin::Content-->
							<div id="kt_app_content" class="app-content flex-column-fluid">
								<!--begin::Content container-->
								<div id="kt_app_content_container" class="app-container container-fluid">
									<!--begin::Row-->
									<div class="row gx-5 gx-xl-10">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between ">      
                                                    <h2 class="mt-auto mb-auto">Claim Details (ID: <?php echo htmlspecialchars($claim['id']); ?>)</h2>
                                                <div class="card-toolbar">
                                                    <button class="btn btn-light-warning">
                                                    Assign
                                                    </button>
                                                </div>
                                            </div>
                                        
                                            <div class="card-body">
                                            <div class="card border-0">
                                                <p><strong>Policyholder Name:</strong> <?php echo htmlspecialchars($claim['policyholder_name']); ?></p>
                                                <p><strong>Incident Type:</strong> <?php echo htmlspecialchars($claim['incident_type']); ?></p>
                                                <p><strong>Description:</strong> <?php echo htmlspecialchars($claim['description']); ?></p>
                                                <p><strong>Status:</strong> <?php echo htmlspecialchars($claim['status']); ?></p>
                                            </div>          
                                            <div class="card border-0 mt-10">
                                                <h3 class="mb-5">Uploaded Documents</h3>
                                                <div class="row">
                                                    <div class="col">
                                                        <a href="<?php echo htmlspecialchars($claim['insurance_certificate']); ?>" target="_blank">
                                                            <i class="ki-solid ki-file fs-3x text-gray-400 me-n1 text-center"></i>
                                                            <div>Insurance Certificate</div>
                                                        </a>
                                                    </div>
                                                    <div class="col">
                                                        <a href="<?php echo htmlspecialchars($claim['driving_license']); ?>" target="_blank">
                                                            <i class="ki-solid ki-file fs-3x text-gray-400 me-n1 text-center"></i>
                                                            <div>Driving License</div>
                                                        </a>
                                                    </div>
                                                    <div class="col">
                                                        <a href="<?php echo htmlspecialchars($claim['log_book']); ?>" target="_blank">
                                                            <i class="ki-solid ki-file fs-3x text-gray-400 me-n1 text-center"></i>
                                                            <div>Log Book</div>
                                                        </a>
                                                    </div>
                                                    <div class="col">
                                                        <a href="<?php echo htmlspecialchars($claim['police_report']); ?>" target="_blank">
                                                            <i class="ki-solid ki-file fs-3x text-gray-400 me-n1 text-center"></i>
                                                            <div>Police Report</div>
                                                        </a>
                                            </div>
                                            <?php if ($claim['damage_estimate']): ?>
                                                <div class="col">
                                                    <a href="<?php echo htmlspecialchars($claim['damage_estimate']); ?>" target="_blank">
                                                        <i class="ki-solid ki-file fs-3x text-gray-400 me-n1 text-center"></i>
                                                        <div>Damage Estimate</div>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                               
                                            </div>
                                            </div>
                                
                                            <div class="card-footer justify-content-end align-items-end">
                                                <form method="POST" style="all: unset; display: flex; gap: 10px;" class="align-self-end">
                                                    <button class="btn btn-success" type="submit" name="action" value="approve">Approve Claim</button>
                                                    <button class="btn btn-danger" type="submit" name="action" value="reject">Reject Claim</button>
                                                </form>
                                            </div>
                                        </div>
										
									</div>
									<!--end::Row-->
								</div>
								<!--end::Content container-->
							</div>
							<!--end::Content-->
						</div>
						<!--end::Content wrapper-->
						<!--begin::Footer-->
						<div id="kt_app_footer" class="app-footer align-items-center justify-content-center justify-content-md-between flex-column flex-md-row py-3">
							<!--begin::Copyright-->
							<div class="text-dark order-2 order-md-1">
								<span class="text-muted fw-semibold me-1">2024&copy;</span>
								<a href="" target="_blank" class="text-gray-800 text-hover-primary">ClaimGate</a>
							</div>
							<!--end::Copyright-->
						</div>
						<!--end::Footer-->
					</div>
					<!--end:::Main-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::App-->
		<!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<i class="ki-duotone ki-arrow-up">
				<span class="path1"></span>
				<span class="path2"></span>
			</i>
		</div>
		<!--end::Scrolltop-->

		<!--begin::Javascript-->
		<script>var hostUrl = "../../assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="../../assets/plugins/global/plugins.bundle.js"></script>
		<script src="../../assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Vendors Javascript(used for this page only)-->
		<script src="../../assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
		<script src="../../assets/plugins/custom/datatables/datatables.bundle.js"></script>
		<!--end::Vendors Javascript-->
		<!--begin::Custom Javascript(used for this page only)-->
		<script src="../../assets/js/widgets.bundle.js"></script>
		<script src="../../assets/js/custom/widgets.js"></script>
		<script src="../../assets/js/custom/apps/chat/chat.js"></script>
		<script src="../../assets/js/custom/utilities/modals/upgrade-plan.js"></script>
		<script src="../../assets/js/custom/utilities/modals/create-account.js"></script>
		<script src="../../assets/js/custom/utilities/modals/create-app.js"></script>
		<script src="../../assets/js/custom/utilities/modals/users-search.js"></script>
		<!--end::Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>