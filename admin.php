<?php
require_once 'config.php';
requireAdmin();

$error   = '';
$success = '';

// POST handlers 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfVerify();
    $action = $_POST['action'] ?? '';

    if ($action === 'add_opportunity') {
        $title           = clean($_POST['title']       ?? '');
        $sector          = clean($_POST['sector']      ?? '');
        $description     = clean($_POST['description'] ?? '');
        $location        = clean($_POST['location']    ?? '');
        $is_paid         = isset($_POST['is_paid']);
        $rate            = $is_paid ? floatval($_POST['rate'] ?? 0) : 0;
        $rate_type       = in_array($_POST['rate_type'] ?? '', ['hourly','per_task']) ? $_POST['rate_type'] : 'hourly';
        $time_commitment = clean($_POST['time_commitment'] ?? '');
        $skills          = array_values(array_filter(array_map('trim', explode(',', $_POST['required_skills'] ?? ''))));

        if (empty($title) || empty($sector) || empty($description) || empty($location)) {
            $error = 'Please fill in all required fields.';
        } else {
            $data = [
                'title'           => $title, 'sector'          => $sector,
                'description'     => $description, 'location'  => $location,
                'is_paid'         => $is_paid, 'rate'          => $rate,
                'rate_type'       => $rate_type, 'time_commitment' => $time_commitment,
                'required_skills' => $skills, 'status'         => 'active',
                'created_by'      => $_SESSION['user_id'],
            ];
            $result = supabaseRequest('opportunities', 'POST', $data);
            if (in_array($result['code'], [200, 201])) {
                $success = 'Opportunity published successfully!';
            } else {
                $error = 'Failed to add opportunity. Please try again.';
                error_log('Add opp error: ' . json_encode($result));
            }
        }

    } elseif ($action === 'edit_opportunity') {
        $opp_id          = clean($_POST['opp_id']      ?? '');
        $title           = clean($_POST['title']       ?? '');
        $sector          = clean($_POST['sector']      ?? '');
        $description     = clean($_POST['description'] ?? '');
        $location        = clean($_POST['location']    ?? '');
        $is_paid         = isset($_POST['is_paid']);
        $rate            = $is_paid ? floatval($_POST['rate'] ?? 0) : 0;
        $rate_type       = in_array($_POST['rate_type'] ?? '', ['hourly','per_task']) ? $_POST['rate_type'] : 'hourly';
        $time_commitment = clean($_POST['time_commitment'] ?? '');
        $skills          = array_values(array_filter(array_map('trim', explode(',', $_POST['required_skills'] ?? ''))));

        if (empty($opp_id) || empty($title)) {
            $error = 'Missing required fields.';
        } else {
            $update = [
                'title' => $title, 'sector' => $sector, 'description' => $description,
                'location' => $location, 'is_paid' => $is_paid, 'rate' => $rate,
                'rate_type' => $rate_type, 'time_commitment' => $time_commitment,
                'required_skills' => $skills,
            ];
            $result = supabaseRequest('opportunities?id=eq.' . rawurlencode($opp_id), 'PATCH', $update);
            if (in_array($result['code'], [200, 204])) {
                header('Location: admin.php?updated=1&tab=manage&subtab_manage=opp'); exit;
            } else {
                $error = 'Failed to update opportunity.';
            }
        }

    } elseif ($action === 'delete_opportunity') {
        $opp_id = clean($_POST['opp_id'] ?? '');
        if (!empty($opp_id)) {
            $result = supabaseRequest('opportunities?id=eq.' . rawurlencode($opp_id), 'DELETE');
            $success = in_array($result['code'], [200, 204]) ? 'Opportunity deleted.' : '';
            if (empty($success)) $error = 'Failed to delete opportunity.';
        }

    } elseif ($action === 'update_application_status') {
        $app_id    = clean($_POST['app_id']     ?? '');
        $newStatus = clean($_POST['new_status'] ?? '');
        if (!empty($app_id) && in_array($newStatus, ['approved','declined','pending'])) {
            $result = supabaseRequest('applications?id=eq.' . rawurlencode($app_id), 'PATCH', ['status' => $newStatus]);
            if (in_array($result['code'], [200, 204])) {
                $success = 'Application ' . ucfirst($newStatus) . ' successfully!';
            } else {
                $error = 'Failed to update status. HTTP ' . $result['code'];
            }
        }

    } elseif ($action === 'delete_application') {
        $app_id = clean($_POST['app_id'] ?? '');
        if (!empty($app_id)) {
            $result = supabaseRequest('applications?id=eq.' . rawurlencode($app_id), 'DELETE');
            $success = in_array($result['code'], [200, 204]) ? 'Application deleted.' : '';
            if (empty($success)) $error = 'Failed to delete application.';
        }

    } elseif ($action === 'edit_user') {
        $uid      = clean($_POST['user_id']   ?? '');
        $fname    = clean($_POST['full_name']  ?? '');
        $email    = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $phone    = clean($_POST['phone']      ?? '');
        $location = clean($_POST['location']   ?? '');
        $is_admin = isset($_POST['is_admin']);
        $newPw    = $_POST['new_password'] ?? '';

        if (empty($uid) || empty($fname) || empty($email)) {
            $error = 'Name and email are required.';
        } elseif (!empty($newPw) && strlen($newPw) < 8) {
            $error = 'New password must be at least 8 characters.';
        } else {
            $update = [
                'full_name' => $fname,
                'email'     => $email,
                'phone'     => $phone,
                'location'  => $location,
                'is_admin'  => $is_admin,
            ];
            if (!empty($newPw)) {
                $update['password'] = password_hash($newPw, PASSWORD_BCRYPT);
            }
            $result = supabaseRequest('users?id=eq.' . rawurlencode($uid), 'PATCH', $update);
            if (in_array($result['code'], [200, 204])) {
                header('Location: admin.php?updated_user=1&tab=users'); exit;
            } else {
                $error = 'Failed to update user. HTTP ' . $result['code'];
            }
        }

    } elseif ($action === 'delete_user') {
        $uid = clean($_POST['user_id'] ?? '');
        if (!empty($uid) && $uid !== (string)$_SESSION['user_id']) {
            $result = supabaseRequest('users?id=eq.' . rawurlencode($uid), 'DELETE');
            $success = in_array($result['code'], [200, 204]) ? 'User deleted successfully.' : '';
            if (empty($success)) $error = 'Failed to delete user. HTTP ' . $result['code'];
        } else {
            $error = 'You cannot delete your own account.';
        }

    } elseif ($action === 'add_resource') {
        $r_title   = clean($_POST['r_title']         ?? '');
        $r_desc    = clean($_POST['r_description']   ?? '');
        $r_url     = clean($_POST['r_url']           ?? '');
        $r_type    = clean($_POST['r_resource_type'] ?? '');
        $validTypes = ['course', 'tutorial', 'certificate'];
        if (empty($r_title) || empty($r_desc) || empty($r_url) || !in_array($r_type, $validTypes)) {
            $error = 'Please fill in all required resource fields.';
        } else {
            $rData = ['title' => $r_title, 'description' => $r_desc, 'url' => $r_url, 'resource_type' => $r_type];
            $result = supabaseRequest('resources', 'POST', $rData);
            if (in_array($result['code'], [200, 201])) {
                header('Location: admin.php?resource_added=1&tab=add&subtab_add=res'); exit;
            } else {
                $error = 'Failed to add resource. HTTP ' . $result['code'];
            }
        }

    } elseif ($action === 'edit_resource') {
        $r_id      = clean($_POST['resource_id']     ?? '');
        $r_title   = clean($_POST['r_title']         ?? '');
        $r_desc    = clean($_POST['r_description']   ?? '');
        $r_url     = clean($_POST['r_url']           ?? '');
        $r_type    = clean($_POST['r_resource_type'] ?? '');
        $validTypes = ['course', 'tutorial', 'certificate'];
        if (empty($r_id) || empty($r_title) || empty($r_url) || !in_array($r_type, $validTypes)) {
            $error = 'Please fill in all required resource fields.';
        } else {
            $rData = ['title' => $r_title, 'description' => $r_desc, 'url' => $r_url, 'resource_type' => $r_type];
            $result = supabaseRequest('resources?id=eq.' . rawurlencode($r_id), 'PATCH', $rData);
            if (in_array($result['code'], [200, 204])) {
                header('Location: admin.php?resource_updated=1&tab=manage&subtab_manage=res'); exit;
            } else {
                $error = 'Failed to update resource. HTTP ' . $result['code'];
            }
        }

    } elseif ($action === 'delete_resource') {
        $r_id = clean($_POST['resource_id'] ?? '');
        if (!empty($r_id)) {
            $result = supabaseRequest('resources?id=eq.' . rawurlencode($r_id), 'DELETE');
            $success = in_array($result['code'], [200, 204]) ? 'Resource deleted.' : '';
            if (empty($success)) $error = 'Failed to delete resource. HTTP ' . $result['code'];
        }
    }
}

if (isset($_GET['updated'])) $success = 'Opportunity updated successfully!';
if (isset($_GET['updated_user'])) $success = 'User updated successfully!';
if (isset($_GET['resource_added'])) $success = 'Resource added successfully!';
if (isset($_GET['resource_updated'])) $success = 'Resource updated successfully!';

// Fetch data
$result             = supabaseRequest('opportunities?order=created_at.desc', 'GET');
$adminOpportunities = ($result['code'] === 200 && !empty($result['data'])) ? $result['data'] : [];

// Fetch ALL users — dedicated cURL with service key to guarantee RLS bypass
$_svcKey    = defined('SUPABASE_SERVICE_KEY') ? SUPABASE_SERVICE_KEY : SUPABASE_KEY;
$_usersCh   = curl_init(SUPABASE_URL . '/rest/v1/users?select=*');
curl_setopt_array($_usersCh, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_TIMEOUT        => 15,
    CURLOPT_HTTPHEADER     => [
        'apikey: '               . $_svcKey,
        'Authorization: Bearer ' . $_svcKey,
        'Content-Type: application/json',
        'Prefer: return=representation',
    ],
]);
$_usersResp = curl_exec($_usersCh);
$_usersCode = curl_getinfo($_usersCh, CURLINFO_HTTP_CODE);
$_usersCurlErr = curl_error($_usersCh);
curl_close($_usersCh);
$allUsers = ($_usersCode === 200 && !empty($_usersResp)) ? (json_decode($_usersResp, true) ?? []) : [];
if ($_usersCode !== 200) {
    error_log('Users fetch failed: HTTP ' . $_usersCode . ' | cURL: ' . $_usersCurlErr . ' | Body: ' . substr($_usersResp, 0, 300));
}
// Sort: admins first, then A → Z by full_name within each group
usort($allUsers, function($a, $b) {
    $aAdmin = !empty($a['is_admin']) ? 0 : 1;
    $bAdmin = !empty($b['is_admin']) ? 0 : 1;
    if ($aAdmin !== $bAdmin) return $aAdmin - $bAdmin;
    return strcasecmp($a['full_name'] ?? '', $b['full_name'] ?? '');
});

// Fetch applications
$appsResult = supabaseRequest('applications?order=created_at.desc&select=id,status,cover_letter,created_at,user_id,opportunity_id', 'GET');
$allApps    = ($appsResult['code'] === 200 && !empty($appsResult['data'])) ? $appsResult['data'] : [];

// Build lookup maps
$userMap = [];
foreach ($allUsers as $u) $userMap[$u['id']] = $u;
$oppMap = [];
foreach ($adminOpportunities as $o) $oppMap[$o['id']] = $o;

// Fetch resources
$resResult    = supabaseRequest('resources?order=resource_type.asc,title.asc', 'GET');
$allResources = ($resResult['code'] === 200 && !empty($resResult['data'])) ? $resResult['data'] : [];

// Stats
$totalApps    = count($allApps);
$pendingApps  = count(array_filter($allApps, fn($a) => $a['status'] === 'pending'));
$approvedApps = count(array_filter($allApps, fn($a) => $a['status'] === 'approved'));
$declinedApps = count(array_filter($allApps, fn($a) => $a['status'] === 'declined'));
$volunteerPos = count(array_filter($adminOpportunities, fn($o) => !$o['is_paid'] && $o['status'] === 'active'));

function calcAge(?string $dob): ?int {
    if (empty($dob)) return null;
    try { return (new DateTime())->diff(new DateTime($dob))->y; }
    catch (Exception $e) { return null; }
}

$defaultTab        = $_GET['tab']           ?? 'add';
$defaultSubtabAdd  = $_GET['subtab_add']    ?? 'opp';
$defaultSubtabMgmt = $_GET['subtab_manage'] ?? 'opp';

$pageTitle   = 'Admin Dashboard';
$currentPage = 'admin';
include 'partials/head.php';
include 'partials/header.php';
?>

<div class="page-band">
    <div class="container">
        <h1><i class="fas fa-gauge" style="color:var(--orange-400);margin-right:10px"></i>Admin Dashboard</h1>
        <p>Manage volunteer opportunities, applications and platform activities.</p>
    </div>
</div>

<section class="section">
    <div class="container">

        <?php if ($error):   ?><div class="alert alert-error"><i class="fas fa-circle-exclamation"></i><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <?php if ($success): ?><div class="alert alert-success"><i class="fas fa-circle-check"></i><?= htmlspecialchars($success) ?></div><?php endif; ?>

        <!-- ── STATS grid ── -->
        <div class="admin-stats-grid">
            <div class="admin-stat">
                <div class="admin-stat-icon" style="background:#fdf2f8;color:#db2777"><i class="fas fa-heart"></i></div>
                <div><div class="admin-stat-num"><?= $volunteerPos ?></div><div class="admin-stat-lbl">Volunteer Positions</div></div>
            </div>
            <div class="admin-stat">
                <div class="admin-stat-icon" style="background:var(--green-50);color:var(--green-600)"><i class="fas fa-circle-dollar-to-slot"></i></div>
                <div><div class="admin-stat-num"><?= count(array_filter($adminOpportunities, fn($o) => $o['is_paid'])) ?></div><div class="admin-stat-lbl">Paid Positions</div></div>
            </div>
            <div class="admin-stat">
                <div class="admin-stat-icon fi-blue"><i class="fas fa-book-open"></i></div>
                <div><div class="admin-stat-num"><?= isset($allResources) ? count($allResources) : 0 ?></div><div class="admin-stat-lbl">Total Resources</div></div>
            </div>
            <div class="admin-stat">
                <div class="admin-stat-icon" style="background:#fdf4ff;color:#7c3aed"><i class="fas fa-users"></i></div>
                <div><div class="admin-stat-num"><?= count(array_filter($allUsers, fn($u) => empty($u['is_admin']))) ?></div><div class="admin-stat-lbl">Registered Users</div></div>
            </div>
            <div class="admin-stat">
                <div class="admin-stat-icon" style="background:#fff7ed;color:#ea580c"><i class="fas fa-clipboard-list"></i></div>
                <div><div class="admin-stat-num"><?= $totalApps ?></div><div class="admin-stat-lbl">Total Applications</div></div>
            </div>
            <div class="admin-stat">
                <div class="admin-stat-icon" style="background:#fefce8;color:#ca8a04"><i class="fas fa-clock"></i></div>
                <div><div class="admin-stat-num"><?= $pendingApps ?></div><div class="admin-stat-lbl">Pending Review</div></div>
            </div>
        </div>

        <!-- TABS -->
        <div class="admin-tabs-wrap">
            <button class="admin-tab" id="tab-add"          onclick="switchTab('add')">
                <i class="fas fa-plus"></i> Add
            </button>
            <button class="admin-tab" id="tab-manage"       onclick="switchTab('manage')">
                <i class="fas fa-list"></i> Manage
            </button>
            <button class="admin-tab" id="tab-applications" onclick="switchTab('applications')">
                <i class="fas fa-clipboard-list"></i> Applications<?php if($pendingApps>0):?><span class="tab-badge"><?=$pendingApps?></span><?php endif;?>
            </button>
            <button class="admin-tab" id="tab-users"        onclick="switchTab('users')">
                <i class="fas fa-users"></i> Users
            </button>

        </div>

        <!-- ADD PANEL -->
        <div class="admin-panel" id="panel-add">
            <!-- Sub-tabs -->
            <div class="sub-tabs-wrap">
                <button class="sub-tab active" id="subtab-add-opp"  onclick="switchSubTab('add','opp')">
                    <i class="fas fa-briefcase"></i> Opportunity
                </button>
                <button class="sub-tab" id="subtab-add-res" onclick="switchSubTab('add','res')">
                    <i class="fas fa-book-open"></i> Resource
                </button>
            </div>

            <!-- Add Opportunity -->
            <div class="sub-panel active" id="subpanel-add-opp">
                <div class="form-center-wrap">
                    <div class="form-card">
                        <div class="form-head" style="margin-bottom:28px">
                            <div class="form-icon" style="background:var(--orange-50);color:var(--orange-500)"><i class="fas fa-briefcase"></i></div>
                            <h2>Post New Opportunity</h2>
                            <p>Publish a new volunteer position to the platform</p>
                        </div>
                        <form method="POST" action="admin.php" class="js-form">
                            <?= csrfField() ?>
                            <input type="hidden" name="action" value="add_opportunity">
                            <?php include 'partials/opportunity_form_fields.php'; ?>
                            <button type="submit" class="btn btn-primary btn-lg" style="width:100%;justify-content:center">
                                <i class="fas fa-plus"></i> Publish Opportunity
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Add Resource -->
            <div class="sub-panel" id="subpanel-add-res">
                <div class="form-center-wrap">
                    <div class="form-card">
                        <div class="form-head" style="margin-bottom:24px">
                            <div class="form-icon" style="background:var(--blue-50);color:var(--blue-600)"><i class="fas fa-book-open"></i></div>
                            <h2>Add New Resource</h2>
                            <p>Publish a course, tutorial, or certificate link</p>
                        </div>
                        <form method="POST" action="admin.php" class="js-form">
                            <?= csrfField() ?>
                            <input type="hidden" name="action" value="add_resource">
                            <div class="form-row">
                                <div class="form-group" style="flex:2">
                                    <label><i class="fas fa-heading" style="color:var(--blue-400)"></i> Title <span class="req">*</span></label>
                                    <input type="text" name="r_title" placeholder="e.g. Introduction to Python" required>
                                </div>
                                <div class="form-group">
                                    <label><i class="fas fa-tag" style="color:var(--blue-400)"></i> Type <span class="req">*</span></label>
                                    <select name="r_resource_type" required>
                                        <option value="">— Select —</option>
                                        <option value="course">Course</option>
                                        <option value="tutorial">Tutorial</option>
                                        <option value="certificate">Certificate</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-align-left" style="color:var(--blue-400)"></i> Description <span class="req">*</span></label>
                                <textarea name="r_description" rows="3" placeholder="Brief description of the resource..." required></textarea>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-link" style="color:var(--blue-400)"></i> URL <span class="req">*</span></label>
                                <input type="url" name="r_url" placeholder="https://..." required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg" style="width:100%;justify-content:center">
                                <i class="fas fa-plus"></i> Add Resource
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- MANAGE PANEL -->
        <div class="admin-panel" id="panel-manage">
            <!-- Sub-tabs -->
            <div class="sub-tabs-wrap">
                <button class="sub-tab active" id="subtab-manage-opp" onclick="switchSubTab('manage','opp')">
                    <i class="fas fa-briefcase"></i> Opportunities
                </button>
                <button class="sub-tab" id="subtab-manage-res" onclick="switchSubTab('manage','res')">
                    <i class="fas fa-book-open"></i> Resources
                </button>
            </div>

            <!-- Manage Opportunities -->
            <div class="sub-panel active" id="subpanel-manage-opp">
                <?php if (empty($adminOpportunities)): ?>
                    <div class="empty-state">
                        <div class="empty-icon"><i class="fas fa-briefcase"></i></div>
                        <h3>No Opportunities Yet</h3>
                        <p>Switch to Add tab to post your first opportunity.</p>
                        <button onclick="switchTab('add')" class="btn btn-primary"><i class="fas fa-plus"></i> Add Opportunity</button>
                    </div>
                <?php else: ?>
                    <div class="tbl-meta">
                        <strong><?= count($adminOpportunities) ?></strong> opportunit<?= count($adminOpportunities)===1?'y':'ies'?> listed
                    </div>
                    <div class="table-wrap">
                        <table>
                            <thead><tr><th>Title</th><th>Sector</th><th>Location</th><th>Type</th><th>Status</th><th>Actions</th></tr></thead>
                            <tbody>
                            <?php foreach ($adminOpportunities as $ao): ?>
                                <tr>
                                    <td data-label="Title" style="font-weight:700;color:var(--ink)"><?= htmlspecialchars($ao['title']) ?></td>
                                    <td data-label="Sector"><span class="pill" style="font-size:11px"><?= htmlspecialchars($ao['sector']) ?></span></td>
                                    <td data-label="Location"><?= htmlspecialchars($ao['location']) ?></td>
                                    <td data-label="Type">
                                        <?php if ($ao['is_paid']): ?>
                                            <span class="status-pill" style="background:var(--green-50);color:var(--green-700);border:1px solid var(--green-100)"><i class="fas fa-circle-dollar-to-slot" style="font-size:10px;margin-right:3px"></i>Paid</span>
                                        <?php else: ?>
                                            <span class="status-pill" style="background:#fdf2f8;color:#be185d;border:1px solid #f9a8d4"><i class="fas fa-heart" style="font-size:10px;margin-right:3px"></i>Volunteer</span>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="Status"><span class="status-pill dot status-<?= $ao['status'] ?>"><?= ucfirst($ao['status']) ?></span></td>
                                    <td data-label="Actions">
                                        <div class="td-actions">
                                            <button onclick="openEditOpp(<?= htmlspecialchars(json_encode($ao), ENT_QUOTES) ?>)" class="btn btn-secondary btn-xs"><i class="fas fa-pen"></i> Edit</button>
                                            <button onclick="confirmDelete('<?= $ao['id'] ?>','<?= addslashes(htmlspecialchars($ao['title'])) ?>')" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i> Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Manage Resources -->
            <div class="sub-panel" id="subpanel-manage-res">
                <?php if (empty($allResources)): ?>
                    <div class="empty-state">
                        <div class="empty-icon"><i class="fas fa-book-open"></i></div>
                        <h3>No Resources Yet</h3>
                        <p>Switch to Add &rarr; Resource to add your first resource.</p>
                        <button onclick="switchTab('add');switchSubTab('add','res')" class="btn btn-primary"><i class="fas fa-plus"></i> Add Resource</button>
                    </div>
                <?php else: ?>
                    <div class="tbl-meta">
                        <strong><?= count($allResources) ?></strong> resource<?= count($allResources)!==1?'s':''?> listed
                    </div>
                    <div class="table-wrap">
                        <table>
                            <thead><tr><th>Title</th><th>Type</th><th>Description</th><th>URL</th><th>Actions</th></tr></thead>
                            <tbody>
                            <?php foreach ($allResources as $res):
                                $resTypeMeta = match($res['resource_type'] ?? '') {
                                    'course'      => ['rb-course',   'Course'],
                                    'tutorial'    => ['rb-tutorial', 'Tutorial'],
                                    'certificate' => ['rb-cert',     'Certificate'],
                                    default       => ['rb-cert',     ucfirst($res['resource_type'] ?? 'Other')],
                                };
                            ?>
                                <tr>
                                    <td data-label="Title" style="font-weight:700;color:var(--ink)"><?= htmlspecialchars($res['title']) ?></td>
                                    <td data-label="Type">
                                        <span class="res-badge <?= $resTypeMeta[0] ?>"><?= $resTypeMeta[1] ?></span>
                                    </td>
                                    <td data-label="Description">
                                        <div class="cl-preview"><?= htmlspecialchars(mb_strimwidth($res['description'] ?? '', 0, 80, '…')) ?></div>
                                    </td>
                                    <td data-label="URL">
                                        <a href="<?= htmlspecialchars($res['url']) ?>" target="_blank" rel="noopener"
                                           style="font-size:12px;color:var(--blue-600);word-break:break-all">
                                            <i class="fas fa-external-link" style="font-size:10px"></i>
                                            <?= htmlspecialchars(mb_strimwidth($res['url'], 0, 40, '…')) ?>
                                        </a>
                                    </td>
                                    <td data-label="Actions">
                                        <div class="td-actions">
                                            <button onclick="openEditResource(<?= htmlspecialchars(json_encode($res), ENT_QUOTES) ?>)"
                                                    class="btn btn-secondary btn-xs"><i class="fas fa-pen"></i> Edit</button>
                                            <button onclick="confirmDeleteResource('<?= htmlspecialchars($res['id']) ?>','<?= addslashes(htmlspecialchars($res['title'])) ?>')"
                                                    class="btn btn-danger btn-xs"><i class="fas fa-trash"></i> Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- APPLICATIONS PANEL -->
        <div class="admin-panel" id="panel-applications">
            <?php if (empty($allApps)): ?>
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-clipboard-list"></i></div>
                    <h3>No Applications Yet</h3>
                    <p>Volunteer applications will appear here once submitted.</p>
                </div>
            <?php else: ?>
                <div class="tbl-meta">
                    <strong><?= $totalApps ?></strong> application<?= $totalApps===1?'':'s'?> &mdash;
                    <span class="meta-green"><?= $approvedApps ?> approved</span> &middot;
                    <span class="meta-yellow"><?= $pendingApps ?> pending</span> &middot;
                    <span class="meta-red"><?= $declinedApps ?> declined</span>
                </div>
                <div class="table-wrap">
                    <table>
                        <thead><tr><th>Applicant</th><th>Opportunity</th><th>Date</th><th>Cover Letter</th><th>Status</th><th>Actions</th></tr></thead>
                        <tbody>
                        <?php foreach ($allApps as $app):
                            $appUser = $userMap[$app['user_id']] ?? null;
                            $appOpp  = $oppMap[$app['opportunity_id']] ?? null;
                            $appDate = !empty($app['created_at']) ? (new DateTime($app['created_at']))->format('d M Y') : '—';
                            $cl      = $app['cover_letter'] ?? '';
                            $clShort = mb_strimwidth($cl, 0, 60, '…');
                            $statusStyle = match($app['status']) {
                                'approved' => 'background:var(--green-50);color:var(--green-700);border:1px solid var(--green-100)',
                                'declined' => 'background:#fef2f2;color:#dc2626;border:1px solid #fecaca',
                                default    => 'background:#fefce8;color:#a16207;border:1px solid #fde68a',
                            };
                        ?>
                            <tr>
                                <td data-label="Applicant">
                                    <div style="font-weight:700;color:var(--ink)"><?= htmlspecialchars($appUser['full_name'] ?? 'Unknown') ?></div>
                                    <div class="sub-email"><?= htmlspecialchars($appUser['email'] ?? '—') ?></div>
                                </td>
                                <td data-label="Opportunity">
                                    <div style="font-size:13px;font-weight:600;color:var(--ink)"><?= htmlspecialchars($appOpp['title'] ?? 'Unknown') ?></div>
                                    <?php if (!empty($appOpp['sector'])): ?>
                                    <span class="pill" style="font-size:10px;margin-top:3px;display:inline-block"><?= htmlspecialchars($appOpp['sector']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td data-label="Date" style="font-size:12px;color:var(--ink-muted);white-space:nowrap"><?= $appDate ?></td>
                                <td data-label="Cover Letter">
                                    <div class="cl-preview"><?= htmlspecialchars($clShort) ?></div>
                                    <?php if (mb_strlen($cl) > 60): ?>
                                    <button class="cl-read-more" onclick="openCoverModal(this)" data-full="<?= htmlspecialchars($cl) ?>">Read more</button>
                                    <?php endif; ?>
                                </td>
                                <td data-label="Status">
                                    <span class="status-pill" style="<?= $statusStyle ?>"><?= ucfirst($app['status']) ?></span>
                                </td>
                                <td data-label="Actions">
                                    <div class="td-actions">
                                        <?php if ($app['status'] !== 'approved'): ?>
                                        <form method="POST" action="admin.php" style="display:inline">
                                            <?= csrfField() ?>
                                            <input type="hidden" name="action"     value="update_application_status">
                                            <input type="hidden" name="app_id"     value="<?= htmlspecialchars($app['id']) ?>">
                                            <input type="hidden" name="new_status" value="approved">
                                            <button type="submit" class="btn btn-xs btn-approve"><i class="fas fa-check"></i> Approve</button>
                                        </form>
                                        <?php endif; ?>
                                        <?php if ($app['status'] !== 'declined'): ?>
                                        <form method="POST" action="admin.php" style="display:inline">
                                            <?= csrfField() ?>
                                            <input type="hidden" name="action"     value="update_application_status">
                                            <input type="hidden" name="app_id"     value="<?= htmlspecialchars($app['id']) ?>">
                                            <input type="hidden" name="new_status" value="declined">
                                            <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-xmark"></i> Decline</button>
                                        </form>
                                        <?php endif; ?>
                                        <form method="POST" action="admin.php" style="display:inline" onsubmit="return confirm('Delete this application? This cannot be undone.')">
                                            <?= csrfField() ?>
                                            <input type="hidden" name="action" value="delete_application">
                                            <input type="hidden" name="app_id" value="<?= htmlspecialchars($app['id']) ?>">
                                            <button type="submit" class="btn btn-xs btn-secondary" title="Delete"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <!-- USERS PANEL -->
        <div class="admin-panel" id="panel-users">
            <?php if (empty($allUsers)): ?>
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-users"></i></div>
                    <h3>No Users Found</h3>
                    <p>Registered users will appear here.</p>
                    <p style="font-size:12px;color:#dc2626;margin-top:8px">
                        Debug — HTTP code: <?= $_usersCode ?> |
                        Service key defined: <?= defined('SUPABASE_SERVICE_KEY') ? 'YES' : 'NO' ?> |
                        Response: <?= htmlspecialchars(substr($_usersResp ?? '', 0, 200)) ?>
                    </p>
                </div>
            <?php else: ?>
                <div class="tbl-meta"><strong><?= count($allUsers) ?></strong> registered user<?= count($allUsers)!==1?'s':''?></div>
                <div class="table-wrap">
                    <table>
                        <thead><tr>
                            <th style="cursor:pointer;user-select:none" onclick="sortUsersTable(0)" id="thName">
                                Name <span id="sortIcon" style="font-size:10px;margin-left:3px">▲</span>
                            </th>
                            <th>Email</th><th>Location</th><th>Date of Birth</th><th>Age</th><th>Role</th><th>Actions</th>
                        </tr></thead>
                        <tbody>
                        <?php foreach ($allUsers as $u):
                            $age          = calcAge($u['date_of_birth'] ?? null);
                            $dobFormatted = !empty($u['date_of_birth']) ? (new DateTime($u['date_of_birth']))->format('d M Y') : '—';
                            $isSelf       = ((string)$u['id'] === (string)$_SESSION['user_id']);
                        ?>
                            <tr>
                                <td data-label="Name" style="font-weight:700;color:var(--ink)"><?= htmlspecialchars($u['full_name'] ?? '—') ?></td>
                                <td data-label="Email" style="font-size:13px;color:var(--ink-muted)"><?= htmlspecialchars($u['email'] ?? '—') ?></td>
                                <td data-label="Location"><?= htmlspecialchars($u['location'] ?? '—') ?></td>
                                <td data-label="Date of Birth" style="font-size:13px"><?= htmlspecialchars($dobFormatted) ?></td>
                                <td data-label="Age">
                                    <?php if ($age !== null): ?>
                                        <span class="pill" style="font-size:12px;background:var(--blue-50);color:var(--blue-700)"><i class="fas fa-cake-candles" style="font-size:10px"></i> <?= $age ?> yrs</span>
                                    <?php else: ?><span style="color:var(--ink-faint);font-size:13px">Not set</span><?php endif; ?>
                                </td>
                                <td data-label="Role">
                                    <?php if (!empty($u['is_admin'])): ?>
                                        <span class="status-pill" style="background:#fdf4ff;color:#7c3aed;border:1px solid #e9d5ff"><i class="fas fa-shield-halved" style="font-size:10px;margin-right:3px"></i>Admin</span>
                                    <?php else: ?>
                                        <span class="status-pill dot status-active">Volunteer</span>
                                    <?php endif; ?>
                                </td>
                                <td data-label="Actions">
                                    <div class="td-actions">
                                        <button onclick="openEditUser(<?= htmlspecialchars(json_encode($u), ENT_QUOTES) ?>)"
                                                class="btn btn-secondary btn-xs"><i class="fas fa-pen"></i> Edit</button>
                                        <?php if (!$isSelf): ?>
                                        <button onclick="confirmDeleteUser('<?= htmlspecialchars($u['id']) ?>','<?= addslashes(htmlspecialchars($u['full_name'] ?? '')) ?>')"
                                                class="btn btn-danger btn-xs"><i class="fas fa-trash"></i> Delete</button>
                                        <?php else: ?>
                                        <span style="font-size:11px;color:var(--ink-faint);font-style:italic">You</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>


    </div>
</section>

<!-- Delete Opportunity Modal -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box danger">
        <div class="modal-head">
            <h2><i class="fas fa-triangle-exclamation" style="margin-right:8px"></i>Confirm Delete</h2>
            <button class="modal-close" onclick="closeModal('deleteModal')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="delete-warning">
                <div class="dw-icon"><i class="fas fa-trash"></i></div>
                <h3>Delete Opportunity?</h3>
                <p>You are about to permanently delete <strong id="deleteOppName"></strong>. This cannot be undone.</p>
            </div>
            <form method="POST" action="admin.php" id="deleteForm" class="js-form">
                <?= csrfField() ?>
                <input type="hidden" name="action" value="delete_opportunity">
                <input type="hidden" name="opp_id" id="deleteOppId">
                <div class="delete-actions">
                    <button type="button" onclick="closeModal('deleteModal')" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Opportunity Modal -->
<div class="modal-overlay" id="editOppModal">
    <div class="modal-box" style="max-width:680px">
        <div class="modal-head">
            <h2><i class="fas fa-pen" style="margin-right:8px"></i>Edit Opportunity</h2>
            <p id="editOppSubtitle" style="font-size:13px;color:var(--ink-muted);margin:4px 0 0"></p>
            <button class="modal-close" onclick="closeModal('editOppModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form method="POST" action="admin.php" class="js-form" id="editOppForm">
                <?= csrfField() ?>
                <input type="hidden" name="action" value="edit_opportunity">
                <input type="hidden" name="opp_id" id="editOppId">
                <div class="form-group">
                    <label><i class="fas fa-heading" style="color:var(--blue-400)"></i> Title <span class="req">*</span></label>
                    <input type="text" name="title" id="editOppTitle" placeholder="e.g. Community Outreach Coordinator" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-tag" style="color:var(--blue-400)"></i> Sector <span class="req">*</span></label>
                        <input type="text" name="sector" id="editOppSector" placeholder="e.g. Technology, Education" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-location-dot" style="color:var(--blue-400)"></i> Location <span class="req">*</span></label>
                        <input type="text" name="location" id="editOppLocation" placeholder="e.g. Kuala Lumpur" required>
                    </div>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-align-left" style="color:var(--blue-400)"></i> Description <span class="req">*</span></label>
                    <textarea name="description" id="editOppDescription" rows="4"
                              placeholder="Describe the role, responsibilities, and what volunteers will gain..." required></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-screwdriver-wrench" style="color:var(--blue-400)"></i> Required Skills</label>
                        <input type="text" name="required_skills" id="editOppSkills" placeholder="e.g. Communication, Teamwork">
                        <div class="form-hint">Comma-separated.</div>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-clock" style="color:var(--blue-400)"></i> Time Commitment <span class="req">*</span></label>
                        <input type="text" name="time_commitment" id="editOppTimeCommitment" placeholder="e.g. 10 hrs/week" required>
                    </div>
                </div>
                <div class="checkbox-row">
                    <input type="checkbox" id="editOppIsPaid" name="is_paid" onchange="toggleRateFields('editOpp')">
                    <label for="editOppIsPaid">
                        <i class="fas fa-circle-dollar-to-slot" style="color:var(--green-600)"></i> This is a paid position
                    </label>
                </div>
                <div id="rateFields-editOpp" style="display:none">
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-money-bill" style="color:var(--green-600)"></i> Rate (RM)</label>
                            <input type="number" name="rate" id="editOppRate" step="0.01" min="0" placeholder="e.g. 25.00">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-calendar-days" style="color:var(--blue-400)"></i> Rate Type</label>
                            <select name="rate_type" id="editOppRateType">
                                <option value="hourly">Per Hour</option>
                                <option value="per_task">Per Task</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:8px">
                    <button type="submit" class="btn btn-primary btn-lg" style="flex:1;justify-content:center"><i class="fas fa-floppy-disk"></i> Save Changes</button>
                    <button type="button" onclick="closeModal('editOppModal')" class="btn btn-secondary btn-lg" style="flex:1;justify-content:center"><i class="fas fa-xmark"></i> Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal-overlay" id="editUserModal">
    <div class="modal-box" style="max-width:560px">
        <div class="modal-head">
            <h2><i class="fas fa-user-pen" style="margin-right:8px"></i>Edit User</h2>
            <p id="editUserSubtitle" style="font-size:13px;color:var(--ink-muted);margin:4px 0 0"></p>
            <button class="modal-close" onclick="closeModal('editUserModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form method="POST" action="admin.php" class="js-form">
                <?= csrfField() ?>
                <input type="hidden" name="action"  value="edit_user">
                <input type="hidden" name="user_id" id="editUserId">
                <div class="form-group">
                    <label><i class="fas fa-user" style="color:var(--blue-400)"></i> Full Name <span class="req">*</span></label>
                    <input type="text" name="full_name" id="editUserName" required placeholder="Full name">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-envelope" style="color:var(--blue-400)"></i> Email <span class="req">*</span></label>
                        <input type="email" name="email" id="editUserEmail" required placeholder="email@example.com">
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-phone" style="color:var(--blue-400)"></i> Phone</label>
                        <input type="tel" name="phone" id="editUserPhone" placeholder="+60 12 345 6789">
                    </div>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-location-dot" style="color:var(--blue-400)"></i> Location</label>
                    <input type="text" name="location" id="editUserLocation" placeholder="e.g. Kuala Lumpur">
                </div>
                <div class="form-group">
                    <label><i class="fas fa-lock" style="color:var(--blue-400)"></i> New Password <span style="font-size:11px;color:var(--ink-muted);font-weight:400">(leave blank to keep current)</span></label>
                    <input type="password" name="new_password" placeholder="Min. 8 characters" minlength="8" autocomplete="new-password">
                </div>
                <div class="checkbox-row" style="margin-bottom:20px">
                    <input type="checkbox" id="editUserIsAdmin" name="is_admin">
                    <label for="editUserIsAdmin">
                        <i class="fas fa-shield-halved" style="color:#7c3aed"></i> Grant Admin Access
                    </label>
                </div>
                <div style="display:flex;gap:12px;flex-wrap:wrap">
                    <button type="submit" class="btn btn-primary btn-lg" style="flex:1;justify-content:center"><i class="fas fa-floppy-disk"></i> Save Changes</button>
                    <button type="button" onclick="closeModal('editUserModal')" class="btn btn-secondary btn-lg" style="flex:1;justify-content:center"><i class="fas fa-xmark"></i> Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete User Modal -->
<div class="modal-overlay" id="deleteUserModal">
    <div class="modal-box danger" style="max-width:440px">
        <div class="modal-head">
            <h2><i class="fas fa-triangle-exclamation" style="margin-right:8px"></i>Delete User</h2>
            <button class="modal-close" onclick="closeModal('deleteUserModal')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="delete-warning">
                <div class="dw-icon"><i class="fas fa-user-slash"></i></div>
                <h3>Delete this user?</h3>
                <p>You are about to permanently delete <strong id="deleteUserName"></strong>. All their data will be lost. This cannot be undone.</p>
            </div>
            <form method="POST" action="admin.php" class="js-form">
                <?= csrfField() ?>
                <input type="hidden" name="action"  value="delete_user">
                <input type="hidden" name="user_id" id="deleteUserId">
                <div class="delete-actions">
                    <button type="button" onclick="closeModal('deleteUserModal')" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Resource Modal -->
<div class="modal-overlay" id="editResourceModal">
    <div class="modal-box" style="max-width:560px">
        <div class="modal-head">
            <h2><i class="fas fa-pen" style="margin-right:8px"></i>Edit Resource</h2>
            <p id="editResourceSubtitle" style="font-size:13px;color:var(--ink-muted);margin:4px 0 0"></p>
            <button class="modal-close" onclick="closeModal('editResourceModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form method="POST" action="admin.php" class="js-form">
                <?= csrfField() ?>
                <input type="hidden" name="action"      value="edit_resource">
                <input type="hidden" name="resource_id" id="editResourceId">
                <div class="form-row">
                    <div class="form-group" style="flex:2">
                        <label><i class="fas fa-heading" style="color:var(--blue-400)"></i> Title <span class="req">*</span></label>
                        <input type="text" name="r_title" id="editResourceTitle" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-tag" style="color:var(--blue-400)"></i> Type <span class="req">*</span></label>
                        <select name="r_resource_type" id="editResourceType" required>
                            <option value="course">Course</option>
                            <option value="tutorial">Tutorial</option>
                            <option value="certificate">Certificate</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-align-left" style="color:var(--blue-400)"></i> Description <span class="req">*</span></label>
                    <textarea name="r_description" id="editResourceDesc" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-link" style="color:var(--blue-400)"></i> URL <span class="req">*</span></label>
                    <input type="url" name="r_url" id="editResourceUrl" required>
                </div>
                <div style="display:flex;gap:12px;flex-wrap:wrap">
                    <button type="submit" class="btn btn-primary btn-lg" style="flex:1;justify-content:center"><i class="fas fa-floppy-disk"></i> Save Changes</button>
                    <button type="button" onclick="closeModal('editResourceModal')" class="btn btn-secondary btn-lg" style="flex:1;justify-content:center"><i class="fas fa-xmark"></i> Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Resource Modal -->
<div class="modal-overlay" id="deleteResourceModal">
    <div class="modal-box danger" style="max-width:440px">
        <div class="modal-head">
            <h2><i class="fas fa-triangle-exclamation" style="margin-right:8px"></i>Delete Resource</h2>
            <button class="modal-close" onclick="closeModal('deleteResourceModal')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="delete-warning">
                <div class="dw-icon"><i class="fas fa-book-open"></i></div>
                <h3>Delete this resource?</h3>
                <p>You are about to permanently delete <strong id="deleteResourceName"></strong>. This cannot be undone.</p>
            </div>
            <form method="POST" action="admin.php" class="js-form">
                <?= csrfField() ?>
                <input type="hidden" name="action"      value="delete_resource">
                <input type="hidden" name="resource_id" id="deleteResourceId">
                <div class="delete-actions">
                    <button type="button" onclick="closeModal('deleteResourceModal')" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete Resource</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Cover Letter Modal -->
<div class="modal-overlay" id="coverModal">
    <div class="modal-box">
        <div class="modal-head">
            <h2><i class="fas fa-pen-to-square" style="margin-right:8px"></i>Cover Letter</h2>
            <button class="modal-close" onclick="closeModal('coverModal')">&times;</button>
        </div>
        <div class="modal-body" style="max-height:60vh;overflow-y:auto;overflow-x:hidden">
            <p id="coverModalText" style="
                line-height:1.8;
                white-space:pre-wrap;
                word-break:break-word;
                overflow-wrap:anywhere;
                font-size:15px;
                color:var(--ink);
                margin:0;
            "></p>
        </div>
    </div>
</div>

<style>
.admin-stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 32px;
}
@media (max-width: 900px) {
    .admin-stats-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 480px) {
    .admin-stats-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .admin-stat { padding: 14px 12px; gap: 10px; }
    .admin-stat-icon { width: 38px; height: 38px; font-size: 15px; flex-shrink: 0; }
    .admin-stat-num { font-size: 22px; }
    .admin-stat-lbl { font-size: 11px; }
}

.admin-tabs-wrap {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 28px;
    border-bottom: 2px solid var(--border);
    padding-bottom: 0;
}
.admin-tab {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 20px;
    border: none;
    background: transparent;
    font-size: 14px;
    font-weight: 600;
    color: var(--ink-muted);
    cursor: pointer;
    border-bottom: 3px solid transparent;
    margin-bottom: -2px;
    border-radius: 6px 6px 0 0;
    transition: all .18s;
    white-space: nowrap;
    position: relative;
}
.admin-tab:hover { background: var(--blue-50); color: var(--blue-600); }
.admin-tab.active { color: var(--blue-600); border-bottom-color: var(--blue-600); background: var(--blue-50); }
.tab-badge {
    background: #dc2626;
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    padding: 2px 6px;
    border-radius: 99px;
    margin-left: 2px;
}
@media (max-width: 640px) {
    .admin-tab { padding: 8px 14px; font-size: 13px; gap: 5px; }
}
@media (max-width: 380px) {
    .admin-tab { padding: 7px 10px; font-size: 12px; }
}

.admin-panel { display: none; }
.admin-panel.active { display: block; }

.sub-tabs-wrap {
    display: flex;
    gap: 4px;
    margin-bottom: 24px;
    border-bottom: 2px solid var(--border);
    padding-bottom: 0;
}
.sub-tab {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 18px;
    border: none;
    background: transparent;
    font-size: 13px;
    font-weight: 600;
    color: var(--ink-muted);
    cursor: pointer;
    border-bottom: 3px solid transparent;
    margin-bottom: -2px;
    border-radius: 6px 6px 0 0;
    transition: all .18s;
    white-space: nowrap;
}
.sub-tab:hover { background: var(--blue-50); color: var(--blue-600); }
.sub-tab.active { color: var(--blue-600); border-bottom-color: var(--blue-600); background: var(--blue-50); }
.sub-panel { display: none; }
.sub-panel.active { display: block; }

.form-center-wrap {
    display: flex;
    justify-content: center;
}
.form-center-wrap .form-card {
    width: 100%;
    max-width: 740px;
}

.tbl-meta {
    margin-bottom: 14px;
    font-size: 14px;
    color: var(--ink-muted);
}
.meta-green { color: var(--green-600); font-weight: 600; }
.meta-yellow { color: #ca8a04; font-weight: 600; }
.meta-red { color: #dc2626; font-weight: 600; }

.sub-email {
    font-size: 12px;
    color: var(--ink-muted);
    font-weight: 400;
    margin-top: 2px;
    word-break: break-all;
}

.cl-preview {
    font-size: 12px;
    color: var(--ink-muted);
    line-height: 1.5;
    max-width: 200px;
    word-break: break-word;
}
.cl-read-more {
    background: none;
    border: none;
    color: var(--blue-600);
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
    padding: 2px 0;
    text-decoration: underline;
}

.btn-approve {
    background: var(--green-600);
    color: #fff;
    border: none;
}
.btn-approve:hover { background: var(--green-700); }

@media (max-width: 640px) {
    .table-wrap table, .table-wrap thead, .table-wrap tbody,
    .table-wrap th, .table-wrap td, .table-wrap tr { display: block; }
    .table-wrap table { min-width: 0 !important; }
    .table-wrap thead { display: none; }
    .table-wrap tbody tr {
        background: #fff;
        border: 1.5px solid var(--blue-100);
        border-radius: 14px;
        margin-bottom: 12px;
        padding: 14px 16px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .table-wrap tbody td {
        padding: 0;
        font-size: 13px;
        border: none;
        display: flex;
        align-items: flex-start;
        gap: 8px;
        flex-wrap: wrap;
    }
    .table-wrap tbody td::before {
        content: attr(data-label);
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: var(--ink-faint);
        min-width: 80px;
        flex-shrink: 0;
        padding-top: 2px;
    }
    .table-wrap tbody td:first-child { font-size: 14px; font-weight: 700; flex-direction: column; align-items: flex-start; }
    .table-wrap tbody td:first-child::before { display: none; }
    .table-wrap tbody td:last-child { margin-top: 4px; }
    .table-wrap tbody td:last-child::before { display: none; }
    .td-actions { flex-direction: row !important; flex-wrap: wrap !important; gap: 6px !important; }
    .cl-preview { max-width: 100%; }
    .sub-email { max-width: 100%; }
    .form-card { padding: 22px 16px; }
}

.modal-overlay {
    padding: 16px;
    box-sizing: border-box;
}
.modal-box {
    width: 100%;
    max-width: 560px;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    margin: auto;
}
.modal-body {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    -webkit-overflow-scrolling: touch;
}
@media (max-width: 480px) {
    .modal-overlay { padding: 10px; align-items: flex-end; }
    .modal-box { max-width: 100%; max-height: 85vh; border-radius: 16px 16px 0 0; }
    .modal-head h2 { font-size: 16px; }
    .delete-actions { flex-direction: column; gap: 8px; }
    .delete-actions .btn { width: 100%; justify-content: center; }
}
</style>

<script>
function switchTab(name) {
    document.querySelectorAll('.admin-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.admin-tab').forEach(t => t.classList.remove('active'));
    const panel = document.getElementById('panel-' + name);
    const tab   = document.getElementById('tab-'   + name);
    if (panel) panel.classList.add('active');
    if (tab)   tab.classList.add('active');
}

function switchSubTab(parent, key) {
    // deactivate all sub-tabs and sub-panels within this parent panel
    const parentEl = document.getElementById('panel-' + parent);
    if (!parentEl) return;
    parentEl.querySelectorAll('.sub-tab').forEach(t => t.classList.remove('active'));
    parentEl.querySelectorAll('.sub-panel').forEach(p => p.classList.remove('active'));
    const subTab   = document.getElementById('subtab-' + parent + '-' + key);
    const subPanel = document.getElementById('subpanel-' + parent + '-' + key);
    if (subTab)   subTab.classList.add('active');
    if (subPanel) subPanel.classList.add('active');
}

function confirmDelete(id, name) {
    document.getElementById('deleteOppId').value        = id;
    document.getElementById('deleteOppName').textContent = name;
    openModal('deleteModal');
}

function openEditUser(u) {
    document.getElementById('editUserId').value       = u.id;
    document.getElementById('editUserName').value     = u.full_name   ?? '';
    document.getElementById('editUserEmail').value    = u.email       ?? '';
    document.getElementById('editUserPhone').value    = u.phone       ?? '';
    document.getElementById('editUserLocation').value = u.location    ?? '';
    document.getElementById('editUserIsAdmin').checked = !!u.is_admin;
    document.getElementById('editUserSubtitle').textContent = 'Editing: ' + (u.full_name ?? u.email ?? '');
    // clear password field
    document.querySelector('#editUserModal input[name="new_password"]').value = '';
    openModal('editUserModal');
}

function confirmDeleteUser(id, name) {
    document.getElementById('deleteUserId').value         = id;
    document.getElementById('deleteUserName').textContent = name;
    openModal('deleteUserModal');
}

let _userSortAsc = true;
function sortUsersTable(col) {
    const tbody = document.querySelector('#panel-users .table-wrap tbody');
    if (!tbody) return;
    const rows = Array.from(tbody.querySelectorAll('tr'));
    rows.sort((a, b) => {
        // Admins always first — check Role cell (index 5)
        const aIsAdmin = (a.cells[5]?.innerText ?? '').includes('Admin');
        const bIsAdmin = (b.cells[5]?.innerText ?? '').includes('Admin');
        if (aIsAdmin !== bIsAdmin) return aIsAdmin ? -1 : 1;
        // Then sort by clicked column
        const aT = (a.cells[col]?.innerText ?? '').trim().toLowerCase();
        const bT = (b.cells[col]?.innerText ?? '').trim().toLowerCase();
        return _userSortAsc ? aT.localeCompare(bT) : bT.localeCompare(aT);
    });
    _userSortAsc = !_userSortAsc;
    document.getElementById('sortIcon').textContent = _userSortAsc ? '▼' : '▲';
    rows.forEach(r => tbody.appendChild(r));
}

function openCoverModal(btn) {
    document.getElementById('coverModalText').textContent = btn.dataset.full;
    openModal('coverModal');
}

function openEditOpp(o) {
    document.getElementById('editOppId').value          = o.id;
    document.getElementById('editOppTitle').value       = o.title            ?? '';
    document.getElementById('editOppSector').value      = o.sector           ?? '';
    document.getElementById('editOppLocation').value    = o.location         ?? '';
    document.getElementById('editOppDescription').value = o.description      ?? '';
    document.getElementById('editOppTimeCommitment').value = o.time_commitment ?? '';
    // Skills: array or JSON string -> comma separated
    let skills = o.required_skills ?? [];
    if (typeof skills === 'string') { try { skills = JSON.parse(skills); } catch(e) { skills = [skills]; } }
    document.getElementById('editOppSkills').value = Array.isArray(skills) ? skills.join(', ') : '';
    // Paid
    const isPaid = !!o.is_paid;
    document.getElementById('editOppIsPaid').checked = isPaid;
    document.getElementById('rateFields-editOpp').style.display = isPaid ? 'block' : 'none';
    document.getElementById('editOppRate').value     = o.rate      ?? '';
    document.getElementById('editOppRateType').value = o.rate_type ?? 'hourly';
    document.getElementById('editOppSubtitle').textContent = 'Editing: ' + (o.title ?? '');
    openModal('editOppModal');
}

function openEditResource(r) {
    document.getElementById('editResourceId').value             = r.id;
    document.getElementById('editResourceTitle').value          = r.title         ?? '';
    document.getElementById('editResourceDesc').value           = r.description   ?? '';
    document.getElementById('editResourceUrl').value            = r.url           ?? '';
    document.getElementById('editResourceType').value           = r.resource_type ?? 'course';
    document.getElementById('editResourceSubtitle').textContent = 'Editing: ' + (r.title ?? '');
    openModal('editResourceModal');
}

function confirmDeleteResource(id, name) {
    document.getElementById('deleteResourceId').value         = id;
    document.getElementById('deleteResourceName').textContent = name;
    openModal('deleteResourceModal');
}

document.addEventListener('DOMContentLoaded', function () {
    switchTab('<?= addslashes($defaultTab) ?>');
    // Restore sub-tab states from redirect params
    switchSubTab('add',    '<?= addslashes($defaultSubtabAdd) ?>');
    switchSubTab('manage', '<?= addslashes($defaultSubtabMgmt) ?>');
});
</script>

<?php include 'partials/footer.php'; ?>